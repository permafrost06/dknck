@extends('layouts.admin')
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[
            [
                'link' => route('customers.index'),
                'label' => 'Customers',
            ],
        ]" :active="$customer ? 'Add' : 'Update'" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-semibold">{{ $customer ? 'Update' : 'Add New' }} Customer</h3>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center px-3 py-1.5 bg-skin-accent focus:ring ring-skin-accent hover:bg-skin-accent-hover text-skin-inverted uppercase font-semibold text-xs rounded">
                View All
            </a>
        </div>
        <form action="{{ route('customers.store') }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <x-form.alert />
                <x-form.input label="ID" name="customers_id" :value="old('customers_id', $customer?->customers_id)" placeholder="Enter customers id" />

                <x-form.input label="Name" name="name" :value="old('name', $customer?->name)" placeholder="Customer name"/>

                <x-form.input label="Address" name="address" :value="old('address', $customer?->address)" placeholder="Address"/>

                <x-form.input label="Limit" type="number" min="0" name="limit" :value="old('limit', $customer?->limit)" />

                <x-form.select label="Select Type" name="type">
                    <option @selected(old('type', $customer?->type === '1')) value="1">Bongo Bajar</option>
                    <option @selected(old('type', $customer?->type === '2')) value="2">Anexco</option>
                    <option @selected(old('type', $customer?->type === '3')) value="3">Others</option>
                </x-form.select>
            </div>
            <x-button type="submit" class="my-4">
                Create
            </x-button>
        </form>
    </x-cards.card>
@endsection
