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
        // Validate the request data
        $request->validate([
            'memberid' => 'required|exists:members,id',
            'amount' => 'required|numeric',
            'penalty_percentage' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
            'payment_status' => 'required|in:paid,failed_pay',
        ]);

        // Retrieve the member
        $member = Member::findOrFail($request->memberid);

        // Determine the payment status
        $paymentStatus = $request->payment_status;

        // Calculate the penalty amount if the payment failed
        $penaltyAmount = 0;
        if ($paymentStatus === 'failed_pay' && $request->penalty_percentage) {
            $penaltyAmount = ($request->amount * $request->penalty_percentage) / 100;
        } elseif ($paymentStatus === 'paid' && $request->penalty) {
            $penaltyAmount = $request->penalty;
        }

        // Calculate the payment pending amount
        $paymentPendingAmount = $request->amount + $penaltyAmount;

        // Create or update the installment record
        $installment = Installment::create([
            'member_id' => $member->id,
            'amount' => $request->amount,
            'penalty_amount' => $penaltyAmount,
            'payment_pending_amount' => $paymentPendingAmount,
            'paid' => $paymentStatus === 'paid',
            'due_date' => now(),
            'payment_date' => $paymentStatus === 'paid' ? $request->payment_date : null,
        ]);

        // Create a record entry using the Record model
        Record::create([
            'name' => $request->memberName,
            'member_id' => $request->memberid,
            'email' => $request->memberEmail,
            'phone' => $request->memberPhone,
            'address' => $request->memberAddress,
            'installment_amount' => $request->memberInstallmentAmount,
            'amount' => $request->amount,
            'penalty_amount' => $penaltyAmount,
            'payment_pending_amount' => $paymentPendingAmount,
            'paid' => $paymentStatus === 'paid',
            'due_date' => now(),
            'payment_date' => $paymentStatus === 'paid' ? $request->payment_date : null,
        ]);

        // Update the member's installment amount
        if ($paymentStatus === 'paid') {
            $member->installment_amount -= $paymentPendingAmount;
        } else {
            $member->installment_amount = $paymentPendingAmount;
        }

        $member->save();

        // Redirect to the records view for the specific member
        return redirect()->route('records.show', ['member_id' => $member->id])->with([
            'status' => 'success',
            'message' => 'Penalty and installment updated successfully',
        ]);
    }




}
