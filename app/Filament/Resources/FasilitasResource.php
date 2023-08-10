<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FasilitasResource\Pages;
use App\Filament\Resources\FasilitasResource\RelationManagers;
use App\Filament\Resources\FasilitasResource\RelationManagers\BookingRelationManager;
use App\Filament\Resources\FasilitasResource\RelationManagers\GedungRelationManager;
use App\Models\Fasilitas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FasilitasResource extends Resource
{
    protected static ?string $model = Fasilitas::class;

    protected static ?string $navigationIcon = 'iconpark-toilet';

    protected static function getNavigationLabel(): string
    {
        return "Fasilitas";
    }

    public static function getPluralLabel(): string
    {
        return "Fasilitas";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('fasilitas')
                ->label('Fasilitas')
                ->required(),
                
                Forms\Components\TextInput::make('unit')
                ->label('Jumlah Unit')
                ->required(),

                Forms\Components\TextInput::make('harga')
                ->label('Harga')
                ->required(),

                Forms\Components\FileUpload::make('foto')
                ->label('Foto')
                ->required(),

            ]);
        }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('fasilitas')
            ->label('Fasilitas'),
            
            Tables\Columns\TextColumn::make('harga')
            ->label('Harga/unit'),
            
            Tables\Columns\TextColumn::make('unit')
            ->label('Unit Tersedia'),
            
            ImageColumn::make('foto'),
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
            GedungRelationManager::class,
            BookingRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFasilitas::route('/'),
            'create' => Pages\CreateFasilitas::route('/create'),
            'edit' => Pages\EditFasilitas::route('/{record}/edit'),
        ];
    }    
}
