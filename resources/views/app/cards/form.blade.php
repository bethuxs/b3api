@extends('layouts.base')

@section('title', __('cards'))

@section('content')

<h1>
@if($card->id)
    {{ __('Edit Card') }} {{$card->number}}
@else
    {{ __('Create Card') }}
@endif
</h1>

<x-errors :errors="$errors" />


@if($card->id)
<div class="text-end"> 
    {!! Html::form('DELETE', route('app.cards.delete', $card))
    ->open() !!}
        {!! Html::token() !!}
        {!! Html::submit(__('Delete Card'))->class('btn btn-danger') !!}
{!! Html::form()->close() !!}
</div>
@endif

{!! Html::form('POST', route('app.cards.store', $card))
->open() !!}
    {!! Html::token() !!}
    <section class="row">
        <div class="col-3">
            <label>{{__('Name')}}</label>
            {!! Html::text('name')
                ->class('form-control')
                ->placeholder('Name')
                ->value($card->name)
                ->required() !!}
        </div>

        <div class="col-3">
            <label>{{__('Closing Day')}}</label>
            {!! Html::number('closed_day', $card->closed_day, 1, 31)
                ->class('form-control')
                ->placeholder('Closing Day')
                ->required() !!}
        </div>

        <div class="col-3">
               {!! Html::submit(__('Save'))->class('btn btn-primary') !!}
        </div>
</section>
{!! Html::form()->close() !!}

@endsection