<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs for the authenticated user.
     */
    public function index(): Response
    {
        $jobs = Auth::user()->jobs; // Get all jobs posted by the authenticated user
        return Inertia::render('Jobs/Index', [
            'jobs' => $jobs,
        ]);
    }


/**
     * Show all jobs in find-work.
     */
    public function showAllJobs(): Response
{
    // Fetch all job records, 
    $jobs = Job::all(); 

    return Inertia::render('Talent/FindWork', [
        'jobs' => $jobs,
    ]);
}

    /**
     * Show the form for creating a new job.
     */
    public function create(): Response
    {
        return Inertia::render('Jobs/Create');
    }

    /**
     * Store a newly created job in storage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_type' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'skills' => 'nullable|array|max:10',
            'skills.*' => 'nullable|max:255',
            'experience_level' => 'required|string|max:255',
            'budget_type' => 'nullable|string|max:255',
            'budget' => 'required|numeric',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|max:10240', // Max file size 10MB
        ]);

        //Skills
        $skills = $request->skills;
        $skillIds = [];

        foreach ($skills as $skill) {
            $existingSkill = Skill::where('name', $skill['name'])->first();

            if ($existingSkill) {
                $skillIds[] = $existingSkill->id;
            } else {
                $newSkill = Skill::create(['name' => $skill['name']]);
                $skillIds[] = $newSkill->id;
            }
        }
        //Attachment
        if ($request->hasFile('attachment')) {
            // Get the original file name without the extension
            $originalFileName = pathinfo($request->file('attachment')->getClientOriginalName(), PATHINFO_FILENAME);
            // Trim the file name to 10 characters
            $trimmedFileName = substr($originalFileName, 0, 10);
            // Generate the final file name with timestamp and user ID
            $attachmentFileName = time() . '_' . Auth::id() . '_' . $trimmedFileName . '.' . $request->file('attachment')->getClientOriginalExtension();
            // Store the file
            $request->file('attachment')->storeAs('attachments', $attachmentFileName);
        }

        $job = Job::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'project_type' => $request->project_type,
            'category' => $request->category,
            'skills' => implode(',', $skillIds),
            'experience_level' => $request->experience_level,
            'budget_type' => $request->budget_type,
            'budget' => $request->budget,
            'description' => $request->description,
            'location' => $request->location,
            'attachment' => $attachmentFileName ?? null,
        ]);

        return Redirect::to('/employer-dashboard')->with('success', 'Job posted successfully!');
    }

    /**
     * Display the specified job.
     */
    public function show($id): Response
    {
        $job = Job::findOrFail($id);

        // if ($job->user_id !== Auth::id()) {
        //     abort(403, 'Unauthorized action.');
        // }

        return Inertia::render('Talent/JobDetail', [
            'job' => $job,
        ]);
    }


    public function showJobInProposal($id): Response
    {
        $job = Job::findOrFail($id);

        // if ($job->user_id !== Auth::id()) {
        //     abort(403, 'Unauthorized action.');
        // }

        return Inertia::render('Talent/SubmitProposal', [
            'job' => $job,
        ]);
    }


    /**
     * Show the form for editing the specified job.
     */
    public function edit($id): Response
    {
        $job = Job::findOrFail($id);

        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Jobs/Edit', [
            'job' => $job,
        ]);
    }

    /**
     * Update the specified job in storage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $job = Job::findOrFail($id);

        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'project_type' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'skills' => 'nullable|array|max:10',
            'skills.*' => 'string|max:255',
            'experience_level' => 'required|string|max:255',
            'budget_type' => 'required|string|max:255',
            'budget' => 'required|numeric',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $job->update([
            'title' => $request->title,
            'project_type' => $request->project_type,
            'category' => $request->category,
            'skills' => $request->skills,
            'experience_level' => $request->experience_level,
            'budget_type' => $request->budget_type,
            'budget' => $request->budget,
            'description' => $request->description,
            'location' => $request->location,
        ]);

        if ($request->hasFile('attachment')) {
            if ($job->attachment) {
                Storage::delete($job->attachment);
            }

            $job->update([
                'attachment' => $request->file('attachment')->store('attachments'),
            ]);
        }

        return redirect(route('jobs.index'))->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $job = Job::findOrFail($id);

        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($job->attachment) {
            Storage::delete($job->attachment);
        }

        $job->delete();

        return redirect(route('jobs.index'))->with('success', 'Job deleted successfully!');
    }
}
