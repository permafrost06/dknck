@extends('layouts.admin')
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[]" active="ZPL Code" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-medium">Print ZPL Code</h3>
        </div>
        <form id="zpl-code-form" class="p-6">
            <div class="space-y-4">
                <div class="space-y-4">
                    <x-form.input label="ID" name="id" />
                    <x-form.input label="Name" name="name" />
                    <x-form.input type="number" min="0" step="0.01" label="Price" name="price" />
                    <x-form.input type="number" min="0" label="Copies" name="copies" />
                </div>
                <x-button type="submit" class="my-4">
                    Print
                </x-button>
        </form>
    </x-cards.card>
@endsection
