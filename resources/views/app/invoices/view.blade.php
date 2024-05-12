@extends('layouts.pdf')

@section('title', __('Invoices'))

@section('content')
<style type="text/css">
dt{
text-align:right;
}

</style>
<h1>{{ __('Invoice') }} #{{ $invoice->number }}</h1>

<section class="row">
  <div class="col-5">
    <h4>Tecnofalls Serviços De Tecnologia Ltda</h4>

    <h5>CNPJ: 50.550.927/0001-73</h5>
    <h6>Av José Maria De Brito 1707, Monjolo Foz do Iguaçu, PR, Brasil 85864-320</h6>
  </div>
  <div class="col-7">
    <dl class="row ms-5">
      <dt class="col-5">{{ __('Entity') }}</dt>
      <dd class="col-7">{{ $invoice->entity->name }} {{ $invoice->entity->surname }}</dd>

      <dt class="col-5">{{ __('Date') }}</dt>
      <dd class="col-7">{{ $invoice->created_at->format('d/m/Y') }}</dd>

      @if($invoice->entity->taxcode)
        <dt class="col-5">{{ __('Tax code') }}</dt>
        <dd class="col-7">{{ $invoice->entity->taxcode }}</dd>
      @endif

      @if($invoice->entity->address)
      <dt class="col-5">{{ __('Address') }}</dt>
      <dd class="col-7"> {{ $invoice->entity->address }} {{ $invoice->entity->city }} {{ $invoice->entity->state}} </dd>
      @endif
    </dl>
  </div>
</section>

@php
$total = 0;
@endphp

<table class="table">
  <thead>
    <tr>
      <th>{{ __('Name') }}</th>
      <th style="max-width: 10rem">{{ __('Description') }}</th>
      <th>{{ __('Quantity') }}</th>
      <th>{{ __('Price') }}</th>
    </tr>
  </thead>
  @foreach ($invoice->items as $item)
    @php
    $total += $item->quantity * $item->price;
    @endphp
    <tr>
      <td>{{ $item->name }}</td>
      <td>{{ $item->description }}</td>
      <td>{{ $item->quantity }}</td>
      <td>{{ $item->price }} {{$invoice->currency->code}}</td>
    </tr>
  @endforeach
  <tr>
    <th colspan="3" class="text-end">{{ __('Total') }}</th>
    <td>{{ $total }} {{$invoice->currency->code}}</td>
  </tr>
</table>

@endsection
