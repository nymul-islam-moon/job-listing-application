@props(['listing'])

<x-card>
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block" src="{{ $listing->logo ? asset('storage/app/' . $listing->logo) : asset('images/acme.png') }}" alt=""/>
        <div>
            <h3 class="text-2xl">
                <a href="/listings/{{ $listing->id }}">{{ $listing->title }}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>

            <x-listing-tags :tagsCsv="$listing->tags" />

            <div class="text-lg mt-4">
               {{ $listing->location }}
            </div>
        </div>
    </div>
</x-card>
