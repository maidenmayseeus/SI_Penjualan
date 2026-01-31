<?php

namespace App\Filament\Resources\Produks\Schemas;

use App\Models\Produk;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProdukInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('slug'),
                ImageEntry::make('thumbnail'),
                ImageEntry::make('photos.photo')
                ->limit(1)
                ->square()
                ->limitedRemainingText()
                ,
                TextEntry::make('about')
                    ->columnSpanFull(),
                TextEntry::make('sizes.size'),
                TextEntry::make('price')
                    ->money('IDR'),
                TextEntry::make('stock')
                    ->numeric(),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('brand.name')
                    ->label('Brand'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Produk $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
