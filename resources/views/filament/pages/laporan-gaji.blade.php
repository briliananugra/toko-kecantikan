<x-filament-panels::page>

    {{-- Filter Section --}}
    <div style="background:#1f2937; border-radius:12px; padding:16px; margin-bottom:16px; display:flex; gap:16px; flex-wrap:wrap; align-items:flex-end;">

        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Bulan</label>
            <select wire:model.live="selectedMonth" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>

        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Tahun</label>
            <input type="number" wire:model.live="selectedYear" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px; width:100px;" min="2020" max="2030">
        </div>

        <div>
            <label style="color:#9ca3af; font-size:12px; display:block; margin-bottom:4px;">Sistem Kerja</label>
            <select wire:model.live="workDays" style="background:#374151; color:#fff; border:1px solid #4b5563; border-radius:8px; padding:8px 12px;">
                <option value="25">6 Hari/Minggu (÷25)</option>
                <option value="21">5 Hari/Minggu (÷21)</option>
            </select>
        </div>

        <div style="margin-left:auto;">
            <button wire:click="bayarGaji" wire:confirm="Yakin ingin mencatat gaji bulan ini ke Cash Flow?"
                style="background:#f59e0b; color:#000; border:none; border-radius:8px; padding:10px 16px; font-weight:600; cursor:pointer;">
                💰 Catat Gaji ke Cash Flow
            </button>
        </div>

    </div>

    {{-- Info Dasar Hukum --}}
    <div style="background:#1e3a5f; border-radius:12px; padding:12px 16px; margin-bottom:16px; border:1px solid #1e40af;">
        <p style="color:#93c5fd; font-size:12px; margin:0;">
            📋 <strong>Dasar Hukum:</strong> PP No. 36 Tahun 2021 tentang Pengupahan & PP No. 78 Tahun 2015 Pasal 24.
            Status <strong>Hadir, Izin, dan Sakit</strong> tetap dibayar. Status <strong>Alpha</strong> dikenakan potongan.
        </p>
    </div>

    {{-- Total Gaji --}}
    <div style="background:#1f2937; border-radius:12px; padding:16px; margin-bottom:16px; border:1px solid #374151;">
        <p style="color:#9ca3af; font-size:12px; margin-bottom:4px;">Total Gaji Bulan Ini</p>
        <p style="color:#f59e0b; font-size:24px; font-weight:700; margin:0;">Rp {{ number_format($this->getTotalGaji(), 0, ',', '.') }}</p>
    </div>

    {{-- Tabel Gaji --}}
    <div style="background:#1f2937; border-radius:12px; overflow:hidden; border:1px solid #374151;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#111827;">
                    <th style="padding:12px 16px; text-align:left; color:#9ca3af;">Nama</th>
                    <th style="padding:12px 16px; text-align:left; color:#9ca3af;">Jabatan</th>
                    <th style="padding:12px 16px; text-align:center; color:#6ee7b7;">Hadir</th>
                    <th style="padding:12px 16px; text-align:center; color:#fcd34d;">Izin</th>
                    <th style="padding:12px 16px; text-align:center; color:#93c5fd;">Sakit</th>
                    <th style="padding:12px 16px; text-align:center; color:#fca5a5;">Alpha</th>
                    <th style="padding:12px 16px; text-align:right; color:#9ca3af;">Gaji Pokok</th>
                    <th style="padding:12px 16px; text-align:right; color:#fca5a5;">Potongan</th>
                    <th style="padding:12px 16px; text-align:right; color:#f59e0b;">Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->getSalaryData() as $data)
                <tr style="border-top:1px solid #374151;">
                    <td style="padding:12px 16px; color:#fff; font-weight:600;">{{ $data['nama'] }}</td>
                    <td style="padding:12px 16px; color:#9ca3af;">{{ $data['jabatan'] }}</td>
                    <td style="padding:12px 16px; text-align:center; color:#6ee7b7; font-weight:600;">{{ $data['hari_hadir'] }}</td>
                    <td style="padding:12px 16px; text-align:center; color:#fcd34d; font-weight:600;">{{ $data['hari_izin'] }}</td>
                    <td style="padding:12px 16px; text-align:center; color:#93c5fd; font-weight:600;">{{ $data['hari_sakit'] }}</td>
                    <td style="padding:12px 16px; text-align:center; color:#fca5a5; font-weight:600;">{{ $data['hari_alpha'] }}</td>
                    <td style="padding:12px 16px; text-align:right; color:#e5e7eb;">Rp {{ number_format($data['gaji_pokok'], 0, ',', '.') }}</td>
                    <td style="padding:12px 16px; text-align:right; color:#fca5a5;">
                        @if($data['potongan'] > 0)
                            - Rp {{ number_format($data['potongan'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding:12px 16px; text-align:right; color:#f59e0b; font-weight:700;">Rp {{ number_format($data['total_gaji'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="padding:32px; text-align:center; color:#6b7280;">Tidak ada karyawan aktif</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-filament-panels::page>