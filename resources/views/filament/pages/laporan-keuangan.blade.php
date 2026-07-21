<x-filament-panels::page>

    {{-- Filter Section --}}
    <div style="background:#1f2937; border-radius:12px; padding:16px; margin-bottom:16px; display:flex; gap:16px; flex-wrap:wrap; align-items:center;">
        
        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Periode</label>
            <select wire:model.live="filter" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;">
                <option value="daily">Harian</option>
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
            </select>
        </div>

        @if($filter === 'daily')
        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Tanggal</label>
            <input type="date" wire:model.live="selectedDate" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;">
        </div>
        @endif

        @if($filter === 'monthly')
        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Bulan</label>
            <input type="month" wire:model.live="selectedMonth" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;">
        </div>
        @endif

        @if($filter === 'yearly')
        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Tahun</label>
            <input type="number" wire:model.live="selectedYear" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;" min="2020" max="2030">
        </div>
        @endif

        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Jenis</label>
            <select wire:model.live="selectedType" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;">
                <option value="">Semua Jenis</option>
                <option value="income">Pemasukan</option>
                <option value="expense">Pengeluaran</option>
            </select>
        </div>

        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Kategori</label>
            <select wire:model.live="selectedCategory" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;">
                <option value="">Semua Kategori</option>
                @if($selectedType === 'income')
                    <option value="penjualan">Penjualan</option>
                    <option value="lainnya">Lainnya</option>
                @elseif($selectedType === 'expense')
                    <option value="gaji">Gaji Karyawan</option>
                    <option value="pembelian_stok">Pembelian Stok</option>
                    <option value="operasional">Operasional</option>
                    <option value="lainnya">Lainnya</option>
                @else
                    <option value="penjualan">Penjualan</option>
                    <option value="gaji">Gaji Karyawan</option>
                    <option value="pembelian_stok">Pembelian Stok</option>
                    <option value="operasional">Operasional</option>
                    <option value="lainnya">Lainnya</option>
                @endif
            </select>
        </div>

    </div>

    <div style="display:flex; gap:8px; margin-bottom:16px;">
        <button wire:click="exportPdf"
            style="background:#dc2626; color:#fff; border:none; border-radius:8px; padding:10px 16px; font-weight:600; cursor:pointer;">
            📄 Export PDF
        </button>
        <button wire:click="exportExcel"
            style="background:#16a34a; color:#fff; border:none; border-radius:8px; padding:10px 16px; font-weight:600; cursor:pointer;">
            📊 Export Excel
        </button>
    </div>

    {{-- Kartu Ringkasan --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:16px;">

        <div style="background:#064e3b; border-radius:12px; padding:16px; border:1px solid #065f46;">
            <p style="color:#6ee7b7; font-size:12px; margin-bottom:8px;">Total Pemasukan</p>
            <p style="color:#fff; font-size:20px; font-weight:700;">Rp {{ number_format($this->getTotalIncome(), 0, ',', '.') }}</p>
        </div>

        <div style="background:#7f1d1d; border-radius:12px; padding:16px; border:1px solid #991b1b;">
            <p style="color:#fca5a5; font-size:12px; margin-bottom:8px;">Total Pengeluaran</p>
            <p style="color:#fff; font-size:20px; font-weight:700;">Rp {{ number_format($this->getTotalExpense(), 0, ',', '.') }}</p>
        </div>

        <div style="background:#78350f; border-radius:12px; padding:16px; border:1px solid #92400e;">
            <p style="color:#fcd34d; font-size:12px; margin-bottom:8px;">Total Gaji</p>
            <p style="color:#fff; font-size:20px; font-weight:700;">Rp {{ number_format($this->getTotalSalary(), 0, ',', '.') }}</p>
        </div>

        <div style="background:#1e3a5f; border-radius:12px; padding:16px; border:1px solid #1e40af;">
            <p style="color:#93c5fd; font-size:12px; margin-bottom:8px;">Laba Bersih</p>
            <p style="color:#fff; font-size:20px; font-weight:700;">Rp {{ number_format($this->getNetProfit(), 0, ',', '.') }}</p>
        </div>

    </div>

    {{-- Tabel Detail --}}
    <div style="background:#1f2937; border-radius:12px; overflow:hidden; border:1px solid #374151;">
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#111827;">
                    <th style="padding:12px 16px; text-align:left; color:#9ca3af; font-weight:600;">Tanggal</th>
                    <th style="padding:12px 16px; text-align:left; color:#9ca3af; font-weight:600;">Jenis</th>
                    <th style="padding:12px 16px; text-align:left; color:#9ca3af; font-weight:600;">Kategori</th>
                    <th style="padding:12px 16px; text-align:left; color:#9ca3af; font-weight:600;">Jumlah</th>
                    <th style="padding:12px 16px; text-align:left; color:#9ca3af; font-weight:600;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->getTransactions() as $transaction)
                <tr style="border-top:1px solid #374151;">
                    <td style="padding:12px 16px; color:#e5e7eb;">{{ $transaction->date->format('d M Y') }}</td>
                    <td style="padding:12px 16px;">
                        @if($transaction->type === 'income')
                            <span style="background:#065f46; color:#6ee7b7; padding:2px 8px; border-radius:9999px; font-size:12px; font-weight:600;">Pemasukan</span>
                        @else
                            <span style="background:#991b1b; color:#fca5a5; padding:2px 8px; border-radius:9999px; font-size:12px; font-weight:600;">Pengeluaran</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px; color:#e5e7eb;">{{ ucfirst(str_replace('_', ' ', $transaction->category)) }}</td>
                    <td style="padding:12px 16px; color:#e5e7eb;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px; color:#e5e7eb;">{{ $transaction->description ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:32px; text-align:center; color:#6b7280;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-filament-panels::page>