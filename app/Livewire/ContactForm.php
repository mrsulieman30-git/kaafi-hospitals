<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\SettingsService;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $message;
    public $successMessage;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submitForm(SettingsService $settings)
    {
        $data = $this->validate();

        try {
            $adminEmail = $settings->get('contact_email', 'info@kaafihospitals.so');

            Mail::to($adminEmail)->send(new ContactMessageMail($data));

            $this->reset(['name', 'email', 'message']);
            
            $this->successMessage = __('Thank you for your message! We will get back to you soon.');

            Notification::make()
                ->title(__('Message Sent Successfully'))
                ->success()
                ->send();

        } catch (\Exception $e) {
            session()->flash('error', __('Sorry, there was an error sending your message. Please try again later.'));
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
