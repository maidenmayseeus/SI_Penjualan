<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ToggleColumn;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('thumbnail')
                    ->image()
                    ->directory('Produk')
                    ->nullable()
                    ->required(),
                Textarea::make('about')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                TextInput::make('stock')
                    ->required()
                    ->numeric(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->required(),
                Select::make('is_popular')
                    ->options([
                        true => 'True',
                        false => 'False'
                    ])
                    ->required(),
                Repeater::make('sizes')
                    ->relationship()
                    ->schema([
                        TextInput::make('size')
                            ->required(),
                    ])
                    ->columns(1)
                    ->deletable(false)
                    ->addable(false),

                Repeater::make('photos')
                    ->relationship()
                    ->schema([
                        FileUpload::make('photo')
                            ->image()
                            ->directory('Produk-photos')
                            ->nullable()
                            ->required(),
                    ]),

            ]);
    }
}
