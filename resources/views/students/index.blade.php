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

    /* Student photo thumbnail */
    .student-photo {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
    }
</style>

<div class="container mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Junior High School Students</h1>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('students.create') }}" class="btn-add action-btn no-print">
                <i class="fas fa-plus"></i> Add Student
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
                <input type="text" id="searchInput" name="search" placeholder="Search by name or LRN..." 
                    class="search-input w-full" value="{{ request('search') }}">
            </div>
            
            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-2">
                <select id="yearFilter" name="year" class="filter-select">
                    <option value="">All School Years</option>
                    @foreach ($schoolYears as $year)
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

    <!-- Students Table -->
    <div class="card overflow-hidden">
        <div class="table-container">
            <table class="min-w-full divide-y divide-gray-200" id="studentsTable">
                <thead>
                    <tr>
                        <!-- <th>Photo</th> -->
                        <th>LRN Number</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>School Year</th>
                        <th class="no-print">Actions</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-gray-200">
                    @foreach ($students as $student)
                    <tr>
                        <!-- <td>
                            <img src="{{ $student->photo_url }}" alt="Student Photo" class="student-photo">
                        </td> -->
                        <td>{{ $student->lrn_number }}</td>
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->school_year }}</td>
                        <td class="no-print">
                            <div class="flex gap-2">
                                <a href="{{ route('students.show', $student->id) }}" class="btn-view action-btn">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('students.edit', $student->id) }}" class="btn-edit action-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="delete-form">
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
            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students
        </div>
        <div class="flex gap-1">
            {{ $students->appends([
                'search' => request('search'),
                'year' => request('year'),
                'grade' => request('grade'),
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
    const gradeFilter = document.getElementById('gradeFilter');
    const rowsPerPage = document.getElementById('rowsPerPage');

    // Update filters function
    function updateFilters() {
        const params = new URLSearchParams();
        
        if (searchInput.value) params.set('search', searchInput.value);
        if (yearFilter.value) params.set('year', yearFilter.value);
        if (gradeFilter.value) params.set('grade', gradeFilter.value);
        if (rowsPerPage.value) params.set('perPage', rowsPerPage.value);
        
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Event listeners for filters
    searchInput.addEventListener('input', debounce(updateFilters, 300));
    yearFilter.addEventListener('change', updateFilters);
    gradeFilter.addEventListener('change', updateFilters);
    rowsPerPage.addEventListener('change', updateFilters);



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