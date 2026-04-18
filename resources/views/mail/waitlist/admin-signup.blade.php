<x-mail::message>
# New Waitlist Signup

A new waitlist signup has been received for {{ config('app.name') }}.

<x-mail::panel>
Email: {{ $waitlistEntry->email }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
