@extends('layouts.admin')

@section('head')
    <script>
        const SALES_API_LINK = "{{ route('sales.api', ['id' => $customer?->id]) }}";
        const SALE_EDIT_LINK = "{{ route('sales.edit', ['id' => '::ID::']) }}";
        const SALE_DELETE_LINK = "{{ route('sales.delete', ['id' => '::ID::']) }}";
        const CSRF = "{{ csrf_token() }}";
    </script>
    @vite(['resources/js/pages/admin/sales.js'])
@endsection

@section('page')
    <div class="mb-6 text-gray-600">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" active="Sales" />
    </div>
    <x-cards.card>
        <div class="flex items-center px-6 py-3 border-b">
            <h3 class="flex-grow text-lg text-gray-600 font-semibold">Sales Ledger</h3>
            <a class="inline-flex items-center px-3 py-1.5 bg-skin-success bg-opacity-90 focus:ring ring-skin-success hover:bg-opacity-100 text-skin-inverted uppercase font-semibold text-xs rounded mr-2"
                href="{{ route('sales.generatePDF', ['id' => $customer?->id]) }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="12" height="12" viewBox="0 0 20 20">
                    <path fill="currentColor" d="M13 8V2H7v6H2l8 8l8-8h-5zM0 18h20v2H0v-2z" />
                </svg> PDF
            </a>
            <a class="inline-flex items-center px-3 py-1.5 bg-skin-accent focus:ring ring-skin-accent hover:bg-skin-accent-hover text-skin-inverted uppercase font-semibold text-xs rounded"
                href="{{ route('sales.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 12 12">
                    <path fill="currentColor"
                        d="M6.5 1.75a.75.75 0 0 0-1.5 0V5H1.75a.75.75 0 0 0 0 1.5H5v3.25a.75.75 0 0 0 1.5 0V6.5h3.25a.75.75 0 0 0 0-1.5H6.5V1.75Z" />
                </svg> Add
            </a>
        </div>
        @if ($details)
            <div class="w-full mx-auto m-5 max-w-sm lg:max-w-max bg-skin-foreground border rounded-lg">
                <div class="flex flex-col lg:flex-row items-center justify-center">
                    <div class="px-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 rounded-full shadow-sm"
                            viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path
                                    d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z" />
                                <path fill="currentColor"
                                    d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2ZM8.5 9.5a3.5 3.5 0 1 1 7 0a3.5 3.5 0 0 1-7 0Zm9.758 7.484A7.985 7.985 0 0 1 12 20a7.985 7.985 0 0 1-6.258-3.016C7.363 15.821 9.575 15 12 15s4.637.821 6.258 1.984Z" />
                            </g>
                        </svg>
                        <h5 class="mb-1 text-xl font-medium text-gray-900">{{ $customer->name }}</h5>
                        <span class="text-sm">Customer ID: {{ $customer->id }}</span>
                    </div>
                    <ul
                        class="w-full divide-y text-sm border-t mt-4 lg:border-t-0 lg:border-l lg:mt-0 lg:min-w-xs">
                        <li class="px-6 py-2.5 flex justify-between items-center">
                            <h6 class="font-medium mr-4">Limit:</h6>
                            <p class="text-lg font-bold">{{ $customer->limit }}</p>
                        </li>
                        <li class="px-6 py-2.5 flex justify-between items-center">
                            <h6 class="font-medium mr-4">Total LV:</h6>
                            <p class="text-lg font-bold">{{ $details->lv }}</p>
                        </li>
                        <li class="px-6 py-2.5 flex justify-between items-center">
                            <h6 class="font-medium mr-4">Goods of Issues:</h6>
                            <p class="text-lg font-bold">{{ $details->goods_of_issues }}</p>
                        </li>
                        <li class="px-6 py-2.5 flex justify-between items-center">
                            <h6 class="font-medium mr-4">Balance Due:</h6>
                            <p class="text-lg font-bold">{{ $details->balance_due }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
        <div class="px-6 py-3" id="vue-app"></div>
    </x-cards.card>
@endsection
