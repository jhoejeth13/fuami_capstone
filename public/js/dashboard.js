// Function to ensure charts are fully rendered before printing
function printCharts() {
    const charts = document.querySelectorAll('canvas'); // Get all chart canvases
    const promises = [];

    // Convert each chart canvas to an image and wait for it to load
    charts.forEach((chart) => {
        const promise = new Promise((resolve) => {
            const image = new Image();
            image.src = chart.toDataURL(); // Convert canvas to image
            image.onload = () => resolve(image);
        });
        promises.push(promise);
    });

    // Wait for all charts to be converted to images
    Promise.all(promises).then((images) => {
        // Replace the canvas elements with their image equivalents
        charts.forEach((chart, index) => {
            const parent = chart.parentElement;
            const image = images[index];
            parent.replaceChild(image, chart); // Replace canvas with image
        });

        // Trigger the print dialog
        printDashboard();
    });
}

// Print Functionality
function printDashboard() {
    const originalContent = document.body.innerHTML; // Save the original content
    const printContent = document.querySelector('.print-content').innerHTML; // Get the content to print

    // Replace the body content with only the print content
    document.body.innerHTML = `
        <div class="p-8">
            ${printContent}
        </div>
    `;

    window.print(); // Trigger the print dialog

    // Restore the original content after printing
    document.body.innerHTML = originalContent;
    window.location.reload(); // Reload to restore functionality
}

// Initialize Charts
function initializeCharts() {
    const chartData = document.getElementById('chart-data');
    const genderData = JSON.parse(chartData.dataset.gender);
    const employmentData = JSON.parse(chartData.dataset.employment);

    console.log('Gender Data:', genderData);
    console.log('Employment Data:', employmentData);

    // Gender Distribution Chart
    if (genderData && document.getElementById('genderChart')) {
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    label: 'Gender Distribution',
                    data: [genderData.male, genderData.female],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)', // Blue for Male
                        'rgba(255, 99, 132, 0.8)', // Red for Female
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value) => value
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // Employment Status Chart
    if (employmentData && document.getElementById('employmentChart')) {
        const employmentCtx = document.getElementById('employmentChart').getContext('2d');
        new Chart(employmentCtx, {
            type: 'bar',
            data: {
                labels: ['Employed', 'Self-Employed', 'Unemployed'],
                datasets: [{
                    label: 'Employment Status',
                    data: [employmentData.employed, employmentData.self_employed, employmentData.unemployed],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)', // Green for Employed
                        'rgba(153, 102, 255, 0.8)', // Purple for Self-Employed
                        'rgba(255, 159, 64, 0.8)', // Orange for Unemployed
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#000',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value) => value
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }
}

// Initialize charts when the page loads
document.addEventListener('DOMContentLoaded', initializeCharts);