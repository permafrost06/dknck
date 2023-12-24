@extends('layouts.admin')
@section('page')
<div class="mb-6">
    <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[]" :active="$product ? 'Update Product' : 'Add Product'" />
</div>
<x-cards.card class="max-w-4xl">
    <div class="flex items-center py-2 border-b px-6">
        <h3 class="flex-grow font-medium">{{ $product ? 'Update' : 'Add New' }} Product</h3>
    </div>
    <form action="{{ route('products.store', ['id' => $product?->id]) }}" method="POST" class="p-6">
        @csrf
        <div class="space-y-4">
            @csrf
            <x-form.alert />
            @csrf
            <div class="space-y-4">

                <x-form.input label="Name" name="name" :value="old('name', $product?->name)" />
                <x-form.input label="Vendor" name="vendor" :value="old('vendor', $product?->vendor)" />

                <x-form.input type="number" min="0" step="0.01" label="Buying Price (Unit)" name="unit_price_buying" :value="old('unit_price_buying', $product?->unit_price_buying)" />

                <x-form.input type="number" min="0" label="Quantity" name="quantity" :value="old('quantity', $product?->quantity)" />

                <x-form.input type="date" label="Date" name="date" :value="old('date', $product?->date??date('Y-m-d'))" />

                <x-form.textarea label="Remarks" name="remarks" placeholder=" ">{{old('remarks', $product?->remarks)}}</x-form.textarea>

            </div>
            <x-button type="submit" class="my-4">
                {{ $product ? 'Update' : 'Add' }}
            </x-button>
    </form>
</x-cards.card>
@if(Session::has("print_layout"))
<script>
    
    const printZpl = (zpl) => {
        var printWindow = window.open();
        printWindow.document.open('text/plain');
        printWindow.document.write(zpl);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
    printZpl(`{!!str_replace('`', '\\`', Session::get('print_layout'))!!}`);
</script>
@endif
@endsection