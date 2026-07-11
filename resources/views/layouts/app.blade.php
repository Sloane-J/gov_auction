<x-layouts::app.sidebar :title="$title ?? null">
    <x-slot name="header">
        <!-- Notifications Bell -->
        <flux:header class="px-4 py-2 border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
            <div class="flex justify-between items-center">
                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ now()->format('M d, Y') }}
                </div>
                <div class="flex items-center gap-4">
                    <flux:dropdown class="relative" align="end" placement="bottom" offset="2">
                        <x-slot name="trigger">
                            <flux:button
                                class="relative"
                                variant="filled"
                                size="sm"
                                icon="bell"
                                icon-only
                                aria-label="{{ auth()->user()->notifications()->whereNull('read_at')->count() > 0 ? 'You have unread notifications' : 'Notifications' }}"
                            >
                                @if(auth()->user()->notifications()->whereNull('read_at')->count() > 0)
                                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-zinc-900"></span>
                                @endif
                            </flux:button>
                        </x-slot>

                        <div class="w-80">
                            <div class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-3">
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notifications</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                    <a href="{{ route('notifications') }}"
                                       class="flex gap-2 border-b border-zinc-100 dark:border-zinc-800 p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $notification->read_at ? '' : 'bg-blue-50/60 dark:bg-blue-950/20' }}">
                                        <span class="mt-1.5 h-2 w-2 flex-shrink-0 rounded-full {{ $notification->read_at ? 'bg-transparent' : 'bg-blue-500' }}"></span>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1 line-clamp-2">{{ $notification->data['message'] ?? '' }}</p>
                                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                                        <flux:icon.bell class="mb-2 h-6 w-6 text-zinc-300 dark:text-zinc-600" />
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">You're all caught up</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">No notifications yet</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="border-t border-zinc-200 dark:border-zinc-700 px-4 py-3 text-center">
                                <a href="{{ route('notifications') }}" class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">View all</a>
                            </div>
                        </div>
                    </flux:dropdown>
                    <!-- User Profile (if any) -->
                </div>
            </div>
        </flux:header>
    </x-slot>

    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
