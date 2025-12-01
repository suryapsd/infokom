<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilAnalisaRekap extends Model
{
    use HasFactory;

    protected $table = 'hasil_analisa_rekap';
    protected $guarded = ['id'];
    public $timestamps = false;
}
