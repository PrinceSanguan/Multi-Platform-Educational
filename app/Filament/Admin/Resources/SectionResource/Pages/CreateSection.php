<?php

namespace App\Filament\Admin\Resources\SectionResource\Pages;

use App\Filament\Admin\Resources\SectionResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateSection extends CreateRecord
{
    protected static string $resource = SectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validateStudentAssignment($data);
        return $data;
    }
    private function validateStudentAssignment(array $data)
    {
        $assignedStudents = $data['students'] ?? [];

        foreach ($assignedStudents as $studentId) {
            $student = User::find($studentId);

            if ($student && $student->section_id) {
                throw ValidationException::withMessages([
                    'students' => "Student {$student->name} is already assigned to another section.",
                ]);
            }
        }
    }


}