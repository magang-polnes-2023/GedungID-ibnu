<?php

namespace App\Filament\Resources\GedungResource\Pages;

use App\Filament\Resources\GedungResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGedung extends EditRecord
{
    protected static string $resource = GedungResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRedirectUrl():string
    {
        return $this->getResource()::getUrl('index');
    }
}
