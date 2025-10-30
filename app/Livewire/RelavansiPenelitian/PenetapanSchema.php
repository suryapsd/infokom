<?php

namespace App\Livewire\RelavansiPenelitian;

use stdClass;
use Livewire\Component;
use App\Models\Penilaian;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\HasilPenilaian;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Log;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs\Tab;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PenetapanSchema extends Component implements HasTable, HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public ?int $id_supersub_kriteria = null;
    public ?int $id_dokumen_penilaian_kaitan = null;

    public array $data = [];

    public function mount($idSupersubKriteria = null, $idDokumenPenilaianKaitan = null)
    {
        $this->id_supersub_kriteria = $idSupersubKriteria;
        $this->id_dokumen_penilaian_kaitan = $idDokumenPenilaianKaitan;

        $this->form->fill([
            'id_supersub_kriteria' => $idSupersubKriteria,
            'id_dokumen_penilaian_kaitan' => $idDokumenPenilaianKaitan,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema(static::getPenetapanForm($this->id_supersub_kriteria, $this->id_dokumen_penilaian_kaitan))
            ->statePath('data');
    }

    public static function getPenetapanForm($id_supersub_kriteria = 1, $id_dokumen_penilaian_kaitan = 0): array
    {
        return [
            Hidden::make('id_supersub_kriteria')->default($id_supersub_kriteria),
            Hidden::make('id_dokumen_penilaian_kaitan')->default($id_dokumen_penilaian_kaitan),

            Select::make('judul')
                ->label('Nama kebijakan/Standar/IKU/IKT')
                ->options([
                    'Kebijakan' => 'Kebijakan',
                    'Standar' => 'Standar',
                    'IKU' => 'IKU',
                    'IKT' => 'IKT',
                ])
                ->required(),

            Textarea::make('keterangan')
                ->label('Keterangan Penetapan')
                ->required()
                ->columnSpanFull(),

            AdvancedFileUpload::make('link_file')
                ->required()
                ->label('Upload File')
                ->disk('public')
                ->directory('file')
                ->acceptedFileTypes(['application/pdf'])
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    return  uniqid() . '-' . $file->getClientOriginalName();
                })
                ->pdfPreviewHeight(400)
                ->pdfDisplayPage(1)
                ->pdfToolbar(true)
                ->pdfZoomLevel(100)
                ->pdfFitType(PdfViewFit::FIT)
                ->pdfNavPanes(true),

        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Penilaian::query()
                    ->where('status_aktif', 1)
                    ->where('id_supersub_kriteria', $this->id_supersub_kriteria)
            )
            ->columns([
                TextColumn::make('id_dokumen_penilaian')
                    ->label('No')
                    ->formatStateUsing(fn(stdClass $rowLoop) => $rowLoop->iteration),
                TextColumn::make('judul')
                    ->label('Nama Kebijakan/Standar/IKU/IKT')
                    ->wrap(),
                TextColumn::make('keterangan')
                    ->label('Keterangan Penetapan')
                    ->wrap(),
            ])
            ->filters([])
            ->recordActions([
                ActionGroup::make([
                    MediaAction::make('file')
                        ->label('Tampilkan File')
                        ->icon(Heroicon::DocumentMagnifyingGlass)
                        ->color('gray')
                        ->media(
                            fn($record) =>
                            Str::startsWith($record->link_file, ['http://', 'https://'])
                                ? $record->link_file
                                : asset('storage/' . $record->link_file)
                        ),
                    Action::make('Analisa')
                        ->requiresConfirmation()
                        ->icon(Heroicon::CloudArrowUp)
                        ->color('warning')
                        ->action(function (Penilaian $record) {
                            $filePath = Storage::disk('public')->path($record->link_file);
                            if (!file_exists($filePath)) {
                                Notification::make()
                                    ->danger()
                                    ->title('Dokumen tidak ditemukan')
                                    ->body('Silakan upload ulang dokumen terlebih dahulu.')
                                    ->send();
                                return;
                            }

                            $analisaDokumen = $this->postAnalisaDokumen($record->link_file);
                            $record->update([
                                'isi' => $analisaDokumen['isi'] ?? null,
                                'hasil' => $analisaDokumen['hasil'] ?? null,
                            ]);

                            Notification::make()
                                ->success()
                                ->title('Berhasil melakukan analisa')
                                ->send();

                            $this->replaceMountedAction('hasil', [
                                'record' => $record->refresh(),
                            ]);
                        }),
                    $this->hasilAction()
                        ->visible(fn($record) => $record->hasil),
                    EditAction::make()
                        ->label('Ubah Data')
                        ->schema(static::getPenetapanForm())
                        ->mutateDataUsing(function (array $data, Penilaian $record): array {
                            if (!empty($data['link_file']) && $record->link_file !== $data['link_file']) {
                                $oldFile = $record->link_file;

                                if (Storage::disk('public')->exists($oldFile)) {
                                    Storage::disk('public')->delete($oldFile);
                                }
                            }
                            // $analisaDokumen = $this->postAnalisaDokumen($data['link_file']);
                            // $data['isi'] = $analisaDokumen['isi'] ?? null;
                            // $data['hasil'] = $analisaDokumen['hasil'] ?? null;
                            return $data;
                        }),
                    DeleteAction::make()
                        ->label('Hapus')
                        ->before(function (Penilaian $record) {
                            if ($record->link_file) {
                                $path = Str::startsWith($record->link_file, 'storage/')
                                    ? str_replace('storage/', '', $record->link_file)
                                    : $record->link_file;

                                if (Storage::disk('public')->exists($path)) {
                                    Storage::disk('public')->delete($path);
                                }
                            }
                        }),
                ])
                    ->label('Actions')
                    ->icon(Heroicon::OutlinedEllipsisVertical)
                    ->size(Size::Small)
                    ->color('gray')
                    ->button()

            ])
            ->toolbarActions([]);
    }

    public function hasilAction(): Action
    {
        return Action::make('hasil')
            ->label('Hasil Penilaian')
            ->icon(Heroicon::DocumentCheck)
            ->color('success')
            ->modalHeading('Hasil Analisa Dokumen')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup')
            ->record(fn($arguments) => $arguments['record'] ?? null)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Isi Dokumen')
                            ->icon(Heroicon::OutlinedDocument)
                            ->schema([
                                TextEntry::make('isi')
                                    ->html()
                                    ->formatStateUsing(fn($state) => nl2br(e($state)))
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Hasil Analisa Dokumen')
                            ->icon(Heroicon::OutlinedDocumentCheck)
                            ->schema([
                                TextEntry::make('hasil')
                                    ->html()
                                    ->formatStateUsing(fn($state) => nl2br(e($state)))
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public function submit()
    {
        try {
            $data = $this->form->getState();
            // $analisaDokumen = $this->postAnalisaDokumen($data['link_file']);
            // $data['isi'] = $analisaDokumen['isi'] ?? null;
            // $data['hasil'] = $analisaDokumen['hasil'] ?? null;
            $data['status_aktif'] = 1;

            Penilaian::create($data);

            Notification::make()
                ->success()
                ->title('Data berhasil disimpan')
                ->send();

            $this->form->fill();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Terjadi Kesalahan Saat Simpan')
                ->body($e->getMessage())
                ->send();

            Log::error('Error Submit Penilaian', ['message' => $e->getMessage()]);
        }
    }

    public function postAnalisaDokumen($dokumen)
    {
        $path = Str::contains($dokumen, 'storage/')
            ? str_replace('storage/', '', $dokumen)
            : $dokumen;

        $filePath = Storage::disk('public')->path($path);

        if (!file_exists($filePath)) {
            throw new \Exception("File tidak ditemukan: {$filePath}");
        }

        $response = Http::timeout(30)
            ->attach('dokumen', fopen($filePath, 'r'), basename($filePath))
            ->post('http://148.230.101.102:8081/analisa/dokumen', [
                'kriteria'  => 'Ketersediaan kebijakan, standar, dan indikator terkait sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian dan pengembangan DTPR di bidang penelitian.',
                'indikator' => 'Tersedianya kebijakan, standar dan indikator terkait sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian dan pengembangan DTPR di bidang penelitian, disertai bukti- bukti yang sahih tetapi kurang lengkap',
            ]);

        if ($response->successful()) {
            $apiResponse = json_decode($response->body(), true);
            return [
                'isi' => $apiResponse[1] ?? null,
                'hasil' => $apiResponse[0][0]['message']['content'] ?? null,
            ];
        }

        throw new \Exception("Gagal kirim ke API: {$response->status()} - {$response->body()}");
    }

    public function render()
    {
        return view('livewire.relavansi-penelitian.penetapan-schema');
    }
}
