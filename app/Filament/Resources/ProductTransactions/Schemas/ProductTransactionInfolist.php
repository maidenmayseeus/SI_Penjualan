<?php

namespace App\Filament\Resources\ProductTransactions\Schemas;

use App\Models\ProductTransaction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductTransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('phone'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('booking_trx_id'),
                TextEntry::make('city'),
                TextEntry::make('post_code'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('produk.name')
                    ->label('Produk'),
                TextEntry::make('produk_size'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('sub_total_amount')
                    ->money('IDR'),
                TextEntry::make('grand_total_amount')
                    ->money('IDR'),
                TextEntry::make('promoCode.name')
                    ->label('Promo code')
                    ->placeholder('-'),
                IconEntry::make('is_paid')
                    ->boolean(),
                ImageEntry::make('proof')
                ->visible(fn(ProductTransaction $record) : bool => $record->is_paid == true),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(ProductTransaction $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
