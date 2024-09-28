<?php

namespace App\Filament\Admin\Pages;

use App\Models\Section;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;

class SectionStudentProgress extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.section-student-progress';

    public $selectedSectionId = null;

    protected $listeners = ['sectionDataUpdated' => 'updateChartData'];

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
