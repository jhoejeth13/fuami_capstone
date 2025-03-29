@extends('layouts.print')

@section('content')
<div class="print-container">
    <div class="header">
        <h1>FUAMI JUNIOR HIGH SCHOOL STUDENT RECORDS</h1>
        <div class="filters">
            @if(request('search'))<p>Search: {{ request('search') }}</p>@endif
            @if(request('year'))<p>School Year: {{ request('year') }}</p>@endif
            <p class="print-date">Printed on: {{ now()->format('F j, Y h:i A') }}</p>
        </div>
    </div>

    <table class="student-table">
        <thead>
            <tr>
                <th>LRN Number</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Address</th>
                <th>School Year</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->lrn_number }}</td>
                <td>{{ $student->full_name }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('M/d/Y') : 'N/A' }}</td>
                <td>{{ $student->address ?? 'N/A' }}</td>
                <td>{{ $student->school_year }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('styles')
<style>
    .print-container {
        max-width: 100%;
    }
    
    .header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #333;
    }
    
    .header h1 {
        margin: 0 0 10px 0;
        font-size: 22px;
        color: #333;
    }
    
    .filters {
        margin-bottom: 15px;
    }
    
    .filters p {
        margin: 3px 0;
        font-size: 13px;
    }
    
    .print-date {
        font-style: italic;
        color: #555;
    }
    
    .student-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    
    .student-table th {
        background-color: #f2f2f2;
        padding: 8px;
        border: 1px solid #ddd;
        font-weight: bold;
        text-align: left;
        font-size: 13px;
    }
    
    .student-table td {
        padding: 8px;
        border: 1px solid #ddd;
        font-size: 13px;
    }
    
    @media print {
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        
        body {
            padding: 0;
            font-size: 12pt;
        }
        
        .header h1 {
            font-size: 18pt;
        }
        
        .student-table {
            font-size: 11pt;
        }
        
        .student-table th,
        .student-table td {
            padding: 6pt 4pt;
        }
        
        /* Prevent page breaks inside rows */
        tr {
            page-break-inside: avoid;
        }
    }
</style>
@endsection