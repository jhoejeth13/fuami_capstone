@extends('layouts.app')

@section('content')
<style>
    .px-4 {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .px-2 {
        padding-left: 1rem;
        padding-right: 2rem;
    }

    .pagination {
        display: flex;
        flex-wrap: nowrap;
        gap: 8px; /* Adds spacing between items */
        padding-left: 0; /* Removes default padding */
        margin: 0; /* Removes default margin */
    }

    .page-item {
        list-style: none; /* Removes list bullets */
    }

    .page-link {
        padding: 8px 12px; /* Adds padding to links */
        border: 1px solid #dee2e6; /* Adds a border */
        border-radius: 4px; /* Rounded corners */
        color: #007bff; /* Blue text color */
        text-decoration: none; /* Removes underline */
    }

    .page-item.active .page-link {
        background-color: #007bff; /* Blue background for active page */
        border-color: #007bff; /* Blue border for active page */
        color: white; /* White text for active page */
    }

    .page-item.disabled .page-link {
        color: #6c757d; /* Gray text for disabled items */
        pointer-events: none; /* Disables clicks */
    }

    .page-link:hover {
        background-color: #f8f9fa; /* Light background on hover */
    }
</style>

<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container flex-1 p-6">
    <!-- Page Heading -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-black">List of SHS Graduates</h1>
        <a href="{{ route('graduates.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-black rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i> Add Graduate
        </a>
    </div>

    <!-- Search and Filter Form -->
    <div class="mb-6 flex justify-between items-center">
        <!-- Search Bar -->
        <input type="text" id="searchInput" name="search" placeholder="Search by name or ID..."
            class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            value="{{ request('search') }}">

        <!-- Year Input and Year Filter Dropdown -->
        <div class="flex space-x-2">
            <!-- Input for adding new year -->
            <input type="number" id="newYearInput" placeholder="Add Year..." 
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="addYearButton" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i> Add Year
            </button>

            <!-- Year Filter Dropdown -->
            <select id="yearFilter" name="year" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Years</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Rows Per Page Filter -->
    <div class="mb-4">
        <label for="rowsPerPage" class="text-sm font-medium text-gray-700">Rows per page:</label>
        <select id="rowsPerPage" name="perPage" class="px-2 py-1 border border-gray-300 rounded-md">
            <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
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
                                <a href="{{ route('graduates.show', $graduate->id) }}" class="inline-flex items-center px-3 py-1.5 border text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('graduates.edit', $graduate->id) }}" class="inline-flex items-center px-3 py-1.5 border text-xs font-medium rounded text-gray bg-yellow-500 hover:bg-yellow-600">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('graduates.destroy', $graduate->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700">
                                        <i class="fas fa-trash mr-1"></i> Delete
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

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $graduates->appends(['search' => request('search'), 'year' => request('year'), 'perPage' => request('perPage')])->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const yearFilter = document.getElementById('yearFilter');
    const addYearButton = document.getElementById('addYearButton');
    const newYearInput = document.getElementById('newYearInput');
    const rowsPerPage = document.getElementById('rowsPerPage');

    // Function to update the URL with filters
    function updateFilters() {
        const search = searchInput.value;
        const year = yearFilter.value;
        const perPage = rowsPerPage.value;

        const url = new URL(window.location.href);
        url.searchParams.set('search', search);
        url.searchParams.set('year', year);
        url.searchParams.set('perPage', perPage);

        window.location.href = url.toString();
    }

    // Event Listeners
    searchInput.addEventListener('input', updateFilters);
    yearFilter.addEventListener('change', updateFilters);
    rowsPerPage.addEventListener('change', updateFilters);

    // Add Year Functionality
    addYearButton.addEventListener('click', function() {
        const newYear = newYearInput.value.trim();

        if (newYear) {
            fetch('{{ route("add.year") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ year: newYear })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.year) {
                    const newOption = document.createElement('option');
                    newOption.value = data.year;
                    newOption.textContent = data.year;
                    yearFilter.appendChild(newOption);
                    newYearInput.value = ''; // Clear input field
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Failed to add year.');
            });
        }
    });

    // SweetAlert2 for Delete Confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                    Swal.fire(
                        'Deleted!',
                        'The graduate has been deleted.',
                        'success'
                    );
                }
            });
        });
    });
});
</script>
@endsection