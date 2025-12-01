<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupersubKriteria extends Model
{
    use HasFactory;

    protected $table = 'supersub_kriteria';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function supersubKriteriaIndikator()
    {
        return $this->hasMany(SupersubKriteriaIndikator::class, 'id_supersub_kriteria', 'id_supersub_kriteria');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_supersub_kriteria', 'id_supersub_kriteria');
    }

    public function hasilAnalisaRekap()
    {
        return $this->belongsTo(HasilAnalisaRekap::class, 'id_supersub_kriteria', 'id_supersub_kriteria');
    }
}
