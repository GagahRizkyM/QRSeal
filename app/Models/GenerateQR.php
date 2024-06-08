<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateQR extends Model
{
    use HasFactory;

    protected $table = 'generate_qr';
    
   
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($table) {
            // $table->updated_by = auth()->id();
            $table->updated_at = now();
        });

        static::creating(function ($table) {
            // $table->created_by = auth()->id();
            $table->created_at = now();
        });
    }
}
