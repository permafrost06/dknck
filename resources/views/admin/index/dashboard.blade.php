@extends('layouts.admin')
@section('head')
    <script>
        const ITEMS_API_LINK = "{{ route('items.api') }}";
        const ITEM_EDIT_LINK = "{{ route('items.edit', ['id' => '::ID::']) }}";
        const ITEM_DELETE_LINK = "{{ route('items.delete', ['id' => '::ID::']) }}";
        
        const SALES_API_LINK = "{{ route('sales.api') }}";
        const SALE_EDIT_LINK = "{{ route('sales.edit', ['id' => '::ID::']) }}";
        const SALE_DELETE_LINK = "{{ route('sales.delete', ['id' => '::ID::']) }}";

        const CSRF = "{{ csrf_token() }}";
    </script>
    @vite(['resources/js/pages/admin/dashboard.js'])
@endsection
@section('page')
    <div class="mb-6 text-gray-600">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin Panel',
        ]" :items="[]" active="" />
    </div>
    <x-cards.card>
        <div class="px-6 py-3" id="items-table"></div>
    </x-cards.card>
@endsection
