<?php

namespace App\Filament\Support;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class TitleSlugFields
{
    public static function make(string $titleLabel = 'Judul'): array
    {
        return [
            TextInput::make('title')
                ->label($titleLabel)
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn(string $operation, $state, Set $set) =>
                    $operation === 'create' ? $set('slug', Str::slug($state)) : null
                ),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->disabled()
                ->dehydrated(),
        ];
    }
}
