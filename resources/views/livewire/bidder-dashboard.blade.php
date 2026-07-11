<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-zinc-600 dark:text-zinc-400">Here's your auction overview.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-900/30 px-4 py-3 text-sm text-green-700 dark:text-green-400">
            {{ session('message') }}
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-6 shadow-sm transition ">
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Active Bids</p>
            <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['active_bids_count'] }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-6 shadow-sm transition ">
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Won (Unpaid)</p>
            <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['won_unpaid_count'] }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-6 shadow-sm transition ">
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Watchlist</p>
            <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['watchlist_count'] }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-6 shadow-sm transition ">
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Total Spent</p>
            <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">
                ${{ number_format($stats['total_spent'], 2) }}
            </p>
        </div>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-sm">
    <div class="flex items-center justify-between p-6 border-b border-zinc-200 dark:border-zinc-700">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Your Auction Activity</h2>
        <div class="flex items-center gap-3">
            <!-- Sort Dropdown -->
            <div class="relative" x-data="{ open: false, sort: '{{ request('sort', 'newest') }}' }">
                <button @click="open = !open" class="">
                    <span x-text="sort === 'newest' ? 'Newest' : sort === 'oldest' ? 'Oldest' : sort === 'price_high' ? 'Price: High' : 'Price: Low'"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-1 w-40 rounded-md border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-lg z-10">
                    <button @click="sort = 'newest'; open = false; $wire.setSort('newest')" class="block w-full px-4 py-2 text-left text-sm text-zinc-700 dark:text-zinc-300  ">Newest</button>
                    <button @click="sort = 'oldest'; open = false; $wire.setSort('oldest')" class="block w-full px-4 py-2 text-left text-sm text-zinc-700 dark:text-zinc-300  ">Oldest</button>
                    <button @click="sort = 'price_high'; open = false; $wire.setSort('price_high')" class="block w-full px-4 py-2 text-left text-sm text-zinc-700 dark:text-zinc-300  ">Price: High to Low</button>
                    <button @click="sort = 'price_low'; open = false; $wire.setSort('price_low')" class="block w-full px-4 py-2 text-left text-sm text-zinc-700 dark:text-zinc-300  ">Price: Low to High</button>
                </div>
            </div>
        </div>
    </div>

    @if (empty($all_items) || count($all_items) === 0)
        <div class="text-center py-12">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <p class="text-base font-medium text-zinc-600 dark:text-zinc-400">No auction activity yet.</p>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-500">Start bidding or add auctions to your watchlist.</p>
            <a href="{{ route('auctions.index') }}" class="inline-block mt-4 rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white ">
                Browse Auctions
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">Item</th>
                        <th class="px-6 py-3 font-medium">Type</th>
                        <th class="px-6 py-3 font-medium">Amount</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">End Date</th>
                        <th class="px-6 py-3 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach ($all_items as $item)
                        <tr class=" /50 transition">
                            <!-- Item -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-sm bg-zinc-100 dark:bg-zinc-800">
                                        @if($item['auction']->images->count() > 0)
                                            <img src="{{ Storage::url($item['auction']->images->first()->image_path) }}" alt="{{ $item['auction']->title }}" class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full items-center justify-center text-zinc-400 dark:text-zinc-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('auctions.show', $item['auction']) }}" class="text-sm font-semibold text-zinc-900 dark:text-zinc-100  line-clamp-1">
                                            {{ $item['auction']->title }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Type -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item['type'] === 'active_bid')
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                        Active Bid
                                    </span>
                                @elseif ($item['type'] === 'won')
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                        Won
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-400">
                                        Watchlist
                                    </span>
                                @endif
                            </td>

                            <!-- Amount -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item['type'] === 'active_bid')
                                    <div>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Your bid</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($item['user_bid'], 2) }}</p>
                                    </div>
                                @elseif ($item['type'] === 'won')
                                    <div>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Winning bid</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($item['auction']->current_price, 2) }}</p>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Current</p>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($item['auction']->current_price ?: $item['auction']->starting_price, 2) }}</p>
                                    </div>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item['type'] === 'active_bid')
                                    @if ($item['is_highest'])
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                            Highest
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                            Outbid
                                        </span>
                                    @endif
                                @elseif ($item['type'] === 'won')
                                    @if ($item['needs_payment'])
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400">
                                            Unpaid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                            Paid
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $item['auction']->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                        {{ ucfirst($item['auction']->status) }}
                                    </span>
                                @endif
                            </td>

                            <!-- End Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                @if ($item['type'] === 'watchlist')
                                    {{ $item['auction']->end_time->format('M d, Y H:i') }}
                                @elseif ($item['type'] === 'active_bid')
                                    {{ $item['auction']->end_time->format('M d, Y H:i') }}
                                @else
                                    @if ($item['payment'])
                                        Paid: {{ $item['payment']->updated_at->format('M d, Y') }}
                                    @else
                                        Ended: {{ $item['auction']->end_time->format('M d, Y') }}
                                    @endif
                                @endif
                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item['type'] === 'won' && $item['needs_payment'])
                                    <a href="{{ route('payment.checkout', $item['auction']) }}" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white ">
                                        Pay Now
                                    </a>
                                @elseif ($item['type'] === 'won' && !$item['needs_payment'])
                                    <a href="{{ route('receipt.show', $item['payment']) }}" class="text-sm text-blue-600 dark:text-blue-400 ">
                                        View Receipt
                                    </a>
                                @else
                                    <a href="{{ route('auctions.show', $item['auction']) }}" class="text-sm text-blue-600 dark:text-blue-400 ">
                                        View Auction
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($all_items instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-4">
                {{ $all_items->links() }}
            </div>
        @endif
    @endif
</div>

    <!-- Payment History Panel -->
    <div class="mt-8 rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-sm">
        <div class="flex items-center justify-between p-6 border-b border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Recent Payment History</h2>
            <a href="{{ route('payment-history') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 ">
                View all
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="p-6">
            @if ($payment_history->isEmpty())
                <div class="text-center py-8">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">No payment history.</p>
                </div>
            @else
                <div class="overflow-x-auto -mx-6">
                    <table class="w-full text-left">
                        <thead class="border-b border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                            <tr>
                                <th class="px-6 py-3 font-medium">Auction</th>
                                <th class="px-6 py-3 font-medium">Amount</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium">Date</th>
                                <th class="px-6 py-3 font-medium">Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach ($payment_history as $payment)
                                <tr class=" /50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('auctions.show', $payment->auction) }}" class="text-sm font-medium text-zinc-900 dark:text-zinc-100 ">{{ $payment->auction->title }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300">${{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $payment->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('receipt.show', $payment) }}" class="text-blue-600 dark:text-blue-400 ">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
