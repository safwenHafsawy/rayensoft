<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Mews\Purifier\Facades\Purifier;

class ContactForm extends Component
{

    public string $fullName = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    // This property is not used in this component, but it will be used as a honey pot to prevent spam bots from submitting the form
    public string $service = '';

    protected array $rules = [
        'fullName' => 'required|min:3|string',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|min:30|string',
        'service' => 'prohibited', // This forbids the field from having any value
    ];

    protected array $messages = [
        'fullName.required' => 'We’d love to know your name',
        'message.required' => 'Tell us a bit about what you’re experiencing so we can better assist you.',
        'email.email' => 'Hmm, that doesn’t look like a valid email',
        'email.required' => 'We need your email to get back to you',
    ];

    public function save(): void
    {
        $ip = request()->ip();
        $key = "contact-form:$ip";

        // Check if the user has exceeded the rate limit for submitting the contact form
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->dispatch(
                'showNotification',
                'Too many attempts! 🚫',
                'You have exceeded the maximum number of attempts to submit the contact form. Please try again later.',
                'error'
            ); // Dispatch error notification
            return;
        }

        // Check if the honeypot field is filled, if so, it's likely a bot submission
        if (!empty($this->service)) {
            RateLimiter::hit($key, 3600);
            $this->dispatch(
                'showNotification',
                'Oops! Something went wrong. 😞',
                'Looks like there was an issue submitting your message. Please try again in a moment',
                'error'
            ); // Dispatch error notification
            return;
        }

        // Validate the form data
        $validatedData = $this->validate();

        try {
            RateLimiter::hit($key, 600);

            // ✅ Purify user input
            $validatedData['fullName'] = Purifier::clean($validatedData['fullName'], ['HTML.Allowed' => '']);
            $validatedData['email'] = Purifier::clean($validatedData['email'], ['HTML.Allowed' => '']);
            $validatedData['subject'] = Purifier::clean($validatedData['subject'], ['HTML.Allowed' => '']);
            $validatedData['message'] = Purifier::clean($validatedData['message'], ['HTML.Allowed' => '']);

            Message::create([
                'fullname' => $validatedData['fullName'],
                'email' => $validatedData['email'],
                'subject' => $validatedData['subject'],
                'message' => $validatedData['message'],
            ]);

            // Pass the validated data to the SendEmail constructor
//            Mail::to($this->email)->send(new SendEmail($validatedData, 'contact_form'));

            //reset form
            $this->resetForm();

            // Dispatch success notification
            $this->dispatch(
                'showNotification',
                'Message sent!',
                'Thanks for reaching out to us. We’ve received your message and will get back to you as soon as possible. Looking forward to chatting with you!',
                'success'
            );

        } catch (\Throwable $e) {
            RateLimiter::hit($key, 900);
            Log::info($e->getMessage());
            $this->dispatch(
                'showNotification',
                'Oops! Something went wrong. 😞',
                'Looks like there was an issue submitting your message. Please try again in a moment',
                'error'
            ); // Dispatch error notification
            return;
        }
    }

    public function resetForm(): void
    {
        $this->reset(['fullName', 'email', 'subject', 'message']);
    }

    public function render(): Factory|View
    {
        return view('livewire.contact-form');
    }
}
