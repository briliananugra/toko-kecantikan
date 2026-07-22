<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="color:#9ca3af; font-size:12px; margin-bottom:4px;">Hari ini</p>
                <p style="font-size:20px; font-weight:700; margin:0;">
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div style="font-size:32px;">📅</div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>