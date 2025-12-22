<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsSection extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'title',
        'content',
        'settings',
        'order',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(CmsPage::class, 'page_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
