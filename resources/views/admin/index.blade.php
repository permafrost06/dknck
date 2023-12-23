@extends('layouts.admin')
@section('head')
    <script>
        const ITEMS_API_LINK = "{{ route('items.api') }}";
        const ITEM_EDIT_LINK = "{{ route('items.edit', ['id' => '::ID::']) }}";
        const ITEM_DELETE_LINK = "{{ route('items.delete', ['id' => '::ID::']) }}";
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
        <div class="flex items-center px-6 py-3 border-b">
            <h3 class="flex-grow text-lg text-gray-600 font-semibold">Stock Items</h3>
            <a class="inline-flex items-center px-3 py-1.5 bg-skin-accent focus:ring ring-skin-accent hover:bg-skin-accent-hover text-skin-inverted uppercase font-semibold text-xs rounded"
                href="{{ route('items.add') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 12 12">
                    <path fill="currentColor"
                        d="M6.5 1.75a.75.75 0 0 0-1.5 0V5H1.75a.75.75 0 0 0 0 1.5H5v3.25a.75.75 0 0 0 1.5 0V6.5h3.25a.75.75 0 0 0 0-1.5H6.5V1.75Z" />
                </svg> Add
            </a>
        </div>

        <div class="px-6 py-3" id="items-table"></div>
    </x-cards.card>
@endsection
