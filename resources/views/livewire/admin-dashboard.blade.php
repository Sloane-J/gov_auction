<div class="container mx-auto px-4 py-8">
    <flux:heading size="xl" level="1" class="mb-2">Admin Dashboard</flux:heading>
    <flux:subheading size="lg" class="mb-8">Manage users, moderate auctions, and view system reports.</flux:subheading>

    @if (session()->has('message'))
        <flux:toast variant="success" class="mb-6">{{ session('message') }}</flux:toast>
    @endif

    <div class="mb-6 flex flex-wrap gap-2 border-b border-zinc-200 dark:border-zinc-700">
    <button wire:click="$set('activeTab', 'overview')"
        class="px-4 py-2 text-sm font-medium border-b-2 transition {{ $activeTab === 'overview' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
        Overview
    </button>
    <button wire:click="$set('activeTab', 'users')"
        class="px-4 py-2 text-sm font-medium border-b-2 transition {{ $activeTab === 'users' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
        Users
    </button>
    <button wire:click="$set('activeTab', 'auctions')"
        class="px-4 py-2 text-sm font-medium border-b-2 transition {{ $activeTab === 'auctions' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
        Auctions
    </button>
    <button wire:click="$set('activeTab', 'categories')"
        class="px-4 py-2 text-sm font-medium border-b-2 transition {{ $activeTab === 'categories' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
        Categories
    </button>
</div>

@if($activeTab === 'overview')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="rounded-lg bg-blue-100 dark:bg-blue-900/40 p-3 text-blue-600 dark:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Total Users</div>
                <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['total_users']) }}</div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="rounded-lg bg-indigo-100 dark:bg-indigo-900/40 p-3 text-indigo-600 dark:text-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Total Auctions</div>
                <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['total_auctions']) }}</div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="rounded-lg bg-green-100 dark:bg-green-900/40 p-3 text-green-600 dark:text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Total Revenue</div>
                <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($stats['total_revenue'], 2) }}</div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="rounded-lg bg-orange-100 dark:bg-orange-900/40 p-3 text-orange-600 dark:text-orange-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.25 10.5 3 3m0 0 3-3m-3 3V1.5" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Total Bids</div>
                <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['total_bids']) }}</div>
            </div>
        </div>
    </div>
</div>
@endif

@if($activeTab === 'users')
    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                <select wire:change="changeRole({{ $user->id }}, $event.target.value)" class="text-sm rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="bidder" {{ $user->role === 'bidder' ? 'selected' : '' }}>Bidder</option>
                                    <option value="officer" {{ $user->role === 'officer' ? 'selected' : '' }}>Officer</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if(auth()->id() !== $user->id)
                                    <button wire:click="suspendUser({{ $user->id }})" wire:confirm="Are you sure you want to suspend this user?" class="text-orange-600 dark:text-orange-400 hover:text-orange-800">Suspend</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $users->links() }}
        </div>
    </div>
@endif

@if($activeTab === 'auctions')
    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Auction</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Creator</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($auctions as $auction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                <a href="{{ route('auctions.show', $auction->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ Str::limit($auction->title, 30) }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $auction->creator->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                <select wire:change="updateAuctionStatus({{ $auction->id }}, $event.target.value)" class="text-sm rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 focus:ring-blue-500 focus:border-blue-500">
    <option value="draft" {{ $auction->status === 'draft' ? 'selected' : '' }}>Draft</option>
    <option value="active" {{ $auction->status === 'active' ? 'selected' : '' }}>Active</option>
    <option value="closed" {{ $auction->status === 'closed' ? 'selected' : '' }}>Closed</option>
    <option value="suspended" {{ $auction->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
</select>
@if($auction->status === 'suspended' && $auction->suspension_reason)
    <p class="text-xs text-red-500 dark:text-red-400 mt-1">Reason: {{ $auction->suspension_reason }}</p>
@endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">${{ number_format($auction->current_price ?: $auction->starting_price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="$set('suspendingAuctionId', {{ $auction->id }})" class="text-orange-600 dark:text-orange-400 hover:text-orange-800 ml-4">Suspend</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($suspendingAuctionId)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Suspend Auction</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">Optionally provide a reason. This will be visible on the auction page.</p>
            <textarea wire:model="suspensionReason" rows="3" placeholder="Reason (optional)" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-4"></textarea>
            <div class="flex justify-end gap-3">
                <button wire:click="cancelSuspend" class="rounded-md border border-zinc-300 dark:border-zinc-600 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800">Cancel</button>
                <button wire:click="confirmSuspend" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Suspend Auction</button>
            </div>
        </div>
    </div>
@endif
        </div>
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $auctions->links() }}
        </div>
    </div>
@endif

@if($activeTab === 'categories')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-1 rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Add Category</h3>
            <form wire:submit.prevent="createCategory" class="space-y-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Category Name</label>
                    <input wire:model="newCategoryName" type="text" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Vehicles" required />
                </div>
                <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Create Category</button>
            </form>
        </div>
        <div class="md:col-span-2 rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Auctions</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $category->auctions_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="deleteCategory({{ $category->id }})" wire:confirm="Delete this category?" class="text-red-600 dark:text-red-400 hover:text-red-800">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
</div>
