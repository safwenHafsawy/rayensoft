<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ServicesDetails extends Component
{
    public int $selected = 0;
    public array $services = [
        [
            'id' => 0,
            'slug' => 'personal-brand-growth',
            'title' => 'Personal Brand Growth',
            'description' => 'Look professional, get booked consistently, and convert more leads — with a system that runs while you focus on your craft.',
            'price' => 'Setup Fee: 350 – 400 TND',
            'monthly' => 'Monthly: 70 – 120 TND',
            'offer' => 'A complete personal brand system with booking, mini CRM, and automated email follow-up — built to help you grow without overwhelm.',
            'details' => [
                'Personal Brand Website / Landing Page',
                'Lead Magnet or Opt-In (Optional)',
                'Appointment Booking Integration',
                'Smart Contact & Inquiry Form',
                'Mini CRM (Lightweight Backend)',
                'Email Capture + Automated Welcome Sequence',
            ],
            'perfectFor' => [
                'Coaches or freelancers tired of DMs and missed opportunities.',
                'Solopreneurs who want a more professional online presence.',
                'Anyone seeking a low-effort way to automate client generation.',
            ],
            'irresistible' => [
                'Built For Your Brand',
                'Automated Client Flow',
                'Affordable and Effective',
                'Seamless Scheduling',
                'List-Building Tools Included',
            ]
        ],
        [
            'id' => 1,
            'slug' => 'digital-commerce-platform',
            'title' => 'Digital Commerce Platform',
            'description' => 'Sell, deliver, and scale your digital products with a streamlined, secure platform built for performance.',
            'price' => 'Setup Fee: 1,000 – 2,000 TND',
            'monthly' => 'Monthly: 100 – 250 TND',
            'offer' => 'We build a high-converting sales platform integrated with payment, delivery, and email marketing — so you can focus on creating.',
            'details' => [
                'High-Converting Sales Landing Page',
                'Integrated Payment System',
                'Digital Product Delivery & Access Control',
                'Automated Email Marketing & Follow-Ups',
                'Sales & Customer Analytics Dashboard',
                'Membership & Subscription Management (Optional)',
            ],
            'perfectFor' => [
                'Course creators or eBook sellers scaling digital offers.',
                'Coaches transitioning to productized content.',
                'Solo founders needing a secure, scalable setup.',
            ],
            'irresistible' => [
                'No Tech Headaches',
                'Secure Product Delivery',
                'Automated Nurturing',
                'Real-Time Sales Data',
                'Subscription-Ready Platform',
            ]
        ],
        [
            'id' => 2,
            'slug' => 'agency-growth-platform',
            'title' => 'Agency Growth Platform',
            'description' => 'A powerful system that helps you attract leads, manage clients, and streamline team workflows — all in one place.',
            'price' => 'Setup Fee: 1,500 – 3,000 TND',
            'monthly' => 'Monthly: 250 – 500 TND',
            'offer' => 'We craft a custom platform with CRM, client portals, pipelines, and analytics — tailored for agencies needing structure and scalability.',
            'details' => [
                'Advanced Multi-Service Website',
                'Custom Lead Intake System',
                'CRM with Lead Status & Notes',
                'Service Request & Pipeline Dashboard (Optional)',
                'Client Portal',
                'Custom Analytics Dashboard',
            ],
            'perfectFor' => [
                'Growing agencies wanting better lead & project tracking.',
                'Teams tired of scattered tools and workflows.',
                'Service businesses needing stronger client communication.',
            ],
            'irresistible' => [
                'All-in-One System',
                'Track Every Lead & Request',
                'Client Transparency Built-In',
                'Smart Team Coordination',
                'Fully Scalable Infrastructure',
            ]
        ],
    ];

    // Switch plan dynamically
    public function selectPlan($id): void
    {
        $this->selected = $id;
    }

    public function render(): Factory|View
    {
        return view('livewire.services-details');
    }
}
