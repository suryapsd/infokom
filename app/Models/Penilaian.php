<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $primaryKey = "id_dokumen_penilaian";
    protected $guarded = ['id_dokumen_penilaian'];
    public $timestamps = false;

    public function hasilPenilaian()
    {
        return $this->belongsTo(HasilPenilaian::class, 'id_dokumen_penilaian', 'id_dokumen_penilaian');
    }
}
