<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('order_number')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled(),
                TextInput::make('game_nickname')
                    ->maxLength(255)
                    ->disabled(),
                TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('$')
                    ->maxLength(255)
                    ->disabled(),
                TextInput::make('payment_method')
                    ->maxLength(255)
                    ->placeholder('paypal, crypto')
                    ->disabled(),
                FileUpload::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->directory('orders')
                    ->visibility('public')
                    ->previewable(true)
                    ->disabled(),
                TextInput::make('transaction_proof')
                    ->label('Bukti Transaksi')
                    ->maxLength(255)
                    ->disabled(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('order_number')->searchable()->sortable(),
                TextColumn::make('user.name')->label('User')->searchable(),
                TextColumn::make('game_nickname')->label('Nickname'),
                TextColumn::make('total_amount')->money('USD')->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),

                TextColumn::make('payment_method')->label('Method')->sortable(),

                ImageColumn::make('payment_proof')
                    ->disk('public')
                    ->label('Bukti'),
                TextColumn::make('payment_proof_date')
                    ->label('Tanggal Pembayaran'),
                TextColumn::make('transaction_proof')->label('Bukti Transaksi'),

                TextColumn::make('created_at')->label('Waktu')->dateTime(),
            ])
            ->filters([
                //
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
