<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CmsMedia extends Model
{
    protected $table = 'cms_media';
    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'url',
        'type',
        'size',
        'alt_text',
        'folder',
        'mime_type',
        'width',
        'height',
    ];
    public function getHumanSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.2f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
    }
    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }
    public function scopeInFolder($query, $folder)
    {
        return $query->where('folder', $folder);
    }
}