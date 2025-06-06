<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Reset Password</h2>
        
         @if(session('error'))
            <div style="color: red;">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('password.post') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="password" 
                       name="password" 
                       placeholder="New Password" 
                       required 
                       pattern=".{6,}" 
                       title="Password must be at least 6 characters long." 
                       oninvalid="this.setCustomValidity(this.title)" 
                       oninput="this.setCustomValidity('')">

            <button type="submit">Reset Password</button>
        </form>
    </div>

</body>
</html>
