<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gigs;
use Inertia\Inertia;
use Inertia\Response;

class GigController extends Controller
{
    public function getGigByStatus(): Response
    {
        $gig = Gigs::all(); 

        return Inertia::render('Talent/GigsRecord', [
            'gigs' => $gig,
        ]);
    }
}
