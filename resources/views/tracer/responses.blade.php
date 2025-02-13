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
                <option value="">All Employment Statuses</option>
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
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Income</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($responses as $index => $response)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <strong>{{ $response->fullname }}</strong><br>
                        Age: {{ $response->age }}<br>
                        Gender: {{ $response->gender }}<br>
                        DOB: {{ date('M d, Y', strtotime($response->birthdate)) }}<br>
                        Civil Status: {{ $response->civil_status }}<br>
                        Religion: {{ $response->religion }}<br>
                        Address: {{ $response->address }}, {{ $response->municipality }}, {{ $response->province }}, {{ $response->region }} Region, {{ $response->country }} {{ $response->postal_code }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        Track: {{ $response->shs_track }}<br>
                        Graduated: {{ $response->year_graduated }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        Employment Status: <strong class="text-blue-600">{{ $response->employment_status }}</strong><br>
                        
                        @if($response->employment_status === 'Employed')
                            Organization: {{ $response->organization_type }}<br>
                            Classification: {{ $response->occupational_classification }}<br>
                            Type: {{ $response->employment_type }}<br>
                            Location: {{ $response->work_location }}<br>
                            Years: {{ $response->years_in_company }}<br>
                            Job Related: {{ $response->job_related_to_shs ? 'Yes' : 'No' }}
                        
                        @elseif($response->employment_status === 'Self-employed')
                            Nature: {{ $response->nature_of_employment }}<br>
                            Company: {{ $response->company_name }}<br>
                            Years: {{ $response->years_in_business }}
                        
                        @else
                            Reason: {{ $response->unemployment_reason }}<br>
                            Is FUAMI a Factor of Unemployment?: {{ $response->fuami_factor ? 'Yes' : 'No' }}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        Phone Number: {{ $response->phone }}<br>
                        Email: {{ $response->email }}<br>
                        @if($response->facebook)
                            <i class="fab fa-facebook text-blue-600"></i> {{ $response->facebook }}<br>
                        @endif
                        @if($response->twitter)
                            <i class="fab fa-twitter text-blue-400"></i> {{ $response->twitter }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                        @if($response->employment_status === 'Employed')
                            <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-800">
                                ₱{{ number_format($response->monthly_income, 2) }}
                            </span>
                        @elseif($response->employment_status === 'Self-employed')
                            <span class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                ₱{{ number_format($response->self_employed_income, 2) }}
                            </span>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
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
    .fab {
        width: 20px;
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