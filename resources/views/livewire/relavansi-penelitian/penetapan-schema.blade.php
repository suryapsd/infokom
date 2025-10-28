<div class="w-full flex flex-col md:flex-row items-start gap-5">
  <div class="w-full md:w-1/3 border border-gray-200 rounded-2xl p-4">
    <form wire:submit.prevent="submit">
      <div class="mb-3">
        {{ $this->form }}
      </div>

      <x-filament::button type="submit">
        Simpan
      </x-filament::button>
    </form>
  </div>

  <div class="w-full md:w-2/3">
    {{ $this->table }}
  </div>
</div>
