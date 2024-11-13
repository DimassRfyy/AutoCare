<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class StorePhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'store_photos';

    protected $fillable = [
        'photo',
        'car_store_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Hapus gambar saat photo dihapus
        static::deleting(function ($StorePhoto) {
            if ($StorePhoto->photo && Storage::disk('public')->exists($StorePhoto->photo)) {
                Storage::disk('public')->delete($StorePhoto->photo);
            }
        });

        // Hapus gambar lama sebelum diperbarui
        static::updating(function ($StorePhoto) {
            if ($StorePhoto->isDirty('photo') && $StorePhoto->getOriginal('photo')) {
                Storage::disk('public')->delete($StorePhoto->getOriginal('photo'));
            }
        });
    }
}
