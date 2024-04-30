@extends('layouts.base')

@section('title', __('Invoices'))

@section('content')
@php
$total = 0;
@endphp
<table class="table">
  @foreach ($invoice->items as $item)
    @php
    $total += $item->quantity * $item->price;
    @endphp
    <tr>
      <td>{{ $item->id }}</td>
      <td>{{ $item->name }}</td>
      <td>{{ $item->description }}</td>
      <td>{{ $item->quantity }}</td>
      <td>{{ $item->price }}</td>
    </tr>
  @endforeach
  <tr>
    <td colspan="4" class="text-end">{{ __('Total') }}</td>
    <td>{{ $total }}</td>
  </tr>
</table>

@endsection
