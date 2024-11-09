<?php

namespace App\Filament\Admin\Resources\GradeResource\Widgets;

use App\Models\Grade;
use App\Models\Section;
use Filament\Facades\Filament;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class StudentGradeChart extends ApexChartWidget
{
    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user->hasAnyRole(['super_admin', 'admin', 'teacher']);
    }

    /**
     * Chart Id
     */
    protected static ?string $chartId = 'studentGradeChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Student Grade Distribution by Section';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        // Fetch all sections
        $sections = Section::with('students.grades')->get();

        $sectionGrades = [];

        // Calculate average grades for each section
        foreach ($sections as $section) {
            $totalGrade = 0;
            $studentCount = 0;

            foreach ($section->students as $student) {
                // Get the student's grades
                $grades = Grade::where('user_id', $student->id)->get();

                foreach ($grades as $grade) {
                    // Calculate the average grade for this student
                    $averageGrade = ($grade->first_quarter + $grade->second_quarter + $grade->third_quarter + $grade->fourth_quarter) / 4;
                    $totalGrade += $averageGrade;
                    $studentCount++;
                }
            }

            // Calculate the average grade for the section
            if ($studentCount > 0) {
                $sectionGrades[$section->name] = $totalGrade / $studentCount;
            }
        }

        // Prepare chart data
        $labels = array_keys($sectionGrades);
        $series = array_values($sectionGrades);

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => $series,
            'labels' => $labels,
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'labels' => [
                            'show' => true,
                            'name' => [
                                'show' => true,
                                'fontSize' => '22px',
                                'fontFamily' => 'inherit',
                            ],
                            'value' => [
                                'show' => true,
                                'fontSize' => '16px',
                                'fontFamily' => 'inherit',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
