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
        'employer_address',
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
    
    protected $casts = [
        'birthdate' => 'date',
        'year_graduated' => 'integer',
        'job_related_to_shs' => 'boolean',
        'fuami_factor' => 'boolean',
    ];
    
    // Get full name as accessor
    public function getFullNameAttribute()
    {
        if (!empty($this->fullname)) {
            return $this->fullname;
        }
        
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