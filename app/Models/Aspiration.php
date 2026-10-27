<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspiration extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aspirations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'dusun',
        'category',
        'title',
        'message',
        'is_anonymous',
        'status',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    /**
     * Scope to filter pending aspirations.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Public display name handling anonymous preference.
     */
    public function getPublicDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Warga Anonim ('.$this->dusun.')';
        }

        return $this->name;
    }
}
