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

    <!-- Search and Filter Form -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Search Bar -->
        <input type="text" id="searchInput" placeholder="Search by name or ID..."
            class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Year Input and Year Filter Dropdown -->
        <div class="flex space-x-2">
            <!-- Input for adding new year -->
            <input type="number" id="newYearInput" placeholder="Add Year..." 
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="addYearButton" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Add Year</button>

            <!-- Year Filter Dropdown -->
            <select id="yearFilter" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Years</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
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
                                <a href="{{ route('graduates.show', $graduate->id) }}" class="inline-flex items-center px-3 py-1.5 border text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700">View</a>
                                <a href="{{ route('graduates.edit', $graduate->id) }}" class="inline-flex items-center px-3 py-1.5 border text-xs font-medium rounded text-gray bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('graduates.destroy', $graduate->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this graduate?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $graduates->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const yearFilter = document.getElementById('yearFilter');
        const addYearButton = document.getElementById('addYearButton');
        const newYearInput = document.getElementById('newYearInput');
        const table = document.getElementById('graduatesTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedYear = yearFilter.value;

            Array.from(rows).forEach(row => {
                const id = row.getElementsByTagName('td')[0].textContent.toLowerCase();
                const name = row.getElementsByTagName('td')[1].textContent.toLowerCase();
                const year = row.getElementsByTagName('td')[3].textContent.trim(); // Trim whitespace

                const matchesSearch = name.includes(searchTerm) || id.includes(searchTerm);
                const matchesYear = selectedYear === '' || parseInt(year) === parseInt(selectedYear);

                row.style.display = matchesSearch && matchesYear ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterRows);
        yearFilter.addEventListener('change', filterRows);

        addYearButton.addEventListener('click', function() {
            const newYear = newYearInput.value.trim();
            if (newYear && !Array.from(yearFilter.options).some(option => option.value === newYear)) {
                const newOption = document.createElement('option');
                newOption.value = newYear;
                newOption.textContent = newYear;
                yearFilter.appendChild(newOption);
                newYearInput.value = ''; // Clear input field
                filterRows(); // Apply filter with the newly added year
            }
        });

        
    });
</script>
@endsection
