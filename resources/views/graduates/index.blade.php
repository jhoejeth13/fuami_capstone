@extends('layouts.app')

@section('content')
<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Custom styles */
    .container {
        max-width: 100%;
        padding: 1.5rem;
    }
    
    .card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th, td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }
    
    th {
        background-color: #f9fafb;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
    }
    
    tr:hover {
        background-color: #f9fafb;
    }
    
    .action-btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .btn-view {
        background-color: #3b82f6;
        color: white;
    }
    
    .btn-edit {
        background-color: #eab308;
        color: white;
    }
    
    .btn-delete {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-add {
        background-color: #10b981;
        color: white;
    }
    
    .btn-print {
        background-color: #3b82f6;
        color: white;
    }
    
    .search-input {
        width: 300px;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        padding: 0.5rem 1rem;
    }
    
    .filter-select {
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        padding: 0.5rem 1rem;
    }
    
    .pagination {
        display: flex;
        gap: 0.25rem;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    background-color: white;
    color:rgb(0, 0, 0); /* Black text */
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.pagination .page-item.active .page-link {
    background-color:rgb(255, 255, 255);
    border-color:rgb(255, 255, 255);
    color: black; /* White text for active button */
}

.pagination .page-link:hover {
    background-color:rgb(0, 77, 230);
    color:rgb(250, 247, 247); /* Keep black text on hover */
}

.pagination .page-item.disabled .page-link {
    color:rgb(0, 0, 0);
    background-color: white;
    pointer-events: none;
}
    
    /* Print-specific styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        table {
            width: 100%;
            font-size: 12pt;
        }
        
        th, td {
            padding: 0.5rem;
        }
    }
</style>

<div class="container mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">List of SHS Graduates</h1>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('graduates.create') }}" class="btn-add action-btn no-print">
                <i class="fas fa-plus"></i> Add Graduate
            </a>
            
            <button id="printFiltered" class="btn-print action-btn no-print">
                <i class="fas fa-print"></i> Print Filtered
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card mb-6 p-4 no-print">
        <div class="flex flex-col md:flex-row md:items-center gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <input type="text" id="searchInput" name="search" placeholder="Search by name or ID..." 
                    class="search-input w-full" value="{{ request('search') }}">
            </div>
            
            <!-- Year Filters -->
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex gap-2">
                    <input type="number" id="newYearInput" placeholder="Add Year..." 
                        class="filter-select">
                    <button id="addYearButton" class="btn-add action-btn">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
                
                <select id="yearFilter" name="year" class="filter-select">
                    <option value="">All Years</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                
                <select id="rowsPerPage" name="perPage" class="filter-select">
                    <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5 rows</option>
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 rows</option>
                    <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15 rows</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25 rows</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Graduates Table -->
    <div class="card overflow-hidden">
        <div class="table-container">
            <table class="min-w-full divide-y divide-gray-200" id="graduatesTable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>SHS Program</th>
                        <th>Year Graduated</th>
                        <th class="no-print">Actions</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-gray-200">
                    @foreach ($graduates as $graduate)
                    <tr>
                        <td>{{ $graduate->ID_student }}</td>
                        <td>{{ $graduate->first_name }} {{ $graduate->middle_name }} {{ $graduate->last_name }}</td>
                        <td>{{ $graduate->gender ?? 'N/A' }}</td>
                        <td>{{ $graduate->strand }}</td>
                        <td>{{ $graduate->year_graduated }}</td>
                        <td class="no-print">
                            <div class="flex gap-2">
                                <a href="{{ route('graduates.show', $graduate->id) }}" class="btn-view action-btn">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('graduates.edit', $graduate->id) }}" class="btn-edit action-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('graduates.destroy', $graduate->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete action-btn">
                                        <i class="fas fa-trash"></i> Delete
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

<!-- Updated Pagination -->
<div class="mt-6 flex items-center justify-between">
    <div class="text-sm text-gray-700">
        Showing {{ $graduates->firstItem() }} to {{ $graduates->lastItem() }} of {{ $graduates->total() }} results
    </div>
    <div class="flex gap-1">
        {{ $graduates->appends([
            'search' => request('search'),
            'year' => request('year'), 
            'perPage' => request('perPage')
        ])->onEachSide(1)->links('vendor.pagination.tailwind-custom') }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const searchInput = document.getElementById('searchInput');
    const yearFilter = document.getElementById('yearFilter');
    const addYearButton = document.getElementById('addYearButton');
    const newYearInput = document.getElementById('newYearInput');
    const rowsPerPage = document.getElementById('rowsPerPage');
    const printFilteredBtn = document.getElementById('printFiltered');

    // Update filters function
    function updateFilters() {
        const params = new URLSearchParams();
        
        if (searchInput.value) params.set('search', searchInput.value);
        if (yearFilter.value) params.set('year', yearFilter.value);
        if (rowsPerPage.value) params.set('perPage', rowsPerPage.value);
        
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Event listeners for filters
    searchInput.addEventListener('input', debounce(updateFilters, 300));
    yearFilter.addEventListener('change', updateFilters);
    rowsPerPage.addEventListener('change', updateFilters);

    // Add year functionality
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
            .then(response => response.json())
            .then(data => {
                if (data.year) {
                    const option = document.createElement('option');
                    option.value = data.year;
                    option.textContent = data.year;
                    yearFilter.appendChild(option);
                    yearFilter.value = data.year;
                    newYearInput.value = '';
                    updateFilters();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to add year', 'error');
            });
        }
    });

    // Print filtered results
    printFilteredBtn.addEventListener('click', function() {
        const params = new URLSearchParams();
        
        if (searchInput.value) params.set('search', searchInput.value);
        if (yearFilter.value) params.set('year', yearFilter.value);
        if (rowsPerPage.value) params.set('perPage', rowsPerPage.value);
        params.set('print', '1');
        
        window.open(`${window.location.pathname}?${params.toString()}`, '_blank');
    });

    // Delete confirmation with SweetAlert
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
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
                    form.submit();
                }
            });
        });
    });

    // Debounce function for search input
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
});
</script>
@endsection