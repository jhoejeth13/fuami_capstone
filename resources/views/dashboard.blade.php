@extends('layouts.app')

@section('content')
    <!-- Link the external CSS file -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

<div class="py-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Message Only -->
        <div class="mb-8">
            <div class="bg-gradient-to-br from-indigo-600 to-blue-500 rounded-xl shadow-xl overflow-hidden text-white no-print">
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-2">Welcome Back!</h1>
                    <p class="text-indigo-100 text-sm mb-4">Here's your school repository overview</p>
                    <div class="mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-indigo-100">Today's Date</span>
                            <span class="font-semibold">{{ date('M d, Y') }}</span>
                        </div>
                        <div class="h-1 w-full bg-white/20 rounded-full mb-4"></div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-calendar-check text-indigo-200"></i>
                            <span class="text-sm text-indigo-100">{{ date('l') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-6 bg-black/10">
                    <button onclick="printCharts()" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all duration-300">
                        <i class="fas fa-print"></i>
                        <span>Print Report</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-all duration-300">
                        <i class="fas fa-sync-alt"></i>
                        <span>Refresh</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Reports & Analytics Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 md:mb-0">Data Analytics</h2>

                <!-- Filters Controls -->
                <div class="flex flex-wrap gap-4 no-print">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex-grow max-w-xs">
                        <select name="filter_type" id="filter_type" onchange="this.form.submit()" class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                            <option value="both" {{ $selectedFilterType === 'both' ? 'selected' : '' }}>All Data</option>
                            <option value="jhs_graduates" {{ $selectedFilterType === 'jhs_graduates' ? 'selected' : '' }}>Total Number of JHS Graduates</option>
                            <option value="graduates" {{ $selectedFilterType === 'graduates' ? 'selected' : '' }}>Total Number of SHS Graduates</option>
                            <option value="alumni" {{ $selectedFilterType === 'alumni' ? 'selected' : '' }}>Alumni Work Status</option>
                        </select>
                        <input type="hidden" name="graduate_year" value="{{ $selectedGraduateYear }}">
                        <input type="hidden" name="employment_year" value="{{ $selectedEmploymentYear }}">
                    </form>

                    @if ($selectedFilterType === 'both' || $selectedFilterType === 'graduates')
                        <form action="{{ route('dashboard') }}" method="GET" class="flex-grow max-w-xs">
                            <select name="graduate_year" id="graduate_year" onchange="this.form.submit()" class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                <option value="all" {{ $selectedGraduateYear === 'all' ? 'selected' : '' }}>All Years</option>
                                @foreach ($availableGraduateYears as $year)
                                    <option value="{{ $year }}" {{ $selectedGraduateYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="filter_type" value="{{ $selectedFilterType }}">
                            <input type="hidden" name="employment_year" value="{{ $selectedEmploymentYear }}">
                        </form>
                    @endif

                    @if ($selectedFilterType === 'both' || $selectedFilterType === 'alumni')
                        <form action="{{ route('dashboard') }}" method="GET" class="flex-grow max-w-xs">
                            <select name="employment_year" id="employment_year" onchange="this.form.submit()" class="w-full px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                                <option value="all" {{ $selectedEmploymentYear === 'all' ? 'selected' : '' }}>All Years</option>
                                @foreach ($availableEmploymentYears as $year)
                                    <option value="{{ $year }}" {{ $selectedEmploymentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="filter_type" value="{{ $selectedFilterType }}">
                            <input type="hidden" name="graduate_year" value="{{ $selectedGraduateYear }}">
                        </form>
                    @endif

                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <i class="fas fa-sync-alt mr-2"></i> Reset
                    </a>
                </div>
            </div>
        </div>

        <!-- Print Content Container -->
        <div class="print-content">
            <div class="print-only">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">FUAMI School Repository Analytics Report</h1>
                <p class="text-sm text-center text-gray-600 mb-6">Generated on {{ date('F d, Y') }}</p>
            </div>

            <!-- Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- JHS Total Card (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'jhs_graduates')
                    <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">Total FUAMI JHS Graduates
                                @if ($selectedGraduateYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedGraduateYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="rounded-full bg-blue-100 p-4 mr-4">
                                    <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $totalJHSStudents ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Total Records</div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <i class="fas fa-chart-line text-5xl text-gray-200"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Total SHS Graduates Card (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'graduates')
                    <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">Total FUAMI SHS Graduates
                                @if ($selectedGraduateYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedGraduateYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="rounded-full bg-blue-100 p-4 mr-4">
                                    <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $totalGraduates }}</div>
                                    <div class="text-sm text-gray-500">Total Records</div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <i class="fas fa-chart-line text-5xl text-gray-200"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Total Employment Card (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'alumni')
                    <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">SHS Alumni Work Status
                                @if ($selectedEmploymentYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedEmploymentYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="rounded-full bg-green-100 p-4 mr-4">
                                    <i class="fas fa-briefcase text-green-600 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $totalAlumni }}</div>
                                    <div class="text-sm text-gray-500">Total Responses</div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <i class="fas fa-chart-bar text-5xl text-gray-200"></i>
                            </div>
                        </div>
                    </div>

                    <!-- JHS Alumni Work Status Card -->
                    <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">JHS Alumni Work Status
                                @if ($selectedEmploymentYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedEmploymentYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="rounded-full bg-purple-100 p-4 mr-4">
                                    <i class="fas fa-briefcase text-purple-600 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-800">{{ $totalJHSAlumni }}</div>
                                    <div class="text-sm text-gray-500">Total Responses</div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <i class="fas fa-chart-bar text-5xl text-gray-200"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- JHS Gender Distribution Chart (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'jhs_graduates')
                    <div class="bg-white overflow-hidden rounded-xl shadow-md">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">JHS Students Gender Distribution
                                @if ($selectedGraduateYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedGraduateYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <span class="w-4 h-4 bg-blue-500 mr-2 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Male</span>
                                    <span class="ml-2 text-blue-600 font-bold">({{ $jhsMaleCount }})</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-4 h-4 bg-pink-500 mr-2 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Female</span>
                                    <span class="ml-2 text-pink-600 font-bold">({{ $jhsFemaleCount }})</span>
                                </div>
                            </div>
                            <div class="h-[300px]">
                                <canvas id="jhsGenderChart" class="w-full h-full"></canvas>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- SHS Gender Distribution Chart (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'graduates')
                    <div class="bg-white overflow-hidden rounded-xl shadow-md">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">SHS Graduates Gender Distribution
                                @if ($selectedGraduateYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedGraduateYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <span class="w-4 h-4 bg-blue-500 mr-2 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Male</span>
                                    <span class="ml-2 text-blue-600 font-bold">({{ $shsMaleCount }})</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-4 h-4 bg-pink-500 mr-2 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Female</span>
                                    <span class="ml-2 text-pink-600 font-bold">({{ $shsFemaleCount }})</span>
                                </div>
                            </div>
                            <div class="h-[300px]">
                                <canvas id="genderChart" class="w-full h-full"></canvas>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Employment Status Chart (Conditional) -->
                @if ($selectedFilterType === 'both' || $selectedFilterType === 'alumni')
                    <div class="bg-white overflow-hidden rounded-xl shadow-md">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">SHS Alumni Work Status Distribution
                                @if ($selectedEmploymentYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedEmploymentYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6">
                            <canvas id="employmentChart" width="400" height="300"></canvas>
                        </div>
                    </div>

                    <!-- JHS Employment Status Chart -->
                    <div class="bg-white overflow-hidden rounded-xl shadow-md">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="font-semibold text-gray-700">JHS Alumni Work Status Distribution
                                @if ($selectedEmploymentYear !== 'all')
                                    <span class="text-sm font-normal text-gray-500">({{ $selectedEmploymentYear }})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6">
                            <canvas id="jhsEmploymentChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js and Chart.js Data Labels plugin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <!-- Pass data to JavaScript using data attributes -->
    <div id="chart-data"
         data-gender='@json($genderData)'
         data-employment='@json($employmentData)'
         data-jhs-gender='@json($jhsGenderData)'
         data-jhs-employment='@json($jhsEmploymentData)'>
    </div>

<!-- Include dashboard.js script -->
<script src="{{ asset('js/dashboard.js') }}"></script>

<style>
    /* Custom select styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    /* Print specific styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        .print-only {
            display: block !important;
        }
        
        body {
            background-color: white !important;
        }
        
        .print-content {
            padding: 1rem;
            max-width: 100%;
        }
    }
    
    .print-only {
        display: none;
    }
</style>
@endsection