<?php

namespace App\Filament\Pages;

use App\Models\ApplicationDownloadStat;
use App\Models\ApplicationSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
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
        $settings = ApplicationSetting::query()->first() ?? new ApplicationSetting();
        $this->form->model($settings)->fill($settings->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('application_open')
                    ->label('Application open')
                    ->helperText('When enabled, the site shows a Download Application button.'),
                FileUpload::make('application_pdf_path')
                    ->label('Application PDF (public)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('downloads')
                    ->disk('public')
                    ->visibility('public')
                    ->storeFileNamesIn('application_pdf_original_name')
                    ->openable()
                    ->downloadable()
                    ->helperText('Upload the form applicants can download.')
                    ->nullable(),
            ])
            ->statePath('data');
    }

    public function getDownloadStatsProperty(): Collection
    {
        return ApplicationDownloadStat::query()
            ->orderByDesc('year')
            ->get();
    }

    public function getCurrentYearDownloadsProperty(): int
    {
        $year = (int) date('Y');

        return (int) (ApplicationDownloadStat::query()->where('year', $year)->value('downloads_count') ?? 0);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $settings = ApplicationSetting::query()->first() ?? new ApplicationSetting();

        $settings->application_open = (bool) ($data['application_open'] ?? false);

        $pdfState = $data['application_pdf_path'] ?? null;
        if ($pdfState instanceof TemporaryUploadedFile) {
            $settings->application_pdf_path = $pdfState->store('downloads', 'public');
        } elseif (is_array($pdfState)) {
            $settings->application_pdf_path = array_values(array_filter($pdfState))[0] ?? null;
        } elseif (is_string($pdfState) || $pdfState === null) {
            $settings->application_pdf_path = $pdfState;
        }

        $originalName = $data['application_pdf_original_name'] ?? null;
        $settings->application_pdf_original_name = is_string($originalName) && $originalName !== ''
            ? $originalName
            : null;

        if (blank($settings->application_pdf_path)) {
            $settings->application_pdf_original_name = null;
        }

        $settings->save();
        $this->form->model($settings)->fill($settings->fresh()->toArray());

        Notification::make()
            ->title('Application status saved.')
            ->success()
            ->send();
    }
}
