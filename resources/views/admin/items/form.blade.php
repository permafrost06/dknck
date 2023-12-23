@extends('layouts.admin')
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[]" :active="$item ? 'Update Item' : 'Add Item'" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-medium">{{ $item ? 'Update' : 'Add New' }} Item</h3>
        </div>
        <form action="{{ route('items.store', ['id' => $item?->id]) }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                @csrf
                <x-form.alert />
                @csrf
                <div class="space-y-4">

                    <x-form.input label="Name" name="name" :value="old('date', $item?->name)" />
                    <x-form.input label="Vendor" name="vendor" :value="old('date', $item?->vendor)" />

                    <x-form.input type="number" min="0" step="0.01" label="Buying Price (Unit)"
                        name="unit_price_buying" :value="old('unit_price_buying', $item?->unit_price_buying)" />

                    <x-form.input type="number" min="0" label="Quantity"
                        name="quantity" :value="old('quantity', $item?->quantity)" />
                    
                    <x-form.input type="date" label="Date" name="date" :value="old('date', $item?->date??date('Y-m-d'))" />
                        
                    <x-form.textarea label="Remarks" name="remarks" placeholder=" ">{{old('remarks', $item?->remarks)}}</x-form.textarea>

                </div>
                <x-button type="submit" class="my-4">
                    {{ $item ? 'Update' : 'Add' }}
                </x-button>
        </form>
    </x-cards.card>
@endsection
