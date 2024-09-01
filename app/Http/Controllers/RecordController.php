<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function showRecords($member_id)
    {
        // Retrieve records with the specified member_id
        $records = Record::where('member_id', $member_id)->get();

        // Return the view with records data
        return view('website.management', ['records' => $records]);
    }
}
