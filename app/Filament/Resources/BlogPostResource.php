<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Concerns\Translatable;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class BlogPostResource extends Resource
{
    use Translatable;

    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Section::make('Content Details')
                        ->schema([
                            // THE TOGGLE: Changes the form dynamically
                            Forms\Components\Select::make('type')
                                ->label('Content Type')
                                ->options([
                                    'post' => 'News Post',
                                    'ad' => 'Hospital Advertisement / Offer',
                                ])
                                ->default('post')
                                ->live()
                                ->required(),

                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true),
                                
                            Forms\Components\Textarea::make('excerpt')
                                ->rows(3)
                                ->required(),
                                
                            // RESTORED: The fully-featured Rich Text Editor
                            Forms\Components\RichEditor::make('content')
                                ->required()
                                ->columnSpanFull()
                                ->toolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                    'table',
                                ]),
                        ])->columnSpan(2),

                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make('Publishing & Images')
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(true),
                                    
                                // THE FIX: ->dehydrated(false) stops the SQL crash!
                                // We also added logic to remember the state when editing.
                                Forms\Components\Radio::make('image_type')
                                    ->label('Image Source')
                                    ->options([
                                        'upload' => 'Upload File',
                                        'url' => 'Image URL',
                                    ])
                                    ->default(fn ($record) => $record && $record->featured_image_url ? 'url' : 'upload')
                                    ->live()
                                    ->dehydrated(false),

                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Upload Image')
                                    ->directory('blog-images')
                                    ->image()
                                    ->hidden(fn (Get $get) => $get('image_type') === 'url'),

                                Forms\Components\TextInput::make('featured_image_url')
                                    ->label('External Image URL')
                                    ->url()
                                    ->hidden(fn (Get $get) => $get('image_type') === 'upload'),
                            ]),

                        // DYNAMIC ADVERTISEMENT SETTINGS
                        Forms\Components\Section::make('Advertisement Settings')
                            ->description('Only visible for Advertisements')
                            ->visible(fn (Get $get) => $get('type') === 'ad')
                            ->schema([
                                Forms\Components\TextInput::make('old_price')
                                    ->label('Old Price')
                                    ->prefix('$')
                                    ->numeric(),
                                    
                                Forms\Components\TextInput::make('new_price')
                                    ->label('New Price')
                                    ->prefix('$')
                                    ->numeric(),
                                    
                                Forms\Components\Toggle::make('has_appointment_btn')
                                    ->label('Include Book Button')
                                    ->default(true),

                                // NEW: Offer Period Dates
                                Forms\Components\DateTimePicker::make('offer_start_date')->label('Offer Starts'),
                                Forms\Components\DateTimePicker::make('offer_end_date')->label('Offer Ends (Expiry)'),
                            ]),

                        // DOCTOR TAGGING
                        Forms\Components\Section::make('Tag a Doctor')
                            ->description('Creates a clickable doctor profile card in the post.')
                            ->schema([
                                Forms\Components\Select::make('linked_doctor_id')
                                    ->label('Featured Specialist')
                                    ->options(\App\Models\Doctor::pluck('name', 'id'))
                                    ->searchable()
                                    ->nullable(),
                            ]),
                    ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('display_image')->label('Image')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->weight('bold')->limit(40),
                Tables\Columns\TextColumn::make('type')->badge()->color(fn (string $state): string => match ($state) {
                    'post' => 'info',
                    'ad' => 'warning',
                }),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('views')->label('Views')->numeric()->sortable(),
            ])
            ->actions([
                // NEW: Extend Offer Action
                Tables\Actions\Action::make('extend_offer')
                    ->label('Extend Offer (7 Days)')
                    ->icon('heroicon-o-clock')
                    ->color('success')
                    ->visible(fn ($record) => $record->type === 'ad')
                    ->action(function ($record) {
                        $currentEnd = $record->offer_end_date ? Carbon::parse($record->offer_end_date) : now();
                        $record->update(['offer_end_date' => $currentEnd->addDays(7)]);
                        Notification::make()->title('Offer Extended by 7 Days!')->success()->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}