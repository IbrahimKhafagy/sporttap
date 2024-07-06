<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <p>You requested a password reset for your account. Click the link below to reset your password:</p>
    <a href="{{ route('password/reset', $token).'?email='.urlencode($email) }}">Reset Password</a>
</body>
</html>
