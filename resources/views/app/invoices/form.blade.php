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


@if($invoice->id)
<div class="text-end"> 
    {!! Html::form('DELETE', route('app.invoices.delete', $invoice))
    ->open() !!}
        {!! Html::token() !!}
        {!! Html::submit(__('Delete Invoice'))->class('btn btn-danger') !!}
{!! Html::form()->close() !!}
</div>
@endif

{!! Html::form('POST', route('app.invoices.store', $invoice))
->open() !!}
    {!! Html::token() !!}
    <section class="row">
    <div class="col-3">
    <label for="entity_id">{{ __('Entity') }}</label>
    {!! Html::select('entity_id')
            ->options($entitys)
            ->placeholder(__('Select one...'))
            ->value($invoice->entity_id)
            ->class('form-control')
            ->required() !!}
    </div>

    <div class="col-3">
        <label>{{__('Currency')}}</label>
        {!! Html::select('currency_id')
            ->options($currencies)
            ->class('form-control')
            ->value($invoice->currency_id)
            ->placeholder(__('Select a currency'))
            ->required() !!}
    </div>

    <div class="col-3">
        <label>{{__('Number')}}</label>
    {!! Html::text('number')
        ->class('form-control')
            ->placeholder('Número')
            ->value($invoice->number)
    !!}

    </div>

    <div class="col-3">
           {!! Html::submit(__('Save'))->class('btn btn-primary') !!}
    </div>
</section>
{!! Html::form()->close() !!}





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