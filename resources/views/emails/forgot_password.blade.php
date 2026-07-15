@component('mail::message')

# Olá, {{ $user->pessoa->nome }}!

Recebemos uma solicitação de recuperação de senha.
Para redefiní-la, utilize o link abaixo.

@component('mail::button', ['url'=>url('reset-password/'.$user->remember_token.'?email='.$user->email)])
Redefinir a senha
@endcomponent

Caso não tenha solicitado, pode ignorar esta solicitação.

Obrigado, <br>
{{ config('app.name') }}
@endcomponent
