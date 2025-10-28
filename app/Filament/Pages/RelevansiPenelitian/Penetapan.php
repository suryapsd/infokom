<?php

namespace App\Filament\Pages\RelevansiPenelitian;

use UnitEnum;
use BackedEnum;
use Filament\Pages\Page;
use App\Models\Penilaian;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Penetapan extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected string $view = 'filament.pages.relevansi-penelitian.penetapan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static string | UnitEnum | null $navigationGroup = 'Relevansi Penelitian';
    protected static ?string $slug = 'relavansi-penelitian/penetapan';
    protected static ?string $navigationLabel = 'Penetapan';
    protected static ?string $title = 'Penetapan';
    // protected ?string $subheading = 'Bagian ini berisi daftar dan penjelasan dokumen kebijakan, standar, dan indikator yang terkait dengan relevansi penelitian yang mencakup sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian, kerjasama di bidang penelitian, serta pengembangan DTPR di bidang penelitian.';

    public function getBreadcrumbs(): array
    {
        return [
            '#' => 'Relevansi Penelitian',
            'penetapan' => 'Penetapan',
        ];
    }

    public ?Penilaian $record = null;
    public $subKriterias = [
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

    public function getViewData(): array
    {
        return [
            'subKriterias' => $this->subKriterias,
        ];
    }
}
