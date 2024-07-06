<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $hidden = ['edit_key'];

    protected $fillable = [
        'company_id',
        'approved_by',
        'review_type',
        'title',
        'job_title',
        'description',
        'salary',
        'rate',
        'start_date',
        'edit_key',
        'review_status',
        'status',
        'sexual_harassment',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'review_id');
    }
}
