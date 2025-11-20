<?php

namespace App\Filament\Pages;

use App\Models\ApplicationSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use UnitEnum;

class ApplicationStatus extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'Application Status';
    protected static ?string $title = 'Application Status';
    protected static UnitEnum|string|null $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.application-status';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = ApplicationSetting::first() ?? new ApplicationSetting();
        $this->form->model($settings)->fill($settings->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('application_open')
                    ->label('Application open')
                    ->helperText('When enabled, the header shows a Download Application button.'),
                FileUpload::make('application_pdf_path')
                    ->label('Application PDF (public)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('downloads')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->helperText('Upload the form applicants can download.')
                    ->nullable(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $settings = ApplicationSetting::first() ?? new ApplicationSetting();

        $settings->application_open = (bool) ($data['application_open'] ?? false);
        $pdfState = $data['application_pdf_path'] ?? null;
        if ($pdfState instanceof TemporaryUploadedFile) {
            $storedPdf = $pdfState->store('downloads', 'public');
            $settings->application_pdf_path = $storedPdf;
        } elseif (is_string($pdfState)) {
            $settings->application_pdf_path = $pdfState;
        }

        $settings->save();
        $this->form->fill($settings->toArray());
        Notification::make()
            ->title('Application status saved.')
            ->success()
            ->send();
    }
}


