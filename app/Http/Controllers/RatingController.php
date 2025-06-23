<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Dosenpa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        return view('dashboard.rating.index', [
            'ratings' => Rating::all(),
            'dosenpa' => Dosenpa::all(),
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
        // $valid = $request->validate([
        //     'rating' => 'required',
        // ]);

        $averageRating = ($request->pertanyaan_1 + $request->pertanyaan_2 + $request->pertanyaan_3 + $request->pertanyaan_4 + $request->pertanyaan_4)/5;
        $pembulatan = round($averageRating, 1);
        $valid['rating'] = $pembulatan;

        // $valid['mahasiswa_id'] = auth()->user()->mahasiswa->id;
        if (auth()->user()->role === 'mahasiswa') {
            $valid['mahasiswa_id'] = auth()->user()->mahasiswa->id;
        } else {
            $valid['dosenpa_id'] = auth()->user()->dosenpa->id;
        }
        $valid['dosenpa_id'] = $request->dosenpa_id;

        Rating::create($valid);

        return redirect('/dashboard/rating')->with('success', 'Rating berhasil ditambahkan');
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
        $valid = $request->validate([
            'rating' => 'required',
        ]);

        $rating->update($valid);

        return redirect('/dashboard/rating')->with('success', 'Rating berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
