@extends('layout')

@section('content')
@include('partials._search')

<a href="{{ url()->previous() }}" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i> Back</a>
<div class="mx-4">
    <x-card class="p-10">
        <div class="flex flex-col items-center justify-center text-center">
            {{-- <img class="w-48 mr-6 mb-6" src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('images/acme.png') }}" alt=""/> --}}

            <h3 class="text-2xl mb-2">{{ $listing->title }}</h3>
            <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>

            <x-listing-tags :tagsCsv="$listing->tags" />

            <div class="text-lg my-4">
                 {{ $listing->location }}
            </div>

            <div class="border border-gray-200 w-full mb-6"></div>
            <div>
                <h3 class="text-3xl font-bold mb-4"> All Prices</h3>
                <div class="text-lg space-y-6">
                    @foreach ($prices as $item)
                        Owner : {{ $item->rel_to_user->name }} | Prices : {{ $item->amount }}  | <br>
                    @endforeach
                </div>
            </div>
        </div>
    </x-card>
    @unless (auth()->user()->id != $listing->user_id)
        <x-card class="mt-4 p-2 flex space-x-6">
            <a href="/listings/{{ $listing->id }}/edit"><i class="fa-solid fa-pencil"></i> Edit</a>
            <form action="/listings/{{ $listing->id }}" method="post">
                @csrf
                @method('DELETE')
                <button class="text-red-500"><i class="fa-solid fa-trash"></i> Delete</button>
            </form>
        </x-card>
    @endunless
</div>

@endsection
