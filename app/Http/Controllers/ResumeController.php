<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ResumeController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add validation rules for other fields as necessary
        ]);

        // Save the resume data
        $resume = Resume::create([
            'user_id' => Auth::id(),
            'name' => $request->input('name'),
            'occupation' => $request->input('occupation'),
            'about' => $request->input('about'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'social_links' => json_encode($request->input('socialLinks')),
            'age' => $request->input('age'),
            'citizen' => $request->input('citizen'),
            'address' => $request->input('address'),
            'favorate_quote' => $request->input('favorate_quote'),
            'expertise' => $request->input('expertise'),
            'what_i_do' => json_encode($request->input('whatIDo')),
            'skills' => json_encode($request->input('skills')),
            'educations' => json_encode($request->input('educations')),
            'experiences' => json_encode($request->input('experiences')),
            'projects' => json_encode($request->input('projects')),
        ]);

        return redirect()->route('setting')->with('success', 'Resume created successfully.');
    }

    public function getResumeData()
   {
        $resume = Resume::where('user_id', Auth::id())->first();
    
        if (!$resume) {
            return response()->json(['message' => 'No resume found'], 404);
        }

        // Pass data to the Inertia view
        return Inertia::render('Setting', [
            'resume' => $resume
        ]);
    }
}
