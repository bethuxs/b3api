<section class="mt-3">
    <h4>{{__('Item')}}</h4>
{!! Html::form('POST', route('app.invoices.item.store', [$invoice, $item]))->class('row')->open() !!}
<div class="col-4">
    {!! Html::text('name')
        ->value(old('name', $item->name ?? ''))
        ->required()
        ->placeholder(__('Nombre'))
        ->addClass('form-control' . ($errors->has('name') ? ' is-invalid' : '')) !!}
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-4">
        {!! Html::textarea('description')
            ->value(old('description', $item->description ?? ''))
            ->required()
            ->placeholder(__('Descripción'))
            ->addClass('form-control' . ($errors->has('description') ? ' is-invalid' : '')) !!}
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
</div>

<div class="col-2">
        {!! Html::input('number', 'quantity')
            ->value(old('quantity', $item->quantity ?? ''))
            ->required()
            ->placeholder(__('Cantidad'))
            ->addClass('form-control' . ($errors->has('quantity') ? ' is-invalid' : '')) !!}
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
</div>

<div class="col-2">
        {!! Html::input('number', 'price')
            ->value(old('price', $item->price ?? ''))
            ->required()
            ->placeholder(__('Precio'))
            ->addClass('form-control' . ($errors->has('price') ? ' is-invalid' : '')) !!}
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
</div>

   

<div class="text-center mt-3 col-12">
 {!! Html::submit(__('Save Item'))->class('btn btn-primary mt-3') !!}
</div>
{{ html()->form()->close() }}
</section>