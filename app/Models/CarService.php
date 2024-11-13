<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'car_services';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'price',
        'about',
        'duration_in_hour'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    protected static function boot()
    {
        parent::boot();

        // Hapus gambar saat service dihapus
        static::deleting(function ($CarService) {
            if ($CarService->icon && Storage::disk('public')->exists($CarService->icon)) {
                Storage::disk('public')->delete($CarService->icon);
            }
        });

        // Hapus gambar lama sebelum diperbarui
        static::updating(function ($CarService) {
            if ($CarService->isDirty('icon') && $CarService->getOriginal('icon')) {
                Storage::disk('public')->delete($CarService->getOriginal('icon'));
            }
        });
    }

    public function storeServices(): HasMany
    {
        return $this->hasMany(StoreService::class, 'car_service_id');
    }
}
