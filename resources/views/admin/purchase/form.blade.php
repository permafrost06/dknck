@extends('layouts.admin')
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[
            [
                'link' => route('purchase.index'),
                'label' => 'Purchase',
            ],
        ]" :active="$purchase ? 'Update' : 'Create'" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-medium">{{ $purchase ? 'Update Purchase' : 'Add New Purchase' }}</h3>
            <a href="{{ route('purchase.index') }}" class="inline-flex items-center px-3 py-1.5 bg-skin-accent focus:ring ring-skin-accent hover:bg-skin-accent-hover text-skin-inverted uppercase font-semibold text-xs rounded">
                View All
            </a>
        </div>
        <form action="{{ route('purchase.store', ['id' => $purchase?->id]) }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                @csrf
                <x-form.alert />

                <x-form.select label="Vendor" name="vendor_id">
                    @foreach ($vendors as $vendor)
                        <option @selected(old('vendor_id', $purchase?->vendor_id) === $vendor->id) value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </x-form.select>

                <x-form.input type="date" label="Date" name="date" :value="old('date', $purchase?->date)" />

                <x-form.input label="Memo Number" name="memo_number" :value="old('memo_number', $purchase?->memo_number)" />
                    
                <x-form.input label="Quantity" name="quantity" :value="old('quantity', $purchase?->quantity)" />

                <x-form.input label="Mark" name="mark" :value="old('mark', $purchase?->mark)" />

                <x-form.input label="Ball" name="ball" :value="old('ball', $purchase?->ball)" />

                <x-form.input type="number" label="G O Issues" name="goods_of_issues" :value="old('goods_of_issues', $purchase?->goods_of_issues)" placeholder=" "/>

                <x-form.input type="number" min="0" step="0.01" label="Paid Money" name="paid_money"
                    :value="old('paid_money', $purchase?->paid_money)"  placeholder=" "/>

                <x-form.input type="number" min="0" step="0.01" label="Balance (DUE)" name="balance_due"
                    :value="old('balance_due', $purchase?->balance_due)"  placeholder=" "/>

                <x-form.textarea label="Comment" name="comment" placeholder=" ">{{old('comment', $purchase?->comment)}}</x-form.textarea>

            </div>
            <x-button type="submit" class="my-4">
                {{ $purchase ? 'Update' : 'Add' }}
            </x-button>
        </form>
    </x-cards.card>
@endsection
