@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Graduate Tracer Study Responses</h1>
            <p class="text-gray-600">Track and manage graduate information</p>
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
        <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Filters & Controls</h2>
                <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-6 items-end">
                    <div class="space-y-2">
                        <label for="graduate_type" class="block text-sm font-medium text-gray-700">Graduate Type</label>
                        <select id="graduate_type" name="graduate_type" onchange="this.form.submit()"
                                class="mt-1 block w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            <option value="SHS" {{ request('graduate_type', 'SHS') == 'SHS' ? 'selected' : '' }}>SHS Graduates</option>
                            <option value="JHS" {{ request('graduate_type') == 'JHS' ? 'selected' : '' }}>JHS Graduates</option>
                        </select>
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
                            <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
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
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <!-- Card Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-white">
                                {{ $response->first_name }} {{ $response->middle_name }} {{ $response->last_name }} {{ $response->suffix }}
                            </h3>
                            <p class="text-blue-100">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $response->employment_status === 'Employed' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }} mr-2">
                                    {{ $response->employment_status }}
                                </span>
                                <span class="text-sm">{{ $response->shs_track }} Track, {{ $response->year_graduated }}</span>
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            @if(Auth::user() && Auth::user()->hasRole('admin'))
                                <a href="{{ route('tracer.edit', $response->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md bg-white text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-edit mr-1.5"></i> Edit
                                </a>
                                <form action="{{ route('tracer.destroy', $response->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md bg-white text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            onclick="return confirm('Are you sure you want to delete this response?')">
                                        <i class="fas fa-trash mr-1.5"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Personal Details -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user-circle text-indigo-500 mr-2"></i> Personal Details
                            </h4>
                            <div class="space-y-3 text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-venus-mars text-gray-400 w-5 mr-2"></i>
                                    <span>{{ $response->gender }}, {{ $response->age }} years old</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-gray-400 w-5 mr-2"></i>
                                    <span>Born: {{ date('M d, Y', strtotime($response->birthdate)) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-heart text-gray-400 w-5 mr-2"></i>
                                    <span>{{ $response->civil_status }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-pray text-gray-400 w-5 mr-2"></i>
                                    <span>{{ $response->religion }}</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-2 mt-1"></i>
                                    <span class="text-sm">{{ $response->address }}, {{ $response->barangay }}, {{ $response->municipality }}, {{ $response->province }}, {{ $response->region }} Region</span>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Details -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-briefcase text-indigo-500 mr-2"></i> Employment Details
                            </h4>
                            <div class="space-y-3 text-gray-700">
                                @if($response->employment_status === 'Employed')
                                    <div class="flex items-center">
                                        <i class="fas fa-building text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->employer_name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-industry text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->organization_type }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tie text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->occupational_classification }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->job_situation }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-history text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->years_in_company }}</span>
                                    </div>
                                @elseif($response->employment_status === 'Self-employed')
                                    <div class="flex items-center">
                                        <i class="fas fa-store text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->company_name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-tag text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->nature_of_employment }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-history text-gray-400 w-5 mr-2"></i>
                                        <span>{{ $response->years_in_business }}</span>
                                    </div>
                                @else
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-circle text-gray-400 w-5 mr-2 mt-1"></i>
                                        <span>{{ $response->unemployment_reason ?? 'No reason provided' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-address-card text-indigo-500 mr-2"></i> Contact Information
                            </h4>
                            <div class="space-y-3 text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 w-5 mr-2"></i>
                                    <span>{{ $response->phone ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 w-5 mr-2"></i>
                                    <span>{{ $response->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-graduation-cap text-gray-400 w-5 mr-2"></i>
                                    <span>{{ $response->shs_track }} Track</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check text-gray-400 w-5 mr-2"></i>
                                    <span>Graduated: {{ $response->year_graduated }}</span>
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
            <div class="inline-flex rounded-md shadow">
                <nav class="flex items-center rounded-md divide-x divide-gray-200">
                    {{-- Previous Page Link --}}
                    @if ($responses->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-300 cursor-not-allowed rounded-l-md">
                            <i class="fas fa-chevron-left mr-1.5"></i> Previous
                        </span>
                    @else
                        <a href="{{ $responses->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-l-md">
                            <i class="fas fa-chevron-left mr-1.5"></i> Previous
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
                            <span class="relative inline-flex items-center px-4 py-2 bg-indigo-600 text-sm font-medium text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($responses->hasMorePages())
                        <a href="{{ $responses->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-r-md">
                            Next <i class="fas fa-chevron-right ml-1.5"></i>
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-300 cursor-not-allowed rounded-r-md">
                            Next <i class="fas fa-chevron-right ml-1.5"></i>
                        </span>
                    @endif
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