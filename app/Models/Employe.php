<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Hobby;

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'name',
        'email',
        'gender',
        'status',
        'phone',
        'user_id',
        'is_active'
    ];

    // Mutator
    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = strtoupper($value);
    // }

    // // accessor 
    // public function getEmailAttribute($value)
    // {
    //     return strtolower($value);
    // }



    // Laravel 9 
    protected function Name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtoupper($value),
        );
    }

    protected function Email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
        );
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    function hobbies(){
        return $this->hasMany(Hobby::class,"id");
    }


    
}
