<form wire:submit.prevent="submit" class="w-full max-w-sm mx-auto space-y-8 px-4 py-2">

    <!-- Step 1: Date Selection -->
    {{-- <section class="space-y-4">
        <div>
            <h2 class="text-lg md:text-xl font-semibold text-darkColor flex items-center gap-2">
                <i class="fa-regular fa-calendar text-primaryColor"></i>
                Step 1 — Choose a Date
            </h2>
            <p class="text-sm text-darkColor/60 mt-1">اختر اليوم الأنسب لك للقاءنا الأول</p>
        </div>

        <div class="relative flex items-center gap-2 md:grid md:grid-cols-[8%_1fr_8%] md:items-center">

            <!-- Prev -->
            <button
                wire:click="prevSetOfDates"
                type="button"
                class="hidden md:flex group items-center gap-1.5 h-9 rounded-xl bg-white/70 hover:bg-white/90 shadow-sm transition
                    {{ $currentPage > 0 ? '' : 'opacity-40 cursor-not-allowed' }}">
                <i class="fa-solid fa-chevron-left text-darkColor/60 group-hover:-translate-x-0.5 transition"></i>
                <span class="text-sm text-darkColor/60 font-medium">Prev</span>
            </button>

            <!-- Dates container -->
            <div
                class="flex md:justify-center gap-2 flex-1 overflow-x-auto snap-mandatory snap-x px-1 py-6 touch-pan-x scrollbar-hide">

                @foreach ($availableMeetingDates as $date => $times)
                    @php $carbonDate = \Carbon\Carbon::parse($date); @endphp

                    <button
                        type="button"
                        wire:click="setDate('{{ $date }}')"
                        class="relative w-20 md:w-24 py-3 flex-shrink-0 snap-center rounded-xl border shadow transition-all bg-white
                {{ $selectedDate === $date ? 'scale-[1.04] border-primaryColor-dark shadow-md' : 'border-gray-200' }}">

                <span class="absolute top-0 left-0 w-full h-3 rounded-t-xl
                {{ $selectedDate === $date ? 'bg-primaryColor-dark' : 'bg-accentColor' }}"></span>

                        <span class="mt-4 flex flex-col items-center text-center px-0.5">
                    <span class="text-[11px] text-darkColor/60 uppercase tracking-wide">
                        {{ $carbonDate->format('l') }}
                    </span>

                    <span
                        class="mt-0.5 text-[28px] sm:text-[34px] font-extrabold font-numbers leading-none text-darkColor">
                        {{ $carbonDate->format('j') }}
                    </span>

                    <span class="mt-0.5 text-[11px] text-darkColor/60">
                        {{ $carbonDate->format('F') }}
                    </span>
                </span>
                    </button>
                @endforeach

            </div>

            <!-- Next -->
            <button
                wire:click="nextSetOfDates"
                type="button"
                class="hidden md:flex group items-center gap-1.5 h-9 rounded-xl bg-white/70 hover:bg-white/90 shadow-sm transition
        {{ $hasNextPage ? '' : 'opacity-40 cursor-not-allowed' }}">
                <span class="text-sm text-darkColor/60 font-medium">Next</span>
                <i class="fa-solid fa-chevron-right text-darkColor/60 group-hover:translate-x-0.5 transition"></i>
            </button>

            <!-- Mobile scroll hint -->
            <div class="md:hidden pointer-events-none absolute bottom-2 left-1/2 -translate-x-1/2">
                <div class="flex items-center justify-center">
                    <div class="h-[2px] w-12 bg-gradient-to-r from-primaryColor-dark via-darkColor/50 to-transparent rounded-full
                animate-[scrollHint_2.2s_ease-in-out_infinite] opacity-60"></div>
                </div>
            </div>

            <!-- Premium fade edges -->
            <div class="md:hidden pointer-events-none absolute inset-0">
                <div class="absolute left-0 top-0 h-full w-8 bg-gradient-to-r from-lightColor/50 to-transparent"></div>
                <div class="absolute right-0 top-0 h-full w-8 bg-gradient-to-l from-lightColor/50 to-transparent"></div>
            </div>
        </div>


        <x-site.input-error :messages="$errors->get('selectedDate')"/>
    </section>

    <!-- Step 2: Time Selection -->
    <section class="space-y-4">
        <div class="flex flex-col items-start space-y-2">
            <h2 class="text-lg md:text-xl font-semibold text-darkColor flex items-center gap-2">
                <i class="fa-regular fa-clock text-primaryColor"></i>
                Step 2 — Pick a Time
            </h2>
            <p class="text-sm text-darkColor/60" dir="rtl">
                @if ($selectedDate)
                    الأوقات المتاحة ليوم
                    <strong class="text-darkColor/80">
                        {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j') }}
                    </strong>
                @else
                    اختر اليوم أولاً لعرض الأوقات المتاحة
                @endif
            </p>
        </div>

        <div class="flex flex-wrap gap-2 sm:gap-3">
            @if ($selectedDate)
                @forelse($selectedDateAvailableTimes as $time)
                    <button
                        type="button"
                        wire:click="setTime('{{ $time }}')"
                        class="relative px-4 py-3 rounded-lg border border-primaryColor-lighter
                        bg-lightColor text-darkColor/70 text-sm font-medium
                        shadow-[0_2px_4px_rgba(0,0,0,0.12)]
                        transition-all duration-200
                        hover:scale-[1.03] hover:shadow-[0_4px_8px_rgba(0,0,0,0.15)]
                        {{ $selectedTime === $time
                            ? 'bg-primaryColor text-white border-primaryColor-dark shadow-[0_4px_8px_rgba(0,0,0,0.18)] scale-[1.05]'
                            : '' }}"
                    >
                        <!-- Small accent stripe -->
                        <span class="absolute top-0 left-0 w-full h-[3px] bg-accentColor"></span>

                        {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                    </button>
                @empty
                    <p class="text-sm text-darkColor/40 italic">لا توجد أوقات متاحة لهذا اليوم</p>
                @endforelse
            @else
                <p class="text-sm text-darkColor/40 italic">الرجاء اختيار اليوم أولاً</p>
            @endif
        </div>
        <x-site.input-error :messages="$errors->get('selectedTime')"/>
    </section> --}}



    <!-- Header Text -->
    <div>
        <h2 class="text-lg md:text-xl font-heading font-semibold">
            Veuillez saisir vos coordonnées
        </h2>
        <p class="text-sm mt-2">أدخل بياناتك لنتمكن من تأكيد الحجز والتواصل معك</p>
    </div>


    <!-- Instructions / Fields -->
    <div class="space-y-5">
        <!-- Full Name -->
        <div class="relative group">
            <x-site.text-input icon="fa-user" type="text" wire:model="fullName" placeholder="Nom complet" />
            <x-site.input-error :messages="$errors->get('fullName')" class="mt-1" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-site.text-input icon="fa-phone" type="text" wire:model="phone" placeholder="Numéro de téléphone" />
            <x-site.input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        <button type="submit" wire:loading.attr="disabled"
            class="relative min-w-fit flex items-center justify-center w-36 px-6 py-3 rounded-2xl font-semibold text-sm uppercase tracking-wide
         text-lightColor bg-primaryColor shadow-lg hover:shadow-2xl
         transition-all duration-300 ease-out
         overflow-hidden cursor-pointer
         before:absolute before:inset-0 before:bg-accentColor before:opacity-0 before:scale-50 before:rounded-2xl
         hover:before:opacity-20 hover:before:scale-100 before:transition-all before:duration-500 before:ease-out
         focus:outline-none focus:ring-4 focus:ring-accentColor/30 disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="submit">
                <i class="fa-solid fa-check mr-2"></i>
                Confirmer la réservation
            </span>


            <span wire:loading wire:target="submit">
                <i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Traitement...
            </span>
        </button>
    </div>

</form>

{{-- 
@script
    <script>
        // Listen for the event
        document.addEventListener('livewire:initialized', () => {

            // Your viewport code here
            const viewPort = window.innerWidth;
            let perPage = 5;

            if (viewPort < 640) {
                perPage = 15;
            } else if (viewPort >= 1024 && viewPort <= 1280) {
                console.log('lg')
                perPage = 3;
            } else if (viewPort > 1280) {
                console.log('xl')
                perPage = 4;
            }

            // Sync + refresh (as before)
            Livewire.dispatch('viewPortSet', {
                perPage
            });
        });
    </script>
@endscript --}}
