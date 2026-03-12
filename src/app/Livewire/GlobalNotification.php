<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GlobalNotification extends Component
{
    public bool $isDisplayed = false; // Controls the visibility of the notification
    public bool $displaySuccessMessage = false;
    public bool $displayErrorMessage = false;
    public bool $displayLoading = false;


    public string $title = ''; // Holds the title of the notification
    public string $message = ''; // Holds the message to be displayed in the notification


    protected $listeners = [
        'showNotification' => 'showGlobalNotification',
        'closeNotification' => 'closeNotification',
    ];

    public function showGlobalNotification($title, $message, $type = 'success'): void
    {
        $this->displayLoading = $type === 'loading';
        $this->displayErrorMessage = $type === 'error';
        $this->displaySuccessMessage = $type === 'success';
        $this->title = $title; // Set the notification title
        $this->message = $message; // Set the notification message
        $this->isDisplayed = true; // Show the notification
    }

    public function closeNotification(): void
    {
        $this->isDisplayed = false; // Hide the notification
        $this->displaySuccessMessage = false;
        $this->displayErrorMessage = false;
        $this->displayLoading = false;
        $this->title = ''; // Clear the notification title
        $this->message = ''; // Clear the notification message
    }


    public function render(): Factory|View
    {
        return view('livewire.global-notification');
    }
}
