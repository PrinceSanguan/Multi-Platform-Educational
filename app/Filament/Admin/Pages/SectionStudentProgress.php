<?php

namespace App\Filament\Admin\Pages;

use App\Models\Section;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SectionStudentProgress extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.section-student-progress';

    public $selectedSectionId = null;

    protected $listeners = ['sectionDataUpdated' => 'updateChartData'];

    public static function canView(): bool
    {
        $user = Auth::user();

        // Allow super admins to view the page
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Check if the user is a teacher assigned to the section
        if ($user->hasRole('teacher') && $user->sections()->exists()) {
            return true;
        }

        // Deny access for all other roles
        return false;
    }

    public function getSectionData()
    {
        if (! $this->selectedSectionId) {
            return [
                'labels' => [],
                'averages' => [],
            ];
        }

        // Fetch section with students and their grades
        $section = Section::with('students.grades')->find($this->selectedSectionId);

        if (! $section) {
            return [
                'labels' => [],
                'averages' => [],
            ];
        }

        // Check if the teacher is assigned to this section
        if (Auth::user()->hasRole('teacher') && Auth::user()->id !== $section->teacher_id) {
            // Log an unauthorized access attempt
            Log::warning('Unauthorized access attempt to section data.', [
                'user_id' => Auth::user()->id,
                'section_id' => $this->selectedSectionId,
            ]);

            // Return empty data if the teacher is not assigned to the section
            return [
                'labels' => [],
                'averages' => [],
            ];
        }

        // Debugging: Log the section data
        Log::info('Section Data:', ['section' => $section]);

        $chartData = [
            'labels' => [],
            'averages' => [],
        ];

        if ($section) {
            foreach ($section->students as $student) {
                $chartData['labels'][] = $student->name;

                // Calculate the student's average grade
                $grades = $student->grades;
                $average = $grades->map(function ($grade) {
                    return ($grade->first_quarter + $grade->second_quarter + $grade->third_quarter + $grade->fourth_quarter) / 4;
                })->avg();

                $chartData['averages'][] = round($average, 2);
            }
        }

        // Debugging: Log the chart data
        Log::info('Chart Data:', $chartData);

        return $chartData;
    }
}
