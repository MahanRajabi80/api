<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'site',
        'rate',
        'total_review',
        'total_interview',
        'is_famous',
        'salary_min',
        'salary_max',
        'status'
    ];

    protected $hidden = ['is_famous', 'status'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function setSiteAttribute($value)
    {
        $this->attributes['site'] = $value;

        if ($value) {
            $parsedUrl = parse_url($value);
            $host = $parsedUrl['host'] ?? $parsedUrl['path'] ?? null;

            if ($host) {
                $domain = $this->extractDomain($host);
                $this->attributes['slug'] = Str::slug($domain, '-');
            }
        }
    }

    private function extractDomain($host)
    {
        $domainParts = explode('.', $host);

        if (count($domainParts) > 2 && $domainParts[0] === 'www') {
            $domainParts = array_slice($domainParts, 1);
        }

        return implode('.', $domainParts);
    }
}
