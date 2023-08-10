<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'iconpark-calendardot';

    protected static function getNavigationLabel(): string
    {
        return "Booking";
    }

    public static function getPluralLabel(): string
    {
        return "Booking";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('users_id')
                ->relationship('user', 'name'),

                Select::make('gedung_id')
                ->relationship('gedung', 'nama'),

                CheckboxList::make('fasilitas')
                ->relationship('fasilitas', 'fasilitas'),
                
                Forms\Components\TextInput::make('no_telp')
                ->label('No Telpon')
                ->required(),

                Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal')
                ->required(),

                Forms\Components\TextInput::make('harga_total')
                ->label('Total Harga')
                ->required(),

                Forms\Components\FileUpload::make('image')
                ->label('Bukti Pembayaran')
                ->required(),
                
                Forms\Components\Select::make('status')
                ->options([
                    'Belum Bayar' => 'Belum Bayar',
                    'Menunggu' => 'Menunggu',
                    'Selesai' => 'Selesai',
                    'Cancel' => 'Cancel',
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Customer'),
                TextColumn::make('gedung.nama')
                    ->label('Nama Gedung'),
                TextColumn::make('fasilitas.fasilitas')
                    ->label('Fasilitas'),
                TextColumn::make('no_telp')
                    ->label('No Telpon'),
                TextColumn::make('tanggal')
                    ->label('Tanggal'),
                TextColumn::make('harga_total')
                    ->label('Total Harga'),
                ImageColumn::make('image')
                    ->label('Bukti Pembayaran'),
                SelectColumn::make('status')
                    ->options([
                        'Belum Bayar' => 'Belum Bayar',
                        'Menunggu' => 'Menunggu',
                        'Selesai' => 'Selesai',
                        'Cancel' => 'Cancel',
                    ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }    
}
