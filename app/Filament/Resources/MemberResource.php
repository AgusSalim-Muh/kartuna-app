<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('kta_number')
                    ->label('No. KTA')
                    ->required()
                    ->default('KTA-' . rand(1000, 9999))
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('full_name')
                    ->label('Nama Lengkap')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('No. WhatsApp')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('rt_rw')
                    ->label('RT/RW')
                    ->placeholder('01/02')
                    ->required(),
                Forms\Components\Select::make('position')
                    ->label('Jabatan')
                    ->options([
                        'Ketua' => 'Ketua',
                        'Sekretaris' => 'Sekretaris',
                        'Bendahara' => 'Bendahara',
                        'Seksi Usaha' => 'Seksi Usaha',
                        'Seksi Humas' => 'Seksi Humas',
                        'Anggota' => 'Anggota',
                    ])
                    ->default('Anggota')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Non-Aktif' => 'Non-Aktif',
                    ])
                    ->default('Aktif')
                    ->required(),
                Forms\Components\FileUpload::make('avatar')
                    ->label('Foto Profil')
                    ->image()
                    ->directory('members'),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('kta_number')->label('No. KTA')->searchable(),
            Tables\Columns\TextColumn::make('full_name')->label('Nama Lengkap')->searchable(),
            Tables\Columns\TextColumn::make('phone')->label('WhatsApp'),
            Tables\Columns\TextColumn::make('position')->label('Jabatan')->badge(),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}