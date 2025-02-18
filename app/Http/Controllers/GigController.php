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
                'category_id' => 'required|string',
                'subcategory_id' => 'required|string',
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
                'images.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 
                'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
                
            ]);
        
            $filePaths = []; // Array to store the file paths

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    // Save each file and get the storage path
                    $filePath = $file->store('uploads', 'public'); // Save to the 'uploads' directory
                    $filePaths[] = $filePath; // Add the file path to the array
                    
                }
            }

            $certificatePath = null;
            if ($request->hasFile('certificate')) {
                $certificatePath = $request->file('certificate')->store('certificates', 'public');
            }

            // Create a new gig and assign user_id from the authenticated user
            $gig = Gig::create([
                'user_id' => Auth::id(), // Set user_id here
                'gig_title' => $validated['gig_title'],
                'gig_description' => $validated['gig_description'],
                'requirements' => isset($validated['requirements']) ? json_encode($validated['requirements']) : null, // Encode requirements to JSON
                'category_id' => $validated['category_id'],
                'subcategory_id' => $validated['subcategory_id'],
                'positive_keywords' => $validated['positive_keywords'],
                'file_path'=> json_encode($filePaths), // Encode file paths as JSON
                'faqs' => isset($validated['faqs']) ? json_encode($validated['faqs']) : null, // Encode faqs to JSON
                'pricing' => json_encode($validated['pricing']), // Encode pricing to JSON
                'status' => 'active', // Set status to active by default
                'certificate' => $certificatePath,
            ]);
        
            Inertia::share('filePaths', $filePaths);
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
            // $gig->positive_keywords = json_decode($gig->positive_keywords, true);
            // following line breaks down the whole pricing string into basic, standard and premium and so on
            $gig->pricing = json_decode($gig->pricing, true);
                    // Pass gig data to the Inertia view
            return Inertia::render('Jobs/JobsHome', [
                'gig' => $gig // Pass the gig data to the component
            ]);
        }
        public function checkout($id, Request $request)
        {
            // Find the gig by id, including the user relationship
            $gig = Gig::with('user')->findOrFail($id);

            // Decode the pricing JSON field
            $gig->pricing = json_decode($gig->pricing, true);

            // Get the selected pricing from the query string
            $selectedPricing = $request->query('pricing');

            // Optionally, validate or ensure the selected pricing matches one of the package prices
            if (!in_array($selectedPricing, [
                $gig->pricing['basic']['price'],
                $gig->pricing['standard']['price'],
                $gig->pricing['premium']['price'],
            ])) {
                // If the pricing is invalid, you can redirect or handle it as needed
                abort(404, 'Invalid pricing option');
            }

            // Return the Inertia view for the checkout page
            return Inertia::render('Jobs/Checkout', [
                'gig' => $gig, // Pass the gig data to the component
                'selectedPricing' => $selectedPricing, // Pass the selected pricing to the component
            ]);
        }


        public function index(Request $request)
        {
            // Fetch the subcategory_id from the query parameter
            $subcategory_id = $request->query('subcategory_id');
    
            // Check if subcategory_id is provided
            if ($subcategory_id) {
                // Retrieve the gigs that match the subcategory_id
                $gigs = Gig::where('subcategory_id', $subcategory_id)->with('user')->get();
            } else {
                // If no subcategory_id is provided, return all gigs
                $gigs = Gig::with('user')->get();
            }
    
            // Return the gigs as a JSON response
            return response()->json($gigs);
        }
 }
