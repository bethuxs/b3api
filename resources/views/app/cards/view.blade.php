@extends("layouts.$layout")

@section('title', __('Invoices'))

@section('content')
<style type="text/css">
table.info td, table.info th{
  padding-right: 1rem;
}

.info th{
  text-align: right;
}

.table{
margin-top: 2rem;
}

table{
  width: 100%;
  table-layout: fixed;
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
    <table class="info">
      <tr>
        <th>{{ __('Entity') }}</th>
        <td>{{ $invoice->entity->name }} {{ $invoice->entity->surname }}</td>
      </tr>

      <tr>
        <th>{{ __('Date') }}</th>
        <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
      </tr>

      @if($invoice->entity->taxcode)
      <tr>
        <th>{{ __('Tax code') }}</th>
        <td>{{ $invoice->entity->taxcode }}</td>
      </tr>
      @endif

      @if($invoice->entity->address)
      <tr>
        <th>{{ __('Address') }}</th>
        <td> {{ $invoice->entity->address }} {{ $invoice->entity->city }} {{ $invoice->entity->state}} </td>
      </tr>
      @endif
    </table>
  </div>
</section>

@php
$total = 0;
@endphp

<table class="table">
  <thead>
    <tr>
      <th>{{ __('Name') }}</th>
      <th style="width: 55%">{{ __('Description') }}</th>
      <th style="width: 12%">{{ __('Quantity') }}</th>
      <th style="width: 12%">{{ __('Price') }}</th>
    </tr>
  </thead>
  <tbody>
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
  </tbody>
  <tr>
    <th colspan="3" class="text-end">{{ __('Total') }}</th>
    <td>{{ $total }} {{$invoice->currency->code}}</td>
  </tr>
</table>

@if($layout != 'pdf')
<footer class="text-center">
  <a href="{{route('app.invoices.view', [$invoice, 1])}}" class="btn btn-primary">{{ __('Download') }}</a>
</footer>
@endif


@endsection
