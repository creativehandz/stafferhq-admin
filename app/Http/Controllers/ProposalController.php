<?php

namespace App\Http\Controllers;


use App\Models\Proposal;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProposalController extends Controller
{
    //
    // public function store(Request $request, $jobId)
    // {
    //     // Validate the incoming request data
    //     $validated = $request->validate([
    //         'cover_letter' => 'required|string',
            
    //     ]);

    //     // Create a new proposal linked to the job
    //     Proposal::create([
    //         'job_id' => $jobId,
    //         'user_id' => auth()->id(), // Assume authenticated user is submitting
    //         'cover_letter' => $request->cover_letter,
    //         'attachment' => $request->attachment,
    //         'status' => 'pending', // Default status for new proposals
    //     ]);

    //     // Redirect back to job page with a success message
    //     return redirect()->route('jobs.show', $jobId)->with('success', 'Proposal submitted successfully!');
    // }

    public function submit(Request $request, $jobId)
    {
        // Validate the request
        $request->validate([
            'cover_letter' => 'required|string|max:5000',
            // Add other validation rules for proposal fields
        ]);

        // Find the job using the jobId
        $job = Job::findOrFail($jobId);

        // Create a new proposal
        $proposal = new Proposal();
        $proposal->job_id = $job->id;
        $proposal->user_id = Auth::id(); // Assuming proposals are submitted by authenticated users
        $proposal->cover_letter = $request->input('cover_letter');
        $proposal->attachment = $request->attachment; // Store the attachment
        $proposal->status = 'pending'; // Set default status
        // Set other proposal fields here

        // Save the proposal to the database
        $proposal->save();

        // Redirect back with success message
        return Redirect::to('/thank-you')->with('success', 'Proposal submitted successfully!');
    }

}
