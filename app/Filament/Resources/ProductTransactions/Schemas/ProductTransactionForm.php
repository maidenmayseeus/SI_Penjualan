<?php

namespace App\Filament\Resources\ProductTransactions\Schemas;

use App\Models\Produk;
use Ramsey\Collection\Set;
use Filament\Schemas\Schema;
use App\Models\ProductTransaction;
use App\Models\PromoCode;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;

class ProductTransactionForm
{

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Product and Price')
                        ->schema([
                            Grid::make(2)
                            ->schema([
                                Select::make('produk_id')
                                ->relationship('produk', 'name')
                                ->required()
                                ->searchable()
                                ->live()
                                ->preload()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $produk = Produk::find($state);
                                    $price = $produk ? $produk->price : 0;
                                    $qty = $get('quantity') ?? 1;
                                    $sta = $price * $qty;

                                    $set('price', $price);
                                    $set('sub_total_amount', $sta);

                                    $discount = $get('discount') ?? 0;
                                    $gta = $sta - $discount;
                                    $set('grand_total_amount', $gta);

                                    $sizes = $produk ? $produk->sizes->pluck('size', 'id')->toArray() : [];
                                    // dd($sizes);
                                    $set('produk_size_options', $sizes);
                                })

                                ->afterStateHydrated(function ($state, callable $get, callable $set) {
                                    $produkid = $state;
                                    if ($produkid) {
                                        $produk = Produk::find($produkid);
                                        $sizes = $produk ? $produk->sizes->pluck('size', 'id')->toArray() : [];
                                        $set('produk_size_options', $sizes);

                                    }

                                }),

                            Select::make('produk_size')
                                ->options(function (callable $get):array {
                                    $sizes = $get('produk_size_options');
                                    return is_array($sizes) ? $sizes : [];
                                })
                                ->required()
                                ->disabled(fn (Get $get) => empty($get('produk_size_options')))
                                ->live(),
                            TextInput::make('quantity')
                                ->required()
                                ->numeric()
                                ->prefix('Qty')
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $price = $get('price');
                                    $qty = $state;
                                    $sta = $price * $qty;
                                    $set('sub_total_amount', $sta);
                                    $discount = $get('discount') ?? 0;
                                    $gta = $sta - $discount;
                                    $set('grand_total_amount', $gta);
                                }),
                            Select::make('promo_code_id')
                                ->relationship('promoCode', 'code')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $sta = $get('sub_total_amount');
                                    $promoCode = PromoCode::find($state);
                                    $discount = $promoCode ? $promoCode->discount_amount : 0;
                                    $set('discount_amount', $discount);
                                    $gta = $sta - $discount;
                                    $set('grand_total_amount', $gta);
                                }),
                            TextInput::make('sub_total_amount')
                                ->required()
                                ->numeric()
                                ->readOnly()
                                ->prefix('IDR'),
                            TextInput::make('grand_total_amount')
                                ->label('Grand Total Amount')
                                ->required()
                                ->numeric()
                                ->prefix('IDR'),
                            TextInput::make('discount_amount')
                                ->label('Discount Amount')
                                ->disabled()
                                ->numeric()
                                ->prefix('IDR'),
                                ])
                        ]),

                Step::make('Customer information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->required()
                                    ->maxLength(20),
                                TextInput::make('address')
                                    ->required()
                                    ->maxLength(500),
                                TextInput::make('city')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('post_code')
                                    ->required()
                                    ->maxLength(20),
                            ]),
                    ]),
                Step::make('Payment Information')
                    ->schema([
                        TextInput::make('booking_trx_id')
                            ->required()
                            ->maxLength(200),
                        ToggleButtons::make('is_paid')
                            ->label('Apakah Sudah Membayar')
                            ->boolean()
                            ->grouped()
                            ->icons([
                                true => 'heroicon-o-pencil',
                                false => 'heroicon-o-clock',
                            ])
                            ->required(),
                        FileUpload::make('proof')
                            ->required()
                            ->image(),
                    ]),

            ])

            ->columnSpanfull()
            ->columns(1)
            ->skippable(),
                ]);

    }
}
