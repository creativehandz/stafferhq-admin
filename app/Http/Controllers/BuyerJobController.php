<?php

namespace App\Http\Controllers;

use App\Models\BuyerJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuyerJobController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'jobTitle' => 'required|string|max:255',
            'jobDescription' => 'required|string',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'budget' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file upload - Save image inside resources/img/project-briefs
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); 
            $image->move(resource_path('img/project-briefs'), $imageName); 

            $imagePath = "resources/img/project-briefs/" . $imageName; 
        }

        // Create Buyer Job
        $buyerJob = BuyerJob::create([
            'job_title' => $request->jobTitle,
            'job_description' => $request->jobDescription,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'budget' => $request->budget,
            'image' => $imagePath, 
        ]);

        return response()->json([
            'message' => 'Job posted successfully!',
            'job' => $buyerJob
        ], 201);
    }
}
