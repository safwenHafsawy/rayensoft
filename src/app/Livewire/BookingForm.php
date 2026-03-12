<?php

namespace App\Livewire;

use App\Models\AvailbleMeetingDates;
use App\Models\ExternalMeeting;
use App\Models\Leads;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class BookingForm extends Component
{

    public array $allAvailableDatesAndTimes = [];
    public array $availableMeetingDates = [];

    public string $selectedDate = '';
    public bool $wasDateSelected = false;
    public ?string $selectedTime = null;
    public bool $wasTimeSelected = false;
    public array $selectedDateAvailableTimes = [];

    public string $fullName = '';
    public string $email = '';
    public string $phone = '';

    public int $currentPage = 0;
    public int $perPage = 5;

    public $plan = null; // this is used as a honey pot to prevent spambots from submitting the form
    // If a bot fills this field, we assume its spam and do not process the booking
    // This field should be hidden from users, but visible to bots

    public bool $hasNextPage = false;

    public function mount(): void
    {

        // $availableDates = AvailbleMeetingDates::where('date', '>', now()->format('Y-m-d'))
        //     ->where('status', 'available')
        //     ->get();

        // $this->allAvailableDatesAndTimes = [];
        // foreach ($availableDates as $availableDate) {
        //     $this->allAvailableDatesAndTimes[$availableDate->date][] = $availableDate->time;
        // }


        //        $this->selectedDate = array_key_first($this->allAvailableDatesAndTimes);
//        $this->selectDate($this->selectedDate);
    }

    public function getPaginatedDates(): array
    {
        $start = $this->currentPage * $this->perPage;
        $slice = array_slice($this->allAvailableDatesAndTimes, $start, $this->perPage, true);
        $this->hasNextPage = ($start + $this->perPage) < count($this->allAvailableDatesAndTimes);

        return $slice;
    }

    public function nextSetOfDates(): void
    {
        if (!$this->hasNextPage)
            return;
        $this->currentPage++;
        $this->availableMeetingDates = $this->getPaginatedDates();
    }

    public function prevSetOfDates(): void
    {
        $this->currentPage = max(0, $this->currentPage - 1);
        $this->availableMeetingDates = $this->getPaginatedDates();
    }

    public function setDate($selectedDate): void
    {

        if (!$this->wasDateSelected) {
            $this->trackEvent('booking_step1_complete', 'date_selected');
        }

        $this->selectedDate = $selectedDate;
        $this->wasDateSelected = true;
        $this->selectedDateAvailableTimes = collect($this->allAvailableDatesAndTimes[$this->selectedDate])
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $this->selectedTime = null;
    }

    public function setTime($selectedTime): void
    {
        if (!$this->wasTimeSelected) {
            $this->trackEvent('booking_step2_complete', 'time_selected');
        }

        $this->wasTimeSelected = true;
        $this->selectedTime = $selectedTime;
    }


    protected array $rules = [
        'fullName' => 'required',
        // 'email' => 'required|email:rfc,dns|max:255',
        'phone' => ['required', 'string', 'min:6', 'max:32', 'regex:/^\\+?\\d[\\d\\s\\-]{5,30}$/'],
    ];

    protected array $messages = [
        'fullName.required' => 'Merci de renseigner votre nom complet',
        'phone.required' => 'Votre numéro de téléphone est nécessaire pour valider l’étape',
        'phone.regex' => 'Oups, ce format de numéro ne semble pas correct'
    ];


    public function submit(): void
    {

        $this->trackEvent('booking_step3_attempt', 'attempt_booking');

        // $ip = request()->ip();
        // $key = 'booking-form:' . $ip;

        // if (RateLimiter::tooManyAttempts($key, 5)) {
        //     $this->dispatch('showNotification',
        //         'Too many attempts! 🚫',
        //         'You’ve reached the limit for bookings. Please try again later.',
        //         'error');
        //     return;
        // }

        // if (!empty($this->plan)) {
        //     RateLimiter::hit($key, 3600);
        //     $this->dispatch('showNotification',
        //         'Something went wrong 😕',
        //         'We couldn’t complete your booking. Please try again in a moment.',
        //         'error');
        //     return;
        // }

        $this->validate();

        try {
            // $cacheKey = 'booking:' . $this->selectedDate . ':' . $this->selectedTime;
            // if (Cache::has($cacheKey)) {
            //     $this->dispatch('showNotification',
            //         'Time Slot Unavailable ⏰',
            //         'Someone else just booked this time slot. Please select another available time.',
            //         'error');
            //     return;
            // }

            // Cache::put($cacheKey, true, 300); // Lock the time slot for 5 minutes
            DB::transaction(function () {
                $lead = Leads::create([
                    'name' => $this->fullName,
                    'email' => $this->email !== '' ? $this->email : null,
                    'phone' => $this->phone,
                    'status' => 'New',
                    // Required fields in the dashboard schema.
                    'industry' => 'Unknown',
                    'lead_reason' => 'Booking',
                    'follow_up_date' => now()->addDay()->toDateString(),
                    'lead_source' => 'Landing Page',
                    'notes' => 'added automatically from booking page',
                ]);

                $usersIds = DB::table('users')
                    ->pluck('id');

                if ($usersIds->isEmpty()) {
                    return;
                }


                $notifications = [];
                $now = now();

                foreach ($usersIds as $id) {
                    if (!$id)
                        continue;

                    $notifications[] = [
                        'id' => \Str::uuid()->toString(), 
                        'type' => 'App\Notifications\NewBookingNotification',
                        'notifiable_type' => 'App\Models\User',
                        'notifiable_id' => $id,
                        'data' => json_encode([
                            'message' => 'New booking request from ' . $lead->name,
                            'lead_name' => $lead->name,
                            'lead_phone' => $lead->phone,
                            'url' => "leads/{$lead->id}",
                        ]),
                        'read_at' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                // 4. Perform the insert
                DB::table('notifications')->insert($notifications);
            });

            // update the availability status for the selected date and time
            // AvailbleMeetingDates::where('date', '=', Carbon::parse($this->selectedDate)->format('Y-m-d'))
            //     ->where('time', $this->selectedTime)
            //     ->update(['status' => 'booked']);

            $this->dispatch(
                'showNotification',
                'C’est tout bon ! 🎉',
                'Merci de nous avoir contactés ! Nous reviendrons vers vous très prochainement pour en savoir plus sur votre activité et vos besoins, afin de préparer ensemble votre session.',
                'success'
            ); // Dispatch success notification

            $this->trackEvent('booking_step3_complete', 'booking_complete');

            $this->clearData();

        } catch (\Throwable $e) {
            Log::error('Booking error: ' . $e->getMessage());
            $this->dispatch(
                'showNotification',
                'Un problème est survenu 😕',
                'Il semble qu’une erreur se soit produite lors de l’envoi de votre demande. Veuillez réessayer dans un instant.',
                'error'
            );
        }
    }


    private function trackEvent(string $name, string $step): void
    {
        // Optional analytics hook. Public-site used Label84 TagManager; keep booking functional without it.
        // Implement your own tracker here if needed.
    }

    private function clearData(): void
    {
        $this->fullName = '';
        $this->email = '';
        $this->selectedDate = '';
        $this->selectedTime = '';
        $this->phone = '';

        $this->resetValidation();
        $this->resetErrorBag();
    }

    #[On('viewPortSet')]
    public function setPerPage($perPage): void
    {
        $this->perPage = $perPage;

        $this->availableMeetingDates = $this->getPaginatedDates();
    }

    public function render(): Factory|View
    {
        return view('livewire.booking-form');
    }
}
