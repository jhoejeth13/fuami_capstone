<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
        'ID_student',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'other_suffix',
        'gender',
        'birthdate',
        'year_graduated',
        'strand',
        'address',
        'picture'
    ];

    public function getFullNameAttribute()
    {
        $name = "{$this->first_name} {$this->last_name}";
        
        if ($this->suffix === 'Others' && $this->other_suffix) {
            return "{$name} {$this->other_suffix}";
        }
        
        return $this->suffix ? "{$name} {$this->suffix}" : $name;
    }

    public function getPhotoUrlAttribute()
    {
        return $this->picture ? asset('storage/'.$this->picture) : asset('images/icon.jpg');
    }

    protected static function booted()
    {
        static::deleting(function ($graduate) {
            if ($graduate->picture) {
                Storage::disk('public')->delete($graduate->picture);
            }
        });
    }
}