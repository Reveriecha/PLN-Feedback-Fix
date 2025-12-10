<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inovasi extends Model
{
    protected $fillable = ['nama_inovasi', 'deskripsi', 'is_active'];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}