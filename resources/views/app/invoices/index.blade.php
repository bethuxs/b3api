@extends('layouts.base')

@section('title', __('Invoices'))

@section('content')
<table class="table">
    <thead>
    <tr>
      <th>{{ __('Number') }}</th>
      <th>{{ __('Name') }}</th>
      <th>{{ __('Date') }}</th>
      <th>{{ __('Actions') }}</th>
    </tr>
  </thead>
  @foreach ($invoices as $invoice)
    <tr>
      <td>{{ $invoice->number }}</td>
      <td>{{ $invoice->entity->name }}</td>
      <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
      <td>
        <a class="btn btn-info" href="{{ route('app.invoices.view', $invoice) }}">{{ __('View') }}</a>
        <a class="btn btn-warning" href="{{ route('app.invoices.edit', $invoice) }}">{{ __('Edit') }}</a>
      </td>
    </tr>
  @endforeach

</table>

@endsection
