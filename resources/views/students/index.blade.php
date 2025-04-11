@extends('layouts.app')

@section('content')
<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Regular view styles */
    @media screen {
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
        
        /* Student photo thumbnail */
        .student-photo {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
        }
    }

    /* Print-specific styles */
    @media print {
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
        }
        
        .no-print {
            display: none !important;
        }
        
        .print-header { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .print-header h1 { 
            margin: 0; 
            font-size: 24px; 
        }
        .print-header p { 
            margin: 5px 0 0; 
            font-size: 14px; 
            color: #555; 
        }
        .print-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 15px; 
            margin-top: 20px;
        }
        .print-card { 
            border: 1px solid #ddd; 
            padding: 15px; 
            border-radius: 5px; 
            page-break-inside: avoid;
        }
        .print-card-header { 
            border-bottom: 1px solid #eee; 
            padding-bottom: 10px; 
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .print-card-photo { 
            width: 60px; 
            height: 60px; 
            border-radius: 5px; 
            margin-right: 15px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .print-card-photo img { 
            max-width: 100%; 
            max-height: 100%; 
        }
        .print-card-title { 
            font-weight: bold; 
            font-size: 16px; 
        }
        .print-card-body { 
            font-size: 13px; 
        }
        .print-card-row { 
            margin-bottom: 5px; 
        }
        .print-card-label { 
            font-weight: bold; 
            display: inline-block; 
            width: 100px; 
        }
    }
</style>

@if(request('print'))
    <!-- Print View Content -->
    <div class="print-header">
        <h1>FUAMI Junior High School Students</h1>
        <p>{{ request('year') ? 'School Year: ' . request('year') : 'All Students' }}</p>
        @if(request('search'))
            <p>Search: {{ request('search') }}</p>
        @endif
    </div>
    <div class="print-grid">
        @foreach ($students as $student)
        <div class="print-card">
            <div class="print-card-header">
                <div class="print-card-photo">
                    @if ($student->photo_path)
                        <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Photo">
                    @else
                        <img src="{{ asset('images/icon.jpg') }}" alt="Default Photo">
                    @endif
                </div>
                <div>
                    <div class="print-card-title">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</div>
                    <div style="font-size: 12px;">LRN: {{ $student->lrn_number }}</div>
                </div>
            </div>
            <div class="print-card-body">
                <div class="print-card-row">
                    <span class="print-card-label">Gender:</span> {{ $student->gender ?? 'N/A' }}
                </div>
                <div class="print-card-row">
                    <span class="print-card-label">Birthdate:</span> 
                    {{ $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('M d, Y') : 'N/A' }}
                </div>
                <div class="print-card-row">
                    <span class="print-card-label">School Year:</span> {{ $student->school_year }}
                </div>
                <div class="print-card-row">
                    <span class="print-card-label">Address:</span> {{ $student->address ?? 'N/A' }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <!-- Regular View Content -->
    <div class="container mx-auto">
        <!-- Page Header -->
        <div class="page-header">
            <h1>List of Junior Highschool Graduates</h1>
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
                    <div class="flex gap-2">
                        <input type="text" id="newYearInput" placeholder="Add School Year..." 
                            class="filter-select">
                        <button id="addYearButton" class="btn-add action-btn">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </div>
                    
                    <select id="yearFilter" name="year" class="filter-select">
                        <option value="">All School Years</option>
                        @foreach ($schoolYears as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select id="rowsPerPage" name="perPage" class="filter-select">
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 rows</option>
                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25 rows</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 rows</option>
                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100 rows</option>
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
                            <td>{{ $student->lrn_number }}</td>
                            <td>{{ $student->first_name }} {{ $student->last_name }} {{ $student->suffix }}</td>
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
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Only run this script for the regular view
    if (!window.location.search.includes('print=1')) {
        // DOM Elements
        const searchInput = document.getElementById('searchInput');
        const yearFilter = document.getElementById('yearFilter');
        const rowsPerPage = document.getElementById('rowsPerPage');
        const printFilteredBtn = document.getElementById('printFiltered');
        const newYearInput = document.getElementById('newYearInput');
        const addYearButton = document.getElementById('addYearButton');

        // Add year functionality
        addYearButton.addEventListener('click', function() {
            const yearValue = newYearInput.value.trim();
            
            if (!yearValue) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a valid school year'
                });
                return;
            }
            
            // Make AJAX request to add year
            fetch('{{ route("add.jhs.year") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ year: yearValue })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Failed to add school year');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Success: add the new year to the dropdown and select it
                const option = document.createElement('option');
                option.value = data.year;
                option.text = data.year;
                
                // Check if the option already exists
                let exists = false;
                for (let i = 0; i < yearFilter.options.length; i++) {
                    if (yearFilter.options[i].value === data.year) {
                        exists = true;
                        break;
                    }
                }
                
                if (!exists) {
                    yearFilter.add(option);
                }
                
                yearFilter.value = data.year;
                
                // Clear input
                newYearInput.value = '';
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'School year added successfully'
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to add school year. It may already exist.'
                });
            });
        });

        // Print filtered results
        printFilteredBtn.addEventListener('click', function() {
            const params = new URLSearchParams(window.location.search);
            params.set('print', '1');
            window.open(`${window.location.pathname}?${params.toString()}`, '_blank');
        });

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

        // Automatically open JHS form modal when JHS is selected
        const tracerTypeSelect = document.getElementById('tracerType');
        const jhsFormModal = document.getElementById('jhsFormModal');
        const jhsFormModalTrigger = document.getElementById('jhsFormModalTrigger');

        if (tracerTypeSelect) {
            tracerTypeSelect.addEventListener('change', function() {
                if (this.value === 'jhs') {
                    // Trigger the modal
                    if (jhsFormModalTrigger) {
                        jhsFormModalTrigger.click();
                    }
                }
            });
        }
    } else {
        // If this is a print view, trigger print when loaded
        window.addEventListener('afterprint', function() {
            window.close();
        });
        
        window.print();
    }
});
</script>
@endsection