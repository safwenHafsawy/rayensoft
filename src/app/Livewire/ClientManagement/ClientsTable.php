<?php

namespace App\Livewire\ClientManagement;

use App\Models\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ClientsTable extends Component
{
    public array $clients = [
        'name' => null,
        'email' => null,
        'phone' => null,
        'location' => null,
        'status' => null,
        'engagement_date'=> null
    ];

    protected $listeners = ['updateClientTable' => 'updateClientTable'];
    public function mount(): void
    {
        $this->fetchClientsDetails();
    }

    public function satisfactionColor($satisfactionLevel): string {
        return match ($satisfactionLevel) {
            'Very Satisfied' => 'text-green-700 bg-green-100',      // Darker green text with light green background
            'Satisfied' => 'text-green-600 bg-green-50',            // Slightly lighter green text with very light green background
            'Neutral' => 'text-gray-600 bg-gray-100',               // Gray for neutral
            'Dissatisfied' => 'text-red-600 bg-red-50',             // Light red text with very light red background
            'Very Dissatisfied' => 'text-red-200 bg-red-100',       // Dark red text with light red background
            default => 'text-gray-500',                             // Default gray text for undefined values
        };
    }

    public function openClientModal($clientId): void
    {
        $this->dispatch('openClientModal', client_id : $clientId);
    }

    public function openAddClientModal (): void
    {
        $this->dispatch('openAddClientModal');
    }

    public function updateClientTable(): void {
        $this->fetchClientsDetails();
    }

    public function fetchClientsDetails (): void {
        $fetchedClientsDetails = Client::with('lead')->get();

        $this->clients = $fetchedClientsDetails->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => !empty($client->lead->name) ? $client->lead->name : 'N/A',
                'email' => !empty($client->lead->email) ? $client->lead->email : 'N/A',
                'phone' => !empty($client->lead->phone) ? $client->lead->phone : 'N/A',
                'location' => (!empty($client->city) || !empty($client->country) ?
                    trim(($client->city ?? '') . ', ' . ($client->country ?? '')) :
                    'N/A'),

                'type' => !empty($client->type) ? $client->type : 'N/A',
                'engagement_date' => !empty($client->engagement_date) ? $client->engagement_date : 'N/A'
            ];
        })->toArray();
    }
    public function render(): Factory|View
    {
        return view('livewire.client-management.clients-table');
    }
}
