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
                    data: [genderData.Male, genderData.Female],
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
            }
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
                    data: [employmentData.Employed, employmentData['Self Employed'], employmentData.Unemployed],
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
            }
        });
    }
}

// Initialize charts when the page loads
document.addEventListener('DOMContentLoaded', function () {
    // Get the chart data from the data attributes
    const chartData = document.getElementById('chart-data');
    
    // Set up Chart.js global defaults
    Chart.defaults.font.family = "'Inter', 'Helvetica', 'Arial', sans-serif";
    Chart.defaults.color = '#6B7280';
    
    // Check if ChartDataLabels is available and register it
    if (window.ChartDataLabels) {
        Chart.register(ChartDataLabels);
        Chart.defaults.plugins.datalabels.color = '#ffffff';
        Chart.defaults.plugins.datalabels.font.weight = 'bold';
    } else {
        console.error('ChartDataLabels plugin not found');
    }
    
    // Function to handle JHS gender chart
    function setupJHSGenderChart() {
        const jhsGenderChart = document.getElementById('jhsGenderChart');
        if (!jhsGenderChart) return;
        
        let jhsGenderData;
        
        try {
            jhsGenderData = JSON.parse(chartData.dataset.jhsGender || '{"Male": 0, "Female": 0}');
        } catch (error) {
            console.error('Error parsing JHS gender data:', error);
            jhsGenderData = {"Male": 0, "Female": 0};
        }
        
        // Default data if empty
        if (Object.keys(jhsGenderData).length === 0) {
            jhsGenderData = {"Male": 0, "Female": 0};
        }
        
        new Chart(jhsGenderChart, {
            type: 'doughnut',
            data: {
                labels: Object.keys(jhsGenderData),
                datasets: [{
                    data: Object.values(jhsGenderData),
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.8)',   // Blue
                        'rgba(236, 72, 153, 0.8)',  // Pink
                    ],
                    borderColor: [
                        'rgba(37, 99, 235, 1)',
                        'rgba(236, 72, 153, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const total = ctx.chart.data.datasets[0].data.reduce((total, data) => total + data, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) + '%' : '0%';
                            return percentage;
                        },
                        display: function(context) {
                            return context.dataset.data[context.dataIndex] > 0;
                        },
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.chart.data.datasets[0].data.reduce((total, data) => total + data, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%',
            }
        });
    }
    
    // Function to handle SHS gender chart
    function setupGenderChart() {
        const genderChart = document.getElementById('genderChart');
        if (!genderChart) return;
        
        let genderData;
        
        try {
            genderData = JSON.parse(chartData.dataset.gender || '{"Male": 0, "Female": 0}');
        } catch (error) {
            console.error('Error parsing gender data:', error);
            genderData = {"Male": 0, "Female": 0};
        }
        
        // Default data if empty
        if (Object.keys(genderData).length === 0) {
            genderData = {"Male": 0, "Female": 0};
        }
        
        new Chart(genderChart, {
            type: 'doughnut',
            data: {
                labels: Object.keys(genderData),
                datasets: [{
                    data: Object.values(genderData),
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.8)',   // Blue
                        'rgba(236, 72, 153, 0.8)',  // Pink
                    ],
                    borderColor: [
                        'rgba(37, 99, 235, 1)',
                        'rgba(236, 72, 153, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const total = ctx.chart.data.datasets[0].data.reduce((total, data) => total + data, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) + '%' : '0%';
                            return percentage;
                        },
                        display: function(context) {
                            return context.dataset.data[context.dataIndex] > 0;
                        },
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.chart.data.datasets[0].data.reduce((total, data) => total + data, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%',
            }
        });
    }
    
    // Function to handle employment status chart
    function setupEmploymentChart() {
        const employmentChart = document.getElementById('employmentChart');
        if (!employmentChart) return;
        
        let employmentData;
        
        try {
            employmentData = JSON.parse(chartData.dataset.employment || '{"Employed": 0, "Self Employed": 0, "Unemployed": 0}');
        } catch (error) {
            console.error('Error parsing employment data:', error);
            employmentData = {"Employed": 0, "Self Employed": 0, "Unemployed": 0};
        }
        
        // Default data if empty
        if (Object.keys(employmentData).length === 0) {
            employmentData = {"Employed": 0, "Self Employed": 0, "Unemployed": 0};
        }
        
        const ctx = employmentChart.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(employmentData),
                datasets: [{
                    data: Object.values(employmentData),
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green
                        'rgba(139, 92, 246, 0.8)',  // Purple
                        'rgba(239, 68, 68, 0.8)',   // Red
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            drawBorder: true,
                            drawOnChartArea: true,
                            drawTicks: true,
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: '#000',
                        formatter: (value) => value,
                        display: function(context) {
                            return context.dataset.data[context.dataIndex] > 0;
                        },
                    }
                },
            }
        });
    }
    
    // Function to handle JHS employment chart
    function setupJHSEmploymentChart() {
        const jhsEmploymentChart = document.getElementById('jhsEmploymentChart');
        if (!jhsEmploymentChart) return;
        
        let jhsEmploymentData;
        
        try {
            jhsEmploymentData = JSON.parse(chartData.dataset.jhsEmployment || '{"Employed": 0, "Unemployed": 0}');
        } catch (error) {
            console.error('Error parsing JHS employment data:', error);
            jhsEmploymentData = {"Employed": 0, "Unemployed": 0};
        }
        
        // Default data if empty
        if (Object.keys(jhsEmploymentData).length === 0) {
            jhsEmploymentData = {"Employed": 0, "Unemployed": 0};
        }
        
        const ctx = jhsEmploymentChart.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(jhsEmploymentData),
                datasets: [{
                    data: Object.values(jhsEmploymentData),
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green for Employed
                        'rgba(239, 68, 68, 0.8)',   // Red for Unemployed
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            drawBorder: true,
                            drawOnChartArea: true,
                            drawTicks: true,
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: '#000',
                        formatter: (value) => value,
                        display: function(context) {
                            return context.dataset.data[context.dataIndex] > 0;
                        },
                    }
                },
            }
        });
    }
    
    // Initialize all charts
    setupJHSGenderChart();
    setupGenderChart();
    setupEmploymentChart();
    setupJHSEmploymentChart();
    
    // Set up event listener for the print button
    const printButton = document.getElementById('print-dashboard');
    if (printButton) {
        printButton.addEventListener('click', function() {
            printCharts();
        });
    }
});