<?php

namespace App\Livewire\Modals;

use App\Models\Client;
use App\Models\Leads;
use App\Models\LeadSocialMediaContact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UpsertLead extends Component
{
    public $users;
    public string $lead_id = '';
    public array $leadData = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'industry' => '',
        'instagram' => '',
        'linkedin' => '',
        'facebook' => '',
        'status' => 'New',
        'lead_source' => '',
    ];

    public bool $isOpen = false;
    public bool $isEditing = false;

    public array $lead_statues = ['New', 'Attempted Contact', 'Contacted', 'Call Back Requested', 'Proposition Sent', 'Meeting Scheduled', 'Won', 'Lost', 'Not Interested'];
    public array $leadSources = ['Booking Page', 'Referrals', 'Website', 'Email', 'Social Media', 'Direct Outreach'];
    public array $industries = ['Website : E-Commerce', 'Website : Services', 'Media Buyer', 'Consultation'];

    protected $listeners = [
        'openAddLeadModal' => 'openLeadModal',
        'openLeadsUpsertModal' => 'openLeadModal',
        'closeModal' => 'closeModal',
    ];

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
        'leadData.lead_source.required' => 'Lead source is required.',
        'leadData.follow_up_date.date' => 'Invalid date format for follow-up.',
        'leadData.found_by.required' => 'Please specify who found this lead.',
        'leadData.industry.required' => 'Please specify the industry for this lead.',
        'leadData.email.required_without_all' => 'Provide at least one contact method (email, phone, or social link).',
        'leadData.phone.required_without_all' => 'A contact method (phone, email, or social link) is required.',
        'leadData.instagram.required_without_all' => 'Add at least one contact detail (social link, phone, or email).',
        'leadData.linkedin.required_without_all' => 'Please provide a contact method (LinkedIn, phone, or email).',
        'leadData.facebook.required_without_all' => 'Share at least one contact method (Facebook, email, or phone).',
    ];

    public function mount(): void
    {
        $usersAll = User::all();

        foreach ($usersAll as $user) {
            $this->users[$user->id] = $user->name;
        }
    }

    public function resetForm(): void
    {
        $this->leadData = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'industry' => '',
            'instagram' => '',
            'linkedin' => '',
            'facebook' => '',
            'status' => 'New',
            'lead_source' => '',
        ];
    }

    public function openLeadModal($lead_id = ''): void
    {
        $this->resetErrorBag();
        $this->resetForm();

        $this->dispatch('lb-stop', key: 'openModal');
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->resetForm();
        $this->resetErrorBag();
        $this->isOpen = false;
    }

    public function submit(): void
    {
        // Validate the lead data based on the editing state
        $this->validate($this->rules());

        $lead_details = [
            'name' => $this->leadData['name'],
            'email' => $this->leadData['email'],
            'phone' => $this->leadData['phone'],
            'status' => 'New',
            'industry' => $this->leadData['industry'],
            'lead_source' => $this->leadData['lead_source'],
        ];


        $lead_socials = [
            'instagram' => $this->leadData['instagram'] ?? '',
            'linkedin' => $this->leadData['linkedin'] ?? '',
            'facebook' => $this->leadData['facebook'] ?? '',
        ];


        $lead = Leads::create($lead_details);
        LeadSocialMediaContact::create([...$lead_socials, 'lead_id' => $lead->id]);
        log_activity('Created New Lead ' . $lead->name);

        $this->dispatch('updateLeadsTable');
        $this->closeModal();
    }

    public function rules(): array
    {
        $rules = [
            'leadData.name' => 'required',
            'leadData.email' => 'nullable|email|required_without_all:leadData.phone,leadData.instagram,leadData.linkedin,leadData.facebook',
            'leadData.phone' => 'nullable|numeric|required_without_all:leadData.email,leadData.instagram,leadData.linkedin,leadData.facebook',
            'leadData.instagram' => 'nullable|string|required_without_all:leadData.email,leadData.phone,leadData.linkedin,leadData.facebook',
            'leadData.linkedin' => 'nullable|string|required_without_all:leadData.email,leadData.phone,leadData.instagram,leadData.facebook',
            'leadData.facebook' => 'nullable|string|required_without_all:leadData.email,leadData.phone,leadData.instagram,leadData.linkedin',
        ];


        $rules['leadData.email'] .= '|unique:leads,email,' . $this->lead_id;
        $rules['leadData.phone'] .= '|unique:leads,phone,' . $this->lead_id;


        return $rules;
    }

    public function convertLeadToClient(): void
    {
        Client::create([
            'lead_id' => $this->lead_id,
            'engagement_date' => now(),
            'country' => '',
            'city' => '',
            'address' => '',
            'type' => 'Neutral'
        ]);

        $this->dispatch('updateClientTable');
    }

    public function deleteRecord($lead_id): void
    {
        $lead = Leads::where('id', $lead_id)->delete();
    }


    public function updated()
    {
        $this->dispatch('lb-stop', key: 'saveForm');
    }

    public function render(): Factory|View
    {
        return view('livewire.modals.upsert-lead');
    }
}
