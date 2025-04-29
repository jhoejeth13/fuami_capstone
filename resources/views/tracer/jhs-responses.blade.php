@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">JHS Graduate Tracer Study</h1>
                    <p class="text-gray-600 mt-2">Track and manage JHS alumni graduates information</p>
                </div>
            </div>
        </div>
        
        <!-- Notification Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter and Control Panel -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Filters & Controls</h2>
                    <span class="text-sm text-gray-500">{{ $responses->firstItem() ?? 0 }} - {{ $responses->lastItem() ?? 0 }} of {{ $responses->total() }} results</span>
                </div>
                <form method="GET" action="{{ route('tracer-responses.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <input type="hidden" name="type" value="jhs">
                    
                    <div class="space-y-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search by Name</label>
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Enter student name..."
                                   class="block w-full rounded-lg border-gray-200 pr-10 pl-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-1">
                            <button type="submit" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                            <label for="employment_status" class="block text-sm font-medium text-gray-700">Employment Status</label>
                        <select id="employment_status" name="employment_status" onchange="this.form.submit()"
                                class="mt-1 block w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            <option value="">All Employment Status</option>
                                <option value="Employed" {{ request('employment_status') == 'Employed' ? 'selected' : '' }}>Employed</option>
                                <option value="Unemployed" {{ request('employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                            </select>
                        </div>

                    <div class="space-y-2">
                            <label for="perPage" class="block text-sm font-medium text-gray-700">Results Per Page</label>
                        <select id="perPage" name="perPage" onchange="this.form.submit()"
                                class="mt-1 block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                    </div>

                    <div class="bg-gray-50 px-4 py-2 rounded-md text-sm text-gray-600 self-end">
                        Showing {{ $responses->firstItem() ?? 0 }} - {{ $responses->lastItem() ?? 0 }} of {{ $responses->total() }} results
                    </div>
                </form>
            </div>
        </div>

        <!-- Response Cards -->
        <div class="space-y-6">
            @forelse($responses as $index => $response)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-blue-200">
                    <div class="relative overflow-hidden">
                        <div class="absolute top-0 right-0 pt-4 pr-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $response->employment_status === 'Employed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                <i class="fas {{ $response->employment_status === 'Employed' ? 'fa-briefcase' : 'fa-user-graduate' }} mr-1.5"></i>
                                {{ $response->employment_status }}
                            </span>
                        </div>
                    <!-- Card Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex justify-between items-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent"></div>
                            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full transform translate-x-20 -translate-y-20"></div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">
                                {{ $response->first_name }} {{ $response->middle_name }} {{ $response->last_name }} {{ $response->suffix }}
                            </h3>
                            <p class="text-blue-100">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $response->employment_status === 'Employed' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }} mr-2">
                                    {{ $response->employment_status }}
                                </span>
                                <span class="text-sm">JHS Graduate, {{ $response->year_graduated }}</span>
                            </p>
                        </div>
                        <div class="flex space-x-2 relative z-10">
                            @if(Auth::user() && Auth::user()->hasRole('admin'))
                                <a href="{{ route('tracer.edit-jhs', $response->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-sm font-medium rounded-lg border border-white/30 hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-200">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>
                                
                                <form action="{{ route('tracer.destroy-jhs', $response->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this response?')"
                                            class="inline-flex items-center px-4 py-2 bg-red-500/20 backdrop-blur-sm text-white text-sm font-medium rounded-lg border border-red-400/30 hover:bg-red-500/30 focus:outline-none focus:ring-2 focus:ring-red-500/50 transition-all duration-200">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Personal Details -->
                        <div class="bg-gray-50/50 rounded-xl p-5 border border-gray-100">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg mr-3">
                                    <i class="fas fa-user-circle"></i>
                                </span>
                                Personal Details
                            </h4>
                            <div class="space-y-3 text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-venus-mars text-gray-400 w-5 mr-2"></i>
                                    <span>{{ $response->gender }}, {{ $response->age }} years old</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-gray-400 w-5 mr-2"></i>
                                    <span><strong>Birthdate:</strong> {{ date('M d, Y', strtotime($response->birthdate)) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-heart text-gray-400 w-5 mr-2"></i>
                                    <span><strong>Civil Status:</strong> {{ $response->civil_status }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-pray text-gray-400 w-5 mr-2"></i>
                                    <span><strong>Religion:</strong> {{ $response->religion }}</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-2 mt-1"></i>
                                    <span class="text-sm">
                                        <strong>Address:</strong> 
                                        <div class="ml-6">
                                            {{ $response->address }},<br>
                                            {{ App\Helpers\LocationHelper::getBarangayName($response->barangay) }},<br>
                                            {{ App\Helpers\LocationHelper::getCityName($response->municipality) }},<br>
                                            {{ App\Helpers\LocationHelper::getProvinceName($response->province) }},<br>
                                        {{ App\Helpers\LocationHelper::getRegionName($response->region) }},
                                        {{ $response->country ?? 'Philippines' }}
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="bg-gray-50/50 rounded-xl p-5 border border-gray-100">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="bg-green-100 text-green-600 p-2 rounded-lg mr-3">
                                    <i class="fas fa-briefcase"></i>
                                </span>
                                Employment Information
                            </h4>
                            <div class="space-y-3 text-gray-700">
                                @if($response->employment_status === 'Employed')
                                    <div class="flex items-center">
                                        <i class="fas fa-building text-gray-400 w-5 mr-2"></i>
                                        <span><strong>Employer:</strong> {{ $response->employer_name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-2"></i>
                                        <span><strong>Work Address:</strong> {{ $response->employer_address }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-industry text-gray-400 w-5 mr-2"></i>
                                        <span><strong>Organization Type:</strong> {{ $response->organization_type }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tie text-gray-400 w-5 mr-2"></i>
                                        <span><strong>Occupation:</strong> {{ $response->occupational_classification }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-gray-400 w-5 mr-2"></i>
                                        <span><strong>Employment Type:</strong> {{ $response->job_situation }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-history text-gray-400 w-5 mr-2"></i>
                                        <span><strong>Years in Company:</strong> {{ $response->years_in_company }}</span>
                                    </div>
                                @else
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-circle text-gray-400 w-5 mr-2 mt-1"></i>
                                        <span><strong>Reason for Unemployment:</strong> {{ $response->unemployment_reason ?? 'No reason provided' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-gray-50/50 rounded-xl p-5 border border-gray-100">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                                    <i class="fas fa-address-card"></i>
                                </span>
                                Contact Information
                            </h4>
                            <div class="space-y-3 text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 w-5 mr-2"></i>
                                    <span><strong>Phone:</strong> {{ $response->phone ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 w-5 mr-2"></i>
                                    <span><strong>Email:</strong> {{ $response->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-graduation-cap text-gray-400 w-5 mr-2"></i>
                                    <span><strong>Educational Attainment:</strong> {{ $response->educational_attainment }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check text-gray-400 w-5 mr-2"></i>
                                    <span><strong>Year Graduated:</strong> {{ $response->year_graduated }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-600">No responses found. Try adjusting your filters.</p>
                </div>
            @endforelse
        </div>

        <!-- Improved Pagination -->
        <div class="mt-8 flex justify-center">
            <!-- Pagination -->
            <div class="mt-8">
                <nav class="flex items-center justify-between" aria-label="Pagination">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($responses->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed rounded-lg">
                                <i class="fas fa-chevron-left mr-2"></i> Previous
                            </span>
                        @else
                            <a href="{{ $responses->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:z-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <i class="fas fa-chevron-left mr-2"></i> Previous
                            </a>
                        @endif

                        @if ($responses->hasMorePages())
                            <a href="{{ $responses->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:z-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                Next <i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed rounded-lg">
                                Next <i class="fas fa-chevron-right ml-2"></i>
                            </span>
                        @endif
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $responses->firstItem() ?? 0 }}</span> to
                                <span class="font-medium">{{ $responses->lastItem() ?? 0 }}</span> of
                                <span class="font-medium">{{ $responses->total() }}</span> results
                            </p>
                        </div>

                        <div>
                            <nav class="relative z-0 inline-flex space-x-2" aria-label="Pagination">
                                {{-- Previous Page Link --}}
                                @if ($responses->onFirstPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed rounded-lg">
                                        <i class="fas fa-chevron-left mr-2"></i>
                                    </span>
                                @else
                                    <a href="{{ $responses->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:z-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <i class="fas fa-chevron-left mr-2"></i>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $start = max(1, $responses->currentPage() - 1);
                                    $end = min($responses->lastPage(), $responses->currentPage() + 2);
                                    
                                    if ($responses->currentPage() <= 2) {
                                        $end = min(4, $responses->lastPage());
                                    }
                                    
                                    if ($responses->currentPage() >= $responses->lastPage() - 1) {
                                        $start = max(1, $responses->lastPage() - 3);
                                    }
                                @endphp

                                @foreach ($responses->getUrlRange($start, $end) as $page => $url)
                                    @if ($page == $responses->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-sm">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:z-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($responses->hasMorePages())
                                    <a href="{{ $responses->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:z-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed rounded-lg">
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Icon styling */
    .fas {
        display: inline-flex;
        justify-content: center;
    }
    
    /* Gradient backgrounds for status indicators */
    .bg-green-200 {
        background-color: rgba(167, 243, 208, 1);
    }
    .text-green-800 {
        color: rgba(6, 95, 70, 1);
    }
    .bg-yellow-200 {
        background-color: rgba(253, 230, 138, 1);
    }
    .text-yellow-800 {
        color: rgba(146, 64, 14, 1);
    }
    
    /* Improved card transitions */
    .hover\:shadow-lg:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Custom form control styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    /* Custom focus states */
    .focus\:ring:focus {
        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
        --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
    }
</style>
@endpush