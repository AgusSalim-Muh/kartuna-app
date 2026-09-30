<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetLoanResource\Pages;
use App\Models\AssetLoan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetLoanResource extends Resource
{
    protected static ?string $model = AssetLoan::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Peminjaman Aset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('asset_id')
                    ->label('Pilih Barang')
                    ->relationship('asset', 'name')
                    ->required(),
                Forms\Components\TextInput::make('borrower_name')
                    ->label('Nama Peminjam (Warga)')
                    ->required(),
                Forms\Components\TextInput::make('borrower_phone')
                    ->label('No. WhatsApp Peminjam')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('qty')
                    ->label('Jumlah Pinjam')
                    ->numeric()
                    ->default(1)
                    ->required(),
                Forms\Components\DatePicker::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->default(now())
                    ->required(),
                Forms\Components\DatePicker::make('return_date')
                    ->label('Rencana Tanggal Kembali'),
                Forms\Components\Select::make('status')
                    ->label('Status Peminjaman')
                    ->options([
                        'Pending' => 'Pending',
                        'Dipinjam' => 'Dipinjam',
                        'Dikembalikan' => 'Dikembalikan',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->default('Pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('asset.name')->label('Barang')->searchable(),
            Tables\Columns\TextColumn::make('borrower_name')->label('Peminjam')->searchable(),
            Tables\Columns\TextColumn::make('qty')->label('Jumlah'),
            Tables\Columns\TextColumn::make('loan_date')->label('Tgl Pinjam')->date(),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetLoans::route('/'),
            'create' => Pages\CreateAssetLoan::route('/create'),
            'edit' => Pages\EditAssetLoan::route('/{record}/edit'),
        ];
    }
}