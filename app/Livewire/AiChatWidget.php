<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\AiConversation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AiChatWidget extends Component
{
    public $messages = [];
    public $userInput = '';
    public $isTyping = false;
    public $sessionId;

    public function mount()
    {
        // Automatically captures the unique browser session (better than IP tracking)
        $this->sessionId = session()->getId();

        // Load existing chat history for this specific visitor
        $history = AiConversation::where('session_id', $this->sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($history->isNotEmpty()) {
            foreach ($history as $chat) {
                $this->messages[] = [
                    'role' => $chat->role,
                    'content' => $chat->message,
                ];
            }
        } else {
            // First time visitor: Send greeting and save it to history instantly
            $greeting = 'Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?';
            $this->messages[] = ['role' => 'assistant', 'content' => $greeting];
            $this->saveConversation('assistant', $greeting);
        }
    }

    public function startContextDiscussion($type, $id)
    {
        // We load the post along with the tagged doctor and their department
        $post = \App\Models\BlogPost::with('linkedDoctor.department')->find($id);

        if ($post) {
            // 1. Extract the main text
            $cleanContent = strip_tags($post->content);
            
            // 2. Extract Pricing Data (The AI couldn't see this before!)
            $pricingInfo = "";
            if ($post->type === 'ad' && $post->new_price) {
                $oldPrice = $post->old_price ? "$" . $post->old_price : "Standard Rate";
                $pricingInfo = "PRICING DETAILS: The consultation fee has a special discount. It is reduced from {$oldPrice} down to exactly $" . $post->new_price . ". ";
            }

            // 3. Extract Doctor Data
            $doctorInfo = "";
            if ($post->linkedDoctor) {
                // Handle JSON translation strings for the department name if needed
                $deptName = $post->linkedDoctor->department->name ?? 'Specialist';
                if (is_string($deptName) && str_starts_with(trim($deptName), '{')) {
                    $decoded = json_decode($deptName, true);
                    $deptName = $decoded['en'] ?? ($decoded['so'] ?? 'Specialist');
                }
                $doctorInfo = "DOCTOR DETAILS: This offer is specifically with Dr. {$post->linkedDoctor->name}, who specializes in {$deptName}. ";
            }

            // 4. The STRICT System Prompt (Forces all-in-one answers)
            $this->messages[] = [
                'role' => 'system',
                'content' => "SYSTEM NOTE: The user clicked 'Discuss with AI' on a {$type} titled '{$post->title}'. 
                CONTENT OVERVIEW: {$cleanContent} 
                {$pricingInfo}
                {$doctorInfo}
                STRICT INSTRUCTIONS: You are a professional KAAFI Hospital receptionist. Do NOT 'drip-feed' information. When the user asks what this is about, provide a highly comprehensive, all-inclusive summary in your VERY FIRST response. You MUST explicitly list the exact prices and discounts, the doctor's name, the medical benefits, and directly ask if they want to secure a booking."
            ];

            // 5. A Smarter, more enticing initial greeting
            $greetingExtras = $post->new_price ? " I have all the details ready, including the special discount to $" . $post->new_price . "." : " I have all the details ready.";
            
            $this->messages[] = [
                'role' => 'assistant',
                'content' => "Welcome! I see you are interested in our **{$post->title}**.{$greetingExtras} Would you like a complete summary of this offer and how to book your appointment?"
            ];
            
            $this->dispatch('scroll-to-bottom');
        }
    }

    public function useShortcut($text)
    {
        $this->userInput = $text;
        $this->sendMessage();
    }

    public function sendMessage()
    {
        if (trim($this->userInput) === '') return;

        $userMessage = $this->userInput;
        $this->messages[] = ['role' => 'user', 'content' => $userMessage];
        $this->userInput = '';
        $this->isTyping = true;

        $this->saveConversation('user', $userMessage);

        $this->dispatch('call-ai-api');
    }

    #[On('call-ai-api')]
    public function processAi()
    {
        $systemPrompt = "You are a warm, highly professional human receptionist at KAAFI Hospitals. 
        CRITICAL RULES:
        1. NEVER refer to yourself as an AI, bot, or system. Speak naturally as a human employee.
        2. ZERO NARRATION (TOKEN SAVING): Never say 'Let me check', 'Let me calculate the date', or explain your internal reasoning. Use your tools silently. Deliver ONLY the final answer.
        3. SMART DECISIONS: If a patient asks for a specific time (e.g., 1:00 PM) and it is unavailable, DO NOT explain the math. Simply pick the closest available slot and offer it confidently.
        4. COMMON SENSE TIME FORMATTING: Never output weird system times like '13:22'. Round to the nearest clean half-hour and always use AM/PM formatting.
        5. EMPATHY: If a doctor is fully booked or doesn't work that day, immediately suggest their next available working day without apologizing excessively.
        
        Booking Workflow:
        1. Help the user choose a doctor and a date/time.
        2. Once a time is agreed upon, ask for the Patient's Name and Mobile Phone Number.
        3. Use the book_appointment tool to confirm the booking.
        4. Tell them their request was sent to our front desk, and they can track it in the Patient Portal using their phone number as their password.";

        $this->callDeepSeekAPI($systemPrompt);
    }

    private function callDeepSeekAPI($systemPrompt)
    {
        try {
            $response = Http::timeout(45)->withHeaders([
                'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.deepseek.com/v1/chat/completions', [
                'model' => env('DEEPSEEK_MODEL', 'deepseek-chat'),
                'messages' => array_merge(
                    [['role' => 'system', 'content' => $systemPrompt]],
                    $this->messages
                ),
                'tools' => $this->getAITools(),
                'tool_choice' => 'auto',
            ]);

            if ($response->successful()) {
                $responseData = $response->json('choices.0.message');

                if (isset($responseData['tool_calls'])) {
                    $this->handleToolCalls($responseData['tool_calls'], $systemPrompt);
                } else {
                    $aiResponse = $responseData['content'];
                    $this->messages[] = ['role' => 'assistant', 'content' => $aiResponse];
                    $this->saveConversation('assistant', $aiResponse);
                    $this->isTyping = false;
                }
            } else {
                $this->messages[] = ['role' => 'assistant', 'content' => 'I am so sorry, but my desk computer is running a bit slow right now. Could you please try asking that again?'];
                $this->isTyping = false;
            }
        } catch (\Exception $e) {
            $this->messages[] = ['role' => 'assistant', 'content' => 'I apologize, but I seem to have lost my connection. Please give me a moment.'];
            $this->isTyping = false;
            Log::error('AI Error: ' . $e->getMessage());
        }
    }

    private function handleToolCalls($toolCalls, $systemPrompt)
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => null,
            'tool_calls' => $toolCalls
        ];

        foreach ($toolCalls as $call) {
            $functionName = $call['function']['name'];
            $args = json_decode($call['function']['arguments'], true) ?? [];
            $result = '';

            if ($functionName === 'get_hospital_directory') {
                $result = $this->getHospitalDirectory();
            } elseif ($functionName === 'check_availability') {
                $result = $this->checkAvailability($args['doctor_id'] ?? null, $args['date'] ?? null);
            } elseif ($functionName === 'book_appointment') {
                $result = $this->bookAppointment($args);
            } elseif ($functionName === 'search_blog') {
                $result = $this->searchBlog($args['query'] ?? '');
            }

            $this->messages[] = [
                'role' => 'tool',
                'tool_call_id' => $call['id'],
                'name' => $functionName,
                'content' => json_encode($result)
            ];
        }

        $this->callDeepSeekAPI($systemPrompt);
    }

    // --- AI TOOLS (PHP Execution) ---

    private function getHospitalDirectory()
    {
        $doctors = Doctor::where('is_active', true)->with('department')->get()->map(function($doc) {
            return "ID: {$doc->id} | Name: {$doc->name} | Dept: " . ($doc->department->name ?? 'General');
        });
        return ['doctors' => $doctors];
    }

    private function checkAvailability($doctorId, $date = null)
    {
        if (!$doctorId) return ['error' => 'Missing doctor_id'];
        
        try {
            $schedules = DoctorSchedule::where('doctor_id', $doctorId)->where('is_active', true)->get();
            $workingDays = [];
            foreach ($schedules as $sched) {
                $days = is_array($sched->day_of_week) ? $sched->day_of_week : [$sched->day_of_week];
                $workingDays = array_merge($workingDays, $days);
            }
            $workingDays = array_unique($workingDays);

            if (!$date) {
                return ['status' => 'info', 'message' => 'No specific date provided.', 'working_days' => array_values($workingDays)];
            }

            $parsedDate = Carbon::parse($date);
            $dayName = $parsedDate->format('l');

            $activeSchedule = null;
            foreach ($schedules as $schedule) {
                $days = is_array($schedule->day_of_week) ? $schedule->day_of_week : [$schedule->day_of_week];
                if (in_array($dayName, $days)) {
                    $activeSchedule = $schedule;
                    break;
                }
            }

            if (!$activeSchedule) {
                return [
                    'status' => 'error', 
                    'message' => "Doctor does not work on {$dayName}s.",
                    'working_days' => array_values($workingDays)
                ];
            }

            $booked = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $parsedDate->toDateString())
                ->whereIn('status', ['pending', 'approved'])
                ->pluck('appointment_time')
                ->map(fn($time) => Carbon::parse($time)->format('H:i'))
                ->toArray();

            $slots = [];
            $start = Carbon::parse($activeSchedule->start_time);
            $end = Carbon::parse($activeSchedule->end_time);

            while ($start->lessThan($end)) {
                $timeString = $start->format('H:i');
                if (!in_array($timeString, $booked)) {
                    if (!($parsedDate->isToday() && $start->isPast())) {
                        $slots[] = $start->format('H:i');
                    }
                }
                $start->addMinutes(30);
            }

            return ['status' => 'success', 'available_slots' => $slots];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Invalid date format.'];
        }
    }

    private function bookAppointment($data)
    {
        try {
            if (!isset($data['patient_name'], $data['patient_phone'], $data['doctor_id'], $data['date'], $data['time'])) {
                return ['error' => 'Missing required booking fields. Please ask the patient for the missing information.'];
            }

            return DB::transaction(function () use ($data) {
                $rawPhone = preg_replace('/[^0-9]/', '', $data['patient_phone']); 
                $rawPhone = ltrim($rawPhone, '0');
                $formattedPhone = '+252' . $rawPhone;

                $patient = User::where('phone', $formattedPhone)->first();

                if (!$patient) {
                    $patient = new User();
                    $patient->name = $data['patient_name'];
                    $patient->phone = $formattedPhone;
                    $patient->email = 'patient_' . uniqid() . '@kaafihospitals.so'; 
                    $patient->password = Hash::make('0' . $rawPhone);
                    $patient->save();

                    if (class_exists(\Spatie\Permission\Models\Role::class)) {
                        $roleExists = \Spatie\Permission\Models\Role::where('name', 'Patient')->exists();
                        if ($roleExists) {
                            $patient->assignRole('Patient');
                        }
                    }
                }

                $doctor = Doctor::find($data['doctor_id']);
                if (!$doctor) return ['error' => 'Doctor not found in system.'];

                $appointment = new Appointment();
                $appointment->user_id = $patient->id;
                $appointment->department_id = $doctor->department_id ?? null; 
                $appointment->doctor_id = $doctor->id;
                $appointment->appointment_date = $data['date'];
                $appointment->appointment_time = Carbon::parse($data['time'])->format('H:i:s');
                $appointment->status = 'pending';
                $appointment->notes = 'Booked via AI Assistant';
                $appointment->save();

                return [
                    'status' => 'success', 
                    'message' => 'Appointment booked successfully in the database!',
                    'portal_instructions' => "Login with Phone: 0{$rawPhone} and Password: 0{$rawPhone}"
                ];
            });

        } catch (\Exception $e) {
            Log::error('AI Booking Database Crash: ' . $e->getMessage());
            return [
                'status' => 'error', 
                'message' => 'SYSTEM ERROR: ' . $e->getMessage() . ' - IMPORTANT: Tell the user exactly what this error says so the developer can fix the database.'
            ];
        }
    }

    private function searchBlog($query)
    {
        $posts = BlogPost::where('is_published', true)
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->take(3)
            ->get(['title', 'slug', 'excerpt']);
            
        return ['articles' => $posts];
    }

    private function getAITools()
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_hospital_directory',
                    'description' => 'Get a list of all active doctors, their IDs, and their departments.',
                ]
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'check_availability',
                    'description' => 'Check available time slots for a specific doctor. If date is empty, it returns the days of the week they usually work.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'doctor_id' => ['type' => 'integer'],
                            'date' => ['type' => 'string', 'description' => 'Optional. Date in YYYY-MM-DD format.'],
                        ],
                        'required' => ['doctor_id']
                    ]
                ]
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'book_appointment',
                    'description' => 'Book an appointment for a patient in the database.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'patient_name' => ['type' => 'string'],
                            'patient_phone' => ['type' => 'string', 'description' => 'Local phone number, e.g., 0908854328'],
                            'doctor_id' => ['type' => 'integer'],
                            'date' => ['type' => 'string', 'description' => 'YYYY-MM-DD format'],
                            'time' => ['type' => 'string', 'description' => 'HH:MM format in 24-hour time'],
                        ],
                        'required' => ['patient_name', 'patient_phone', 'doctor_id', 'date', 'time']
                    ]
                ]
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_blog',
                    'description' => 'Search the hospital blog for health tips, articles, or news.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'query' => ['type' => 'string', 'description' => 'Search keyword'],
                        ],
                        'required' => ['query']
                    ]
                ]
            ]
        ];
    }

    private function saveConversation($role, $content)
    {
        if (is_string($content)) {
            AiConversation::create([
                'session_id' => $this->sessionId,
                'role' => $role,
                'message' => $content,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.ai-chat-widget');
    }
}
