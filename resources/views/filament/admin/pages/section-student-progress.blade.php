<x-filament::page>
    <div>
        {{-- <h2 class="text-2xl font-bold mb-4">Student Progress per Section</h2> --}}

        <!-- Section Dropdown -->
        <div class="mb-4">
            <select wire:model="selectedSectionId" class="form-control">
                <option value="">Select Section</option>
                @foreach (\App\Models\Section::all() as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Chart Container -->
        <canvas id="studentProgressChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('studentProgressChart').getContext('2d');
            let studentChart;

            function renderChart(chartData) {
                if (studentChart) {
                    studentChart.destroy();
                }

                studentChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Average Grades',
                            data: chartData.averages,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            }

            window.addEventListener('sectionDataUpdated', event => {
                // Debugging: Log the event data
                console.log('Received sectionDataUpdated event:', event.detail);
                
                renderChart(event.detail);
            });
        });
    </script>
</x-filament::page>