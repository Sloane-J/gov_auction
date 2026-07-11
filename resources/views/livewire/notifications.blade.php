<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-1">Notifications</h1>
    <p class="text-zinc-600 dark:text-zinc-400 mb-6">Recent updates and alerts from auctions.</p>

    @if ($notifications->isEmpty())
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-8 shadow-sm text-center">
            <p class="text-zinc-500 dark:text-zinc-400">No notifications.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($notifications as $notification)
                <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-5 shadow-sm {{ $notification->read_at ? 'opacity-60' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ $notification->data['title'] ?? 'Notification' }}
                            </h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-2">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 ml-4">
                            @if (!$notification->read_at)
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                    New
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
