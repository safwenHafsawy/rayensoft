@php
    $plans = [
        [
            'id' => 0,
            'cardTitle' => 'Agency Growth Platform',
            'briefings' => [
                'Multi-Service Custom Website',
                'Lead Intake & CRM Integration',
                'Client Portal & Pipeline Dashboard',
                'Project & Request Workflow',
                'Performance Analytics Dashboard',
                'Team Collaboration Tools',
            ],
            'type' => 'regular',
        ],
        [
            'id' => 1,
            'cardTitle' => 'Personal Brand Growth Plan',
            'briefings' => [
                'Professional Personal Website',
                'Smart Booking + Calendar Sync',
                'Mini CRM & Lead Forms',
                'Lead Magnet & Email Capture',
                'Automated Welcome Sequence',
                'Optional Landing Page Funnels',
            ],
            'type' => 'main',
        ],
        [
            'id' => 2,
            'cardTitle' => 'Digital Commerce Platform',
            'briefings' => [
                'Sales-Optimized Landing Page',
                'Secure Digital Delivery System',
                'Integrated Payment Gateway',
                'Behavior-Based Email Sequences',
                'Analytics for Sales & Users',
                'Optional Subscriptions & Memberships',
            ],
            'type' => 'regular',
        ],
    ];
@endphp

<section class="w-full px-4 md:px-2 xl:px-36 mt-20">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-5 xl:gap-8 items-stretch">
        @foreach ($plans as $plan)
            <x-site.pricing-card
                :id="$plan['id']"
                :cardTitle="$plan['cardTitle']"
                :briefings="$plan['briefings']"
                :type="$plan['type']"
            />
        @endforeach
    </div>
</section>
