<?php

namespace App\Livewire\ClientManagement;

use App\Models\Leads;
use App\Models\LeadSocialMediaContact;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LeadInfoCard extends Component
{
    public Leads $lead;
    public string $lead_id = '';
    public bool $isEditing = false;

    public array $leadData = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'status' => '',
        'industry' => '',
        'lead_source' => '',
        'notes' => '',
        'instagram' => '',
        'linkedin' => '',
        'facebook' => '',
    ];
    public array $leadSources = ['Booking Page', 'Referrals', 'Website', 'Email', 'Social Media', 'Direct Outreach'];
    public array $industries = ['Website : E-Commerce', 'Website : Services', 'Media Buyer', 'Consultation'];
    public function mount(Leads $lead): void
    {
        $this->leadData = [
            'name' => $lead->name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'status' => $lead->status,
            'industry' => $lead->industry,
            'lead_source' => $lead->lead_source,
            'notes' => $lead->notes,
            'instagram' => $lead->socialMedia?->instagram ?? '',
            'linkedin' => $lead->socialMedia?->linkedin ?? '',
            'facebook' => $lead->socialMedia?->facebook ?? '',
        ];
        $this->lead_id = $lead->id;
    }

    public function edit(): void
    {
        $this->isEditing = true;
    }

    public function cancel(): void
    {
        $this->isEditing = false;
    }

    public function saveLeadData(): void
    {
        // Validate the lead data based on the editing state
        $this->validate($this->rules());

        $lead_details = [
            'name' => $this->leadData['name'],
            'email' => $this->leadData['email'],
            'phone' => $this->leadData['phone'],
            // 'status' => $this->leadData['status'] ?? 'New', // Status is managed via activity for now, or keep it if you want direct edits
            'industry' => $this->leadData['industry'] ?? null,
            'lead_source' => $this->leadData['lead_source'] ?? null,
            // 'notes' => $this->leadData['notes'], // Notes might be separate now
        ];

        $lead_socials = [
            'instagram' => $this->leadData['instagram'] ?? '',
            'linkedin' => $this->leadData['linkedin'] ?? '',
            'facebook' => $this->leadData['facebook'] ?? '',
        ];


        // Update basic details
        $this->lead->update([
            'name' => $this->leadData['name'],
            'email' => $this->leadData['email'],
            'phone' => $this->leadData['phone'],
            'industry' => $this->leadData['industry'] ?? null,
            'lead_source' => $this->leadData['lead_source'] ?? null,
        ]);

        // Update Socials
        if ($this->lead->socialMedia) {
            $this->lead->socialMedia->update($lead_socials);
        } else {
            LeadSocialMediaContact::create([...$lead_socials, 'lead_id' => $this->lead->id]);
        }

        log_activity(auth()->user()->name . ' updated lead ' . $this->lead->name);

        // Refresh the model
        $this->lead->refresh();
        $this->isEditing = false;
    }

    public function rules(): array
    {
        $rules = [
            'leadData.name' => 'required',
            'leadData.email' => 'nullable|email|required_without_all:leadData.phone',
            'leadData.phone' => 'nullable|numeric|required_without_all:leadData.email',
            'leadData.industry' => 'required',
            'leadData.lead_source' => 'required',
            'leadData.notes' => 'nullable|string',
        ];

        if (!$this->isEditing) {
            $rules['leadData.email'] .= '|unique:leads,email';
            $rules['leadData.phone'] .= '|unique:leads,phone';
        } else {
            $rules['leadData.email'] .= '|unique:leads,email,' . $this->lead_id;
            $rules['leadData.phone'] .= '|unique:leads,phone,' . $this->lead_id;
        }

        return $rules;
    }

    protected array $messages = [
        'leadData.name.required' => 'Name is required – we need to know who we’re working with!',
        'leadData.email.email' => 'Invalid email. Please double-check.',
        'leadData.email.unique' => 'This email is already in use.',
        'leadData.phone.numeric' => 'Phone number should only have numbers.',
        'leadData.phone.unique' => 'Phone number already linked to another lead.',
        'leadData.instagram.string' => 'Invalid Instagram link. Check formatting.',
        'leadData.instagram.unique' => 'This Instagram handle is already used.',
        'leadData.linkedin.string' => 'Check if the LinkedIn link is valid.',
        'leadData.linkedin.unique' => 'This LinkedIn profile is already in use.',
        'leadData.facebook.string' => 'Ensure the Facebook link is formatted correctly.',
        'leadData.facebook.unique' => 'This Facebook link is already in use.',
        'leadData.lead_reason.required' => 'Lead reason is required for context.',
        'leadData.lead_source.required' => 'Lead source is required.',
        'leadData.follow_up_date.required' => 'Follow-up date is required.',
        'leadData.follow_up_date.date' => 'Invalid date format for follow-up.',
        'leadData.found_by.required' => 'Please specify who found this lead.',
        'leadData.industry.required' => 'Please specify the industry for this lead.',
        'leadData.follow_up_date.after' => 'The follow-up date must be after today.',
        'leadData.follow_up_date.before_or_equal' => 'The follow-up date must be within the next 15 days.',
    ];

    public function getStatusClass($status): string
    {
        return match ($status) {
            'New' => 'text-white bg-blue-500',
            'Call Back Requested' => 'text-white bg-red-500',
            'Call Back' => 'text-amber-900 bg-amber-300',
            'Inquiry' => 'text-white bg-violet-600',
            'Processing' => 'text-white bg-sky-500',
            'Proposition Sent' => 'text-white bg-fuchsia-600',
            'Won' => 'text-white bg-emerald-500',
            'Not Interested' => 'text-stone-700 bg-stone-200',
            'Junk' => 'text-zinc-400 bg-zinc-100 line-through',
            default => 'text-gray-500',
        };
    }

    public function getStatusIcon($status): string
    {
        return match ($status) {
            'New' => 'fa-solid fa-star',
            'Call Back Requested' => 'fa-solid fa-phone-volume',
            'Call Back' => 'fa-solid fa-phone-arrow-up-right',
            'Inquiry' => 'fa-solid fa-circle-question',
            'Processing' => 'fa-solid fa-spinner',
            'Proposition Sent' => 'fa-solid fa-paper-plane',
            'Won' => 'fa-solid fa-trophy',
            'Not Interested' => 'fa-solid fa-ban',
            'Junk' => 'fa-solid fa-trash-can',
            default => 'fa-solid fa-circle',
        };
    }

    public function render(): View
    {
        return view('livewire.client-management.lead-info-card');
    }
}
