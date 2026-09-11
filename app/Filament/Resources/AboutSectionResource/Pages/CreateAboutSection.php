<?php

namespace App\Filament\Resources\AboutSectionResource\Pages;

use App\Filament\Resources\AboutSectionResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutSection extends CreateRecord
{
    protected static string $resource = AboutSectionResource::class;

    public function getHeading(): string
    {
        return 'Buat Profil Baru (About Section)';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola profil pengabdian masyarakat, latar belakang program, dan poin-poin keunggulan.';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan & Publikasikan')
            ->icon('heroicon-o-check');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batalkan');
    }
}
