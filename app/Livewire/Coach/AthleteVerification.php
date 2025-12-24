<?php

namespace App\Livewire\Coach;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\UserVerification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class AthleteVerification extends Component
{
    use WithPagination;

    // State untuk Modal Reject
    public $showRejectModal = false;
    public $selectedUserId = null;
    public $rejectionNote = '';

    public function mount()
    {
        // Security Gate: Tendang jika bukan Coach
        if (! Auth::user()->isCoach()) {
            abort(403, 'Akses ditolak. Halaman ini khusus Pelatih.');
        }
    }

    public function getAthletesProperty()
    {
        $coach = Auth::user();

        // Ambil ID semua unit yang dipegang pelatih ini
        $unitIds = $coach->coachedUnits()->pluck('units.id')->toArray();

        return User::query()
            ->with(['unit', 'level']) // <--- TAMBAHKAN BARIS INI (Solusi)
            ->where('role', 'user')
            ->whereIn('unit_id', $unitIds)
            ->where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function approve($userId)
    {
        $athlete = User::find($userId);

        // Security Check (Unit match)
        $coach = Auth::user();
        $coachUnitIds = $coach->coachedUnits->pluck('id')->toArray();

        if (! in_array($athlete->unit_id, $coachUnitIds)) {
            session()->flash('error', 'Akses ditolak.');
            return;
        }

        DB::transaction(function () use ($athlete, $coach) {
            // 1. Update Status (Ini akan mentrigger Observer -> Generate NIA)
            // Kita harus force fill agar observer jalan jika data tidak dirty,
            // tapi disini status pasti berubah dari pending -> approved.
            $athlete->verification_status = 'approved';
            $athlete->rejection_note = null;
            $athlete->save();

            // 2. Refresh model untuk mendapatkan data terbaru (termasuk NIA yang baru digenerate observer)
            $athlete->refresh();

            // 3. BUAT SNAPSHOT (Rekaman Kebenaran)
            // Kita simpan hanya atribut yang "Verifiable" agar hemat storage
            $snapshotData = $athlete->only(User::VERIFIABLE_ATTRIBUTES);

            UserVerification::create([
                'user_id' => $athlete->id,
                'verifier_id' => $coach->id,
                'approved_at' => now(),
                'snapshot_data' => $snapshotData,
            ]);
        });

        session()->flash('message', "Atlet {$athlete->name} berhasil disetujui & NIA diterbitkan.");
    }

    // Buka Modal Reject
    public function openRejectModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->rejectionNote = ''; // Reset note
        $this->showRejectModal = true;
    }

    public function reject()
    {
        // Validasi input
        $this->validate([
            'rejectionNote' => 'required|string|min:5',
        ], [
            'rejectionNote.required' => 'Alasan penolakan wajib diisi.',
            'rejectionNote.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $athlete = User::find($this->selectedUserId);

        // SECURITY CHECK (Agar coach tidak menolak atlet unit lain via inspect element)
        $coachUnitIds = Auth::user()->coachedUnits->pluck('id')->toArray();
        if (! in_array($athlete->unit_id, $coachUnitIds)) {
            $this->reset(['rejectionNote', 'showRejectModal', 'selectedUserId']);
            session()->flash('error', 'Anda tidak memiliki hak menolak atlet ini.');
            return;
        }

        // === PERBAIKAN UTAMA ADA DISINI ===
        // Ganti 'status' menjadi 'verification_status' agar sesuai dengan query filter
        $athlete->update([
            'verification_status' => 'rejected', // <--- SEBELUMNYA 'status'
            'rejection_note' => $this->rejectionNote,
        ]);

        // Reset dan tutup modal
        $this->reset(['rejectionNote', 'showRejectModal', 'selectedUserId']);

        // Flash message
        session()->flash('message', 'Permintaan atlet telah ditolak.');
    }

    public function render()
    {
        return view('livewire.coach.athlete-verification', [
            'athletes' => $this->athletes
        ]);
    }
}
