<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

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
                Forms\Components\Grid::make(3)
                    ->schema([
                        // Main Content Column (2/3)
                        Forms\Components\Section::make('Post Content')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TinyEditor::make('content')
                                    ->required()
                                    ->profile('default')
                                    ->columnSpanFull()
                                    ->showMenuBar()
                                    ->direction('auto')
                                    ->minHeight(500),
                            ])
                            ->columnSpan(2),

                        // Sidebar Column (1/3)
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Publishing')
                                    ->schema([
                                        Forms\Components\Select::make('blog_category_id')
                                            ->relationship('category', 'name')
                                            ->nullable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required(),
                                                Forms\Components\TextInput::make('slug')
                                                    ->required(),
                                            ]),
                                        Forms\Components\Select::make('user_id')
                                            ->relationship('user', 'name')
                                            ->default(auth()->id())
                                            ->nullable(),
                                        Forms\Components\Toggle::make('is_published')
                                            ->required()
                                            ->default(false),
                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->default(now()),
                                    ]),
                                Forms\Components\Section::make('Featured Image')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('blog')
                                            ->visibility('public')
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('16:9')
                                            ->imageResizeTargetWidth('1200')
                                            ->imageResizeTargetHeight('675'),
                                    ]),
                                Forms\Components\Section::make('SEO & Social Preview')
                                    ->description('These fields control how this post appears when shared on social media.')
                                    ->schema([
                                        Forms\Components\Textarea::make('excerpt')
                                            ->rows(3)
                                            ->maxLength(300)
                                            ->helperText('Short summary shown in link previews (max 300 chars).'),
                                        Forms\Components\TextInput::make('meta_title')
                                            ->maxLength(70)
                                            ->helperText('Overrides the post title in search results (max 70 chars).'),
                                        Forms\Components\Textarea::make('meta_description')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Description for search engines & social cards (max 160 chars).'),
                                    ])
                                    ->collapsible(),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->square()
                    ->size(60),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Likes')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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