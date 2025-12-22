<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class CmsPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_published',
        'order',
        'template',
    ];
    protected $casts = [
        'content' => 'array',
        'is_published' => 'boolean',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }
    public function sections()
    {
        return $this->hasMany(CmsSection::class, 'page_id')->orderBy('order');
    }
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}