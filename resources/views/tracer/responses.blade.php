@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    <!-- Page Heading -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Graduate Tracer Study Responses</h2>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
        <form method="GET" action="{{ url()->current() }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:gap-4">
            <!-- Employment Status Filter -->
            <select name="employment_status" onchange="this.form.submit()"
                    class="w-full sm:w-64 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Employment Status</option>
                <option value="Employed" {{ request('employment_status') == 'Employed' ? 'selected' : '' }}>Employed</option>
                <option value="Unemployed" {{ request('employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
            </select>

            <!-- Rows Per Page Filter -->
            <select name="perPage" onchange="this.form.submit()"
                    class="w-full sm:w-32 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
            </select>

            <!-- Results Count -->
            <div class="text-sm text-gray-600">
                Showing {{ $responses->firstItem() }} - {{ $responses->lastItem() }} of {{ $responses->total() }} results
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Personal Information</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Education</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Employment Details</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Contact Info</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($responses as $index => $response)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 border border-gray-300">
                        <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-gray-500"></i>
                                <span>Name: {{ $response->first_name }} {{ $response->middle_name }} {{ $response->last_name }} {{ $response->suffix }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-birthday-cake text-gray-500"></i>
                                <span>Age: {{ $response->age }} Years Old</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-venus-mars text-gray-500"></i>
                                <span>Sex: {{ $response->gender }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-500"></i>
                                <span>DOB: {{ date('M d, Y', strtotime($response->birthdate)) }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-heart text-gray-500"></i>
                                <span>Civil Status: {{ $response->civil_status }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-pray text-gray-500"></i>
                                <span>Religion: {{ $response->religion }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-gray-500"></i>
                                <span>Address: {{ $response->address }}, {{ $response->barangay }},{{ $response->municipality }}, {{ $response->province }}, {{ $response->region }} Region, {{ $response->country }} {{ $response->postal_code }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 border border-gray-300">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-graduation-cap text-gray-500"></i>
                                <span>Track: {{ $response->shs_track }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-check text-gray-500"></i>
                                <span>Graduated: {{ $response->year_graduated }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 border border-gray-300">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-briefcase text-gray-500"></i>
                                <span>Employment Status: <strong class="text-blue-600">{{ $response->employment_status }}</strong></span>
                            </div>
                            @if($response->employment_status === 'Employed')
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-building text-gray-500"></i>
                                    <span>Organization: {{ $response->organization_type }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user-tie text-gray-500"></i>
                                    <span>Classification: {{ $response->occupational_classification }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock text-gray-500"></i>
                                    <span>Employment Type: {{ $response->job_situation }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock text-gray-500"></i>
                                    <span>Employer Name: {{ $response->employer_name }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar-alt text-gray-500"></i>
                                    <span>Years: {{ $response->years_in_company }}</span>
                                </div>
                            @elseif($response->employment_status === 'Self-employed')
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-industry text-gray-500"></i>
                                    <span>Nature: {{ $response->nature_of_employment }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-building text-gray-500"></i>
                                    <span>Company: {{ $response->company_name }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar-alt text-gray-500"></i>
                                    <span>Years: {{ $response->years_in_business }}</span>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-exclamation-circle text-gray-500"></i>
                                    <span>Reason: {{ $response->unemployment_reason ?? 'N/A' }}</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 border border-gray-300">
                        <div class="space-y-2">
                        <div class="flex items-center space-x-2">
    <i class="fas fa-phone text-gray-500"></i>
    <span>Phone Number: {{ $response->phone ?? 'N/A' }}</span>
</div>
<div class="flex items-center space-x-2">
    <i class="fas fa-envelope text-gray-500"></i>
    <span>Email: {{ $response->email ?? 'N/A' }}</span>
</div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex items-center justify-center">
        <nav class="flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($responses->onFirstPage())
                <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $responses->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            @php
                // Show max 4 page numbers around current page
                $start = max(1, $responses->currentPage() - 1);
                $end = min($responses->lastPage(), $responses->currentPage() + 2);
                
                // Adjust if we're near the start
                if ($responses->currentPage() <= 2) {
                    $end = min(4, $responses->lastPage());
                }
                
                // Adjust if we're near the end
                if ($responses->currentPage() >= $responses->lastPage() - 1) {
                    $start = max(1, $responses->lastPage() - 3);
                }
            @endphp

            @foreach ($responses->getUrlRange($start, $end) as $page => $url)
                @if ($page == $responses->currentPage())
                    <span class="px-3 py-1 rounded border border-blue-500 bg-blue-500 text-white">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($responses->hasMorePages())
                <a href="{{ $responses->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Next
                </a>
            @else
                <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">
                    Next
                </span>
            @endif
        </nav>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fab, .fas {
        width: 16px;
        text-align: center;
    }
    /* Add border to table cells */
    table {
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #d1d5db; /* Light gray border */
    }
    /* Pagination styling */
    nav a, nav span {
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.875rem; /* 14px */
        line-height: 1.25rem; /* 20px */
    }
    nav a:hover {
        background-color: #f3f4f6;
    }
    .cursor-not-allowed {
        cursor: not-allowed;
    }
</style>
@endpush