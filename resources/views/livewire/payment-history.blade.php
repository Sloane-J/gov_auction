<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-1">Payment History</h1>
    <p class="text-zinc-600 dark:text-zinc-400 mb-6">All your auction payments, receipts, and status.</p>

    @if ($payments->isEmpty())
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 p-8 shadow-sm text-center">
            <p class="text-zinc-500 dark:text-zinc-400">No payments recorded yet.</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 shadow-sm">
            <table class="w-full text-left">
                <thead class="border-b border-zinc-200 dark:border-zinc-700 text-sm text-zinc-600 dark:text-zinc-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Auction</th>
                        <th class="px-6 py-4 font-semibold">Amount</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Reference</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold">Receipt</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach ($payments as $payment)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('auctions.show', $payment->auction) }}" class="text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:underline">{{ $payment->auction->title }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-700 dark:text-zinc-300">${{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $payment->reference ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('receipt.show', $payment) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Download PDF</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @endif
</div>