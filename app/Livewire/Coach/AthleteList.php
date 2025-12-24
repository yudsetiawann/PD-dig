<?php

namespace App\Livewire\Coach;

use App\Models\User;
use App\Models\Unit; // Pastikan import Model Unit
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AthleteList extends Component
{
    use WithPagination;

    // State untuk menyimpan Unit yang sedang dipilih
    public $selectedUnitId = null;
    public $selectedUnitName = null;

    public $search = '';

    // Reset pagination saat search berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Method untuk memilih Unit (Masuk ke tampilan detail)
    public function selectUnit($unitId, $unitName)
    {
        $this->selectedUnitId = $unitId;
        $this->selectedUnitName = $unitName;
        $this->resetPage(); // Reset halamannya ke 1
        $this->search = ''; // Optional: Reset search saat ganti unit
    }

    // Method untuk kembali ke daftar Unit
    public function backToUnits()
    {
        $this->selectedUnitId = null;
        $this->selectedUnitName = null;
        $this->search = '';
    }

    // Mengambil daftar Unit yang dibina pelatih (beserta jumlah atlet aktif)
    public function getUnitsProperty()
    {
        $coach = Auth::user();

        // Kita ambil unit binaan, lalu hitung user yang statusnya approved & role user
        return $coach->coachedUnits()
            ->withCount(['users as active_athletes_count' => function ($query) {
                $query->where('role', 'user')
                    ->where('verification_status', 'approved');
            }])
            ->orderBy('name', 'asc')
            ->get();
    }

    // Mengambil atlet (Hanya jalan jika unit sudah dipilih)
    public function getAthletesProperty()
    {
        // Jika belum pilih unit, kembalikan collection kosong (untuk keamanan)
        if (!$this->selectedUnitId) {
            return [];
        }

        return User::query()
            ->where('role', 'user')
            ->where('verification_status', 'approved')
            ->where('unit_id', $this->selectedUnitId) // Filter by Selected Unit
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->with(['level']) // Unit tidak perlu di-load lagi karena sudah pasti satu unit
            ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.coach.athlete-list', [
            'units' => $this->units,
            // Load athletes hanya jika selectedUnitId tidak null
            'athletes' => $this->selectedUnitId ? $this->athletes : []
        ]);
    }
}
