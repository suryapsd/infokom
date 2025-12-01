<?php

namespace App\Filament\Pages\RelevansiPenelitian;

use UnitEnum;
use BackedEnum;
use Filament\Pages\Page;
use App\Models\Penilaian;
use Filament\Actions\Action;
use App\Models\SupersubKriteria;
use App\Models\HasilAnalisaRekap;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Http;
use App\Models\SupersubKriteriaDummy;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class Penetapan extends Page implements HasForms, HasTable, HasActions
{
    use InteractsWithForms, InteractsWithTable, InteractsWithActions;

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

    public function getViewData(): array
    {
        $subKriterias = SupersubKriteria::with('supersubKriteriaIndikator', 'hasilAnalisaRekap')->get()->toArray();
        return [
            'subKriterias' => $subKriterias,
        ];
    }

    public function analisaRekap(): Action
    {
        return Action::make('analisaRekap')
            ->label('Proses')
            ->icon('heroicon-o-arrow-path-rounded-square')
            ->action(function (array $data, array $arguments) {
                $supersubKriteria = SupersubKriteria::with('supersubKriteriaIndikator', 'penilaian')->where('id_supersub_kriteria', $arguments['id_supersub_kriteria'])->first();

                $response = Http::timeout(30)
                    ->post('http://148.230.101.102:8081/analisa/rekap', [
                        'kriteria'  => $supersubKriteria->keterangan,
                        // 'relevant_chunks' => $supersubKriteria->penilaian->pluck('deskripsi')->join("\n\n"),
                        'relevant_chunks' => 'e. Tenaga penunja ng akademik dan tenaga administrasi melipu ti bidang d an jenjang \npendidikan ten aga penunjang akademik, rasionya terhadap mahasiswa, bidang dan \njenjang pendidikan ten aga administrasi, rasionya terhadap mahasiswa. \nf.  Sarana dan prasarana fisik  melipu ti jenis dan jumlah peralatan p enunja ng akademik, \njenis d an jumlah peralatan administrasi dan ruangan, termasuk luas  tiap jenis \nruangan. \ng. Kepustakaan/sumber  belajar  melipu ti  jenis  dan  jumlah  buku  dan  jurn al  untuk \nperkuli ahan inti (pokok), untuk  perkuliahan pendukun g, kategori umum/lain-\nlain, d an dis tribusi buku menurut b ahasa dan tahun p enerbitan. \n \n \nPasal 2 1 \n(1)  Penyelenggaraan standardisasi ha rus m emenuhi hal-hal sebagai berikut. \na. Standar lingkup melipu ti standar kualitatif d an kuantitatif. \nb. Kejelasan dinyatakan dalam rumus an yang spesifik dan atau dalam bentuk jumlah, \npersentase, atau uku ran.\n\n(1) Standardisasi  program  studi  merupakan  upaya  pembaku an  yang  dilakukan  untuk  \nmem elihara   dan menin gkatkan kinerja setiap program studi  ditinjau dari indikator \nyang terdiri dari relevansi, efektivitas, efisiensi,  dan produktivitas untuk  menghasilkan \nkeluaran yang optimal. \n(2) Standardisasi ditujukan untuk meningkatkan:  \na. Relevansi pr ogram dengan kebutuhan lin gkungan dan perkembangan tekn ologi. \nb. Kualitas proses dan hasil yang dicapai secara berkesinambung an. \nc. Efisiensi program, secara internal (efisiensi  penyelenggaraan) dan secara \neksternal (pemanfaatan dan kemanfaatan keluaran). \nd. Produktivitas pros es yang ditempuh dal am menghasilkan keluaran. \n(3) Proses standardisasi program menggunakan dua ragam standar sebagai berikut.  \na. Standar yang bersifat kualitatif m eliputi: \n1) kesesuaian p rogram de ngan bida ng ilmu jurusan yang membinanya; \n2) kesesuaian p rogram de ngan kebutuhan l apangan;\n\nc. Kelayakan dinyatakan tidak bersifat mutlak mel ainkan dalam b entuk rentangan.  \n(2)  Standardisasi dilakuk an melalui hal-hal sebagai berikut. \na. Analisis dokumen k ebijakan tent ang stand ardisasi berbagai komponen.  \nb. Penyiapan panduan standardisasi un tuk pi mpinan  unive rsitas. \nc. Penyampaian ku esioner untuk p impinan program studi, dos en, dan mah asiswa.  \nd. Wawancara dengan pimpinan p rogram studi, dos en, dan mah asiswa. \ne. Observasi langsung ke program studi yang bersangkutan.  \n(3)  Standardisasi dilakukan oleh t im khusus  yang dibentuk oleh  Univ ersitas  Bina Sarana \nInformatika,  anggotanya mewakili semua jurus an yang ada dan mewakili berbagai \nbidang  yang relevan. \n \n \nBAB IX  \nPENUTUP \n \nPengembangan dan Pemutakhiran Kurikulum meng gunakan KKNI ini mulai berlaku sejak \ntangg al ditetapkan sebagai pedoman  untuk  pengembangan Kurikulum  Univ ersitas  Bina \nSarana Informatik a. Hal-hal yang belum tercantum dalam ketentu an ini akan ditentukan\nPengelolaan sarana dan prasarana meliputi perencanaan, pengadaan, \npembukuan, penggunaan, pemanfaatan, pemeliharaan, penghapusan, dan \npertanggungjawaban.\n \n(5)\n \nPengelolaan sarana dan prasarana\n \ndiselenggarakan berdasarkan ketentuan \nperaturan perundang\n-\nundangan. \n \n(6)\n \nPengembangan sarana dan prasarana \nsebagaimana dimaksud ayat (1) \ndis\nesuaikan dengan rencana strategis \nUniversitas Bina Sarana Informatika\n. \n \n(7)\n \nPengelolaan dan pendayagunaan sarana dan prasarana dilaporkan melalui \nsistem manajemen dan akuntansi\n \ndisampaikan\n \nkepada Y\nayasan\n.\n \n(8)\n \nKetentuan lebih lanjut mengenai pengelolaan sarana dan prasarana \ndiatur \ndengan \nPeraturan \nY\nayasan\n.\n \n \nParagraf 3\n \nPola Pengelolaan Anggaran \n \n \nPasal \n21\n \n(1)\n \nPengelolaan \nanggaran\n \nmeliputi perencanaan, pelaksanaan, \npertanggungjawaban, dan pelaporan.\n \n(2)\n \nPengelolaan anggaran dilaksanakan berdasarkan prinsip efisiensi, efektivitas, \ntransparansi, dan akuntabilitas sesuai dengan ketentuan \nY\nayasan\n\nParagraf 1\n \nUmum\n \n \nPasal 19\n \nPola pengelolaan \nUniversitas Bina Sarana Informatika\n \nterdiri atas:\n \na.\n \nPengelolaan Sarana Prasarana,\n \nb.\n \nPengelolaan Anggaran,\n \nc.\n \nPengelolaan Kerjasama,\n \nd.\n \nPengelolaan Pendanaan dan Kekayaan,\n \ne.\n \nBentuk dan tata cara penetapan peraturan.\n \n \n \n \n \n \n \n<D\\DVDQ\n%LQD6DUDQD,QIRUPDWLND\n \n-\n \n17 \n-\n \n \nParagraf 2\n \nPola Pengelolaan Sarana dan Prasarana\n \n \nPasal 20\n \n(1)\n \nSarana dan prasarana \nmerupakan semua fasilitas utama dan pendukung \npelaksanaan tugas dan fungsi \nUniversitas Bina Sarana Informatika\n. \n \n(2)\n \nSarana dan prasarana sebagaimana dimaksud pada ayat (1) berada di bawah \npengaturan, pengawasan, dan tanggung jawab \nY\nayasan\n.\n \n(3)\n \nDosen, \nm\nahasiswa, dan \nt\nenaga \nk\nependidikan\n \nd\na\np\na\nt\n \nm\ne\nm\na\nnf\naa\nt\nk\na\nn \nsarana dan \nprasarana\n \ny\na\nn\ng\n \nt\ne\nr\ns\ne\nd\ni\na\n \ns\ne\nc\na\nra\n \nb\ne\nr\nt\na\nn\ngg\nun\ng\n \nj\na\nw\na\nb\n \nsesuai dengan k\ne\nt\ne\nn\nt\nu\na\nn\n \np\ne\nr\na\nt\nu\nr\na\nn perundang\n-\nundangan.\n \n(4)\n\nntuk publikasi ilmiah lainnya yang diakui \noleh \nk\nementerian \nyang menangani\n \np\nendidikan \nt\ninggi.\n \n(7)\n \nHasil penelitian \nyang \nmerupakan kekayaan intelektual wajib dilindungi sesuai \ndengan ketentuan peraturan perundang\n-\nundangan.\n \n(8)\n \nP\nenelitian\n \ndilaksanakan dan dikoordinasikan oleh\n \nLembaga Penelitian dan \nPengabdian Masyarakat\n \n(LPPM\n)\n.\n \n(9)\n \nKetentuan lebih lanjut mengenai \np\nenelitian diatur \ndengan\n \nPeraturan Rektor\n \nsetelah mendapat \npertimbangan Senat\n. \n \n \n \n \n \n<D\\DVDQ\n%LQD6DUDQD,QIRUPDWLND\n \n-\n \n10 \n-\n \n \nBagian Ketiga\n \nPengabdian Kepada \nMasyarakat\n \n \nPasal\n \n11\n \n(1)\n \nPengabdian kepada masyarakat merupakan kegiatan \nSivitas Akademika\n \nUniversitas Bina Sarana Informatika\n \ndalam mengamalkan dan membudayakan \nilmu pengetahuan dan/atau teknologi\n \nmelalui \npemberdayaan masyarakat, \npengembangan industri, jasa, \ndan wilayah\n \nuntuk \nmeningkatkan \nkesejahteraan \nmasyarakat dan mencerdaskan kehidupan bangsa.\n \n(2)\n \nPe\nngabdian kepada masyarakat\n',
                        'indikator' => $supersubKriteria->supersubKriteriaIndikator[0],
                        'indikator' => $supersubKriteria->supersubKriteriaIndikator[1],
                        'indikator' => $supersubKriteria->supersubKriteriaIndikator[2],
                        'indikator' => $supersubKriteria->supersubKriteriaIndikator[3],
                    ]);

                if ($response->successful()) {
                    $apiResponse = json_decode($response->body(), true);
                    $response = $apiResponse;
                    [$deskripsi, $nilaiPart] = explode('NILAI_AKHIR=', $response);
                    $deskripsi = trim($deskripsi);
                    $nilaiAkhir = trim($nilaiPart);
                    HasilAnalisaRekap::updateOrCreate(
                        [
                            'id_supersub_kriteria' => $arguments['id_supersub_kriteria']
                        ],
                        [
                            'deskripsi' => $deskripsi,
                            'nilai_akhir' => $nilaiAkhir,
                        ]
                    );
                    Notification::make()
                        ->title('Berhasil melakukan analisa.')
                        ->success()
                        ->send();
                } else {
                    Notification::make()
                        ->title('Gagal melakukan analisa.')
                        ->danger()
                        ->send();
                }
            });
    }
}
