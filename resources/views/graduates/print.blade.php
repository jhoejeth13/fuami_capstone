@extends('layouts.print')

@section('content')
<div class="header">
    <h1>FUAMI Senior High School Graduates</h1>
    <p>{{ $year ? 'Year Graduated: ' . $year : 'All Graduates' }}</p>
</div>
<!-- <div class="print-date">Printed on: {{ now()->format('M d, Y') }}</div> -->
<div class="grid-container">
    @foreach ($graduates as $graduate)
    <div class="card">
    <div class="card-header">
    <div class="card-photo">
        @if ($graduate->picture)
            <img src="{{ asset('storage/' . $graduate->picture) }}" alt="Photo">
        @else
            <img src="{{ asset('images/icon.jpg') }}" alt="Default Photo" class="w-full h-full object-cover">
        @endif
    </div>
    <div>
                <div class="card-title">{{ $graduate->first_name }} {{ $graduate->last_name }}</div>
                <div style="font-size: 12px;">ID: {{ $graduate->ID_student }}</div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-row">
                <span class="card-label">Gender:</span> {{ $graduate->gender ?? 'N/A' }}
            </div>
            <div class="card-row">
                <span class="card-label">Birthdate:</span> 
                {{ $graduate->birthdate ? \Carbon\Carbon::parse($graduate->birthdate)->format('M d, Y') : 'N/A' }}
            </div>
            <div class="card-row">
                <span class="card-label">Year Grad:</span> {{ $graduate->year_graduated }}
            </div>
            <div class="card-row">
                <span class="card-label">Strand:</span> {{ $graduate->strand }}
            </div>
            <div class="card-row">
                <span class="card-label">Address:</span> {{ $graduate->address ?? 'N/A' }}
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- <div class="watermark">
    <img src="{{ asset('images/icon.jpg') }}" alt="Watermark">
</div> -->
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
    .print-date { 
        text-align: right; 
        font-size: 12px; 
        margin-bottom: 10px; 
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
    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        opacity: 0.1;
        z-index: -1;
        pointer-events: none;
    }
    .watermark img {
        width: 400px; /* Adjust size as needed */
        height: auto;
    }
    @media print {
        body { 
            padding: 0; 
        }
        .grid-container {
            grid-template-columns: repeat(2, 1fr);
        }
        .watermark {
            opacity: 0.1; /* Ensure watermark is visible when printed */
        }
    }
</style>
@endsection