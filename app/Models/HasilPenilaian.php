<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilPenilaian extends Model
{
    use HasFactory;

    protected $table = 'hasil_penilaian';
    protected $guarded = ['id'];
    public $timestamps = false;
}
