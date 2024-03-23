@extends('layouts.base')

@section('title', 'Spread')

@section('content')
{{html()->form('POST', route('financial.spread'))->open()}}


<table>
  @foreach($currencies as $currency)
    <tr>
      @php
       html()->model($currency)
      @endphp
      <td>{{$currency->name}}</td>
      <td>{{html()->text('sell')->name("spread[$currency->id][sell]")->class('form-control') }}</td>
      <td>{{html()->text('buy')->name("spread[$currency->id][buy]")->class('form-control') }}</td>
    </tr>
  @endforeach
</table>
{{html()->submit(__('Save'))->class('btn btn-primary')}}
{{html()->form()->close()}}
@endsection
