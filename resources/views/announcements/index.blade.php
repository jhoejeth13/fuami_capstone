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
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #3b82f6;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: white;
            pointer-events: none;
        }
        
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-expired {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .no-print {
            display: block;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
        }
    }

    /* Print-specific styles */
    @media print {
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
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
        
        .print-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .print-table th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        
        .print-table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        
        .print-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
    }
</style>

@if(request('print'))
    <!-- Print View Content -->
    <div class="print-header">
        <h1>FUAMI Announcements</h1>
        <p>Printed on {{ now()->format('M d, Y h:i A') }}</p>
    </div>
    
    <table class="print-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Preview</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($announcements as $announcement)
            <tr>
                <td>{{ $announcement->title }}</td>
                <td>{{ Str::limit(strip_tags($announcement->content), 100) }}</td>
                <td>
                    @if($announcement->expiry_date->isPast())
                        <span class="status-badge status-expired">Expired</span>
                    @else
                        <span class="status-badge status-active">Active</span>
                    @endif
                </td>
                <td>{{ $announcement->created_at->format('M d, Y') }}</td>
                <td>{{ $announcement->expiry_date->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <!-- Regular View Content -->
    <div class="container mx-auto">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Announcements Management</h1>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('announcements.create') }}" class="btn-add action-btn no-print">
                    <i class="fas fa-plus"></i> New Announcement
                </a>
                
                <!-- <button id="printFiltered" class="btn-print action-btn no-print">
                    <i class="fas fa-print"></i> Print
                </button> -->
            </div>
        </div>

        <!-- Filters Section -->
        <div class="card mb-6 p-4 no-print">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <input type="text" id="searchInput" name="search" placeholder="Search announcements..." 
                        class="search-input w-full" value="{{ request('search') }}">
                </div>
                
                <!-- Status Filter -->
                <select id="statusFilter" name="status" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
                
                <!-- Rows Per Page -->
                <select id="rowsPerPage" name="perPage" class="filter-select">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 rows</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25 rows</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 rows</option>
                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100 rows</option>
                </select>
            </div>
        </div>

        <!-- Announcements Table -->
        <div class="card overflow-hidden">
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Preview</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="no-print">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($announcements as $announcement)
                        <tr>
                            <td class="font-medium">{{ $announcement->title }}</td>
                            <td>{{ Str::limit(strip_tags($announcement->content), 80) }}</td>
                            <td>
                                @if($announcement->expiry_date->isPast())
                                    <span class="status-badge status-expired">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Expired
                                    </span>
                                @else
                                    <span class="status-badge status-active">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </span>
                                @endif
                                <div class="text-xs text-gray-500 mt-1">
                                    Expires: {{ $announcement->expiry_date->format('M d, Y') }}
                                </div>
                            </td>
                            <td>
                                {{ $announcement->created_at->format('M d, Y') }}
                            </td>
                            <td class="no-print">
                                <div class="flex gap-2">
                                    <a href="{{ route('announcements.show', $announcement->id) }}" class="btn-view action-btn">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn-edit action-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete action-btn">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-bullhorn text-4xl text-gray-400 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900">No announcements found</h3>
                                    <p class="text-gray-500 mt-1">Get started by creating your first announcement</p>
                                    <a href="{{ route('announcements.create') }}" class="btn-add action-btn mt-4">
                                        <i class="fas fa-plus mr-2"></i> Create Announcement
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing {{ $announcements->firstItem() }} to {{ $announcements->lastItem() }} of {{ $announcements->total() }} announcements
            </div>
            <div class="flex gap-1">
                {{ $announcements->appends([
                    'search' => request('search'),
                    'status' => request('status'),
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
        const statusFilter = document.getElementById('statusFilter');
        const rowsPerPage = document.getElementById('rowsPerPage');
        const printFilteredBtn = document.getElementById('printFiltered');

        // Print filtered results
        printFilteredBtn.addEventListener('click', function() {
            const params = new URLSearchParams(window.location.search);
            params.set('print', '1');
            window.open(`${window.location.pathname}?${params.toString()}`, '_blank');
        });

        // Update filters function
        function updateFilters() {
            const params = new URLSearchParams();
            
            if (searchInput.value) {
                params.set('search', searchInput.value);
            }
            
            if (statusFilter.value) params.set('status', statusFilter.value);
            if (rowsPerPage.value) params.set('perPage', rowsPerPage.value);
            
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }

        // Event listeners for filters
        searchInput.addEventListener('input', function() {
            // Add slight delay for search input to prevent too many requests
            if (this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(updateFilters, 500);
        });
        
        statusFilter.addEventListener('change', updateFilters);
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