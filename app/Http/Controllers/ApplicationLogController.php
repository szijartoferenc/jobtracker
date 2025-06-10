<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationLog;
use Illuminate\Http\Request;

class ApplicationLogController extends Controller
{
     public function store(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'logged_at' => 'required|date',
        ]);

        $application->logs()->create([
            'status' => $request->status,
            'note' => $request->note,
            'logged_at' => $request->logged_at,
        ]);

        return redirect()->back()->with('success', 'Naplóbejegyzés hozzáadva.');
    }
}
