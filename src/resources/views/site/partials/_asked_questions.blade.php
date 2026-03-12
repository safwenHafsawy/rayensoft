@php
    $asked_questions = [
        [
            'question' => 'What’s included in the setup fee?',
            'answer' =>
                'The setup fee covers the full design, development, and launch of your tailored digital platform. This includes strategy sessions, custom website/landing page creation, systems integration, and any automation tools included in your plan.',
        ],
        [
            'question' => 'Is the monthly fee mandatory?',
            'answer' =>
                'Yes — the monthly fee ensures your platform stays optimized, maintained, and supported. It also covers essential updates, feature improvements, backups, and ongoing strategy support to keep growing your business.',
        ],
        [
            'question' => 'Can I upgrade or switch plans later?',
            'answer' =>
                ' Absolutely. Our solutions are designed to scale with you. If your business evolves or you need more advanced features, you can move to a higher-tier plan at any time.',
        ],
        [
            'question' => 'What if I don’t have any tech skills?',
            'answer' =>
                ' No problem at all. We handle the technical setup, integrations, and updates — and provide onboarding and support so you can manage your platform easily',
        ],
        [
            'question' => 'What’s a Mini CRM and how does it help me?',
            'answer' =>
                'It’s a lightweight client tracker built right into your backend. You’ll be able to manage leads, track conversations, and plan follow-ups — all in one simple, intuitive place.',
        ],
        [
            'question' => 'How long does it take to launch my platform?',
            'answer' =>
                'Timelines vary by plan and complexity, but most launches take around 4 weeks. We’ll give you a precise timeline during your free consultation.',
        ],
        [
            'question' => 'What support do I get after launch?',
            'answer' =>
                'All plans include priority support. We’re here to help with updates, changes, troubleshooting, or strategy guidance whenever you need it.',
        ],
        [
            'question' => 'Can I cancel anytime?',
            'answer' => 'Our plans are designed as a 6-month growth partnership. Why? Because real results take time.
                    During the first 6 months, we focus on building a solid foundation and driving organic growth.
                    If after that you’re not seeing results, we step in and manage marketing for you — at no extra cost.
                    And if there’s still no traction, we’ll offer a partial refund (up to 50%, depending on our agreement).
                    You’re not just hiring a developer. You’re partnering with a team that’s committed to your success.',
        ],
    ];
@endphp



<section id="faq" class="relative w-full pb-16 mb-4 section-dark overflow-hidden">
    <div
        class="absolute top-20 left-1/3 w-72 h-72 bg-primaryColor-light/8 rounded-full blur-[120px] pointer-events-none">
    </div>
    <div class="absolute bottom-0 right-12 w-80 h-80 bg-accentColor/5 rounded-full blur-[120px] pointer-events-none">
    </div>
    <div class="relative px-4 md:px-8 max-w-5xl mx-auto">
        <div class="py-8 text-center">
            <h4 class="text-3xl md:text-4xl font-bold font-heading gradient-text tracking-wider uppercase">
                FAQ
            </h4>
            <p class="text-gray-500 text-sm mt-2">
                Find answers to the most common questions — fast and clear.
            </p>
        </div>

        <div class="space-y-4 mt-8">
            @foreach ($asked_questions as $index => $qst)
                <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }" class="rounded-xl glass-card overflow-hidden">
                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-6 py-4 text-left font-medium text-white hover:bg-white/5 transition">
                        <span>{{ $qst['question'] }}</span>
                        <svg :class="{ 'rotate-180': open }"
                            class="w-5 h-5 text-accentColor transform transition-transform" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="px-6 pb-4 text-gray-400">
                        {{ $qst['answer'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
