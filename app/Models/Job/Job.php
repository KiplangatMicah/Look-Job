<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
protected $table = "jobs";
    protected $fillable = [
        'id',
        'job_title',
        'company',
        'job_region',
        'job_type',
        'vacancy',
        'experience',
        'salary',
        'gender',
        'application_deadline',
        'job_description',
        'responsibilities',
        'education_experience',
        'other_benefits',
        'category',
        'image',
    ] ;

    public $timestamps = true;
}
