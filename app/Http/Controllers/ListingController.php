<?php

namespace App\Http\Controllers;

use App\Http\Requests\Listing\ListingStoreRequest;
use App\Models\Listing;
use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // show all listings
    public function index(Request $request)
    {
        // dd($request->tag); // show tags in die dump
        return view('listings.index', [
            'heading' => 'Latest Listings',
            // 'listings' => Listing::all(), // get all listing
            // 'listings' => Listing::latest()->filter(request(['tag', 'search']))->get(), // get all listing in sorting way latest first
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(10), // get all listing in sorting way latest first
            // 'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(2), // get all listing in sorting way latest first
        ]);
    }

    // show single listing
    public function show(Listing $listing)
    {
        $prices = Price::where('product_id', $listing->id)->get();

        return view('listings.show', [
            'listing' => $listing,
            'prices' => $prices,
        ]);
    }

    // show create from
    public function create()
    {
        return view('listings.create');
    }

    // Store Listing Data
    public function store(Request $request)
    {
        // dd($request->file('logo'));

        $formFields = $request->validate([
            'title' => [
                'required',
            ],
            'company' => [
                'required',
            ],
            'location' => [
                'required',
            ],
            'website' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
            ],
            'amount' => [
                'required',
            ],
            'tags' => [
                'required',
            ],
            'description' => [
                'required',
            ],
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $count = Listing::where('title', '=', $formFields['title'])->first();

        if(!$count){
            $latest_id = Listing::create($formFields)->id;
            $formFields['user_id'] = auth()->id();
            $prices = new Price;
            $prices->amount = $formFields['amount'];
            $prices->product_id = $latest_id;
            $prices->user_id = auth()->id();
            $prices->save();

        }else{
            $id = $count->id;
            $prices = new Price;
            $prices->amount = $formFields['amount'];
            $prices->product_id = $id;
            $prices->user_id = auth()->id();
            $prices->save();
        }

        return redirect('/')->with('success', 'Product created successfully!');




    }

    // Show Edit Form
    public function edit(Listing $listing)
    {
        // dd($listing);
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update Listing Data
    public function update(Request $request, Listing $listing)
    {

        // Make sure logged in user is owner

        if($listing->user_id != auth()->id()){
            abort(404, 'Unauthorize Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required|unique:listings,company,'. $listing->id,
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');

        }

        $listing->update($formFields);

        return back()->with('success', 'Listing updated successfully!');
    }

    // Delete Listing
    public function destroy(Listing $listing)
    {

        // Make sure logged in user is owner

        if($listing->user_id != auth()->id()){
            abort(404, 'Unauthorize Action');
        }

        $listing->delete();
        return redirect('/')->with('success', 'Listing deleted successfully!');
    }

    // Manage Listings
    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
