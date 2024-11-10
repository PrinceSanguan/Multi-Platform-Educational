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

    public $selectedSectionId = null; // Set this dynamically, e.g., via user selection or default

    protected $listeners = ['sectionDataUpdated' => 'updateChartData'];

    public static function canView(): bool
    {
        $user = Auth::user();

        // Allow access if the user has the 'super_admin' or 'principal' role,
        // or if the user is a 'teacher' with assigned sections
        return $user->hasAnyRole(['super_admin', 'principal']) || ($user->hasRole('teacher') && $user->sections()->exists());
    }

    public function getSectionData()
    {
        if (! $this->selectedSectionId) {
            return [
                'labels' => [],
                'averages' => [],
            ];
        }

        $section = Section::with('students.grades')->find($this->selectedSectionId);

        if (! $section) {
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

        foreach ($section->students as $student) {
            $chartData['labels'][] = $student->name;

            // Calculate the student's average grade
            $average = $student->grades->map(function ($grade) {
                return ($grade->first_quarter + $grade->second_quarter + $grade->third_quarter + $grade->fourth_quarter) / 4;
            })->avg();

            $chartData['averages'][] = round($average, 2);
        }

        // Debugging: Log the chart data
        Log::info('Chart Data:', $chartData);

        return $chartData;
    }
}
