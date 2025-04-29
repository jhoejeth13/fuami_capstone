@extends('layouts.app')

@section('content')
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Scoped styles that won't affect the navbar */
    .announcement-create-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem;
    }
    
    .announcement-create-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .announcement-create-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .announcement-create-header {
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

    .announcement-create-header h1 {
        color: white;
        font-size: 2rem;
        margin: 0;
    }

    .announcement-form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
    }

    .announcement-form-control {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.625rem 0.75rem;
        width: 100%;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .announcement-form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .announcement-form-control.is-invalid {
        border-color: #ef4444;
    }

    .announcement-invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
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
    }

    .announcement-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .announcement-btn-cancel {
        background-color: #6b7280;
        color: white;
    }

    .announcement-btn-submit {
        background-color: #10b981;
        color: white;
    }

    .announcement-btn-cancel:hover {
        background-color: #4b5563;
    }

    .announcement-btn-submit:hover {
        background-color: #059669;
    }

    .announcement-input-group {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
    }

    .announcement-input-group-text {
        display: flex;
        align-items: center;
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6b7280;
        text-align: center;
        white-space: nowrap;
        background-color: #f9fafb;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        border-right: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .announcement-input-group .announcement-form-control {
        position: relative;
        flex: 1 1 auto;
        width: 1%;
        min-width: 0;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .announcement-rich-text-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
        background-color: #f9fafb;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
    }

    .announcement-rich-text-toolbar button {
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        padding: 0.375rem 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .announcement-rich-text-toolbar button:hover {
        background-color: #f3f4f6;
    }

    .announcement-rich-text-toolbar button i {
        font-size: 0.875rem;
        color: #4b5563;
    }

    .announcement-textarea {
        min-height: 200px;
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .announcement-character-counter {
        font-size: 0.75rem;
        color: #6b7280;
        text-align: right;
        margin-top: 0.25rem;
    }

    .announcement-image-preview {
        max-width: 100%;
        max-height: 300px;
        margin-top: 1rem;
        display: none;
    }

    @media (max-width: 768px) {
        .announcement-create-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .announcement-form-actions {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .announcement-form-actions .announcement-action-btn {
            width: 100%;
        }
    }
</style>

<div class="announcement-create-container">
    <!-- Page Header -->
    <div class="announcement-create-header">
        <h1>Create New Announcement</h1>
        <div>
            <a href="{{ route('announcements.index') }}" class="announcement-action-btn announcement-btn-cancel">
                <i class="fas fa-chevron-left mr-2"></i> Back to Announcements
            </a>
        </div>
    </div>

    <!-- Announcement Form Card -->
    <div class="announcement-create-card">
        <div class="p-6">
            <form action="{{ route('announcements.store') }}" method="POST" id="announcementForm" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                
                <!-- Title Field -->
                <div class="mb-6">
                    <label for="title" class="announcement-form-label">Announcement Title <span class="text-red-500">*</span></label>
                    <div class="announcement-input-group">
                        <span class="announcement-input-group-text">
                            <i class="fas fa-heading"></i>
                        </span>
                        <input type="text" 
                               class="announcement-form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               required
                               maxlength="100"
                               placeholder="Enter a clear and descriptive title">
                        @error('title')
                            <div class="announcement-invalid-feedback">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="flex justify-between mt-1">
                        <small class="text-gray-500">Max 100 characters</small>
                        <small class="text-gray-500"><span id="titleCounter">0</span>/100</small>
                    </div>
                </div>
                
                <!-- Content Field -->
                <div class="mb-6">
                    <label for="content" class="announcement-form-label">Announcement Content <span class="text-red-500">*</span></label>
                    <textarea class="announcement-form-control announcement-textarea @error('content') is-invalid @enderror" 
                              id="content" 
                              name="content" 
                              rows="8" 
                              required 
                              placeholder="Provide all relevant details for this announcement">{{ old('content') }}</textarea>
                    <div class="announcement-rich-text-toolbar">
                        <button type="button" data-command="bold" title="Bold">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" data-command="italic" title="Italic">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" data-command="underline" title="Underline">
                            <i class="fas fa-underline"></i>
                        </button>
                        <button type="button" data-command="insertUnorderedList" title="Bullet List">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button type="button" data-command="insertOrderedList" title="Numbered List">
                            <i class="fas fa-list-ol"></i>
                        </button>
                        <button type="button" data-command="createLink" title="Insert Link">
                            <i class="fas fa-link"></i>
                        </button>
                        <button type="button" data-command="unlink" title="Remove Link">
                            <i class="fas fa-unlink"></i>
                        </button>
                    </div>
                    @error('content')
                        <div class="announcement-invalid-feedback">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Image Upload Field -->
                <div class="mb-6">
                    <label for="image" class="announcement-form-label">Announcement Image (Optional)</label>
                    <div class="announcement-input-group">
                        <span class="announcement-input-group-text">
                            <i class="fas fa-image"></i>
                        </span>
                        <input type="file" 
                               class="announcement-form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image"
                               accept="image/*">
                        @error('image')
                            <div class="announcement-invalid-feedback">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <small class="text-gray-500 mt-1">Maximum file size: 5MB. Allowed formats: jpeg, png, jpg</small>
                    <img id="imagePreview" class="announcement-image-preview" src="#" alt="Image preview">
                </div>
                
                <!-- Expiry Date Field -->
                <div class="mb-6">
                    <label for="expiry_date" class="announcement-form-label">Expiration Date <span class="text-red-500">*</span></label>
                    <div class="announcement-input-group">
                        <span class="announcement-input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        <input type="date" 
                               class="announcement-form-control @error('expiry_date') is-invalid @enderror" 
                               id="expiry_date" 
                               name="expiry_date" 
                               value="{{ old('expiry_date') }}" 
                               required>
                        @error('expiry_date')
                            <div class="announcement-invalid-feedback">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <small class="text-gray-500 mt-1">Announcement will automatically expire after this date</small>
                </div>
                
                <!-- Form Actions -->
                <div class="announcement-form-actions flex justify-end gap-3 pt-4 mt-6 border-t">
                    <a href="{{ route('announcements.index') }}" class="announcement-action-btn announcement-btn-cancel">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    <button type="submit" class="announcement-action-btn announcement-btn-submit">
                        <i class="fas fa-paper-plane mr-2"></i> Publish Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap validation
        const form = document.getElementById('announcementForm');
        if (form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }
        
        // Set minimum expiry date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('expiry_date').min = today;
        
        // Enhanced text editor functionality
        const textarea = document.getElementById('content');
        const toolbarButtons = document.querySelectorAll('[data-command]');
        
        toolbarButtons.forEach(button => {
            button.addEventListener('click', function() {
                const command = this.getAttribute('data-command');
                if (command === 'createLink') {
                    const url = prompt('Enter the URL:');
                    if (url) document.execCommand(command, false, url);
                } else {
                    document.execCommand(command, false, null);
                }
                textarea.focus();
            });
        });
        
        // Character counter for title
        const titleInput = document.getElementById('title');
        const titleCounter = document.getElementById('titleCounter');
        
        if (titleInput && titleCounter) {
            titleCounter.textContent = titleInput.value.length;
            
            titleInput.addEventListener('input', function() {
                titleCounter.textContent = this.value.length;
                if (this.value.length > 100) {
                    this.value = this.value.substring(0, 100);
                    titleCounter.textContent = 100;
                }
            });
        }

        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.src = '#';
            }
        });
    });
</script>
@endsection
@endsection