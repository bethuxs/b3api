<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;

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

}
