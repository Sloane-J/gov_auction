<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="shopping-bag" :href="route('auctions.index')" :current="request()->routeIs('auctions.*')" wire:navigate>
                        {{ __('Browse Auctions') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="bookmark" :href="route('watchlist')" :current="request()->routeIs('watchlist')" wire:navigate>
                        {{ __('Watchlist') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="banknotes" :href="route('my-bids')" :current="request()->routeIs('my-bids')" wire:navigate>
                        {{ __('My Bids & Won') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="bell" :href="route('notifications')" :current="request()->routeIs('notifications')" wire:navigate>
                        {{ __('Notifications') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                @if(auth()->check() && auth()->user()->role === 'bidder')
                    <flux:sidebar.group :heading="__('Bidder')" class="grid mt-4">
                        <flux:sidebar.item icon="credit-card" :href="route('payment-history')" :current="request()->routeIs('payment-history')" wire:navigate>
                            {{ __('Payment History') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif

                @if(auth()->check() && auth()->user()->role === 'officer')
                    <flux:sidebar.group :heading="__('Officer')" class="grid mt-4">
                        <flux:sidebar.item icon="cog" :href="route('officer.auctions')" :current="request()->routeIs('officer.auctions')" wire:navigate>
                            {{ __('Manage Auctions') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="chart-bar" :href="route('officer.analytics')" :current="request()->routeIs('officer.analytics')" wire:navigate>
                            {{ __('Auction Analytics') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <flux:sidebar.group :heading="__('Admin')" class="grid mt-4">
                        <flux:sidebar.item icon="banknotes" :href="route('admin.bids')" :current="request()->routeIs('admin.bids')" wire:navigate>
                            {{ __('Bid Monitoring') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="credit-card" :href="route('admin.payments')" :current="request()->routeIs('admin.payments')" wire:navigate>
                            {{ __('Payments') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="chart-pie" :href="route('my-bids')" :current="request()->routeIs('my-bids')" wire:navigate>
                            {{ __('Reports') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="clipboard-document-check" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                            {{ __('Auction Moderation') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="user-minus" :href="route('my-bids')" :current="request()->routeIs('my-bids')" wire:navigate>
                            {{ __('Suspend Users') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <!-- Notifications Bell -->
            <flux:dropdown align="end" offset="8">
                <x-slot name="trigger">
                    <flux:button icon="bell" variant="ghost" size="sm" class="relative hover:bg-zinc-100/50 dark:hover:bg-zinc-800/50 transition-colors">
                        @if($unreadCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-lime-500 shadow-[0_0_8px_rgba(132,204,22,0.6)] text-[10px] font-bold text-zinc-900 leading-none ring-2 ring-white dark:ring-zinc-900">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </flux:button>
                </x-slot>

                <div class="w-80 sm:w-96 rounded-xl border border-zinc-200/50 dark:border-zinc-700/50 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-xl shadow-2xl overflow-hidden flex flex-col max-h-[32rem]">
                    <!-- Dropdown Header -->
                    <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-200/50 dark:border-zinc-700/50 bg-zinc-50/50 dark:bg-zinc-800/50">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notifications</h3>
                        @if($unreadCount > 0)
                            <button wire:click="markAllAsRead" class="text-xs font-medium text-lime-600 dark:text-lime-400 hover:text-lime-700 dark:hover:text-lime-300 transition-colors">
                                Mark all read
                            </button>
                        @endif
                    </div>

                    <!-- Notification List (Infinite Scroll Container) -->
                    <div class="overflow-y-auto overscroll-contain flex-1">
                        @forelse($notifications as $notification)
                            <a href="{{ route('notifications') }}"
                               class="block px-4 py-3.5 border-b border-zinc-100/50 dark:border-zinc-800/50 last:border-0 hover:bg-zinc-50/80 dark:hover:bg-zinc-800/80 transition-all {{ $notification->read_at ? 'opacity-75' : 'bg-lime-50/30 dark:bg-lime-900/10' }}">
                                <div class="flex gap-3 items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        @if(!$notification->read_at)
                                            <span class="block h-2 w-2 rounded-full bg-lime-500 shadow-[0_0_6px_rgba(132,204,22,0.6)]"></span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2 leading-relaxed">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                        <p class="text-[11px] font-medium text-zinc-400 mt-1.5">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100/50 dark:bg-zinc-800/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">All clear</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">No new notifications</p>
                            </div>
                        @endforelse

                        <!-- Infinite Scroll Trigger for Livewire -->
                        @if($notifications->isNotEmpty())
                            <div x-intersect="$wire.loadMoreNotifications" class="h-8 flex items-center justify-center py-2">
                                <div wire:loading wire:target="loadMoreNotifications" class="w-4 h-4 rounded-full border-2 border-lime-500 border-t-transparent animate-spin"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </flux:dropdown>

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
