<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'graduate_type',
        'fullname',
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
        'shs_track',
        'year_graduated',
        'facebook',
        'twitter',
        'phone',
        'email',
        'employment_status',
        'organization_type',
        'occupational_classification',
        'employer_name',
        'employment_type',
        'work_location',
        'job_situation',
        'years_in_company',
        'monthly_income',
        'job_related_to_shs',
        'reason_staying_job',
        'nature_of_employment',
        'company_name',
        'years_in_business',
        'self_employed_income',
        'unemployment_reason',
        'fuami_factor',
    ];

    // Scope for JHS graduates
    public function scopeJhs($query)
    {
        return $query->where('graduate_type', 'JHS');
    }
    
    // Scope for SHS graduates
    public function scopeShs($query)
    {
        return $query->where('graduate_type', 'SHS');
    }
}