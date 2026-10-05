<?php

namespace App\Filament\Resources\NewsResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Article')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(190)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                if (filled($get('slug'))) {
                                    return;
                                }

                                $set('slug', Str::slug((string) $state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(190)
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the article URL. Auto-generated from the title if left empty.'),
                        FileUpload::make('feature_image_path')
                            ->label('Feature image')
                            ->image()
                            ->directory('news')
                            ->disk('public')
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->nullable()
                            ->helperText('Recommended size: 1600×900 (16:9). Also used as the social share image.'),
                        Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->rows(3)
                            ->maxLength(500)
                            ->nullable()
                            ->helperText('Short summary shown on the news list and used as a fallback meta description.'),
                        RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'link',
                                'h2',
                                'h3',
                                'redo',
                                'undo',
                            ]),
                        DateTimePicker::make('published_at')
                            ->label('Publish date')
                            ->seconds(false)
                            ->native(false)
                            ->nullable()
                            ->helperText('Leave empty to keep as draft. Set to now or a past date to publish.'),
                    ]),
                Section::make('SEO')
                    ->description('Optional overrides for search engines and social sharing. Leave blank to auto-generate from title/excerpt.')
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta title')
                            ->maxLength(70)
                            ->helperText('Recommended max ~60–70 characters. Defaults to the article title.'),
                        Textarea::make('meta_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Recommended max ~150–160 characters. Defaults to the excerpt or content preview.'),
                        TextInput::make('meta_keywords')
                            ->label('Meta keywords')
                            ->maxLength(255)
                            ->helperText('Optional comma-separated keywords (e.g. jaffna film festival, cinema news).'),
                    ]),
            ]);
    }
}
