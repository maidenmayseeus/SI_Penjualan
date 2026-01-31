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
                Fieldset::make('Product Information')->columnSpanFull()->columns([
                    'default' => 2,
                    'md' => 1
                ])->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('IDR'),
                    FileUpload::make('thumbnail')
                        ->image()
                        ->imageEditor()
                        ->imageAspectRatio('1:1')
                        ->imageEditorAspectRatioOptions([
                            '1:1',
                            '4:3'
                        ])
                        ->automaticallyCropImagesToAspectRatio('1:1')
                        ->directory('Produk')
                        ->nullable()
                        ->required(),
                    Repeater::make('photos')
                        ->relationship()
                        ->schema([
                            FileUpload::make('photo')
                                ->image()
                                ->imageEditor()
                                ->imageAspectRatio('1:1')
                                ->imageEditorAspectRatioOptions([
                                    '1:1',
                                    '4:3'
                                ])
                                ->automaticallyCropImagesToAspectRatio('1:1')
                                ->directory('Produk-photos')
                                ->nullable()
                                ->required(),
                        ]),
                    Repeater::make('sizes')
                        ->relationship()
                        ->schema([
                            TextInput::make('size')
                                ->required(),
                        ])
                        ->columns(1)
                        ->deletable(false)
                        ->addable(true),
                    Fieldset::make('Informasi tambahan')->columnSpanFull()->columns([
                        'default' => 2,
                        'md' => 1
                    ])->schema([
                        Textarea::make('about')
                            ->required()
                            ->columnSpanFull(),

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

                    ])

                ]),


            ]);
    }
}
