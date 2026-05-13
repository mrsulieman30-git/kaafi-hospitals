<x-mail::message>
# New Contact Message

You have received a new message from the KAAFI Hospitals website contact form.

**Name:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}

**Message:**  
{{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
