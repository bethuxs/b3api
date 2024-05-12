@extends('layouts.base')

@section('title', __('Dashboard'))

@section('content')
<a class="btn btn-primary" href="{{ route('app.invoices.index') }}">{{ __('Invoices') }}</a>
@endsection