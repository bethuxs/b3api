@extends('layouts.base')

@section('title', __('Invoices'))

@section('content')
<table class="table">
  @foreach ($invoices as $invoice)
    <tr>
      <td>{{ $invoice->id }}</td>
      <td>{{ $invoice->entity->name }}</td>
    </tr>
  @endforeach

</table>

@endsection
