

<h2>Password Reset</h2>

<form action="{{ route('reset_password') }}" method="POST">
    @csrf
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <button type="submit">Reset Password</button>
</form>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
