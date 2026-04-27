<x-filament-panels::page>

    {{-- Filter Section --}}
    <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 p-4 mb-4">
        <div class="flex flex-wrap gap-4">
            <select wire:model.live="filter"
                class="fi-select-input rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 py-2 px-3">
                <option value="daily">Harian</option>
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
            </select>

            @if($filter === 'daily')
            <input type="date" wire:model.live="selectedDate"
                class="fi-select-input rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 py-2 px-3">
            @endif

            @if($filter === 'monthly')
            <input type="month" wire:model.live="selectedMonth"
                class="fi-select-input rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 py-2 px-3">
            @endif

            @if($filter === 'yearly')
            <input type="number" wire:model.live="selectedYear"
                class="fi-select-input rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 py-2 px-3"
                min="2020" max="2030">
            @endif
        </div>
    </div>

    {{-- Kartu Ringkasan --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

        <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 p-4">
            <p class="fi-section-description text-sm text-gray-500">Total Pemasukan</p>
            <p class="text-xl font-bold text-success-600">Rp {{ number_format($this->getTotalIncome(), 0, ',', '.') }}</p>
        </div>

        <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 p-4">
            <p class="fi-section-description text-sm text-gray-500">Total Pengeluaran</p>
            <p class="text-xl font-bold text-danger-600">Rp {{ number_format($this->getTotalExpense(), 0, ',', '.') }}</p>
        </div>

        <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 p-4">
            <p class="fi-section-description text-sm text-gray-500">Total Gaji</p>
            <p class="text-xl font-bold text-warning-600">Rp {{ number_format($this->getTotalSalary(), 0, ',', '.') }}</p>
        </div>

        <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 p-4">
            <p class="fi-section-description text-sm text-gray-500">Laba Bersih</p>
            <p class="text-xl font-bold text-primary-600">Rp {{ number_format($this->getNetProfit(), 0, ',', '.') }}</p>
        </div>

    </div>

    {{-- Tabel Detail --}}
    <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
        <table class="w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800">
                    <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Tanggal</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Jenis</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Kategori</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Jumlah</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($this->getTransactions() as $transaction)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $transaction->date->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        @if($transaction->type === 'income')
                            <span class="fi-badge rounded-md px-2 py-1 text-xs font-medium bg-success-100 text-success-700">Pemasukan</span>
                        @else
                            <span class="fi-badge rounded-md px-2 py-1 text-xs font-medium bg-danger-100 text-danger-700">Pengeluaran</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $transaction->category)) }}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $transaction->description ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-filament-panels::page>