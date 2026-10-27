<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'umkms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'owner_name',
        'nik',
        'whatsapp',
        'category',
        'dusun',
        'address',
        'price',
        'price_unit',
        'description',
        'image_path',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'integer',
    ];

    /**
     * Scope to filter only approved UMKM.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to filter pending UMKM.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Helper to get sanitized WhatsApp number starting with 62 (without leading zero or special characters).
     */
    public function getCleanWhatsappNumberAttribute(): string
    {
        $phone = preg_replace('/\D/', '', (string) $this->whatsapp);

        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        } elseif (! str_starts_with($phone, '62')) {
            $phone = '62'.$phone;
        }

        return $phone;
    }

    /**
     * Helper to generate a direct WhatsApp order URL with pre-filled message.
     */
    public function getWhatsappOrderUrlAttribute(): string
    {
        $message = "Halo, saya melihat toko {$this->name} di website PojokNgadiluwih dan tertarik untuk memesan produk Anda.";

        return 'https://wa.me/'.$this->clean_whatsapp_number.'?text='.rawurlencode($message);
    }
}
