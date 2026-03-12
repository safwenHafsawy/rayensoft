<section class="relative w-full pb-24 overflow-hidden">

    <div class="absolute top-0 w-full h-full bg-gray-50 -skew-y-3 origin-top-left"></div>

    <div class="relative z-10 flex justify-center gap-4 md:gap-6 px-4 py-8">
        @foreach($services as $service)
            <button   wire:click="selectPlan({{ $service['id'] }})"
                    class="cursor-pointer px-5 py-2.5 md:px-7 md:py-3 text-sm md:text-base font-semibold rounded-full transition-all duration-300 shadow-md transform hover:scale-[1.03] focus:outline-none
                       {{ $selected == $service['id']
                            ? 'bg-primaryColor text-white shadow-primaryColor/50'
                            : 'bg-white text-darkColor/90 border border-lightColor/10 hover:bg-gray-100' }}">
                {{ $service['title'] }}
            </button>
        @endforeach
    </div>

    <div class="relative w-full md:container md:mx-auto px-4">
        <div id="plan-details-card"
             class="bg-white p-6 md:p-12 lg:p-16 rounded-3xl shadow-2xl shadow-darkColor/2- border border-primaryColor-lighter transition-all duration-500">

            <div class="text-center mb-10 md:mb-12">
                <h2 class="text-xl md:text-3xl font-heading font-bold text-gray-800 mb-3">{{ $services[$selected]['description'] }}</h2>
                <p class="text-lg md:text-xl font-medium text-primaryColor-dark">{{ $services[$selected]['offer'] }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12 pb-10 border-b border-gray-200">

                <div class="p-4 rounded-xl">
                    <h3 class="flex items-center text-xl md:text-2xl font-heading font-bold text-darkColor/80 mb-4">
                        <i class="fa-solid fa-list-check text-primaryColor mr-3"></i> What's Included?
                    </h3>
                    <ul class="space-y-3">
                        @foreach ($services[$selected]['details'] as $detail)
                            <li class="flex items-start space-x-3">
                                <i class="fa-solid fa-check-circle text-lg text-green-500 mt-0.5"></i>
                                <p class="text-base text-gray-600">{{ $detail }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-4 rounded-xl border-t lg:border-t-0 lg:border-l border-gray-100">
                    <h3 class="flex items-center text-xl md:text-2xl font-heading font-bold text-darkColor/80 mb-4">
                        <i class="fas fa-bullseye text-primaryColor mr-3"></i> Perfect For?
                    </h3>
                    <ul class="space-y-3">
                        @foreach ($services[$selected]['perfectFor'] as $perfectFor)
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-arrow-right text-lg text-primaryColor mt-0.5"></i>
                                <p class="text-base text-gray-600">{{ $perfectFor }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-4 rounded-xl border-t lg:border-t-0 lg:border-l border-gray-100">
                    <h3 class="flex items-center text-xl md:text-2xl font-heading font-bold text-darkColor/80 mb-4">
                        <i class="fas fa-star-of-life text-primaryColor mr-3"></i> Irresistible Benefits
                    </h3>
                    <ul class="space-y-3">
                        @foreach ($services[$selected]['irresistible'] as $whyChoose)
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-bolt text-lg text-yellow-500 mt-0.5"></i>
                                <p class="text-base text-gray-600 font-semibold">{{ $whyChoose }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="w-full text-center flex flex-col items-center pt-10">
                <div class="mt-4 max-w-lg text-center p-4 rounded-md">
                    <p class="text-base font-body text-gray-500">
                        🔒 <strong>Built for results — not quick fixes.</strong> We work with serious businesses
                        ready for a 6-month minimum commitment to see consistent growth.
                    </p>
                </div>

                <x-site.primary-button route="book">
                    Book Free Discovery Session <i class="fa-solid fa-arrow-right ml-2"></i>
                </x-site.primary-button>
            </div>

        </div>
    </div>
</section>
