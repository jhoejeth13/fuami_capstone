@extends('layouts.app')

@section('content')
<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif
<style>
    /* Custom styles */
    .container {
        max-width: 100%;
        padding: 1.5rem;
    }
    
    .card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .page-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .page-header h1 {
        color: white;
        font-size: 2rem;
        margin: 0;
    }

    table {
        border-radius: 0.75rem;
        overflow: hidden;
    }

    th {
        background-color: #f3f4f6;
        color: #374151;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 0.75rem;
        font-size: 0.75rem;
    }

    td {
        padding: 0.625rem;
        vertical-align: middle;
        font-size: 0.875rem;
    }

    tr:nth-child(even) {
        background-color: #f9fafb;
    }

    tr:hover {
        background-color: #f3f4f6;
        transition: background-color 0.3s ease;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .btn-view {
        background-color: #3b82f6;
        color: white;
    }

    .btn-edit {
        background-color: #10b981;
        color: white;
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
    }

    .btn-add {
        background-color: #6366f1;
        color: white;
    }

    .btn-print {
        background-color: #8b5cf6;
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
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    /* Improved Pagination Styles */
/* Replace the existing pagination styles with these: */
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
    color: #000;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.pagination .page-item.active .page-link {
    background-color: #fff;
    border-color: #fff;
    color: #000;
}

.pagination .page-link:hover {
    background-color: #004de6;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    color: #000;
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
    <div class="page-header">
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
                    <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10 rows</option>
                    <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25 rows</option>
                    <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50 rows</option>
                    <option value="100" {{ request('perPage', 10) == 100 ? 'selected' : '' }}>100 rows</option>
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
                        <th>LRN Number</th>
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
                        <td>{{ $graduate->first_name }} {{ $graduate->middle_name }} {{ $graduate->last_name }} {{ $graduate->suffix }}</td>
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

    <!-- Pagination -->
<div class="mt-6 flex items-center justify-between">
    <div class="text-sm text-gray-700">
        Showing {{ $graduates->firstItem() }} to {{ $graduates->lastItem() }} of {{ $graduates->total() }} graduates
    </div>
    <div class="flex gap-1">
        {{ $graduates->appends([
            'search' => request('search'),
            'year' => request('year'),
            'perPage' => request('perPage')
        ])->onEachSide(1)->links('vendor.pagination.tailwind-custom') }}
    </div>
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
        
        if (searchInput.value) {
            params.set('search', searchInput.value);
        }
        
        if (yearFilter.value) {
            params.set('year', yearFilter.value);
        }
        
        // Always include rows per page in the params
        params.set('perPage', rowsPerPage.value);
        
        // Reset to page 1 when changing filters
        params.set('page', '1');
        
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Event listener for search input to trigger on input change
    searchInput.addEventListener('input', updateFilters);

    // Event listeners for filters
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

// Print filtered results - update this to include perPage
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
});
</script>
@endsection