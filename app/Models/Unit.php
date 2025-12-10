<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['nama_unit', 'is_active'];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}