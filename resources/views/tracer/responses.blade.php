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
                <option value="Self-employed" {{ request('employment_status') == 'Self-employed' ? 'selected' : '' }}>Self-employed</option>
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
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Personal Information</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Education</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employment Details</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Info</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($responses as $index => $response)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-user text-gray-500"></i>
                                <strong>{{ $response->fullname }}</strong>
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
                                <span>Address: {{ $response->address }}, {{ $response->municipality }}, {{ $response->province }}, {{ $response->region }} Region, {{ $response->country }} {{ $response->postal_code }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
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
                    <td class="px-6 py-4 text-sm text-gray-900">
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
                                    <span>Type: {{ $response->employment_type }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-pin text-gray-500"></i>
                                    <span>Location: {{ $response->work_location }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar-alt text-gray-500"></i>
                                    <span>Years: {{ $response->years_in_company }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-check-circle text-gray-500"></i>
                                    <span>Job Related: {{ $response->job_related_to_shs ? 'Yes' : 'No' }}</span>
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
                                    <span>Reason: {{ $response->unemployment_reason }}</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-phone text-gray-500"></i>
                                <span>Phone Number: {{ $response->phone }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-envelope text-gray-500"></i>
                                <span>Email: {{ $response->email }}</span>
                            </div>
                            @if($response->facebook)
                                <div class="flex items-center space-x-2">
                                    <i class="fab fa-facebook text-blue-600"></i>
                                    <span>{{ $response->facebook }}</span>
                                </div>
                            @endif
                            @if($response->twitter)
                                <div class="flex items-center space-x-2">
                                    <i class="fab fa-twitter text-blue-400"></i>
                                    <span>{{ $response->twitter }}</span>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $responses->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .fab, .fas {
        width: 16px;
        text-align: center;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }
    .page-item {
        margin: 0 0.25rem;
    }
    .page-link {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        color: #374151;
    }
    .page-item.active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
</style>
@endpush