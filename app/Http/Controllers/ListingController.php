<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class ListingController extends Controller
{
    // show all listings
    public function index()
    {
        return view('listings/index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(6)
        ]);
    }


    // create listing
    public function create()
    {
        return view('listings/create');
    }

    // show single listing
    public function show(Listing $listing)
    {
        return view('listings/show', [
            'listing' => $listing
        ]);
    }
    // store listing data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => '',
            'email' => ['required', 'email'],
            'tags' => '',
            'description' => ''
        ]);

        if($request->hasFile('logo'))
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();


        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }
    // show Edit form
    public function edit(Listing $listing)
    {
        return view('listings/edit', ['listing' => $listing]);
    }
    // update listing data
    public function update(Request $request, Listing $listing)
    {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id())
        {
            abort(403, 'Unauthorized action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => '',
            'email' => ['required', 'email'],
            'tags' => '',
            'description' => ''
        ]);

        if($request->hasFile('logo'))
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        //dd($formFields);
        $listing->update($formFields);

        return redirect("/listing/".$listing->id)->with('message', 'Listing updated successfully!');
    }
    public function destroy(Listing $listing)
    {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id())
        {
            abort(403, 'Unauthorized action');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }
    //manage listings
    public function manage()
    {
        return view('/listings/manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
