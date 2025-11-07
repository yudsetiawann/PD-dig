<?php

// namespace App\Filament\Pages;

// use UnitEnum;
// use BackedEnum;
// use Carbon\Carbon;
// use Filament\Pages\Page;
// use App\Models\Participant;
// use Filament\Actions\Action;
// use App\Models\TrainingAttendance;
// use Illuminate\Support\Collection;
// use Filament\Forms\Contracts\HasForms;
// use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Select;
// use Filament\Notifications\Notification;
// use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Concerns\InteractsWithForms;

// class DailyAttendance extends Page implements HasForms
// {
//     use InteractsWithForms;

//     protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
//     protected string $view = 'filament.pages.daily-attendance';
//     protected static ?string $navigationLabel = 'Absensi Latihan Harian';
//     protected static string|UnitEnum|null $navigationGroup = 'Data Atlet';
//     protected static ?string $title = 'Absensi Latihan Harian';
//     protected static ?int $navigationSort = 3;

//     public Carbon $selectedDate;
//     public Collection $attendanceData;
//     public array $schools = [];
//     public array $levels = [];
//     public string $search = '';
//     public string $selectedSchool = '';
//     public string $selectedLevel = '';


//     public function mount(): void
//     {
//         $this->selectedDate = Carbon::today();

//         // Ambil semua pilihan unik dari database
//         $this->schools = Participant::query()
//             ->whereNotNull('school')
//             ->where('school', '!=', '')
//             ->pluck('school')
//             ->unique()
//             ->sort()
//             ->values()
//             ->toArray();

//         $this->levels = Participant::query()
//             ->whereNotNull('level')
//             ->where('level', '!=', '')
//             ->pluck('level')
//             ->unique()
//             ->sort()
//             ->values()
//             ->toArray();

//         $this->loadAttendanceData();
//     }

//     public function updatedSearch(): void
//     {
//         $this->loadAttendanceData();
//     }

//     public function updatedSelectedSchool(): void
//     {
//         $this->loadAttendanceData();
//     }

//     public function updatedSelectedLevel(): void
//     {
//         $this->loadAttendanceData();
//     }

//     // 🔵 Muat data absensi sesuai pencarian & filter
//     protected function loadAttendanceData(): void
//     {
//         $dateString = $this->selectedDate->toDateString();

//         $query = Participant::query()
//             ->when(
//                 $this->search,
//                 fn($q) =>
//                 $q->where(function ($sub) {
//                     $sub->where('name', 'like', "%{$this->search}%")
//                         ->orWhere('school', 'like', "%{$this->search}%")
//                         ->orWhere('level', 'like', "%{$this->search}%");
//                 })
//             )
//             ->when($this->selectedSchool, fn($q) => $q->where('school', $this->selectedSchool))
//             ->when($this->selectedLevel, fn($q) => $q->where('level', $this->selectedLevel))
//             ->orderBy('name');

//         $participants = $query->get();

//         $existingAttendance = TrainingAttendance::where('date', $dateString)
//             ->pluck('is_present', 'participant_id');

//         $this->attendanceData = $participants->map(function ($participant) use ($existingAttendance) {
//             return [
//                 'id' => $participant->id,
//                 'name' => $participant->name,
//                 'school' => $participant->school,
//                 'level' => $participant->level,
//                 'is_present' => $existingAttendance->get($participant->id, false),
//             ];
//         });
//     }

//     // 🔴 Toggle kehadiran
//     public function toggleAttendance(int $participantId): void
//     {
//         $dateString = $this->selectedDate->toDateString();

//         $attendance = TrainingAttendance::firstOrNew([
//             'participant_id' => $participantId,
//             'date' => $dateString,
//         ]);

//         $attendance->is_present = !$attendance->is_present;
//         $attendance->save();

//         // Optimasi: Update koleksi di memori
//         $this->attendanceData = $this->attendanceData->map(function ($item) use ($participantId, $attendance) {
//             if ($item['id'] === $participantId) {
//                 $item['is_present'] = $attendance->is_present;
//             }
//             return $item;
//         });

//         Notification::make()
//             ->title('Status kehadiran diperbarui')
//             ->success()
//             ->send();
//     }

//     // 📅 Ganti tanggal
//     protected function getHeaderActions(): array
//     {
//         return [
//             Action::make('changeDate')
//                 ->label('Ganti Tanggal')
//                 ->icon('heroicon-o-calendar')
//                 ->schema([
//                     DatePicker::make('date')
//                         ->label('Pilih Tanggal Absensi')
//                         ->default($this->selectedDate)
//                         ->required(),
//                 ])
//                 ->action(function (array $data): void {
//                     $this->selectedDate = Carbon::parse($data['date']);
//                     $this->loadAttendanceData();
//                 }),
//         ];
//     }

//     protected function getHeaderFormSchema(): array
//     {
//         return [
//             //
//         ];
//     }
// }
