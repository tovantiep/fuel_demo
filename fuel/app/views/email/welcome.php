
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome Email</title>
</head>
<body>
    <h2>Xin chào <?= e($username) ?>,</h2>
    <p>Tài khoản của bạn đã được tạo thành công.</p>
    <p><strong>Email:</strong> <?= e($email) ?></p>
    <p><strong>Username:</strong> <?= e($username) ?></p>
    <p><strong>Password:</strong> <?= e($password) ?></p>
    <p>Hãy đăng nhập để sử dụng hệ thống.</p>
</body>
</html>