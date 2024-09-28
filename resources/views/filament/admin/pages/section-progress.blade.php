<x-filament::page>
    <div>
        <h2 class="text-2xl font-bold mb-4">Overall Progress of Each Section</h2>

        <!-- Add a container for the chart -->
        <canvas id="sectionProgressChart" width="400" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Fetch the data passed from the backend
            const chartData = @json($this->getSectionData());

            // Debug: Log the data to the console to verify it
            console.log('Chart Data:', chartData);

            // Check if chartData is valid
            if (!chartData || !chartData.labels || !chartData.averages) {
                console.error('Invalid chart data. Ensure getSectionData() returns the correct structure.');
                return; // Exit if data is invalid
            }

            // Initialize the chart
            const ctx = document.getElementById('sectionProgressChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Average Grades',
                        data: chartData.averages,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
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
        });
    </script>
</x-filament::page>