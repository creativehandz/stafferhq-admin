<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\ResumeUpdateRequest; 
use Illuminate\Support\Facades\Redirect;

class ResumeController extends Controller
{
    //
    public function store(Request $request)
    {

        try {
             // Check if a resume already exists for the authenticated user
            $existingResume = Resume::where('user_id', Auth::id())->first();

            if ($existingResume) {
                // If a resume exists, redirect to the edit resume page
                return redirect()->route('resume.edit')->with('info', 'Resume already exists. You can edit it.');
            }

                $request->validate([
                    'name' => 'required|string|max:255',
                    'whatIDo.*.icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'projects.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    // Add validation rules for other fields as necessary
                ]);

            // Handle the 'whatIDo' icons
            $whatIDo = $request->input('whatIDo', []);
            foreach ($whatIDo as $key => $item) {
                if ($request->hasFile("whatIDo.$key.icon")) {
                    $file = $request->file("whatIDo.$key.icon");
                    $originalFilename = $file->getClientOriginalName();
                    // Check if the original filename has spaces
                     if (strpos($originalFilename, ' ') !== false) {
                         // Replace spaces with underscores if spaces are found
                         $originalFilename = str_replace(' ', '_', $originalFilename);
                     }
                 
                     $filename = time() . '_' . $originalFilename;
                    $path = $file->storeAs('uploads/icons', $filename, 'public');
                    $whatIDo[$key]['icon'] = $path;
                } else {
                    $whatIDo[$key]['icon'] = null;
                }
            }

            // Handle the 'projects' images
            $projects = $request->input('projects', []);
            foreach ($projects as $key => $project) {
                if ($request->hasFile("projects.$key.image")) {
                    $file = $request->file("projects.$key.image");
                    $originalFilename = $file->getClientOriginalName();
                    // Check if the original filename has spaces
                    if (strpos($originalFilename, ' ') !== false) {
                        // Replace spaces with underscores if spaces are found
                        $originalFilename = str_replace(' ', '_', $originalFilename);
                    }
                
                    $filename = time() . '_' . $originalFilename;
                    $path = $file->storeAs('uploads/projects', $filename, 'public');
                    $projects[$key]['image'] = $path;
                } else {
                    $projects[$key]['image'] = null;
                }
            }
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
                'what_i_do' => json_encode($whatIDo),
                'skills' => json_encode($request->input('skills')),
                'educations' => json_encode($request->input('educations')),
                'experiences' => json_encode($request->input('experiences')),
                'projects' => json_encode($projects),
            ]);

            return redirect()->route('setting')->with('success', 'Resume created successfully.');

        } catch (\Exception $e) {
            // Log the error to the console
            echo "Error creating resume: " . $e->getMessage() . "\n";
            // Log the error
            \Log::error('Error creating resume: ' . $e->getMessage());
           
            // Handle the error and return an appropriate response
            return redirect()->back()->with('error', 'An error occurred while creating the resume. Please try again later.');
        }
       
       
    }

    public function getResumeData()
   {
        $resume = Resume::where('user_id', Auth::id())->first();
    
        if (!$resume) {
            return redirect()->route('error-page')->with('error', 'Resume not found.');
        }

        // Pass data to the Inertia view
        return Inertia::render('Talent/Setting', [
            'resume' => $resume
        ]);
    }

    public function editResume()
{
    $resume = Resume::where('user_id', Auth::id())->first();

    if (!$resume) {
        return redirect()->route('error-page')->with('error', 'Resume not found.');
    }

    // Pass data to the Inertia view for the "Edit Resume" page
    return Inertia::render('Talent/EditResume', [
        'resume' => $resume
    ]);
}

/**
     * Update the resume data.
     *
     * @param ResumeUpdateRequest $request
     * @return RedirectResponse
     */
    public function updateResume(ResumeUpdateRequest $request): RedirectResponse
    {
        try {
                // Retrieve the existing resume record
            $resume = Resume::where('user_id', Auth::id())->first();

            if (!$resume) {
                return redirect()->route('error-page')->with('error', 'Resume not found.');
            }

             // Decode existing whatIDo and projects fields to handle existing file paths
        $existingWhatIDo = json_decode($resume->what_i_do, true) ?? [];
        $existingProjects = json_decode($resume->projects, true) ?? [];

          // Handle the 'whatIDo' icons
          $whatIDo = $request->input('whatIDo', []);
          foreach ($whatIDo as $key => $item) {
              if ($request->hasFile("whatIDo.$key.icon")) {
                // Delete old icon if it exists
                // if (!empty($existingWhatIDo[$key]['icon']) && Storage::disk('public')->exists($existingWhatIDo[$key]['icon'])) {
                //     Storage::disk('public')->delete($existingWhatIDo[$key]['icon']);
                // }

                
                //add new file
                  $file = $request->file("whatIDo.$key.icon");
                  $originalFilename = $file->getClientOriginalName();
                  // Check if the original filename has spaces
                   if (strpos($originalFilename, ' ') !== false) {
                       // Replace spaces with underscores if spaces are found
                       $originalFilename = str_replace(' ', '_', $originalFilename);
                   }
               
                   $filename = time() . '_' . $originalFilename;
                  $path = $file->storeAs('uploads/icons', $filename, 'public');
                  $whatIDo[$key]['icon'] = $path;
              } else {
                  $whatIDo[$key]['icon'] = null;
              }
          }

            // Handle the 'projects' images
            $projects = $request->input('projects', []);
            foreach ($projects as $key => $project) {
                if ($request->hasFile("projects.$key.image")) {
                    // Delete old image if it exists
                    // if (!empty($existingProjects[$key]['image']) && Storage::disk('public')->exists($existingProjects[$key]['image'])) {
                    //     Storage::disk('public')->delete($existingProjects[$key]['image']);
                    // }
                    
                    //add new file    
                    $file = $request->file("projects.$key.image");
                    $originalFilename = $file->getClientOriginalName();
                    // Check if the original filename has spaces
                    if (strpos($originalFilename, ' ') !== false) {
                        // Replace spaces with underscores if spaces are found
                        $originalFilename = str_replace(' ', '_', $originalFilename);
                    }
                
                    $filename = time() . '_' . $originalFilename;
                    $path = $file->storeAs('uploads/projects', $filename, 'public');
                    $projects[$key]['image'] = $path;
                } else {
                    $projects[$key]['image'] = null;
                }
            }

            // Update the resume with new data
            $resume->update([
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
                'what_i_do' => json_encode($whatIDo),
                'skills' => json_encode($request->input('skills')),
                'educations' => json_encode($request->input('educations')),
                'experiences' => json_encode($request->input('experiences')),
                'projects' => json_encode($projects),
            ]);
            // Redirect to the setting page with a success message
            return redirect()->route('setting')->with('success', 'Resume updated successfully.');


        } catch (\Exception $e) {
            // Log the error to the console
            echo "Error updating resume: " . $e->getMessage() . "\n";
            // Log the error
            \Log::error('Error updating resume: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
          
            // Handle the error and return an appropriate response
            return redirect()->back()->with('error', 'An error occurred while updating the resume. Please try again later.');
        }    
    }
}
