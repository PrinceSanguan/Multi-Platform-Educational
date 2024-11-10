<x-filament::page>
    <div>
        <h2 class="text-2xl font-bold mb-4">Section and Student Progress</h2>
        <canvas id="sectionProgressChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chartData = @json($this->getSectionData());

            console.log('Chart Data:', chartData); // Debugging: Verify the data structure

            // Check if chartData is valid
            if (!chartData || !chartData.labels || !chartData.averages) {
                console.error('Invalid chart data. Ensure getSectionData() returns the correct structure.');
                return; // Exit if data is invalid
            }

            // Initialize the chart with each student's average grade in their respective section
            const ctx = document.getElementById('sectionProgressChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels, // Section - Student names
                    datasets: [{
                        label: 'Average Grades by Student',
                        data: chartData.averages,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Sections - Students'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Average Grade'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    layout: {
                        padding: {
                            left: 20,
                            right: 20
                        }
                    },
                    barThickness: 25 // Adjust as needed for clarity
                }
            });
        });
    </script>
</x-filament::page>
