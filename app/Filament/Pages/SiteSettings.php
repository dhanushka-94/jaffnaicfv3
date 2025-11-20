<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use UnitEnum;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Site Settings';
    protected static ?string $title = 'Site Settings';
    protected static UnitEnum|string|null $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::first() ?? new SiteSetting();
        $this->form->model($settings)->fill($settings->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')
                    ->label('Site name')
                    ->required()
                    ->maxLength(120),
                FileUpload::make('logo_path')
                    ->label('Logo')
                    ->image()
                    ->directory('logos')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->nullable(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $settings = SiteSetting::first() ?? new SiteSetting();

        $settings->site_name = $data['site_name'] ?? 'JAFFNA ICF';

        // Manually store the uploaded file to ensure it is moved to the public disk
        $logoState = $data['logo_path'] ?? null;
        if ($logoState instanceof TemporaryUploadedFile) {
            $storedPath = $logoState->store('logos', 'public');
            $settings->logo_path = $storedPath;
        } elseif (is_string($logoState)) {
            // Already stored path (keep as is)
            $settings->logo_path = $logoState;
        }

        $settings->save();
        // Refresh the form state so the preview reflects the saved path
        $this->form->fill($settings->toArray());
        Notification::make()
            ->title('Settings saved.')
            ->success()
            ->send();
    }
}


