<?php

namespace App\Filament\Admin\Pages;

use App\Models\Section;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class SectionProgress extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Modules';

    protected static string $view = 'filament.admin.pages.section-progress';

    public function getSectionData()
    {
        $user = Auth::user();

        // For super_admin or principal, get all sections; otherwise, get sections assigned to the teacher
        $sectionsQuery = Section::with('students.grades');
        if ($user->hasRole('teacher')) {
            $sectionsQuery->where('user_id', $user->id);
        }

        $sections = $sectionsQuery->get();

        $chartData = [
            'labels' => [],
            'averages' => [],
        ];

        foreach ($sections as $section) {
            // For each section, calculate the average grade for each student
            foreach ($section->students as $student) {
                $averageGrade = $student->grades->map(function ($grade) {
                    return ($grade->first_quarter + $grade->second_quarter + $grade->third_quarter + $grade->fourth_quarter) / 4;
                })->avg();

                // Add section name with student name as a label and the average grade as data
                $chartData['labels'][] = "{$section->name} - {$student->name}";
                $chartData['averages'][] = round($averageGrade, 2);
            }
        }

        return $chartData;
    }
}
