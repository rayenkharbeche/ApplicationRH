<!-- resources/views/emails/reset_password.blade.php -->

<p>Bonjour {{ $user_name }},</p>

<p>Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>

<p><a href="{{ $reset_link }}">{{ $reset_link }}</a></p>

<p>Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet email.</p>

<p>Merci,</p>
<p>L'équipe de support</p>
