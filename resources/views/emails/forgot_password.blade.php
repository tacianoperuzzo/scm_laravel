@component('mail::message')

Hi, {{ $user->name }}, forgot password?

@component('mail::button', ['url'=>url('reset-password/'.$user->remember_token.'?email='.$user->email)])
Reset your password
@endcomponent

Thanks, <br>
@endcomponent
