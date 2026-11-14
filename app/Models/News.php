<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image_path',
        'author_id',
        'published_at',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi: Berita ini dibuat oleh siapa (User/Admin)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Akses nama penulis berita secara aman (tetap berfungsi jika database MySQL tidak aktif).
     */
    public function getAuthorNameAttribute(): string
    {
        if (! empty($this->attributes['author_name'])) {
            return $this->attributes['author_name'];
        }

        try {
            if ($this->author_id) {
                return $this->author?->name ?? 'Admin Desa';
            }
        } catch (\Throwable) {
            return 'Admin Desa';
        }

        return 'Admin Desa';
    }

    /**
     * Akses URL publik dari gambar berita (local storage atau remote URL).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return asset('storage/' . ltrim($this->image_path, '/'));
    }
}