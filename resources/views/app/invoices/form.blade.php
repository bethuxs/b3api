@extends('layouts.base')

@section('title', __('Invoices'))

@section('content')

<h1>
@if($invoice->id)
    {{ __('Edit Invoice') }} {{$invoice->number}}
@else
    {{ __('Create Invoice') }}
@endif
</h1>

<x-errors :errors="$errors" />

{!! Html::form('POST', route('app.invoices.store', $invoice))
->open() !!}
    {!! Html::token() !!}
    {!! Html::select('entity_id')
            ->options($entitys)
            ->placeholder(__('Select one...'))
            ->value($invoice->entity_id)
            ->required() !!}
    {!! Html::select('currency_id')
            ->options($currencies)
            ->value($invoice->currency_id)
            ->placeholder(__('Select a currency'))
            ->required() !!}
    {!! Html::text('number')
            ->placeholder('Número')
            ->value($invoice->number)

    !!}
    <!-- Puedes agregar más campos aquí según sea necesario -->
    {!! Html::submit('Guardar')->class('btn btn-primary') !!}
{!! Html::form()->close() !!}

@if($invoice->id)
    {!! Html::form('DELETE', route('app.invoices.delete', $invoice))
    ->open() !!}
        {!! Html::token() !!}
        {!! Html::submit(__('Delete'))->class('btn btn-danger') !!}
{!! Html::form()->close() !!}
@endif

@if($invoice->items->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Total') }}</th>
            </tr>
        </thead>
        @foreach ($invoice->items as $i)
            <tr>
                <td>{{ $i->name }}</td>
                <td>{{ $i->description }}</td>
                <td>{{ $i->quantity }}</td>
                <td>{{ $i->price }}</td>
                <td>{{ $i->quantity * $i->price }} {{$invoice->currency->code}}</td>
            </tr>
        @endforeach
    </table>
@endif

@if($invoice->exists)
    @include('app.invoices.item', ['item' => $item, 'invoice' => $invoice])
@endif



@endsection