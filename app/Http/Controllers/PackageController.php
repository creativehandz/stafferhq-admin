<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PackageController extends Controller
{
    public function storePackageInSession(Request $request)
    {
        // Store package details in the session
        $request->session()->put('packageName', $request->input('packageName'));
        $request->session()->put('packagePrice', $request->input('packagePrice'));
        $request->session()->put('packageDescription', $request->input('packageDescription'));
        $request->session()->put('deliveryTime', $request->input('deliveryTime'));
        $request->session()->put('revisions', $request->input('revisions'));
        $request->session()->put('gigId', $request->input('gigId'));

        return Redirect::to('/checkout')->with('success', 'Package submitted successfully!');
        // return redirect()->route('Jobs/Checkout'); // Redirect to the checkout page
    }
}
