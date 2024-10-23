<?php

// app/Http/Controllers/RequirementController.php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequirementController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'requirements' => 'required|string|max:2500',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx,txt|max:2048', // Adjust file types as needed
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public'); // Save the file in 'storage/app/public/uploads'
        }

        // Store the form data in the database
        Requirement::create([
            'requirements' => $validatedData['requirements'],
            'file_path' => $filePath,
        ]);

        return response()->json(['message' => 'Requirements submitted successfully!'], 200);
    }
}
