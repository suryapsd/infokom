<x-filament-panels::page>
  {{-- Page content --}}
  <p class="text-gray-500 text-sm">Bagian ini berisi daftar dan penjelasan dokumen kebijakan, standar, dan indikator yang terkait dengan relevansi penelitian yang mencakup sarana dan prasarana penelitian, pembiayaan penelitian, peta jalan penelitian, kerjasama di bidang penelitian, serta pengembangan DTPR di bidang penelitian.</p>
  <div class="bg-white border border-gray-200 p-4 rounded-2xl space-y-4">
    @foreach ($subKriterias as $item)
      <x-filament::section collapsible collapsed>
        <x-slot name="heading" class="bg-gray-500">
          {{ chr(65 + $loop->index) }}. {{ $item['title'] }}
        </x-slot>
        <x-filament::section icon="heroicon-o-information-circle" class="mb-3">
          <x-slot name="heading">
            Informasi
          </x-slot>
          <ol class="space-y-1">
            @foreach ($item['informasi'] as $key => $value)
              <li class="flex items-start gap-2 text-sm">
                <div class="w-6 text-right">{{ $loop->iteration }}.</div>
                <div class="flex-1">{{ $value }}</div>
              </li>
            @endforeach
          </ol>
        </x-filament::section>

        <x-filament::section icon="heroicon-o-bars-3-bottom-left" class="mb-3">
          <x-slot name="heading">
            Input Data
          </x-slot>
          <livewire:relavansi-penelitian.penetapan-schema :id-supersub-kriteria="$item['id_supersub_kriteria']" :id-dokumen-penilaian-kaitan="$item['id_dokumen_penilaian_kaitan']" :key="$item['id_supersub_kriteria']" />
        </x-filament::section>

        <x-filament::section icon="heroicon-o-document-text">
          <x-slot name="heading">
            Analisa
          </x-slot>
          <div class="w-full justify-items-center">
            <form wire:submit.prevent="submit">
              <div class="mt-8">
                <x-filament::button type="submit" icon="heroicon-o-arrow-path-rounded-square">
                  Proses
                </x-filament::button>
              </div>
            </form>
          </div>
          <div class="w-full flex flex-col md:flex-row items-start gap-5 mt-5">
            <div class="w-full md:w-3/4">
              <p class="font-semibold text-sm">Deskripsi Hasil Assesmen:</p>
              <p class="text-sm">Prodi sudah menetapkan kebijakan, melalui :</p>
            </div>

            <div class="w-full md:w-1/4 text-center">
              <p class="font-semibold text-sm">Nilai:</p>
              <p class="font-bold text-4xl">3.0</p>
            </div>
          </div>
        </x-filament::section>
      </x-filament::section>
    @endforeach
  </div>
</x-filament-panels::page>
