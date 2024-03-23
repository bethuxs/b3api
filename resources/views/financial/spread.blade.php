@extends('layouts.base')

@section('title', 'Spread')

@section('content')
{{html()->form('POST', route('financial.spread'))->open()}}

<table class="table">
  <tr>
    <th>@lang('Currency')</th>
    <th>@lang('Buy')</th>
    <th>@lang('Sell')</th>
    <th>@lang('Amount')</th>
  </tr>
  @foreach($currencies as $currency)
    <tr>
      @php
       html()->model($currency)
      @endphp
      <td>{{$currency->name}}</td>
      <td>{{html()->text('sell')->name("spread[$currency->id][sell]")->class('form-control') }}</td>
      <td>{{html()->text('buy')->name("spread[$currency->id][buy]")->class('form-control') }}</td>
      <td>{{html()->text('mean')->name("spread[$currency->id][mean]")->class('form-control') }}</td>
    </tr>
  @endforeach
</table>
<footer class="text-center">
  {{html()->submit(__('Save'))->class('btn btn-primary')}}
</footer>
{{html()->form()->close()}}
@endsection
