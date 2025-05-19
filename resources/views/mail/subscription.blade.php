<x-mail::message>
# Verify your email address

You subscribe to the weather in the city **{{ $subscription->city }}**, with frequency: **{{ $subscription->frequency }}**.
You need to verify your email address to continue
<x-mail::button :url="$url">
    Confirm the subscription
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
