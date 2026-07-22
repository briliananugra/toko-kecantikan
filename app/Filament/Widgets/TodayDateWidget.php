<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TodayDateWidget extends Widget
{
    // Sengaja dibuat sangat rendah, supaya sejajar dengan kotak "Welcome" (AccountWidget)
    protected static ?int $sort = -2;

    protected string $view = 'filament.widgets.today-date-widget';
}