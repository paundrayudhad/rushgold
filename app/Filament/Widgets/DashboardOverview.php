<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Stat::make('Total Orders', number_format(Order::count())),
            Stat::make('Total Revenue', '$ ' . number_format(Order::sum('total_amount'))),
            Stat::make('Total Products', number_format(Product::count())),
            Stat::make('Total Users', number_format(User::count())),
        ];
    }
}

