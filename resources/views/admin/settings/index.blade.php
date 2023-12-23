@extends('layouts.admin')
@section('page')
    <div class="mb-6">
        <x-breadcrumb :home="[
            'route' => 'admin.index',
            'label' => 'Admin',
        ]" :items="[]" active="Settings" />
    </div>
    <x-cards.card class="max-w-4xl">
        <div class="flex items-center py-2 border-b px-6">
            <h3 class="flex-grow font-medium">Settings</h3>
        </div>
        <form action="{{ route('settings.set') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                @csrf
                <x-form.alert />
                @csrf
                <div class="space-y-4">
                    <x-form.textarea label="Print Layout" name="print_layout" placeholder=" " rows="10">{{old('print_layout', $settings['print_layout']??'')}}</x-form.textarea>
                </div>
                <x-button type="submit" class="my-4"> Save </x-button>
        </form>
    </x-cards.card>
@endsection
