@extends('layouts.app')

@section('content')
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Consistent styling with create.blade.php */
    .announcement-show-container {
        max-width: 100%;
        padding: 1.5rem;
    }
    
    .announcement-show-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .announcement-show-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .announcement-show-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem 0.75rem 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .announcement-show-header h1 {
        color: white;
        font-size: 2rem;
        margin: 0;
    }

    .announcement-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin: 1.5rem 0;
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .announcement-meta-item {
        display: flex;
        align-items: center;
        color: #4b5563;
    }

    .announcement-meta-item i {
        margin-right: 0.5rem;
        color: #3b82f6;
    }

    .announcement-content {
        padding: 1.5rem;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #4a5568;
        white-space: pre-line;
    }

    .announcement-image-container {
        padding: 0 1.5rem;
        margin-bottom: 1.5rem;
    }

    .announcement-image {
        max-width: 100%;
        max-height: 500px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: block;
        margin: 0 auto;
    }

    .announcement-badge {
        padding: 0.35em 0.85em;
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .announcement-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .announcement-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .announcement-btn-back {
        background-color: #3b82f6;
        color: white;
    }

    .announcement-btn-back:hover {
        background-color: #2563eb;
    }

    @media (max-width: 768px) {
        .announcement-show-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .announcement-meta {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .announcement-image {
            max-height: 300px;
        }
    }
</style>

<div class="announcement-show-container">
    <!-- Announcement Show Card -->
    <div class="announcement-show-card">
        <!-- Card Header -->
        <div class="announcement-show-header">
            <h1>{{ $announcement->title }}</h1>
            <a href="{{ route('announcements.index') }}" class="announcement-action-btn announcement-btn-back">
                <i class="fas fa-arrow-left mr-2"></i> Back to Announcements
            </a>
        </div>
        
        <!-- Meta Information -->
        <div class="announcement-meta">
            <div class="announcement-meta-item">
                <i class="far fa-calendar-plus"></i>
                <span>Posted: {{ $announcement->created_at->format('F j, Y \a\t g:i A') }}</span>
            </div>
            <div class="announcement-meta-item">
                <i class="far fa-calendar-minus"></i>
                <span>Expires: </span>
                <span class="announcement-badge {{ $announcement->expiry_date->isPast() ? 'bg-red-500 text-white' : 'bg-green-100 text-green-800' }}">
                    {{ $announcement->expiry_date->format('F j, Y') }}
                    @if($announcement->expiry_date->isPast())
                        (Expired)
                    @else
                        (Active)
                    @endif
                </span>
            </div>
        </div>
        
        <!-- Announcement Image -->
        @if($announcement->image_path)
        <div class="announcement-image-container">
            <img src="{{ asset('storage/' . $announcement->image_path) }}" 
                 alt="Announcement Image" 
                 class="announcement-image">
        </div>
        @endif
        
        <!-- Announcement Content -->
        <div class="announcement-content">
            {!! nl2br(e($announcement->content)) !!}
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@endsection