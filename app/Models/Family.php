<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'surname', 'birthdate', 'mobile_no', 'address',
        'state', 'city', 'pincode', 'marital_status', 'wedding_date',
        'hobbies', 'photo'
    ];

    protected $casts = [
        'birthdate' => 'date:dd-mm-YYYY',
        'wedding_date' => 'date',
        'hobbies' => 'array',
    ];

    

    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'family_id', 'id');
    }
}
