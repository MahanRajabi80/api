<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'approved_by',
        'review_id',
        'description',
        'edit_key'
    ];

    protected $hidden = ['edit_key'];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
