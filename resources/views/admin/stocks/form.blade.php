@extends('layouts.admin')
@section('head')
    @vite('resources/js/pages/admin/stock_form.js')
@endsection
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[
            [
                'link' => route('stocks.status'),
                'label' => 'Stock',
            ],
        ]" :active="$stock ? 'Update' : 'Insert'" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-3 border-b px-6">
            <h3 class="flex-grow font-semibold">{{ $stock ? 'Update Stock' : 'Insert Stock' }}</h3>
            <a href="{{ route('stocks.status') }}"
                class="bg-skin-accent focus:ring ring-skin-accent hover:bg-skin-accent-hover text-skin-inverted text-xs px-2 py-1.5 rounded-md">
                View All
            </a>
        </div>
        <form action="{{ route('stocks.store', ['stock' => $stock?->id ?? 'add']) }}" method="POST" class="p-6"
            enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">

                <x-form.alert />

                <div>
                    <label class="mb-2 ml-1 font-bold text-xs">Stock Type</label>
                    <div
                        class="text-sm flex w-full rounded-lg border border-solid px-3 py-2">
                        <div class="flex items-center mr-4">
                            <input id="type-in" type="radio" value="in" name="type" @checked(old('type', $stock?->type === 'in'))
                                class="w-4 h-4 text-skin-accent bg-skin-neutral bg-opacity-5 focus:ring-skin-accent focus:ring-2">
                            <label for="type-in" class="ml-2 font-medium">In</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="type-out" type="radio" value="out" name="type" @checked(old('type', $stock?->type === 'out'))
                                class="w-4 h-4 text-skin-accent bg-skin-neutral bg-opacity-5 focus:ring-skin-accent focus:ring-2">
                            <label for="type-out" class="ml-2 font-medium">Out</label>
                        </div>
                    </div>
                    @if ($errors->has('type'))
                        <label class="text-xs leading-normal mt-0 text-skin-danger">
                            {{ $errors->first('type') }}
                        </label>
                    @endif
                </div>

                <x-form.input type="datetime-local" step="60" label="Date & Time" name="date_time"
                    value="{{ old('date_time', date('Y-m-d H:i', $stock?->date_time ? strtotime($stock?->date_time) : time())) }}" />

                <div>
                    <x-form.input label="Item Code" name="item_code" autocomplete="off"
                        value="{{ old('item_code', $stock?->item_code) }}" list="items-list" />

                    <datalist id="items-list">
                        @foreach ($item_codes as $item)
                            <option value="{{ $item }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <x-form.input label="Brand" name="brand" list="brands-list" autocomplete="off"
                        value="{{ old('brand', $stock?->brand) }}" />
                    <datalist id="brands-list">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <x-form.input type="number" label="Quantity" name="quantity" :value="old('quantity', $stock?->quantity)" />

                <x-form.input type="number" label="Per Unit Cost" name="unit_cost" :value="old('unit_cost', $stock?->unit_cost)" />

                <x-form.input type="number" label="Adjustment" name="adjustment" :value="old('adjustment', $stock?->adjustment)" />


                <div>
                    <x-form.input id="merchant_name" :label="old('type', $stock?->type) == 'out' ? 'Buyer Name' : 'Supplier Name'" name="merchant_name" list="merchants-list"
                        autocomplete="off" placeholder="" :value="old('merchant_name', $stock?->merchant_name)" />
                    <datalist id="merchants-list">
                        @foreach ($merchant_names as $merchant)
                            <option value="{{ $merchant }}"></option>
                        @endforeach
                    </datalist>
                </div>


                <div>
                    <x-form.input id="merchant_contact" :label="old('type', $stock?->type) == 'out' ? 'Buyer Contact' : 'Supplier Contact'" name="merchant_contact"
                        list="merchant_contacts-list" autocomplete="off" placeholder="" :value="old('merchant_contact', $stock?->merchant_contact)" />
                    <datalist id="merchant_contacts-list">
                        @foreach ($merchant_contacts as $merchant_contact)
                            <option value="{{ $merchant_contact }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <div @class([
                    'space-y-4 overflow-hidden',
                    'hidden' => old('type', $stock?->type) === 'out',
                ]) id="in-group">

                    <div>
                        <x-form.input id="carrier_name" label="Carrier Name" name="carrier_name" list="carrier_names-list"
                            autocomplete="off" :value="old('carrier_name', $stock?->carrier_name)" />
                        <datalist id="carrier_names-list">
                            @foreach ($carrier_names as $carrier_name)
                                <option value="{{ $carrier_name }}"></option>
                            @endforeach
                        </datalist>
                    </div>


                    <div>
                        <x-form.input id="carrier_contact" label="Carrier Contact" name="carrier_contact"
                            list="carrier_contacts-list" autocomplete="off" :value="old('carrier_contact', $stock?->carrier_contact)" />
                        <datalist id="carrier_contacts-list">
                            @foreach ($carrier_contacts as $carrier_contact)
                                <option value="{{ $carrier_contact }}"></option>
                            @endforeach
                        </datalist>
                    </div>



                    <div>
                        <x-form.input label="Border" name="border" list="borders-list" autocomplete="off"
                            value="{{ old('border', $stock?->border) }}" />
                        <datalist id="borders-list">
                            @foreach ($borders as $border)
                                <option value="{{ $border }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium" for="file_input">Attachment</label>
                    <div class="text-sm rounded-lg border border-solid px-3 py-5 text-gray-700">
                        <input type="file" name="attachment" id="file_input" class="hidden" />
                        <svg class="text-skin-accent w-24 mb-4 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <div class="flex justify-center gap-10">
                            <label for="file_input"
                                class="rounded-md shadow bg-skin-accent hover:bg-skin-accent-hover text-skin-inverted uppercase font-medium px-4 py-2.5 cursor-pointer">Select</label>
                            <button type="button" id="preview-attachment" data-old="{{$stock?->attachment}}"
                                @class(["rounded-md shadow bg-skin-foreground hover:bg-skin-neutral hover:bg-opacity-10 text-skin-secondary uppercase font-medium px-4 py-2.5 cursor-pointer", "hidden" => !$stock?->attachment])>Preview</button>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-skin-secondary" id="file_input_help">PNG, JPG or PDF</p>

                </div>
                <x-form.textarea label="Remarks" name="remarks">{{ old('remarks', $stock?->remarks) }}</x-form.textarea>
            </div>
            <x-button type="submit" class="my-4">
                {{ $stock ? 'Update' : 'Add' }}
            </x-button>
        </form>
    </x-cards.card>
    <div id="attachment-modal" class="fixed z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full bg-black bg-opacity-30 justify-center items-center">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-skin-foreground rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Stock Attachment
                    </h3>
                    <button type="button"
                        class="text-skin-secondary bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex gap-2 border-b text-sm">
                    <button class="py-3 px-6 border-b-2 border-skin-accent" id="old-att-btn" type="button">Old</button>
                    <button class="py-3 px-6 border-skin-accent" type="button" id="new-att-btn">New</button>
                </div>
                <div class="h-[60vh]">
                    @if($stock?->attachment)
                        @if(str_ends_with($stock->attachment, '.pdf'))
                        <iframe class="h-full w-full" id="old-attachment" src="{{$stock->attachment}}" frameborder="0"></iframe>
                        @else
                        <img id="old-attachment" src="{{$stock->attachment}}" alt="" class="h-full w-full object-contain" />
                        @endif
                    @else
                        <p id="old-attachment" class="p-6">No attachment!</p>
                    @endif
                    <div id="new-attachment" class="hidden h-full">
                        <p class="p-6">No attachment!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
