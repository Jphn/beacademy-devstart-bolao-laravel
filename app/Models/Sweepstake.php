<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sweepstake extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'dozens',
        'next_date'
    ];
}
