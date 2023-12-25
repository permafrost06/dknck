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
        <form id="zpl-code-form" method="POST" action="{{ route('zpl.static') }}" class="p-6">
            @csrf
            <x-form.alert />
            <div class="space-y-4">
                <div class="space-y-4">
                    <x-form.input label="ID" name="id" :value="old('id')" />
                    <x-form.input label="Name" name="name" :value="old('name')" />
                    <x-form.input type="number" min="0" step="0.01" label="Price" name="price"
                        :value="old('price')" />
                    <x-form.input type="number" min="0" label="Copies" name="quantity" :value="old('quantity')" />
                </div>
                <x-button type="submit" class="my-4" id="zpl-code-form-btn">
                    Print
                </x-button>
        </form>
    </x-cards.card>
    @if (Session::has('zpl-code'))
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
            printZpl(`{!! str_replace('`', '\\`', Session::get('zpl-code')) !!}`);
        </script>
    @endif
@endsection
