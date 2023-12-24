@extends('layouts.admin')
@section('head')
    <script>
        const PRODUCTS_API_LINK = "{{ route('products.api') }}";
        const PRODUCT_EDIT_LINK = "{{ route('products.edit', ['id' => '::ID::']) }}";
        const PRODUCT_DELETE_LINK = "{{ route('products.delete', ['id' => '::ID::']) }}";
        
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
        <div class="px-6 py-3" id="product-table"></div>
    </x-cards.card>
@endsection
