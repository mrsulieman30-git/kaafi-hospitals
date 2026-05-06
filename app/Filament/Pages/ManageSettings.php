<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\SettingsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationGroup = 'System';
    
    protected static ?string $title = 'Hospital Settings';

    public ?array $data = [];

    public function mount(SettingsService $settingsService): void
    {
        // Load existing settings from the database and populate the form
        $settings = Setting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('hospital_name')
                                    ->label('Hospital Name')
                                    ->required()
                                    ->default('KAAFI Hospitals'),
                                Forms\Components\Textarea::make('hospital_address')
                                    ->label('Main Address')
                                    ->rows(3),
                                Forms\Components\TextInput::make('working_hours')
                                    ->label('General Working Hours')
                                    ->default('24/7'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Contact Info')
                            ->schema([
                                Forms\Components\TextInput::make('contact_phone')
                                    ->label('Primary Phone Number')
                                    ->tel(),
                                Forms\Components\TextInput::make('emergency_phone')
                                    ->label('Emergency Phone Number')
                                    ->tel(),
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Primary Email')
                                    ->email(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Social Links')
                            ->schema([
                                Forms\Components\TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url(),
                                Forms\Components\TextInput::make('twitter_url')
                                    ->label('Twitter URL')
                                    ->url(),
                                Forms\Components\TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(SettingsService $settingsService): void
    {
        $data = $this->form->getState();

        // Update or create each setting in the database
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'text', 'group' => 'general']
            );
        }

        // Clear the cache so the frontend immediately reflects the changes
        $settingsService->clearCache();

        Notification::make()
            ->success()
            ->title('Settings updated successfully')
            ->send();
    }
}
