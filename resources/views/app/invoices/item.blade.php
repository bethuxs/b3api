
    {!! Html::form('POST', route('app.invoices.item.store', [$invoice, $item]))->open() !!}
        {!! Html::text('name')
            ->value(old('name', $item->name ?? ''))
            ->required()
            ->placeholder(__('Nombre'))
            ->addClass('form-control' . ($errors->has('name') ? ' is-invalid' : '')) !!}
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        {!! Html::textarea('description')
            ->value(old('description', $item->description ?? ''))
            ->required()
            ->placeholder(__('Descripción'))
            ->addClass('form-control' . ($errors->has('description') ? ' is-invalid' : '')) !!}
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        {!! Html::input('number', 'quantity')
            ->value(old('quantity', $item->quantity ?? ''))
            ->required()
            ->placeholder(__('Cantidad'))
            ->addClass('form-control' . ($errors->has('quantity') ? ' is-invalid' : '')) !!}
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        {!! Html::input('number', 'price')
            ->value(old('price', $item->price ?? ''))
            ->required()
            ->placeholder(__('Precio'))
            ->addClass('form-control' . ($errors->has('price') ? ' is-invalid' : '')) !!}
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    {!! Html::submit(__('Guardar'))->class('btn btn-primary') !!}
{{ html()->form()->close() }}







    

