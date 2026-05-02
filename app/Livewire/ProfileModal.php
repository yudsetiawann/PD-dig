<?php

// app/Livewire/ProfileModal.php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

class ProfileModal extends Component
{
    public $showModal = false;
    public $userId = null;

    // Mendengarkan event 'show-profile' dari komponen manapun
    #[On('show-profile')]
    public function loadProfile($id)
    {
        $this->userId = $id;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->userId = null;
    }

    #[Computed]
    public function member()
    {
        if (!$this->userId) {
            return null;
        }

        // Semua logic relasi dipusatkan di sini
        return User::with(['organizationPosition', 'level', 'unit', 'coachedUnits'])
            ->find($this->userId);
    }

    public function render()
    {
        // View ini berisi kode UI modal yang sebelumnya Anda buat di components/profile-modal.blade.php
        return view('livewire.profile-modal');
    }
}
