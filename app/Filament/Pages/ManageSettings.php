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
                                Forms\Components\TextInput::make('city_name')
                                    ->label('City Name')
                                    ->default('Mogadishu'),
                                Forms\Components\Textarea::make('hospital_address')
                                    ->label('Main Address')
                                    ->rows(3),
                                Forms\Components\TextInput::make('working_hours')
                                    ->label('General Working Hours')
                                    ->default('24/7'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Contact Info')
                            ->schema([
                                Forms\Components\TextInput::make('emergency_phone')
                                    ->label('Emergency Hotline')
                                    ->helperText('This number is shown prominently in the top menu.')
                                    ->tel()
                                    ->required()
                                    ->prefixIcon('heroicon-m-phone-arrow-up-right'),
                                Forms\Components\Repeater::make('additional_phones')
                                    ->label('Additional Contact Numbers')
                                    ->schema([
                                        Forms\Components\TextInput::make('number')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->required(),
                                        Forms\Components\TextInput::make('label')
                                            ->label('Label (optional)')
                                            ->placeholder('e.g. Reception, Pharmacy'),
                                    ])
                                    ->collapsible()
                                    ->defaultItems(0)
                                    ->reorderable()
                                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Primary Email')
                                    ->email(),
                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label('WhatsApp Number (with country code)')
                                    ->tel()
                                    ->placeholder('+252610000000'),
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
                                Forms\Components\TextInput::make('tiktok_url')
                                    ->label('TikTok URL')
                                    ->url(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Gallery')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('about_gallery')
                                    ->label('About Us Gallery')
                                    ->helperText('Upload and reorder photos for the About Us gallery.')
                                    ->multiple()
                                    ->image()
                                    ->directory('gallery')
                                    ->reorderable()
                                    ->appendFiles()
                                    ->imageEditor(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Milestones')
                            ->icon('heroicon-m-chart-bar')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('stats_years')
                                            ->label('Years of Experience')
                                            ->default('8')
                                            ->suffix('+'),
                                        Forms\Components\TextInput::make('stats_patients')
                                            ->label('Total Patients Treated')
                                            ->default('107,250'),
                                        Forms\Components\TextInput::make('stats_beds')
                                            ->label('Number of Beds')
                                            ->default('35')
                                            ->suffix('+'),
                                        Forms\Components\TextInput::make('stats_surgeries')
                                            ->label('Successful Surgeries')
                                            ->default('1700')
                                            ->suffix('+'),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Insurance')
                            ->icon('heroicon-m-shield-check')
                            ->schema([
                                Forms\Components\Repeater::make('insurance_providers')
                                    ->label('Accepted Insurance Providers')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->label('Provider Name'),
                                        Forms\Components\FileUpload::make('logo')
                                            ->label('Provider Logo (Optional)')
                                            ->image()
                                            ->directory('insurance'),
                                    ])
                                    ->default([
                                        ['name' => 'CIGNA'],
                                        ['name' => 'Amana'],
                                        ['name' => 'Takaful'],
                                        ['name' => 'Kobciye'],
                                    ])
                                    ->collapsible(),
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
                ['value' => $value]
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
