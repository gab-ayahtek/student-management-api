<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'address',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
