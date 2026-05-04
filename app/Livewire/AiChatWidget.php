<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatWidget extends Component
{
    public $isOpen = false;
    public $messages = [];
    public $newMessage = '';
    public $isLoading = false;

    public function mount()
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => 'Hi! I am Kaafi AI Assistant. How can I help you today? / Sideen kuu caawin karaa?'
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage))) return;

        $userMessage = trim($this->newMessage);
        $this->messages[] = ['role' => 'user', 'content' => $userMessage];
        $this->newMessage = '';
        $this->isLoading = true;

        $this->dispatch('message-sent');

        // Call DeepSeek API
        try {
            $systemPrompt = "You are Kaafi AI Assistant, the official AI assistant for KAAFI Hospitals in Mogadishu, Somalia. 
            Your goal is to answer questions about the hospital, its doctors, and departments. 
            Keep your answers short and concise to save tokens. 
            If asked a question outside of hospital-related topics, politely apologize and state you can only help with hospital matters.
            Always reply in the language the user is speaking (English or Somali).
            Hospital info: KAAFI Hospitals is located in Wadajir District, Mogadishu. Phone: +252 615 666 999.
            Departments: Cardiology, Pediatrics, Neurology, General Medicine, Laboratory & Diagnostics.
            Doctors: Dr. Ahmed Khan (Cardiology), Dr. Sara Mahmood (General), Dr. Usman Ali (Neurology), Dr. Ayesha Malik (Pediatrics), Mohammad Sulieman (Lab Manager).
            Appointments can be requested by visitors on this site and will be confirmed by reception. No online payments.";

            $apiMessages = [['role' => 'system', 'content' => $systemPrompt]];
            foreach ($this->messages as $msg) {
                $apiMessages[] = ['role' => $msg['role'], 'content' => $msg['content']];
            }

            $response = Http::withToken(env('DEEPSEEK_API_KEY'))
                ->post('https://api.deepseek.com/v1/chat/completions', [
                    'model' => env('DEEPSEEK_MODEL', 'deepseek-chat'),
                    'messages' => $apiMessages,
                    'max_tokens' => 150,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $reply = $response->json('choices.0.message.content');
                $this->messages[] = ['role' => 'assistant', 'content' => $reply];
            } else {
                Log::error('DeepSeek API Error', ['response' => $response->body()]);
                $this->messages[] = ['role' => 'assistant', 'content' => 'Sorry, I am having trouble connecting right now. Please try again later.'];
            }
        } catch (\Exception $e) {
            Log::error('DeepSeek Exception', ['message' => $e->getMessage()]);
            $this->messages[] = ['role' => 'assistant', 'content' => 'An error occurred. Please try again.'];
        }

        $this->isLoading = false;
        $this->dispatch('message-received');
    }

    public function render()
    {
        return view('livewire.ai-chat-widget');
    }
}
