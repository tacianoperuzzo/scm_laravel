<x-mail::message>
# Olá, {{ $user->pessoa->nome }}!

Seja muito bem-vindo(a) ao nosso sistema. Estamos felizes em ter você conosco!

Cadastre sua senha através do link abaixo.

<x-mail::button :url="url('reset-password/'.$user->remember_token.'?email='.$user->email)">
Cadastrar uma senha
</x-mail::button>

Acesse o sistema pelo link abaixo.

<x-mail::button :url="url('/')">
Acessar o sistema
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
