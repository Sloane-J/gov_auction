<div class="mx-auto max-w-7xl px-6 pb-20">
    @forelse($auctionsByCategory as $categoryName => $auctions)
        <section class="mb-16" aria-labelledby="category-{{ Str::slug($categoryName) }}">
            <div class="flex items-center justify-between mb-8">
                <h2 id="category-{{ Str::slug($categoryName) }}" class="text-2xl sm:text-3xl font-bold text-white">{{ $categoryName }}</h2>
                <a href="{{ route('auctions.index', ['category' => $categoryName]) }}" class="text-sm font-medium text-gray-400 hover:text-white transition">View All &rarr;</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($auctions as $auction)
                    <a href="{{ route('auctions.show', $auction) }}" class="group block rounded-2xl bg-gray-900 border border-gray-800 overflow-hidden hover:border-gray-600 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                        {{-- Image --}}
                        <div class="aspect-[4/3] bg-gray-800 overflow-hidden">
                            @if($auction->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $auction->images->first()->image_path) }}" alt="{{ $auction->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-600">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-white truncate group-hover:underline">{{ $auction->title }}</h3>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-sm text-gray-400">Current Bid</span>
                                <span class="text-lg font-bold text-white">${{ number_format($auction->current_price, 2) }}</span>
                            </div>
                            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="countdown-timer" data-end="{{ $auction->end_time->toIso8601String() }}">Ends {{ $auction->end_time->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @empty
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">No active auctions right now. Check back soon.</p>
        </div>
    @endforelse
</div>
