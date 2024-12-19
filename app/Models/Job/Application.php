<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    protected $table = "applications";
    protected $fillable = [
        'id',
        'job_id',
        'cv',
        'user_id',
        'job_image',
        'job_title',
        'company',
        'job_region',
        'job_type',
    ] ;

    public $timestamps = true;
}
