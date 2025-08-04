<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'User Management' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN (hoặc local nếu có) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
        <div class="container-fluid">
            <h1 class="h4 mb-0">Management System</h1>
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
