<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address', 'device_id', 'content_type', 'content_id', 'created_at'];

    public $timestamps = false;
}
