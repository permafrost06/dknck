@extends('layouts.admin')
@section('head')
<script>
    const ITEM_INFO_URL = '{{route("items.api.info", ["id"=>"::ID::"])}}';
</script>
@vite(['resources/js/pages/admin/sales-form.js'])
@endsection
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[]" :active="$sale ? 'Update Sale' : 'Add Sale'" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-medium">{{ $sale ? 'Update' : 'Add New' }} Sale</h3>
        </div>
        <form action="{{ route('sales.store', ['id' => $sale?->id]) }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                @csrf
                <x-form.alert />
                @csrf
                <div class="space-y-4">

                    <x-form.input label="Item ID" :readonly="!!$sale" autocomplete="off" id="item-id" name="item_id" :value="old('item_id', $sale?->item_id)" />

                    <p class="text-sm italic pl-2 !mt-0" id="item-info"></p>

                    <x-form.input type="number" min="0" step="0.01" label="Sale Price (Unit)"
                        name="sale_price" :value="old('sale_price', $sale?->sale_price)" />

                    <x-form.input type="number" min="0" label="Quantity"
                        name="quantity" :value="old('quantity', $sale?->quantity)" />

                </div>
                <x-button type="submit" class="my-4">
                    {{ $sale ? 'Update' : 'Add' }}
                </x-button>
        </form>
    </x-cards.card>
@endsection
