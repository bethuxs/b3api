<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Card as Model;


class Card extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Model::orderBy('created_at', 'desc')
            ->paginate(20);
        return view('app.cards.index', compact('cards'));
    
    }

    public function edit(Model $card)
    {
        $user = auth()->user();
        return view('app.cards.form', compact('card'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Model $card)
    {
        $request->validate([
            'name' => 'required',
            'closed_day' => 'required|numeric|min:1|max:31',
        ]);

        $user = auth()->user();
        $card->user_id = $user->id;
        $card->name = $request->name;
        $card->closed_day = $request->closed_day;
        $card->save();
        return redirect()->route('app.cards.edit', $card);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
