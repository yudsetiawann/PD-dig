<div>
    @if($showModal && $this->member)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-slate-100 bg-opacity-50 dark:bg-slate-900 dark:bg-opacity-80 transition-opacity backdrop-blur-sm"
                    wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div class="relative z-50 inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-200 dark:border-gray-700">

                    {{-- Header Modal --}}
                    <div class="bg-linear-to-r from-blue-600 to-indigo-700 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">Profil Detail</h3>
                        <button type="button" wire:click="closeModal"
                            class="text-white/70 hover:text-white transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-6">
                        <div class="flex flex-col sm:flex-row gap-6">

                            {{-- Kolom Kiri --}}
                            <div class="sm:w-1/3 my-auto flex flex-col items-center text-center border-b sm:border-b-0 sm:border-r border-gray-100 dark:border-gray-700 pb-6 sm:pb-0 sm:pr-6">
                                <x-avatar :model="$this->member" class="h-24 w-24 mx-auto mb-2" />
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white leading-tight">
                                    {{ $this->member->name }}
                                </h2>
                                <p class="text-sm text-blue-600 dark:text-blue-400 font-medium mt-1">
                                    @if($this->member->role === 'coach')
                                        {{ $this->member->organizationPosition?->name ?? 'Pelatih' }}
                                    @else
                                        Anggota
                                    @endif
                                </p>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="sm:w-2/3">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 border-b border-gray-100 dark:border-gray-700 pb-2">
                                    Informasi Anggota
                                </h4>

                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2 mb-6">
                                    <div>
                                        <dt class="text-xs text-gray-500 dark:text-gray-400">Tingkatan</dt>
                                        <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $this->member->level?->name ?? 'Strip Putih' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 dark:text-gray-400">Tahun Bergabung</dt>
                                        <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $this->member->join_year ?? '-' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 dark:text-gray-400">Status</dt>
                                        <dd><x-status-badge variant="green">Aktif</x-status-badge></dd>
                                    </div>
                                </dl>

                                @if($this->member->role === 'coach')
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 border-b border-gray-100 dark:border-gray-700 pb-2">
                                        Lokasi Melatih (Unit Binaan)
                                    </h4>

                                    <div class="flex flex-wrap gap-2">
                                        @if ($this->member->coachedUnits && $this->member->coachedUnits->isNotEmpty())
                                            @foreach ($this->member->coachedUnits as $unit)
                                                <x-status-badge variant="blue">{{ $unit->name }}</x-status-badge>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500 italic">Belum ada data unit binaan.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Footer Modal --}}
                    <div class="bg-gray-100 dark:bg-gray-700/50 px-6 py-3 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="closeModal"
                            class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
