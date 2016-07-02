<!-- Confirm your email display -->
<h1>Thanks for signing up!</h1>

<p>
    We just need you to <a href="{{ url('/api/auth/confirm/'.$user->token)}}">confirm your email address</a>real quick!
</p>