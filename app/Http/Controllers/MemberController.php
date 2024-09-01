<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Ensure you import the Member model
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'installment_amount' => 'required|numeric|min:0',
        ]);

        // Attempt to create the new member
        $member = Member::create($validatedData);

        // Check if the member was created successfully
        if ($member) {
            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => 'Member added successfully!'
            ]);
        } else {
            // Log the failure
            Log::error('Member creation failed: Unable to create member.');

            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to add member. Please try again later.'
            ], 500);
        }
    }


    public function getData()
    {
        $members = Member::query();

        return DataTables::of($members)
            ->addColumn('actions', function ($member) {
                return '
                <button class="btn btn-primary btn-sm edit-btn" data-id="' . $member->id . '">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="' . $member->id . '">
                    <i class="fas fa-trash"></i>
                </button>
            ';
            })
            ->make(true);
    }

    public function show($id)
    {
        $member = Member::find($id);
        if ($member) {
            return response()->json([
                'success' => true,
                'data' => $member
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }
    }


    public function membersdata($id)
    {
        $memberdata = Member::find($id);
        if ($memberdata) {
            return response()->json([
                'success' => true,
                'data' => $memberdata
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        if ($member) {
            $member->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Member updated successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }
    }


    public function destroy($id)
    {
        $member = Member::find($id);

        if ($member) {
            $member->delete();
            return response()->json([
                'success' => true,
                'message' => 'Member deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }
    }



}
