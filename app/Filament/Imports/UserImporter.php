<?php

namespace App\Filament\Imports;

use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('avatar_url')
                ->rules(['max:255']),
            ImportColumn::make('email_verified_at')
                ->rules(['email', 'datetime']),
            ImportColumn::make('password')
                ->rules(['required', 'max:255']),
            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('section_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('theme')
                ->rules(['max:255']),
            ImportColumn::make('theme_color')
                ->rules(['max:255']),
            ImportColumn::make('active_status')
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('avatar')
                ->rules(['required', 'max:255']),
            ImportColumn::make('dark_mode')
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('messenger_color')
                ->rules(['max:255']),
            ImportColumn::make('parent_id')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?User
    {
        // return User::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new User();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
