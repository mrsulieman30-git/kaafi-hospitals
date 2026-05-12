<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\SettingsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Dotswan\MapPicker\Fields\Map;

class ManageBrandSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Brand & Website';
    protected static ?string $title = 'Brand Settings';
    
    protected static string $view = 'filament.pages.manage-brand-settings';

    public ?array $data = [];

    public function mount(SettingsService $settingsService): void
    {
        // Load existing settings from the key-value table by known brand keys
        $brandKeys = [
            'logo_path', 'logo_height', 'logo_position',
            'hero_bg_path', 'hero_bg_opacity',
            'chatbot_avatar_path', 'location_coordinates',
        ];
        $settings = Setting::whereIn('key', $brandKeys)->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        // Form Controls (Left)
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Logo Configuration')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo_path')
                                            ->label('Upload Logo')
                                            ->image()
                                            ->directory('brand')
                                            ->deletable(true)
                                            ->live(),
                                            
                                        Forms\Components\TextInput::make('logo_height')
                                            ->label('Logo Height (px)')
                                            ->numeric()
                                            ->minValue(20)
                                            ->maxValue(120)
                                            ->live(onBlur: true),
                                            
                                        Forms\Components\Select::make('logo_position')
                                            ->label('Navigation Position')
                                            ->options([
                                                'left' => 'Align Left',
                                                'center' => 'Center Logo',
                                                'right' => 'Align Right',
                                            ])
                                            ->live(),
                                    ]),

                                Forms\Components\Section::make('Hero Background')
                                    ->schema([
                                        Forms\Components\FileUpload::make('hero_bg_path')
                                            ->label('Upload Homepage Background')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('brand')
                                            ->deletable(true)
                                            ->live(),
                                            
                                        Forms\Components\TextInput::make('hero_bg_opacity')
                                            ->label('Background Opacity (%)')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->live(onBlur: true)
                                            ->helperText('Lower values keep text readable.'),
                                    ]),

                                Forms\Components\Section::make('AI Assistant')
                                    ->schema([
                                        Forms\Components\FileUpload::make('chatbot_avatar_path')
                                            ->label('Chatbot Avatar')
                                            ->image()
                                            ->circleCropper()
                                            ->directory('brand')
                                            ->deletable(true)
                                            ->live(),
                                    ]),

                                Forms\Components\Section::make('Hospital Location')
                                    ->description('Click on the map to set the exact pin location for the hospital.')
                                    ->schema([
                                        Map::make('location_coordinates')
                                            ->label('Interactive Map')
                                            ->columnSpanFull()
                                            ->defaultLocation(11.2829, 49.1816) 
                                            ->zoom(14)
                                            ->clickable(true)
                                            ->draggable(true)
                                            ->showMarker(true)
                                            ->markerColor('#003B73')
                                            ->tilesUrl('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}')
                                            ->afterStateHydrated(function ($state, $component) {
                                                if (is_string($state) && !empty($state)) {
                                                    $component->state(json_decode($state, true));
                                                }
                                            })
                                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state),
                                    ]),
                            ])->columnSpan(1),

                        // Live Preview Window (Right)
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Real-Time Live Preview')
                                    ->description('This is how your brand will look to patients.')
                                    ->schema([
                                        Forms\Components\Placeholder::make('preview')
                                            ->hiddenLabel()
                                            ->content(fn (Forms\Get $get) => view('filament.components.brand-preview', [
                                                'logo_path' => $get('logo_path'),
                                                'logo_height' => $get('logo_height'),
                                                'logo_position' => $get('logo_position'),
                                                'hero_bg_path' => $get('hero_bg_path'),
                                                'hero_bg_opacity' => $get('hero_bg_opacity'),
                                                'chatbot_avatar_path' => $get('chatbot_avatar_path'),
                                            ])),
                                    ]),
                            ])->columnSpan(2),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(SettingsService $settingsService): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService->clearCache();

        Notification::make()->success()->title('Brand settings successfully updated!')->send();
    }
}
