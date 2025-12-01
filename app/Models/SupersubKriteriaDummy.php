<?php

namespace App\Models;

class SupersubKriteriaDummy
{
    public static function all()
    {
        return [
            [
                'id_supersub_kriteria' => 1,
                'id_dokumen_penilaian_kaitan' => 0,
                'title' => 'Ketersediaan kebijakan, standar, dan indikator terkait sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian dan pengembangan DTPR di bidang penelitian.',
                'informasi' => [
                    1 => 'Tersedianya kebijakan, standar dan indikator terkait sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian dan pengembangan DTPR di bidang penelitian, disertai bukti- bukti yang sahih tetapi kurang lengkap.',
                    2 => 'Tersedianya kebijakan, standar dan indikator terkait sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian dan pengembangan DTPR di bidang penelitian, disertai bukti- bukti yang sahih dan cukup lengkap.',
                    3 => 'Tersedianya kebijakan, standar dan indikator terkait sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian dan pengembangan DTPR di bidang penelitian, disertai bukti- bukti yang sahih dan lengkap.',
                    4 => 'Tersedianya kebijakan, standar dan indikator terkait sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian dan pengembangan DTPR di bidang penelitian, disertai bukti- bukti yang sahih dan sangat lengkap.',
                ]
            ],
            [
                'id_supersub_kriteria' => 2,
                'id_dokumen_penilaian_kaitan' => 0,
                'title' => 'Ketersediaan kebijakan, standar dan indikator terkait implementasi peta jalan penelitian, pelibatan mahasiswa berdasarkan visi misi perguruan tinggi, UPPS, visi misi keilmuan program studi, dan kebutuhan masyarakat serta DUDIKA.',
                'informasi' => [
                    1 => 'Tersedianya kebijakan, standar dan indikator terkait implementasi peta jalan penelitian, pelibatan mahasiswa berdasarkan visi misi perguruan tinggi, UPPS, visi misi keilmuan program studi, dan kebutuhan masyarakat serta DUDIKA, disertai bukti-bukti yang sahih tetapi kurang lengkap.',
                    2 => 'Tersedianya kebijakan, standar dan indikator terkait implementasi peta jalan penelitian, pelibatan mahasiswa berdasarkan visi misi perguruan tinggi, UPPS, visi misi keilmuan program studi, dan kebutuhan masyarakat serta DUDIKA, disertai bukti-bukti yang sahih dan cukup lengkap.',
                    3 => 'Tersedianya kebijakan, standar dan indikator terkait implementasi peta jalan penelitian, pelibatan mahasiswa berdasarkan visi misi perguruan tinggi, UPPS, visi misi keilmuan program studi, dan kebutuhan masyarakat serta DUDIKA, disertai bukti-bukti yang sahih dan lengkap.',
                    4 => 'Tersedianya kebijakan, standar dan indikator terkait implementasi peta jalan penelitian, pelibatan mahasiswa berdasarkan visi misi perguruan tinggi, UPPS, visi misi keilmuan program studi, dan kebutuhan masyarakat serta DUDIKA, disertai bukti-bukti yang sahih dan sangat lengkap.',
                ]
            ],
            [
                'id_supersub_kriteria' => 3,
                'id_dokumen_penilaian_kaitan' => 0,
                'title' => 'Ketersediaan kebijakan, standar, dan indikator terkait perolehan hibah penelitian, kerjasama penelitian, publikasi baik lingkup lokal, nasional, dan internasional, perolehan HKI, serta keberlanjutan penelitian.',
                'informasi' => [
                    1 => 'Tersedianya kebijakan, standar, dan indikator terkait perolehan hibah penelitian, kerjasama penelitian, publikasi baik lingkup lokal, nasional, dan internasional, perolehan HKI, serta keberlanjutan penelitian, disertai bukti-bukti yang sahih tetapi kurang lengkap.',
                    2 => 'Tersedianya kebijakan, standar, dan indikator terkait perolehan hibah penelitian, kerjasama penelitian, publikasi baik lingkup lokal, nasional, dan internasional, perolehan HKI, serta keberlanjutan penelitian, disertai bukti-bukti yang sahih dan cukup lengkap.',
                    3 => 'Tersedianya kebijakan, standar, dan indikator terkait perolehan hibah penelitian, kerjasama penelitian, publikasi baik lingkup lokal, nasional, dan internasional, perolehan HKI, serta keberlanjutan penelitian, disertai bukti-bukti yang sahih dan lengkap.',
                    4 => 'Tersedianya kebijakan, standar, dan indikator terkait perolehan hibah penelitian, kerjasama penelitian, publikasi baik lingkup lokal, nasional, dan internasional, perolehan HKI, serta keberlanjutan penelitian, disertai bukti-bukti yang sahih dan sangat lengkap.',
                ]
            ],
        ];
    }

    public static function find($id)
    {
        return collect(self::all())->firstWhere('id_supersub_kriteria', $id);
    }
}
