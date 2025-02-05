<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
        'ID_student',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birthdate',
        'year_graduated',
        'strand',
        'address',
        'picture'
    ];
}