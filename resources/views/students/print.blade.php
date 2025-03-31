@extends('layouts.print')

@section('content')
<div class="header">
    <h1>FUAMI Junior High School Students</h1>
    <p>{{ $school_year ? 'School Year: ' . $school_year : 'All Students' }}</p>
    @if(request('search'))
        <p>Search: {{ request('search') }}</p>
    @endif
</div>
<div class="grid-container">
    @foreach ($students as $student)
    <div class="card">
        <div class="card-header">
            <div class="card-photo">
                @if ($student->photo_path)
                    <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Photo">
                @else
                    <img src="{{ asset('images/icon.jpg') }}" alt="Default Photo" class="w-full h-full object-cover">
                @endif
            </div>
            <div>
                <div class="card-title">{{ $student->first_name }} {{ $student->last_name }}</div>
                <div style="font-size: 12px;">LRN: {{ $student->lrn_number }}</div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-row">
                <span class="card-label">Gender:</span> {{ $student->gender ?? 'N/A' }}
            </div>
            <div class="card-row">
                <span class="card-label">Birthdate:</span> 
                {{ $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('M d, Y') : 'N/A' }}
            </div>
            <div class="card-row">
                <span class="card-label">School Year:</span> {{ $student->school_year }}
            </div>
            <div class="card-row">
                <span class="card-label">Grade Level:</span> {{ $student->grade_level ?? 'N/A' }}
            </div>
            <div class="card-row">
                <span class="card-label">Address:</span> {{ $student->address ?? 'N/A' }}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('styles')
<style>
    body { 
        font-family: Arial, sans-serif; 
        margin: 0; 
        padding: 20px; 
    }
    .header { 
        text-align: center; 
        margin-bottom: 20px; 
    }
    .header h1 { 
        margin: 0; 
        font-size: 24px; 
    }
    .header p { 
        margin: 5px 0 0; 
        font-size: 14px; 
        color: #555; 
    }
    .grid-container { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 15px; 
        margin-top: 20px;
    }
    .card { 
        border: 1px solid #ddd; 
        padding: 15px; 
        border-radius: 5px; 
        page-break-inside: avoid;
    }
    .card-header { 
        border-bottom: 1px solid #eee; 
        padding-bottom: 10px; 
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    .card-photo { 
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
    .card-photo img { 
        max-width: 100%; 
        max-height: 100%; 
    }
    .card-title { 
        font-weight: bold; 
        font-size: 16px; 
    }
    .card-body { 
        font-size: 13px; 
    }
    .card-row { 
        margin-bottom: 5px; 
    }
    .card-label { 
        font-weight: bold; 
        display: inline-block; 
        width: 100px; 
    }
    
    @media print {
        body { 
            padding: 0; 
        }
        .grid-container {
            grid-template-columns: repeat(2, 1fr);
        }
        .card {
            page-break-inside: avoid;
        }
    }
</style>
@endsection