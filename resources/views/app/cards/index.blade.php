@extends('layouts.base')

@section('title', __('Cards'))

@section('content')
<h1>{{ __('Cards') }}</h1>

<a class="btn btn-primary" href="{{ route('app.cards.create') }}">{{ __('Create') }}</a>

<table class="table table-striped">
    <thead>
    <tr>
      <th>{{ __('ID') }}</th>
      <th>{{ __('Name') }}</th>
      <th>{{ __('Closing Date') }}</th>
      <th>{{ __('Actions') }}</th>
    </tr>
  </thead>
  @foreach ($cards as $invoice)
    <tr>
      <td>{{ $invoice->id }}</td>
      <td>{{ $invoice->name }}</td>
      <td>{{ $invoice->closed_day }}</td>
      <td>
        <a class="btn btn-info" href="{{ route('app.cards.view', $invoice) }}">{{ __('View') }}</a>
        <a class="btn btn-warning" href="{{ route('app.cards.edit', $invoice) }}">{{ __('Edit') }}</a>
      </td>
    </tr>
  @endforeach
</table>

  {{ $cards->links() }}

@endsection
