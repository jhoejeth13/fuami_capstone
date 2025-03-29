@extends('layouts.app')

@section('content')
    <!-- Link the external CSS file -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="mb-8 no-print">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            </div>

            <!-- Filter Type Dropdown -->
            <div class="mb-8 no-print">
                <form action="{{ route('dashboard') }}" method="GET">
                    <label for="filter_type" class="block text-sm font-medium text-gray-700">Filter By:</label>
                    <select name="filter_type" id="filter_type" onchange="this.form.submit()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                        <option value="both" {{ $selectedFilterType === 'both' ? 'selected' : '' }}>Both Total Number of Graduates and Alumni Work Status</option>
                        <option value="graduates" {{ $selectedFilterType === 'graduates' ? 'selected' : '' }}>Total Number of Graduates</option>
                        <option value="alumni" {{ $selectedFilterType === 'alumni' ? 'selected' : '' }}>Alumni Work Status</option>
                    </select>
                    <input type="hidden" name="graduate_year" value="{{ $selectedGraduateYear }}">
                    <input type="hidden" name="employment_year" value="{{ $selectedEmploymentYear }}">
                </form>
            </div>

            <!-- Filters Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 no-print">
                <!-- Graduate Year Filter (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'graduates')
                    <div>
                        <form action="{{ route('dashboard') }}" method="GET">
                            <label for="graduate_year" class="block text-sm font-medium text-gray-700">Filter by Graduate Year:</label>
                            <select name="graduate_year" id="graduate_year" onchange="this.form.submit()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                                <option value="all" {{ $selectedGraduateYear === 'all' ? 'selected' : '' }}>All Years</option>
                                @foreach ($availableGraduateYears as $year)
                                    <option value="{{ $year }}" {{ $selectedGraduateYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="filter_type" value="{{ $selectedFilterType }}">
                            <input type="hidden" name="employment_year" value="{{ $selectedEmploymentYear }}">
                        </form>
                    </div>
                @endif

                <!-- Employment Year Filter (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'alumni')
                    <div>
                        <form action="{{ route('dashboard') }}" method="GET">
                            <label for="employment_year" class="block text-sm font-medium text-gray-700">Filter by Employment Year:</label>
                            <select name="employment_year" id="employment_year" onchange="this.form.submit()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                                <option value="all" {{ $selectedEmploymentYear === 'all' ? 'selected' : '' }}>All Years</option>
                                @foreach ($availableEmploymentYears as $year)
                                    <option value="{{ $year }}" {{ $selectedEmploymentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="filter_type" value="{{ $selectedFilterType }}">
                            <input type="hidden" name="graduate_year" value="{{ $selectedGraduateYear }}">
                        </form>
                    </div>
                @endif
            </div>

            <!-- Clear Filters and Print Buttons -->
            <div class="mb-8 flex items-center gap-4 no-print">
                <a href="{{ route('dashboard') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md shadow-sm transition duration-300 ease-in-out">Clear Filters</a>
                <button onclick="printCharts()" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300 flex items-center gap-2">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>

            <!-- Print Content Container -->
            <div class="print-content">
                <h1 class="text-3xl font-bold text-gray-800">Summary Report</h1> <br>

                <!-- Cards Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Total Graduates Card (Conditional) -->
                    @if ($selectedFilterType === 'both' || $selectedFilterType === 'graduates')
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg transform transition duration-500 hover:scale-105 relative">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">
                                            Total Number of FUAMI Graduates
                                            @if ($selectedGraduateYear !== 'all')
                                                ({{ $selectedGraduateYear }})
                                            @endif
                                        </div>
                                        <div class="mt-2 text-3xl font-semibold text-gray-900">
                                            {{ $totalGraduates }}
                                        </div>
                                    </div>
                                    <div class="text-blue-500">
                                        <i class="fas fa-graduation-cap text-4xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Total Employment Card (Conditional) -->
                    @if ($selectedFilterType === 'both' || $selectedFilterType === 'alumni')
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg transform transition duration-500 hover:scale-105 relative">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">
                                            Total of FUAMI Alumni Work Status
                                            @if ($selectedEmploymentYear !== 'all')
                                                ({{ $selectedEmploymentYear }})
                                            @endif
                                        </div>
                                        <div class="mt-2 text-3xl font-semibold text-gray-900">
                                            {{ $totalAlumni }}
                                        </div>
                                    </div>
                                    <div class="text-green-500">
                                        <i class="fas fa-briefcase text-4xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gender Distribution Chart (Conditional) -->
                    @if ($selectedFilterType === 'both' || $selectedFilterType === 'graduates')
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">SHS Graduates Gender
                                @if ($selectedGraduateYear !== 'all')
                                    ({{ $selectedGraduateYear }})
                                @endif
                            </h2>
                            <canvas id="genderChart" width="400" height="200"></canvas>
                        </div>
                    @endif

                    <!-- Employment Status Chart (Conditional) -->
                    @if ($selectedFilterType === 'both' || $selectedFilterType === 'alumni')
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Employment Status
                                @if ($selectedEmploymentYear !== 'all')
                                    ({{ $selectedEmploymentYear }})
                                @endif
                            </h2>
                            <canvas id="employmentChart" width="400" height="200"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Pass data to JavaScript using data attributes -->
    <div id="chart-data"
         data-gender='@json($genderData)'
         data-employment='@json($employmentData)'>
    </div>

    <!-- Include Chart.js and chartjs-plugin-datalabels -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <!-- Include external JavaScript file -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection