<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = [
        'nama',
        'nip',
        'unit_id',
        'inovasi_id',
        'lama_implementasi',
        'rating_kemudahan',
        'rating_kesesuaian',
        'rating_keandalan',
        'feedback',
        'saran',
    ];
    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class);
    }
    
    public function getAverageRatingAttribute()
    {
        return round(($this->rating_kemudahan + $this->rating_kesesuaian + $this->rating_keandalan) / 3, 2);
    }
}