<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Resources\Concerns\Translatable;

class PageResource extends Resource
{
    use Translatable;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Page Content')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                            )
                                            ->columnSpanFull(),
                                            
                                        TinyEditor::make('content')
                                            ->required()
                                            ->fileAttachmentsDirectory('pages')
                                            ->columnSpanFull()
                                            ->profile('default|simple|full')
                                            ->direction('ltr')
                                            ->setRelativeUrls(false)
                                            ->setRemoveScriptHost(false)
                                            ->setConvertUrls(true),
                                    ]),
                            ])->columnSpan(2),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Publishing')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Published to Website')
                                            ->default(true),
                                            
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->prefix('/')
                                            ->helperText('The URL address (e.g. "about-us")'),
                                    ]),
                                    
                                Forms\Components\Section::make('Search Engine Optimization')
                                    ->schema([
                                        Forms\Components\Textarea::make('meta_description')
                                            ->rows(3)
                                            ->maxLength(160),
                                    ]),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('slug')
                    ->icon('heroicon-m-globe-alt')
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => '/' . $state),
                    
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle'),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Modified')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->actions([
                // THE NEW LIVE FRONTEND PREVIEW
                Tables\Actions\Action::make('preview')
                    ->label('Live Preview')
                    ->icon('heroicon-m-device-phone-mobile')
                    ->color('success')
                    ->slideOver()
                    ->modalHeading(fn (Page $record) => 'Live Preview: ' . $record->title)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close Preview')
                    ->modalContent(fn (Page $record) => view('filament.components.iframe-modal', [
                        'url' => url('/' . $record->slug)
                    ])),

                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
