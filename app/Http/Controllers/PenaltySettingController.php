<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\member;
use App\Models\penalty_setting;
use App\Models\Record;
use Illuminate\Http\Request;
use Monolog\Handler\InsightOpsHandler;

class PenaltySettingController extends Controller
{
    public function getPenaltySettings()
    {
        // Fetch all penalty settings ordered by the latest first
        $penalties = penalty_setting::orderBy('created_at', 'desc')->get();

        // Extract penalty percentages
        $penaltyPercentages = $penalties->pluck('penalty_percentage');

        return response()->json([
            'success' => true,
            'penalty_percentages' => $penaltyPercentages
        ]);
    }

    public function penaltysubmit(Request $request)
    {
        $request->validate([
            'memberid' => 'required|exists:members,id',
            'amount' => 'required|numeric',
            'penalty_percentage' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_status' => 'required|in:paid,failed_pay',
            'member_old_installment' => 'required|numeric',
            'member_incresed_installment' => 'required|numeric',
            'installment_increased' => 'nullable|numeric',
        ]);

        $member = Member::findOrFail($request->memberid);
        $recordCount = Record::where('member_id', $member->id)->count();
        if ($recordCount >= 12) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'You have already installed 12 payments.',
            ]);
        }

        $paymentStatus = $request->payment_status;

        // Initialize penalty amount
        $penaltyAmount = 0;


        if ($paymentStatus === 'failed_pay' && $request->penalty_percentage) {
            $penaltyAmount = ($request->installment_increased * $request->penalty_percentage) / 100;
        }

        // Calculate the payment pending amount based on payment status
        if ($paymentStatus === 'failed_pay') {
            $paymentPendingAmount = $request->member_incresed_installment - $request->amount + $penaltyAmount;
        } else { // paymentStatus === 'paid'
            $paymentPendingAmount = $request->member_old_installment - $request->amount;
        }

        Installment::create([
            'member_id' => $member->id,
            'amount' => $request->amount,
            'penalty_amount' => $penaltyAmount,
            'payment_pending_amount' => $paymentPendingAmount,
            'payment_pending_old' => $request->member_old_installment,
            'payment_pending_increased' => $request->member_incresed_installment,
            'paid' => $paymentStatus === 'paid',
            'due_date' => now()->startOfMonth()->addMonth()->day(7),
            'payment_date' => $paymentStatus === 'paid' ? $request->payment_date : null,
        ]);

        Record::create([
            'name' => $request->memberName,
            'member_id' => $request->memberid,
            'email' => $request->memberEmail,
            'phone' => $request->memberPhone,
            'address' => $request->memberAddress,
            'installment_amount' => $request->member_old_installment,
            'installment_amount_stand_current' => $request->member_incresed_installment,
            'paid_amount' => $request->amount,
            'penalty_amount' => $penaltyAmount,
            'payment_pending_amount' => $paymentPendingAmount,
            'paid' => $paymentStatus === 'paid',
            'due_date' => now()->startOfMonth()->addMonth()->day(7),
            'payment_date' => $paymentStatus === 'paid' ? $request->payment_date : null,
        ]);

        $member->installment_amount = $paymentPendingAmount;
        $member->save();

        return redirect()->route('records.show', ['member_id' => $member->id])->with([
            'status' => 'success',
            'message' => 'Penalty and installment updated successfully',
        ]);
    }



}
