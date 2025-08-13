<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'User Management' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
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
        header {
            background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
            color: #fff;
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

<!-- Layout -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <?= Html::anchor('users/index', 'Users', [
                            'class' => 'nav-link' . (\Uri::segment(1) === 'users' ? ' active' : '')
                        ]) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::anchor('post/index', 'Posts', [
                            'class' => 'nav-link' . (\Uri::segment(1) === 'post' ? ' active' : '')
                        ]) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::anchor('category/index', 'Categories', [
                            'class' => 'nav-link' . (\Uri::segment(1) === 'category' ? ' active' : '')
                        ]) ?>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main role="main" class="col-md-10 ms-sm-auto px-4">
            <?= isset($content) ? $content : '' ?>
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
