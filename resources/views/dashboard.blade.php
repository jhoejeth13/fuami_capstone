@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Graduate Year Filter -->
                <div id="graduateFilter">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <label for="graduate_year" class="block text-sm font-medium text-gray-700">Filter Graduates:</label>
                        <select name="graduate_year" id="graduate_year" onchange="this.form.submit()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="no_filter" {{ $selectedGraduateYear === 'no_filter' ? 'selected' : '' }}>No Filter</option>
                            <option value="all" {{ $selectedGraduateYear === 'all' ? 'selected' : '' }}>All Years</option>
                            @foreach ($availableGraduateYears as $year)
                                <option value="{{ $year }}" {{ $selectedGraduateYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="employment_year" value="{{ $selectedEmploymentYear }}">
                    </form>
                </div>

                <!-- Employment Year Filter -->
                <div id="employmentFilter">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <label for="employment_year" class="block text-sm font-medium text-gray-700">Filter Employment:</label>
                        <select name="employment_year" id="employment_year" onchange="this.form.submit()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="no_filter" {{ $selectedEmploymentYear === 'no_filter' ? 'selected' : '' }}>No Filter</option>
                            <option value="all" {{ $selectedEmploymentYear === 'all' ? 'selected' : '' }}>All Years</option>
                            @foreach ($availableEmploymentYears as $year)
                                <option value="{{ $year }}" {{ $selectedEmploymentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="graduate_year" value="{{ $selectedGraduateYear }}">
                    </form>
                </div>

                <!-- Combined Filter -->
                <div>
                    <form action="{{ route('dashboard') }}" method="GET">
                        <label for="combined_year" class="block text-sm font-medium text-gray-700">Filter Both:</label>
                        <select name="combined_year" id="combined_year" onchange="this.form.graduate_year.value = this.value; this.form.employment_year.value = this.value; this.form.submit();" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="no_filter" {{ $selectedGraduateYear === 'no_filter' && $selectedEmploymentYear === 'no_filter' ? 'selected' : '' }}>No Filter</option>
                            <option value="all" {{ $selectedGraduateYear === 'all' && $selectedEmploymentYear === 'all' ? 'selected' : '' }}>All Years</option>
                            @foreach ($availableGraduateYears->intersect($availableEmploymentYears) as $year)
                                <option value="{{ $year }}" {{ $selectedGraduateYear == $year && $selectedEmploymentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="graduate_year">
                        <input type="hidden" name="employment_year">
                    </form>
                </div>
            </div>

            <!-- Total Graduates Card -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105 relative mb-8">
                <div class="p-6 text-white">
                    <div class="text-sm font-medium text-blue-100">
                        Total of FUAMI SHS Graduates
                        @if ($selectedGraduateYear !== 'no_filter' && $selectedGraduateYear !== 'all')
                            ({{ $selectedGraduateYear }})
                        @endif
                    </div>
                    <div class="mt-2 text-3xl font-semibold">
                        {{ $totalGraduates }}
                    </div>
                    <div class="mt-4">
                        <span class="text-sm text-blue-100"><br>Last updated: {{ $lastUpdated->format('M d, Y') }}</span>
                    </div>
                </div>
                <!-- Icon Background -->
                <i class="fas fa-graduation-cap absolute bottom-4 right-4 text-white opacity-20 text-6xl"></i>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gender Distribution Chart -->
                @if ($selectedEmploymentYear === 'no_filter' || ($selectedGraduateYear !== 'no_filter' && $selectedEmploymentYear !== 'no_filter'))
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Gender Distribution
                            @if ($selectedGraduateYear !== 'no_filter' && $selectedGraduateYear !== 'all')
                                ({{ $selectedGraduateYear }})
                            @endif
                        </h2>
                        <canvas id="genderChart" width="400" height="200"></canvas>
                    </div>
                @endif

                <!-- Employment Status Chart -->
                @if ($selectedGraduateYear === 'no_filter' || ($selectedGraduateYear !== 'no_filter' && $selectedEmploymentYear !== 'no_filter'))
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Employment Status
                            @if ($selectedEmploymentYear !== 'no_filter' && $selectedEmploymentYear !== 'all')
                                ({{ $selectedEmploymentYear }})
                            @endif
                        </h2>
                        <canvas id="employmentChart" width="400" height="200"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gender Distribution Chart
        @if ($selectedEmploymentYear === 'no_filter' || ($selectedGraduateYear !== 'no_filter' && $selectedEmploymentYear !== 'no_filter'))
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            const genderChart = new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        label: 'Gender Distribution',
                        data: [{{ $genderData['male'] }}, {{ $genderData['female'] }}],
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
                        }
                    }
                }
            });
        @endif

        // Employment Status Chart
        @if ($selectedGraduateYear === 'no_filter' || ($selectedGraduateYear !== 'no_filter' && $selectedEmploymentYear !== 'no_filter'))
            const employmentCtx = document.getElementById('employmentChart').getContext('2d');
            const employmentChart = new Chart(employmentCtx, {
                type: 'bar',
                data: {
                    labels: ['Employed', 'Self-Employed', 'Unemployed'],
                    datasets: [{
                        label: 'Employment Status',
                        data: [{{ $employmentData['employed'] }}, {{ $employmentData['self_employed'] }}, {{ $employmentData['unemployed'] }}],
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
                        }
                    }
                }
            });
        @endif

        // Hide the other filter when one is selected
        document.addEventListener('DOMContentLoaded', function() {
            const graduateFilter = document.getElementById('graduateFilter');
            const employmentFilter = document.getElementById('employmentFilter');
            const graduateYearSelect = document.getElementById('graduate_year');
            const employmentYearSelect = document.getElementById('employment_year');

            graduateYearSelect.addEventListener('change', function() {
                if (this.value !== 'no_filter') {
                    employmentFilter.style.display = 'none';
                } else {
                    employmentFilter.style.display = 'block';
                }
            });

            employmentYearSelect.addEventListener('change', function() {
                if (this.value !== 'no_filter') {
                    graduateFilter.style.display = 'none';
                } else {
                    graduateFilter.style.display = 'block';
                }
            });

            // Initial check to hide/show filters based on current selection
            if (graduateYearSelect.value !== 'no_filter') {
                employmentFilter.style.display = 'none';
            }
            if (employmentYearSelect.value !== 'no_filter') {
                graduateFilter.style.display = 'none';
            }
        });
    </script>
@endsection