<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'User Management' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN (hoặc local nếu có) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">-->
    <style>
        body {
            min-height: 100vh;
            background: #f8fafc;
        }
        .sidebar {
            min-height: 100vh;
            border-right: 1px solid #e5e7eb;
        }
        .sidebar .nav-link.active {
            font-weight: bold;
            color: #6366f1 !important;
        }
        header, footer {
            background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
            color: #fff;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 100;
        }
        main {
            min-height: 80vh;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="py-3 px-4 mb-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">Management System</h1>

            <?php if (\Auth::check()): ?>
                <div class="d-flex align-items-center">
                <span class="me-3">
                    Hello, <strong><?= e(\Auth::get_screen_name()) ?></strong>
                </span>
                    <?= Html::anchor('login/profile', '<i class="bi bi-person-circle"></i> Change Password', [
                        'class' => 'btn btn-sm btn-light me-2'
                    ]) ?>
                    <?= Html::anchor('login/logout', '<i class="bi bi-box-arrow-right"></i> Logout', [
                        'class' => 'btn btn-sm btn-danger'
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>
    </header>
    <!-- Main Layout -->
    <?= isset($content) ? $content : '' ?>
    <!-- Footer -->
    <footer class="py-2 mt-4">
        <div class="container-fluid text-center">
            <small>&copy; <?= date('Y') ?> User Management. All rights reserved.</small>
        </div>
    </footer>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
