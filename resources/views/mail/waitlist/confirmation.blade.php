<x-mail::message>
# You're on the waitlist

Thanks for joining the {{ config('app.name') }} waitlist.

We will email **{{ $waitlistEntry->email }}** as soon as access opens up.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
