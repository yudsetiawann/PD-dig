<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PublicCoachList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $coaches = User::query()
            ->where('role', 'coach') // Filter hanya pelatih
            ->with(['coachedUnits', 'media']) // Eager load relasi unit & foto profil
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(12);

        return view('livewire.public-coach-list', [
            'coaches' => $coaches
        ]);
    }
}
