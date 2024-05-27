@extends('layouts.base')

@section('title', __('Invoices'))

@section('content')
<h1>{{ __('Invoices') }}</h1>

<a class="btn btn-primary" href="{{ route('app.invoices.create') }}">{{ __('Create') }}</a>

<table class="table table-striped">
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

  {{ $invoices->links() }}

@endsection
