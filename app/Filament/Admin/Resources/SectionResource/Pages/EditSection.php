<?php

namespace App\Filament\Admin\Resources\SectionResource\Pages;

use App\Filament\Admin\Resources\SectionResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditSection extends EditRecord
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->validateStudentAssignment($data);

        return $data;
    }

    private function validateStudentAssignment(array $data)
    {
        $assignedStudents = $data['students'] ?? [];

        foreach ($assignedStudents as $studentId) {
            $student = User::find($studentId);

            if ($student && $student->section_id && $student->section_id !== $this->record->id) {
                throw ValidationException::withMessages([
                    'students' => "Student {$student->name} is already assigned to another section.",
                ]);
            }
        }
    }
}
