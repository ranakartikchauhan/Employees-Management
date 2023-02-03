<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;
    protected $table = 'employee_hobbies';
    protected $fillable = [
        'hobbies',
        'employee_id'
    ];


    protected function employee()
    {
    	return $this->belongsTo(Employe::class,"employee_id");
    }
}
