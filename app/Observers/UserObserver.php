<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Hanya generate jika NIA belum ada, dan Data Pendukung Lengkap
        if (is_null($user->nia) && $user->join_year && $user->date_of_birth) {
            $this->generateNia($user);
        }
    }

    /**
     * Logic Generator NIA yang Aman dari Konflik.
     * Dibungkus DB::transaction() agar lockForUpdate() efektif di semua konteks,
     * termasuk saat dipanggil dari luar transaksi (misal: profile update).
     * Nested transaction dari AthleteVerification::approve() tetap aman via savepoint.
     */
    private function generateNia(User $user): void
    {
        DB::transaction(function () use ($user) {
            // Format: YYYY (Join) + DDMMYYYY (TTL) + XXXX (Urut)
            $yearJoined = $user->join_year;
            $dob        = $user->date_of_birth->format('dmY');

            $lastUser = User::where('join_year', $yearJoined)
                ->whereNotNull('nia')
                ->orderBy('nia', 'desc')
                ->lockForUpdate()
                ->first();

            $nextSequence = $lastUser
                ? intval(substr($lastUser->nia, -4)) + 1
                : 1;

            $user->nia = $yearJoined . $dob . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Handle the User "updating" event.
     * Terpanggil SEBELUM query UPDATE dikirim ke DB — perubahan pada model otomatis ikut tersimpan.
     */
    public function updating(User $user): void
    {
        // Reset status verifikasi jika atribut identitas vital berubah
        if ($user->isDirty(User::VERIFIABLE_ATTRIBUTES)) {
            $this->handleVerifiableDataChange($user);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Generate NIA jika user baru melengkapi data yang dibutuhkan
        if (is_null($user->nia) && $user->join_year && $user->date_of_birth) {
            $this->generateNia($user);
            $user->saveQuietly();
        }

        // Generate NIA jika status baru saja disetujui dan NIA belum ada
        if (
            $user->wasChanged('verification_status') &&
            $user->verification_status === 'approved' &&
            is_null($user->nia)
        ) {
            $this->generateNia($user);
            $user->saveQuietly();
        }
    }

    /**
     * Logic Inti: Bandingkan data baru dengan Snapshot Terakhir
     */
    private function handleVerifiableDataChange(User $user)
    {
        // Jika user belum pernah diverifikasi sama sekali, biarkan logic default (biasanya pending/incomplete)
        $lastVerification = $user->latestVerification()->first();

        if (! $lastVerification) {
            $user->verification_status = 'pending';
            return;
        }

        // Ambil Snapshot Data Lama
        $snapshot = $lastVerification->snapshot_data; // Array dari JSON

        // Bandingkan Data Input Baru vs Snapshot
        $isMatch = true;
        foreach (User::VERIFIABLE_ATTRIBUTES as $attribute) {
            // Ambil value baru (yang sedang disubmit)
            $newValue = $user->$attribute;

            // Ambil value lama dari snapshot (gunakan null coalescing operator)
            $snapshotValue = $snapshot[$attribute] ?? null;

            // Normalisasi perbandingan (karena JSON decode mungkin beda tipe data dengan Model Cast)
            // Contoh: "2023" (string) vs 2023 (int) atau Date Object vs String Date
            if ($attribute === 'date_of_birth' && $newValue instanceof \DateTime) {
                $newValue = $newValue->format('Y-m-d');
                // Pastikan snapshot formatnya juga Y-m-d (biasanya string dari JSON)
                $snapshotValue = substr($snapshotValue, 0, 10);
            }

            // Loose comparison (==) cukup aman untuk string/int form data
            if ($newValue != $snapshotValue) {
                $isMatch = false;
                break; // Ada satu saja beda, langsung break
            }
        }

        if ($isMatch) {
            // MAGIC MOMENT: User mengembalikan data ke kondisi terakhir yg di-ACC
            $user->verification_status = 'approved';
        } else {
            // Data berbeda dari snapshot terakhir
            $user->verification_status = 'pending';
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
