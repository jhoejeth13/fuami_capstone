<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Juniorhighschool extends Model
{
    use HasFactory;

    protected $table = 'juniorhighschool';

    protected $fillable = [
        'lrn_number',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'gender',
        'birthdate',
        'address',  
        'school_year',
        'photo_path'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . 
               ($this->middle_name ? $this->middle_name . ' ' : '') . 
               $this->last_name . 
               ($this->suffix ? ' ' . $this->suffix : '');
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo_path ? asset('storage/'.$this->photo_path) : asset('images/icon.jpg');
    }

    protected static function booted()
    {
        static::deleting(function ($student) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
        });
    }
}