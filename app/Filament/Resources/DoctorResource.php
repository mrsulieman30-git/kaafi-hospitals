<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    
    protected static ?string $navigationGroup = 'Hospital Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Professional Details')
                                    ->description('Public information displayed on the website.')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                            ),

                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->helperText('URL friendly name.'),

                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., Consultant Cardiologist'),

                                        Forms\Components\Select::make('department_id')
                                            ->relationship('department', 'name')
                                            ->required()
                                            ->preload()
                                            ->searchable(),

                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->prefixIcon('heroicon-m-phone'),
                                    ])->columns(2),

                                Forms\Components\Section::make('Video Biography')
                                    ->description('Paste a YouTube link to display a video bio on the doctor\'s profile.')
                                    ->schema([
                                        Forms\Components\TextInput::make('youtube_video_url')
                                            ->label('YouTube URL')
                                            ->url()
                                            ->live(onBlur: true)
                                            ->prefixIcon('heroicon-m-video-camera')
                                            ->placeholder('https://www.youtube.com/watch?v=...'),
                                            
                                        // Custom view to preview the video instantly
                                        Forms\Components\ViewField::make('video_preview')
                                            ->view('filament.forms.components.youtube-preview')
                                            ->visible(fn (Forms\Get $get) => filled($get('youtube_video_url'))),
                                    ]),
                            ])->columnSpan(2),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Profile Image')
                                    ->schema([
                                        Forms\Components\Radio::make('image_type')
                                            ->label('Image Source')
                                            ->options([
                                                'upload' => 'Upload File',
                                                'url' => 'Image URL',
                                            ])
                                            ->default('url')
                                            ->live(),

                                        Forms\Components\FileUpload::make('image')
                                            ->label('Upload Image')
                                            ->image()
                                            ->directory('doctor-images')
                                            ->hidden(fn (Forms\Get $get) => $get('image_type') === 'url'),

                                        Forms\Components\TextInput::make('image_url')
                                            ->label('External Image URL')
                                            ->url()
                                            ->placeholder('https://images.pexels.com/...')
                                            ->hidden(fn (Forms\Get $get) => $get('image_type') === 'upload'),
                                    ]),

                                Forms\Components\Section::make('Status')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Active on Website')
                                            ->default(true),
                                    ]),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('display_image')
                    ->label('Photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')
                    ->relationship('department', 'name'),
            ])
            ->actions([
                // THE NEW LIVE FRONTEND PREVIEW
                Tables\Actions\Action::make('preview')
                    ->label('Live Preview')
                    ->icon('heroicon-m-device-phone-mobile')
                    ->color('success')
                    ->slideOver()
                    ->modalHeading(fn (Doctor $record) => 'Live Preview: ' . $record->name)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close Preview')
                    ->modalContent(fn (Doctor $record) => view('filament.components.iframe-modal', [
                        'url' => url('/doctor/' . $record->slug)
                    ])),
                    
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}