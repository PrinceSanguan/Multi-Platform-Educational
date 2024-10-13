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
    protected static ?string $navigationGroup = 'Teachers';
    protected static string $view = 'filament.admin.pages.section-progress';

    public function getSectionData()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a teacher and fetch sections assigned to them
        $sections = Section::with('students.grades')
            ->where('teacher_id', $user->id) // Assuming 'teacher_id' exists in the sections table
            ->get();

        $chartData = [
            'labels' => [],
            'averages' => [],
        ];

        foreach ($sections as $section) {
            // Calculate the average grade for the section
            $averageGrades = $section->students->flatMap->grades->map(function ($grade) {
                return ($grade->first_quarter + $grade->second_quarter + $grade->third_quarter + $grade->fourth_quarter) / 4;
            });

            $average = $averageGrades->isNotEmpty() ? $averageGrades->avg() : 0;

            // Add section name and average to the chart data
            $chartData['labels'][] = $section->name;
            $chartData['averages'][] = round($average, 2);
        }

        return $chartData;
    }
}