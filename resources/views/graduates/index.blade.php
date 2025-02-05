@extends('layouts.app')

@section('content')
<br>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Heading -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-black">List of SHS Graduates</h1>
        <a href="{{ route('graduates.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-black rounded-md font-semibold text-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Add Graduate
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Search Bar -->
        <input type="text" id="searchInput" placeholder="Search by name or ID..." class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Entries Filter -->
        <select id="entriesFilter" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="25">25</option>
            <option value="all">All</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="graduatesTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year Graduated</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($graduates as $graduate)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $graduate->ID_student }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $graduate->first_name }} {{ $graduate->middle_name }} {{ $graduate->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $graduate->gender ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $graduate->year_graduated }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <!-- View Button -->
                                <a href="{{ route('graduates.show', $graduate->id) }}" class="inline-flex items-center px-3 py-1.5 border border-w text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    View
                                </a>
                                <!-- Edit Button -->
                                <a href="{{ route('graduates.edit', $graduate->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-gray bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    Edit
                                </a>
                                <!-- Delete Form -->
                                <form action="{{ route('graduates.destroy', $graduate->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this graduate?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const entriesFilter = document.getElementById('entriesFilter');
        const table = document.getElementById('graduatesTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        // Search Functionality
        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            Array.from(rows).forEach(row => {
                const name = row.getElementsByTagName('td')[1].textContent.toLowerCase();
                const id = row.getElementsByTagName('td')[0].textContent.toLowerCase();
                if (name.includes(searchTerm) || id.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Entries Filter Functionality
        entriesFilter.addEventListener('change', function() {
            const selectedValue = entriesFilter.value;
            Array.from(rows).forEach((row, index) => {
                if (selectedValue === 'all' || index < selectedValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection