<?php

namespace App\Filament\Resources\ProductTransactions\Tables;

use App\Models\ProductTransaction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProductTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('produk.thumbnail'),
                ImageColumn::make('proof'),
                TextColumn::make('name')
                    ->searchable(),
                    TextColumn::make('produk.name')
                    ->searchable(),
                    TextColumn::make('booking_trx_id')
                        ->label('Booking Trx Id')
                        ->searchable(),
                IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon(Heroicon::CheckCircle)
                    ->falseIcon(Heroicon::XCircle)
                    ->label('Paid'),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('produk_id')
                ->relationship('produk', 'name' )
                ->label('Produk')
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('approve')
                ->label('Approve')
                ->icon(Heroicon::CheckCircle)
                ->action(function(ProductTransaction $record):void{
                  $record->is_paid = true;
                  $record->save();
                  Notification::make()
                  ->title('Transaction approved successfully')
                  ->success()
                  ->body('the Transaction for {$record->name} has been marked as paid.')
                  ->send();
                })->color('success')
                ->visible(fn(ProductTransaction $record): bool => !$record->is_paid)
                ->requiresConfirmation(),
                Action::make('download_proof')->label('Download Proof')
                ->icon(HeroIcon::ArrowDownTray)
                ->url(fn(ProductTransaction $record): string|null => $record->proof ? asset('storage/'. $record->proof):null)
                ->openUrlInNewTab()
                ->visible(fn(ProductTransaction $record): bool => !empty($record->proof)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
