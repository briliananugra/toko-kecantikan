<x-filament-panels::page>

    {{-- Filter Section --}}
    <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 p-4 mb-4">
        <div class="flex flex-wrap gap-4 items-center">

            {{-- Pilih Bulan --}}
            <div>
                <label class="text-sm text-gray-600 dark:text-gray-400 mb-1 block">Bulan</label>
                <select wire:model.live="selectedMonth"
                    class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 py-2 px-3">
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

            {{-- Pilih Tahun --}}
            <div>
                <label class="text-sm text-gray-600 dark:text-gray-400 mb-1 block">Tahun</label>
                <input type="number" wire:model.live="selectedYear"
                    class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 py-2 px-3"
                    min="2020" max="2030">
            </div>

            {{-- Sistem Kerja --}}
            <div>
                <label class="text-sm text-gray-600 dark:text-gray-400 mb-1 block">Sistem Kerja</label>
                <select wire:model.live="workDays"
                    class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 py-2 px-3">
                    <option value="25">6 Hari/Minggu (÷25)</option>
                    <option value="21">5 Hari/Minggu (÷21)</option>
                </select>
            </div>

            {{-- Tombol Bayar Gaji --}}
            <div class="ml-auto mt-4">
                <button wire:click="bayarGaji"
                    wire:confirm="Yakin ingin mencatat gaji bulan ini ke Cash Flow?"
                    class="rounded-lg bg-primary-600 px-4 py-2 text-white text-sm font-medium hover:bg-primary-500">
                    💰 Catat Gaji ke Cash Flow
                </button>
            </div>

        </div>
    </div>

    {{-- Info Dasar Hukum --}}
    <div class="fi-section rounded-xl bg-blue-50 dark:bg-blue-950 ring-1 ring-blue-200 dark:ring-blue-800 p-3 mb-4">
        <p class="text-xs text-blue-700 dark:text-blue-300">
            📋 <strong>Dasar Hukum:</strong> PP No. 36 Tahun 2021 tentang Pengupahan & PP No. 78 Tahun 2015 Pasal 24.
            Status <strong>Hadir, Izin, dan Sakit</strong> tetap dibayar. Status <strong>Alpha</strong> dikenakan potongan.
        </p>
    </div>

    {{-- Total Gaji --}}
    <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 p-4 mb-4">
        <p class="text-sm text-gray-500">Total Gaji Bulan Ini</p>
        <p class="text-2xl font-bold text-primary-600">
            Rp {{ number_format($this->getTotalGaji(), 0, ',', '.') }}
        </p>
    </div>

    {{-- Tabel Gaji --}}
    <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
        <table class="w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800">
                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300">Nama</th>
                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300">Jabatan</th>
                    <th class="px-4 py-3 text-center text-gray-600 dark:text-gray-300">Hadir</th>
                    <th class="px-4 py-3 text-center text-gray-600 dark:text-gray-300">Izin</th>
                    <th class="px-4 py-3 text-center text-gray-600 dark:text-gray-300">Sakit</th>
                    <th class="px-4 py-3 text-center text-gray-600 dark:text-gray-300">Alpha</th>
                    <th class="px-4 py-3 text-right text-gray-600 dark:text-gray-300">Gaji Pokok</th>
                    <th class="px-4 py-3 text-right text-gray-600 dark:text-gray-300">Potongan</th>
                    <th class="px-4 py-3 text-right text-gray-600 dark:text-gray-300">Total Gaji</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($this->getSalaryData() as $data)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                    <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">{{ $data['nama'] }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $data['jabatan'] }}</td>
                    <td class="px-4 py-3 text-center text-green-600 font-medium">{{ $data['hari_hadir'] }}</td>
                    <td class="px-4 py-3 text-center text-yellow-600 font-medium">{{ $data['hari_izin'] }}</td>
                    <td class="px-4 py-3 text-center text-blue-600 font-medium">{{ $data['hari_sakit'] }}</td>
                    <td class="px-4 py-3 text-center text-red-600 font-medium">{{ $data['hari_alpha'] }}</td>
                    <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">
                        Rp {{ number_format($data['gaji_pokok'], 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 text-right text-red-600">
                        @if($data['potongan'] > 0)
                            - Rp {{ number_format($data['potongan'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right font-bold text-primary-600">
                        Rp {{ number_format($data['total_gaji'], 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                        Tidak ada karyawan aktif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-filament-panels::page>