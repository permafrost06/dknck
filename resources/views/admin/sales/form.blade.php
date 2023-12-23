@extends('layouts.admin')
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[
            [
                'link' => route('sales.index'),
                'label' => 'Sales',
            ],
        ]" :active="$sale ? 'Update' : 'Create'" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-medium">{{ $sale ? 'Update' : 'Add New' }} Deposit</h3>
            <a class="inline-flex items-center px-3 py-1.5 bg-skin-accent focus:ring ring-skin-accent hover:bg-skin-accent-hover text-skin-inverted uppercase font-semibold text-xs rounded"
                href="{{ route('sales.index') }}">
                View All
            </a>
        </div>
        <form action="{{ route('sales.store', ['id' => $sale?->id]) }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                @csrf
                <x-form.alert />
                @csrf
                <div class="space-y-4">
                    <x-form.select label="Customer" name="customer_id">
                        @foreach ($customers as $customer)
                            <option @selected(old('customer_id', $sale?->customer_id) === $customer->id) value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </x-form.select>

                    <x-form.input type="date" label="Date" name="date" :value="old('date', $sale?->date)" />
                    <x-form.input label="Memo Number" name="memo_number" :value="old('memo_number', $sale?->memo_number)" />
                    <x-form.input type="number" label="G O Issues" name="goods_of_issues" :value="old('goods_of_issues', $sale?->goods_of_issues)"  placeholder=" "/>
                    <x-form.input label="LV" type="number" step="0.01" name="lv" :value="old('lv', $sale?->lv)" />

                    <x-form.input type="number" min="0" step="0.01" label="Received Money" name="received_money"
                        :value="old('received_money', $sale?->received_money)" />
                    <x-form.input type="number" min="0" step="0.01" label="Balance (DUE)" name="balance_due"
                        :value="old('balance_due', $sale?->balance_due)" />
                    <x-form.textarea label="Comment" name="comment">{{ old('comment', $sale?->comment) }}</x-form.textarea>
                </div>
                <x-button type="submit" class="my-4">
                    {{ $sale ? 'Update' : 'Add' }}
                </x-button>
        </form>
    </x-cards.card>
@endsection
