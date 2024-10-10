<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gig;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Gigs;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class GigController extends Controller
{
    public function getGigByStatus(): Response
    {
        $gigs = Gig::with('user')->get(); // Fetch gigs with related user

        // Decode the pricing JSON for each gig
        foreach ($gigs as $gig) {
            $gig->pricing = json_decode($gig->pricing, true);
        }

        return Inertia::render('Gigs/GigsRecord', [
            'gigs' => $gigs,
        ]);
    }

    public function create()
    {
        return Inertia::render('Gigs/demo');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gig_title' => 'required|string|max:255',
            'gig_description' => 'nullable|string',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'positive_keywords' => 'nullable|string',
            'requirements.*' => 'required|string|max:255',
            'faqs' => 'nullable|array', // Validate that it's an array
            'faqs.*.question' => 'required|string|max:255', // Each question is required
            'faqs.*.answer' => 'required|string|max:1000', // Each answer is required
            'pricing' => 'required|array', // Validate that pricing is an array
            'pricing.basic.name' => 'required|string|max:255',
            'pricing.basic.description' => 'nullable|string',
            'pricing.basic.delivery_time' => 'required|string',
            'pricing.basic.revisions' => 'required|string',
            'pricing.basic.price' => 'required|integer|min:1',
            'pricing.standard.name' => 'required|string|max:255',
            'pricing.standard.description' => 'nullable|string',
            'pricing.standard.delivery_time' => 'required|string',
            'pricing.standard.revisions' => 'required|string',
            'pricing.standard.price' => 'required|integer|min:1',
            'pricing.premium.name' => 'required|string|max:255',
            'pricing.premium.description' => 'nullable|string',
            'pricing.premium.delivery_time' => 'required|string',
            'pricing.premium.revisions' => 'required|string',
            'pricing.premium.price' => 'required|integer|min:1',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 
            
        ]);
    
        // Create a new gig and assign user_id from the authenticated user
        $gig = Gig::create([
            'user_id' => Auth::id(), // Set user_id here
            'gig_title' => $validated['gig_title'],
            'gig_description' => $validated['gig_description'],
            'requirements' => isset($validated['requirements']) ? json_encode($validated['requirements']) : null, // Encode requirements to JSON
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'positive_keywords' => $validated['positive_keywords'],
            'faqs' => isset($validated['faqs']) ? json_encode($validated['faqs']) : null, // Encode faqs to JSON
            'pricing' => json_encode($validated['pricing']), // Encode pricing to JSON
        ]);
    
        // return response()->json($gig, 201); // Return created gig
        return redirect()->route('gigs-record')->with('success', 'Gig created successfully.');
    }
    public function getGigs()
    {
        $gigs = Gig::with('user')->get();
    
        // Decode the pricing JSON for each gig
        foreach ($gigs as $gig) {
            $gig->pricing = json_decode($gig->pricing, true);
        }
    
        return response()->json($gigs);
    }
    
    public function show($id)
    {
        // Fetch gig with the associated user
        $gig = Gig::with('user')->findOrFail($id);
        
        // Pass gig data to the Inertia view
        return Inertia::render('Jobs/JobsHome', [
            'gig' => $gig // Pass the gig data to the component
        ]);
    }
 }
