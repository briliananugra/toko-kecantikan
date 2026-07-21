<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #000; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        p.subtitle { margin-top: 0; margin-bottom: 16px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
        .summary td { border: none; padding: 4px 8px; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Laporan Keuangan</h1>
    <p class="subtitle">{{ $periodeLabel }}{{ $filterLabel ? ' — ' . $filterLabel : '' }}</p>

    <table class="summary">
        <tr>
            <td><strong>Total Pemasukan:</strong></td>
            <td>Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            <td style="width:40px;"></td>
            <td><strong>Total Gaji:</strong></td>
            <td>Rp {{ number_format($totalSalary, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Pengeluaran:</strong></td>
            <td>Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
            <td></td>
            <td><strong>Laba Bersih:</strong></td>
            <td>Rp {{ number_format($netProfit, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th class="text-right">Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td>{{ $t->date->format('d M Y') }}</td>
                <td>{{ $t->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $t->category)) }}</td>
                <td class="text-right">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                <td>{{ $t->description ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top:16px; font-size:10px; color:#777;">Dicetak pada {{ now()->format('d M Y H:i') }}</p>
</body>
</html>