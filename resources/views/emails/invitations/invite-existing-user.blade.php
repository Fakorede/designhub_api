@component('mail::message')
# Hi,

You have been invited to join team **{{ $invitation->team->name }}**.

Since you are already registered on the platform, you can accept or reject the invitation in your [team management console]({{ $url }}).

@component('mail::button', ['url' => $url])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
