<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JHSTracerResponse extends Model
{
    use HasFactory;
    
    protected $table = 'jhs_tracer_responses';
    
    protected $fillable = [
        'graduate_type',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'age',
        'gender',
        'birthdate',
        'civil_status',
        'religion',
        'address',
        'barangay',
        'municipality',
        'province',
        'region',
        'postal_code',
        'country',
        'year_graduated',
        'phone',
        'email',
        'employment_status',
        'employer_name',
        'employer_address',
        'organization_type',
        'occupational_classification',
        'job_situation',
        'years_in_company',
        'unemployment_reason',
    ];
    
    protected $casts = [
        'birthdate' => 'date',
        'year_graduated' => 'integer',
    ];
    
    // Get full name as accessor
    public function getFullNameAttribute()
    {
        $fullName = "{$this->first_name} ";
        
        if (!empty($this->middle_name)) {
            $fullName .= substr($this->middle_name, 0, 1) . ". ";
        }
        
        $fullName .= $this->last_name;
        
        if (!empty($this->suffix)) {
            $fullName .= ", {$this->suffix}";
        }
        
        return $fullName;
    }
}