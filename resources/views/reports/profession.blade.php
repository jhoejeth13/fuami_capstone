@extends('layouts.app')

@section('content')
<!-- Link the external CSS file -->
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

<div class="py-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-gradient-to-br from-indigo-600 to-blue-500 rounded-xl shadow-xl overflow-hidden text-white no-print">
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-2">FUAMI Alumni Profession Analysis</h1>
                    <p class="text-indigo-100 text-sm mb-4">Fr. Urios Academy of Magallanes, Inc. Graduates Database System</p>
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center space-x-4">
                            <span class="text-indigo-100">Report Type</span>
                            <span class="font-semibold">{{ $graduateType }} Alumni Professions</span>
                        </div>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all duration-300">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="font-semibold text-gray-700">
                        <i class="fas fa-filter text-blue-500 mr-2"></i> Filter Options
                    </h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('reports.profession') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="graduate_type" class="block text-sm font-medium text-gray-700 mb-1">Graduate Type</label>
                            <select name="graduate_type" id="graduate_type" class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                <option value="JHS" {{ $graduateType == 'JHS' ? 'selected' : '' }}>Junior High School</option>
                                <option value="SHS" {{ $graduateType == 'SHS' ? 'selected' : '' }}>Senior High School</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Graduation Year</label>
                            <select name="year" id="year" class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                <option value="">All Years</option>
                                @foreach($years as $yr)
                                    <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>
                                        {{ $yr }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select name="gender" id="gender" class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                <option value="">All Genders</option>
                                <option value="Male" {{ $selectedGender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $selectedGender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition-colors duration-300">
                                <i class="fas fa-filter mr-2"></i> Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($professionData->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <i class="fas fa-info-circle text-4xl text-blue-500 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900">No data found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your filters to see results</p>
                    </div>
                </div>
            </div>
        @else
            <!-- Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Alumni Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="font-semibold text-gray-700">Total Alumni</h3>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-100 p-4 mr-4">
                                <i class="fas fa-users text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-gray-800">{{ $totalGraduates }}</div>
                                <div class="text-sm text-gray-500">Total Records</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Unique Professions Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="font-semibold text-gray-700">Unique Professions</h3>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-100 p-4 mr-4">
                                <i class="fas fa-briefcase text-green-600 text-2xl"></i>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-gray-800">{{ $professionData->count() }}</div>
                                <div class="text-sm text-gray-500">Different Professions</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Top Profession Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="font-semibold text-gray-700">Top Profession</h3>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="rounded-full bg-purple-100 p-4 mr-4">
                                <i class="fas fa-trophy text-purple-600 text-2xl"></i>
                            </div>
                            <div>
                                <div class="text-xl font-bold text-gray-800 truncate">{{ $professionData->first()->occupational_classification ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $professionData->first()->total ?? 0 }} alumni</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Data Coverage Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="font-semibold text-gray-700">Data Coverage</h3>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="rounded-full bg-yellow-100 p-4 mr-4">
                                <i class="fas fa-database text-yellow-600 text-2xl"></i>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-gray-800">{{ number_format(($professionData->sum('total') / $totalGraduates) * 100, 1) }}%</div>
                                <div class="text-sm text-gray-500">of alumni with data</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart and Table Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Chart Section -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md">
                    <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-700">
                            <i class="fas fa-chart-pie text-blue-500 mr-2"></i> Profession Distribution
                        </h3>
                        <div class="flex space-x-1">
                            <button type="button" class="px-3 py-1 text-sm rounded-l-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 chart-type-btn active" data-type="doughnut">
                                Doughnut
                            </button>
                            <button type="button" class="px-3 py-1 text-sm border-t border-b border-gray-300 bg-white text-gray-700 hover:bg-gray-50 chart-type-btn" data-type="pie">
                                Pie
                            </button>
                            <button type="button" class="px-3 py-1 text-sm rounded-r-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 chart-type-btn" data-type="bar">
                                Bar
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="h-[300px]">
                            <canvas id="professionChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="bg-white overflow-hidden rounded-xl shadow-md">
                    <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-700">
                            <i class="fas fa-table text-blue-500 mr-2"></i> Profession Breakdown
                        </h3>
                        <div class="relative max-w-xs">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="professionSearch" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search...">
                        </div>
                    </div>
                    <div class="p-0">
                        <div class="overflow-auto" style="max-height: 350px;">
                            <table class="min-w-full divide-y divide-gray-200" id="professionTable">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profession</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Alumni</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">%</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($professionData as $profession)
                                        <tr class="profession-row hover:bg-gray-50" data-profession="{{ strtolower($profession->occupational_classification) }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: {{ getProfessionalColor($loop->index) }}"></span>
                                                    <span class="text-sm font-medium text-gray-900">{{ $profession->occupational_classification }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                                {{ $profession->total }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{ number_format(($profession->total / $totalGraduates) * 100, 1) }}%
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button class="text-indigo-600 hover:text-indigo-900 view-alumni-btn" 
                                                        data-profession="{{ $profession->occupational_classification }}"
                                                        data-count="{{ $profession->total }}">
                                                    <i class="fas fa-eye mr-1"></i> View Alumni
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 text-right text-sm text-gray-500">
                        Showing {{ $professionData->count() }} profession categories
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Alumni Modal -->
<div class="fixed inset-0 overflow-y-auto z-50 hidden" id="alumniModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                            Alumni List
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-4">
                                Showing <span id="alumniCount">0</span> alumni working as <span id="modalProfession" class="font-semibold"></span>
                            </p>
                            <div class="overflow-auto max-h-96">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year Graduated</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="alumniList">
                                        <!-- Alumni will be inserted here dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@if(!$professionData->isEmpty())
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare data for chart
    const professionLabels = @json($professionData->pluck('occupational_classification'));
    const professionCounts = @json($professionData->pluck('total'));
    const totalGraduates = {{ $totalGraduates }};
    const allAlumni = @json($allAlumni ?? []);
    
    // Color generator
    function getProfessionalColor(index) {
        const colors = [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
            '#858796', '#5a5c69', '#3a3b45', '#2e59d9', '#17a673',
            '#2c9faf', '#dda20a', '#be2617', '#6c757d', '#5a6268'
        ];
        return colors[index % colors.length];
    }

    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 12,
                    padding: 15,
                    font: {
                        size: 11
                    },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const percentage = ((value / totalGraduates) * 100).toFixed(1);
                        return `${label}: ${value} alumni (${percentage}%)`;
                    }
                },
                displayColors: true,
                usePointStyle: true,
                padding: 12,
                backgroundColor: 'rgba(0,0,0,0.85)'
            }
        },
        animation: {
            animateScale: true,
            animateRotate: true,
            duration: 1500
        }
    };

    // Create the initial chart
    const ctx = document.getElementById('professionChart').getContext('2d');
    let professionChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: professionLabels,
            datasets: [{
                label: 'Alumni Count',
                data: professionCounts,
                backgroundColor: professionLabels.map((_, index) => getProfessionalColor(index)),
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 15
            }]
        },
        options: {
            ...commonOptions,
            cutout: '60%'
        }
    });
    
    // Chart type switching
    document.querySelectorAll('.chart-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.chart-type-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Destroy the current chart
            professionChart.destroy();
            
            // Create new chart with selected type
            const newOptions = {...commonOptions};
            
            // Special options for bar chart
            if (this.dataset.type === 'bar') {
                newOptions.indexAxis = 'y'; // Horizontal bar chart
                newOptions.scales = {
                    x: {
                        beginAtZero: true
                    }
                };
            }
            
            professionChart = new Chart(ctx, {
                type: this.dataset.type,
                data: {
                    labels: professionLabels,
                    datasets: [{
                        label: 'Alumni Count',
                        data: professionCounts,
                        backgroundColor: professionLabels.map((_, index) => getProfessionalColor(index)),
                        borderColor: '#fff',
                        borderWidth: 2,
                        hoverOffset: 15
                    }]
                },
                options: newOptions
            });
        });
    });
    
    // Table search functionality
    document.getElementById('professionSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('#professionTable tbody tr').forEach(row => {
            const profession = row.dataset.profession;
            if (profession.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Alumni modal functionality
    const modal = document.getElementById('alumniModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalProfession = document.getElementById('modalProfession');
    const alumniCount = document.getElementById('alumniCount');
    const alumniList = document.getElementById('alumniList');
    
    document.querySelectorAll('.view-alumni-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const profession = this.dataset.profession;
            const count = this.dataset.count;
            
            // Filter alumni by selected profession
            const filteredAlumni = allAlumni.filter(alumni => 
                alumni.occupational_classification === profession
            );
            
            // Update modal content
            modalProfession.textContent = profession;
            alumniCount.textContent = count;
            
            // Clear previous alumni list
            alumniList.innerHTML = '';
            
            // Populate alumni list
            filteredAlumni.forEach(alumni => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                const fullName = `${alumni.first_name} ${alumni.middle_name ? alumni.middle_name + ' ' : ''}${alumni.last_name}${alumni.suffix ? ' ' + alumni.suffix : ''}`;
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${fullName}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${alumni.year_graduated}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${alumni.gender}</div>
                    </td>
                `;
                
                alumniList.appendChild(row);
            });
            
            // Show modal
            modal.classList.remove('hidden');
        });
    });
    
    // Close modal
    document.querySelector('.close-modal').addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endif

@php
function getProfessionalColor($index) {
    $colors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#858796', '#5a5c69', '#3a3b45', '#2e59d9', '#17a673',
        '#2c9faf', '#dda20a', '#be2617', '#6c757d', '#5a6268'
    ];
    return $colors[$index % count($colors)];
}
@endphp

<style>
    /* Custom select styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    /* Active state for chart type buttons */
    .chart-type-btn.active {
        background-color: #e5e7eb;
        font-weight: 500;
    }
    
    /* Table row hover effect */
    .profession-row:hover {
        background-color: #f9fafb;
    }
    
    /* Sticky table header */
    thead.sticky th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f9fafb;
    }
    
    /* Modal transition */
    #alumniModal {
        transition: opacity 0.3s ease;
    }

    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection