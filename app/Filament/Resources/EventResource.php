<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Kegiatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Nama Kegiatan')
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->label('Lokasi')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Waktu Mulai')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_time')
                    ->label('Waktu Selesai')
                    ->required(),
                Forms\Components\TextInput::make('budget_estimate')
                    ->label('Estimasi Biaya (Rp)')
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Select::make('status')
                    ->label('Status Kegiatan')
                    ->options([
                        'Rencana' => 'Rencana',
                        'Berjalan' => 'Berjalan',
                        'Selesai' => 'Selesai',
                        'Batal' => 'Batal',
                    ])
                    ->default('Rencana')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Kegiatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')->label('Kegiatan')->searchable(),
            Tables\Columns\TextColumn::make('location')->label('Lokasi'),
            Tables\Columns\TextColumn::make('start_time')->label('Mulai')->dateTime(),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ]);
}
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}