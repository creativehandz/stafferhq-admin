<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gigs;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class GigController extends Controller
{
    public function getGigByStatus(): Response
    {
        $gig = Gigs::all(); 

        return Inertia::render('Gigs/GigsRecord', [
            'gigs' => $gig,
        ]);
    }

//     public function store(Request $request)
//     {
//         // Validate incoming request data
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'required|string',
//             'price' => 'required|numeric',
//         ]);

//         // Create the gig using the validated data
//         Gigs::create([
//             'title' => $request->input('title'),
//             'description' => $request->input('description'),
//             'price' => $request->input('price'),
//         ]);

//         // Redirect back to the gigs list with a success message
//         return Redirect::route('gigs.index')->with('success', 'Gig created successfully.');
//     }

        public function create()
        {
            return Inertia::render('Gigs/GigCreation');
        }
 }
