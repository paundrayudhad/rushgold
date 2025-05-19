<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestTransactions extends BaseWidget
{
    protected static ?string $heading = 'Transaksi Terbaru';

    protected function getTableQuery(): Builder
    {
        return Order::query()
            ->latest() // urutkan berdasarkan yang terbaru
            ->limit(10); // batasi hanya 10 transaksi terakhir
    }

    public function getColumnSpan(): int | string | array{
        return 'full';
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('order_number')
                ->label('ID'),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Pelanggan')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('total_amount')
                ->label('Total')
                ->money('IDR', true),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->colors([
                    'success' => 'selesai',
                    'warning' => 'pending',
                    'danger' => 'gagal',
                ]),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime('d M Y H:i'),
        ];
    }
}

