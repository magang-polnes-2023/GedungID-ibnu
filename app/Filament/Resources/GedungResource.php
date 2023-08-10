<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GedungFasilitasResource\RelationManagers\FasilitasRelationManager;
use App\Filament\Resources\GedungResource\Pages;
use App\Filament\Resources\GedungResource\RelationManagers;
use App\Filament\Resources\GedungResource\RelationManagers\FasilitasRelationManager as RelationManagersFasilitasRelationManager;
use App\Models\gedung;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\FormsComponent;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GedungResource extends Resource
{
    protected static ?string $model = gedung::class;

    protected static ?string $navigationIcon = 'iconpark-buildingfour';

    protected static function getNavigationLabel(): string
    {
        return "Gedung";
    }

    public static function getPluralLabel(): string
    {
        return "Gedung";
    }

    public static function form(Form $form): Form
    {
        return $form
        
            ->schema([
                Card::make()
                ->schema([
                    Forms\Components\TextInput::make('nama')
                ->label('Nama')
                ->required(),
                
                Forms\Components\TextInput::make('lokasi')
                ->label('Lokasi')
                ->required(),

                CheckboxList::make('fasilitas')
                ->relationship('fasilitas', 'fasilitas'),
                // Select::make('fasiitas')
                // ->multiple()
                // ->relationship('fasilitas', 'fasilitas'),
                
                Forms\Components\TextInput::make('kapasitas')
                ->label('Kapasitas')
                ->required(),
                
                Forms\Components\TextInput::make('deskripsi')
                ->label('Deskripsi')
                ->required(),
                
                Forms\Components\TextInput::make('harga')
                ->label('Harga')
                ->required(),

                Forms\Components\FileUpload::make('foto')
                ->label('Foto')
                ->required(),
                
                Forms\Components\Select::make('ketersediaan')
                ->options([
                    'Tersedia' => 'Tersedia',
                    'Tidak Tersedia' => 'Tidak Tersedia'
                    ])
                ->label('Ketersediaan')
                ->required(),
                ])
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('lokasi'),
                Tables\Columns\TextColumn::make('fasilitas.fasilitas'),
                Tables\Columns\TextColumn::make('kapasitas'),
                Tables\Columns\TextColumn::make('harga'),
                ImageColumn::make('foto'),
                SelectColumn::make('ketersediaan')
                ->options([
                    'Tersedia' => 'Tersedia',
                    'Tidak Tersedia' => 'Tidak Tersedia'
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
            
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGedungs::route('/'),
            'create' => Pages\CreateGedung::route('/create'),
            'edit' => Pages\EditGedung::route('/{record}/edit'),
        ];
    }    
}
