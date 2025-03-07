<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id', 'name', 'birthdate', 'marital_status', 
        'wedding_date', 'education', 'photo'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'wedding_date' => 'date',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id', 'id');
    }
}
