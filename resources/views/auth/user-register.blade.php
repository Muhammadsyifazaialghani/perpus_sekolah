<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Registration</title>
</head>
<body>
    <h1>Register as User</h1>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form method="POST" action="{{ url('/user/register') }}">
        @csrf
        <label for="name">Name:</label><br />
        <input type="text" id="name" name="name" value="{{ old('name') }}" required /><br /><br />

        <label for="email">Email:</label><br />
        <input type="email" id="email" name="email" value="{{ old('email') }}" required /><br /><br />

        <label for="password">Password:</label><br />
        <input type="password" id="password" name="password" required /><br /><br />

        <label for="password_confirmation">Confirm Password:</label><br />
        <input type="password" id="password_confirmation" name="password_confirmation" required /><br /><br />

        <button type="submit">Register</button>
    </form>
</body>
</html>
