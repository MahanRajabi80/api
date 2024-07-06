<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Reason;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reason_id',
        'review_id',
        'comment_id',
        'description',
        'content_type',
    ];

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
}
