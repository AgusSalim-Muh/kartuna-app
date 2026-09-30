<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Keuangan Kas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transaction_code')
                    ->label('Kode Transaksi')
                    ->required()
                    ->default('TRX-' . time())
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('type')
                    ->label('Jenis Transaksi')
                    ->options([
                        'Pemasukan' => 'Pemasukan',
                        'Pengeluaran' => 'Pengeluaran',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->label('Kategori')
                    ->placeholder('Contoh: Iuran Kas / Pembelian Aset / Operasional')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Nominal (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                Forms\Components\DatePicker::make('transaction_date')
                    ->label('Tanggal')
                    ->default(now())
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Keterangan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('proof_file')
                    ->label('Bukti Kwitansi / Transfer')
                    ->image()
                    ->directory('transactions'),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('transaction_code')->label('Kode'),
            Tables\Columns\TextColumn::make('type')->label('Jenis')->badge(),
            Tables\Columns\TextColumn::make('category')->label('Kategori'),
            Tables\Columns\TextColumn::make('amount')->label('Nominal')->money('IDR'),
            Tables\Columns\TextColumn::make('transaction_date')->label('Tanggal')->date(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}