<x-filament-panels::page>
  {{-- Header: Judul + Filter + Pencarian --}}
  <div class="mb-4 flex flex-wrap items-center gap-4">
    <h2 class="text-xl font-semibold flex-1">
      Tanggal: {{ $selectedDate->format('d F Y') }}
    </h2>

    {{-- 🔍 Kolom Pencarian Live --}}
    <div class="relative border border-gray-300 dark:border-gray-700 rounded-lg">
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
      </div>

      <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search..."
        class="rounded-lg dark:bg-gray-800 dark:text-gray-300 text-md py-1 pl-10" />
    </div>

    {{-- 🏫 Filter Ranting/Sekolah --}}
    <div>
      <select wire:model.live="selectedSchool"
        class="rounded-lg border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 px-3 py-2 border">
        <option value="">Semua Sekolah</option>
        @foreach ($schools as $school)
          <option value="{{ $school }}">{{ $school }}</option>
        @endforeach
      </select>
    </div>

    {{-- 🎓 Filter Tingkatan --}}
    <div>
      <select wire:model.live="selectedLevel"
        class="rounded-lg border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 px-3 py-2 border">
        <option value="">Semua Tingkatan</option>
        @foreach ($levels as $level)
          <option value="{{ $level }}">{{ $level }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- 🧾 Tabel Absensi --}}
  <x-filament::section>
    <div class="overflow-x-auto rounded-lg border border-gray-300 dark:border-gray-700">
      <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">Nama</th>
            <th scope="col" class="px-6 py-3">Ranting/Sekolah</th>
            <th scope="col" class="px-6 py-3">Tingkatan</th>
            <th scope="col" class="px-6 py-3 text-center">Kehadiran</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($attendanceData as $data)
            <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
              <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                {{ $data['name'] }}
              </td>
              <td class="px-6 py-4">{{ $data['school'] }}</td>
              <td class="px-6 py-4">{{ $data['level'] }}</td>
              <td class="px-6 py-4 text-center">
                {{-- Tombol Toggle Kehadiran --}}
                <button wire:click="toggleAttendance({{ $data['id'] }})" type="button" role="switch"
                  aria-checked="{{ $data['is_present'] ? 'true' : 'false' }}" @class([
                      'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
                      'bg-primary-600' => $data['is_present'],
                      'bg-gray-200 dark:bg-gray-700' => !$data['is_present'],
                  ])>
                  <span class="sr-only">Ubah Kehadiran</span>
                  <span aria-hidden="true" @class([
                      'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                      'translate-x-5' => $data['is_present'],
                      'translate-x-0' => !$data['is_present'],
                  ])>
                  </span>
                </button>
              </td>
            </tr>
          @empty
            <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
              <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                Tidak ada data peserta untuk filter atau pencarian ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </x-filament::section>
</x-filament-panels::page>
