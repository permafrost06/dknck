@extends('layouts.admin')
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[
            [
                'link' => route('vendor.index'),
                'label' => 'Vendors',
            ],
        ]" :active="$vendor ? 'Update' : 'Insert'" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-medium">{{ $vendor ? 'Update Vendor' : 'Insert Vendor' }}</h3>
            <a href="{{ route('vendor.index') }}"
                class="inline-flex items-center px-3 py-1.5 bg-skin-accent focus:ring ring-skin-accent hover:bg-skin-accent-hover text-skin-inverted uppercase font-semibold text-xs rounded">
                View All
            </a>
        </div>
        <form action="{{ route('vendor.store', ['id' => $vendor?->id]) }}" method="POST" class="p-6"
            enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">

                <x-form.alert />

                <x-form.input type="text" label="Name" name="name" value="{{ old('name', $vendor?->name) }}"
                    placeholder="Vendor name" />

                <x-form.textarea label="Address" name="address" placeholder="Vendor address">
                    {{ old('address', $vendor?->address) }}</x-form.textarea>

                <x-form.input type="number" min="0" label="Limit" name="limit"
                    value="{{ old('limit', $vendor?->limit) }}" />

            </div>
            <x-button type="submit" class="my-4">
                {{ $vendor ? 'Update' : 'Add' }}
            </x-button>
        </form>
    </x-cards.card>
@endsection
