<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('asset_code')
                    ->label('Kode Aset')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Barang')
                    ->required(),
                Forms\Components\TextInput::make('total_qty')
                    ->label('Jumlah Total')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('available_qty')
                    ->label('Jumlah Tersedia')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('condition')
                    ->label('Kondisi')
                    ->options([
                        'Bagus' => 'Bagus',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat' => 'Rusak Berat',
                    ])
                    ->default('Bagus')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label('Foto Barang')
                    ->image()
                    ->directory('assets'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset_code')->label('Kode')->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Nama Barang')->searchable(),
                Tables\Columns\TextColumn::make('total_qty')->label('Total'),
                Tables\Columns\TextColumn::make('available_qty')->label('Tersedia'),
                Tables\Columns\TextColumn::make('condition')->label('Kondisi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}