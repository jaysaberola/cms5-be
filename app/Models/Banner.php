<?php

namespace App\Models;

use App\Support\StorageAssetUrl;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Banner extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $fillable = [
        'album_id',
        'title',
        'description',
        'alt',
        'image_path',
        'button_text',
        'url',
        'order',
        'user_id',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return StorageAssetUrl::publicDisk($this->image_path);
    }

    /* =====================
     | Relationships
     ===================== */

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
