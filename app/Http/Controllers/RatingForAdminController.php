<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Models\Dosenpa;
use App\Models\Mahasiswa;

class RatingForAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.rating.admin.index', [
            'ratings' => Rating::all(),
            'dosenpa' => Dosenpa::filter(request(['cari']))->paginate(5),
            'mahasiswa' => Mahasiswa::all(),
            'active' => 'rating'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        //
    }

    public function ratingdosenoll()
    {
        return view('dashboard.rating.admin.ratingdosenoll', [
            'ratings' => Rating::filter(request(['cari', 'start', 'end']))->paginate(10),
            'active' => 'ratingdosenoll'
        ]);
    }
}
