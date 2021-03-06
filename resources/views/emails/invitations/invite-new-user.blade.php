@component('mail::message')
# Hi,

You have been invited to join team **{{ $invitation->team->name }}**.

Since you are not yet signed up on the platform, please [Register for free]({{ $url }}), then accept or reject the invitation in your team management console.

@component('mail::button', ['url' => $url])
Register for free
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
