<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Currency;
use App\Models\Item;

use Illuminate\Validation\Rule;



class Invoices extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')
            ->paginate(25);
        return view('app.invoices.index', compact('invoices'));
    }

    public function view(Invoice $invoice)
    {
        return view('app.invoices.view', compact('invoice'));
    }

    public function edit(Invoice $invoice, Item $item)
    {
        $user = auth()->user();
        $entitys = $user->entitys->pluck('name', 'id');
        $currencies = Currency::all()->pluck('name', 'id');
        return view('app.invoices.form', compact('invoice', 'entitys', 'currencies', 'item'));
    }

    public function store(Request $request, Invoice $invoice)
    {
        $request->validate([
            'entity_id' => 'required|exists:entities,id',
            'number' => [
                'nullable',
                'between:1,128',
                Rule::unique('invoices')->ignore($invoice, 'number'),
            ],
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $user = auth()->user();
        $invoice->entity_id = $request->entity_id;
        $invoice->user_id = $user->id;
        $invoice->number = $request->number ?? Invoice::generateNumber($user);
        $invoice->currency_id = $request->currency_id;
        $invoice->save();
        return redirect()->route('app.invoices.edit', $invoice);
    }

    public function storeItem(Request $request, Invoice $invoice, Item $item)
    {
        $request->validate([
            'name' => 'required|between:3,255',
            'description' => 'required|between:3,255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if (!$item->exists) {
            $item->invoice_id = $invoice->id;
        }

        $item->name = $request->name;
        $item->description = $request->description;
        $item->quantity = $request->quantity;
        $item->price = $request->price;
        $item->save();
        return redirect()->route('app.invoices.edit', $invoice);
    }
}
