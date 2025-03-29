@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Student</h1>
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="lrn_number">LRN Number</label>
            <input type="text" class="form-control" id="lrn_number" name="lrn_number" value="{{ $student->lrn_number }}" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $student->first_name }}" required>
        </div>
        <div class="form-group">
            <label for="middle_name">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $student->middle_name }}">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $student->last_name }}" required>
        </div>
        <div class="form-group">
            <label for="suffix">Suffix</label>
            <input type="text" class="form-control" id="suffix" name="suffix" value="{{ $student->suffix }}">
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $student->gender == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <!-- Birthdate -->
<div class="form-group">
    <label for="birthdate">Birthdate</label>
    <input type="date" class="form-control" id="birthdate" name="birthdate" 
           value="{{ old('birthdate', $student->birthdate ?? '') }}">
</div>

<!-- Address -->
<div class="form-group">
    <label for="address">Address</label>
    <textarea class="form-control" id="address" name="address" rows="2"
              maxlength="255">{{ old('address', $student->address ?? '') }}</textarea>
</div>
        <div class="form-group">
            <label for="school_year">School Year</label>
            <input type="text" class="form-control" id="school_year" name="school_year" value="{{ $student->school_year }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
    <div class="form-group">
    <label for="photo">Student Photo</label>
    @if($student->photo_path)
        <div class="mb-2">
            <img src="{{ $student->photo_url }}" alt="Student Photo" class="img-thumbnail" style="max-height: 150px;">
            <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" id="remove_photo" name="remove_photo">
                <label class="form-check-label" for="remove_photo">Remove current photo</label>
            </div>
        </div>
    @endif
    <input type="file" class="form-control-file" id="photo" name="photo">
    <small class="form-text text-muted"></small>
</div>
</div>
@endsection