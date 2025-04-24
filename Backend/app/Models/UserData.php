<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data';

    // Fields that are mass assignable
    protected $fillable = [
        'user_id', 
        'name', 
        'email', 
        'phone_number', 
        'address', 
        'age', 
        'profile_picture'
    ];

    protected $casts = [
        'age' => 'integer',
    ];


    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture
            ? asset('storage/' . $this->profile_picture)
            : null;
    }

    // Relationship: Each UserData belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
