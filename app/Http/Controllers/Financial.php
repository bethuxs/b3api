<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Financial extends Controller
{
    function spread()
    {
        $currencies = \App\Models\Currency::where('code', '<>', 'VES')->get();
        return view('financial.spread', ['currencies' => $currencies]);
    }

    function spreadPost(Request $request)
    {
        $request->validate([
            'spread' => 'required|array',
            'spread.*.buy' => 'required|numeric',
            'spread.*.sell' => 'required|numeric',
        ]);

        foreach ($request->spread as $currency => $data) {
            $currency = \App\Models\Currency::find($currency);
            $currency->sell = $data['sell'];
            $currency->buy = $data['buy'];
            $currency->save();
        }
        flash(__('Spread updated!'), 'success');
        return redirect()->route('financial.spread');
    }


}
