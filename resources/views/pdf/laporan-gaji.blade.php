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
        .text-right { text-align: right; }
        .total { margin-top: 12px; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Gaji Karyawan</h1>
    <p class="subtitle">Periode: {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th class="text-right">Hadir</th>
                <th class="text-right">Izin</th>
                <th class="text-right">Sakit</th>
                <th class="text-right">Alpha</th>
                <th class="text-right">Gaji Pokok</th>
                <th class="text-right">Potongan</th>
                <th class="text-right">Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaryData as $data)
            <tr>
                <td>{{ $data['nama'] }}</td>
                <td>{{ $data['jabatan'] }}</td>
                <td class="text-right">{{ $data['hari_hadir'] }}</td>
                <td class="text-right">{{ $data['hari_izin'] }}</td>
                <td class="text-right">{{ $data['hari_sakit'] }}</td>
                <td class="text-right">{{ $data['hari_alpha'] }}</td>
                <td class="text-right">Rp {{ number_format($data['gaji_pokok'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($data['potongan'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($data['total_gaji'], 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;">Tidak ada karyawan aktif</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="total">Total Gaji: Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
    <p style="margin-top:16px; font-size:10px; color:#777;">Dicetak pada {{ now()->format('d M Y H:i') }}</p>
</body>
</html>