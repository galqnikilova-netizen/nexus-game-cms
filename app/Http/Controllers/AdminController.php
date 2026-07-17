<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('pages.admin', [
            'metrics' => [
                ['label' => 'Приходи днес', 'value' => '412.80 лв.', 'delta' => '+18.4%'],
                ['label' => 'Нови потребители', 'value' => '186', 'delta' => '+7.1%'],
                ['label' => 'Отворени тикети', 'value' => '12', 'delta' => '-4'],
                ['label' => 'Server uptime', 'value' => '99.96%', 'delta' => '+0.04%'],
            ],
        ]);
    }
}
