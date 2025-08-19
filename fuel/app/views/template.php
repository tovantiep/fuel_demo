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

        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0; /* tránh bị lệch */
        }
    </style>
</head>
<body>
<!-- Header -->
<header class="py-3 px-4 mb-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0"><?= \Fuel\Core\Lang::get('app.management') ?></h1>
        <div class="d-flex align-items-center">
            <!-- Switch Language -->
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

            <div class="me-3 d-flex">
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-0 border d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;" id="langDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                         <span class="flag-icon flag-icon-<?= \Config::get('language') === 'vi' ? 'vn' : 'us' ?> rounded-circle"
                            style="width: 100%; height: 100%; border-radius: 50%; background-size: cover;"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="langDropdown">
                        <li>
                            <?= Html::anchor('lang/switch/en',
                                '<span class="flag-icon flag-icon-us"></span> English',
                                ['class' => 'dropdown-item']) ?>
                        </li>
                        <li>
                            <?= Html::anchor('lang/switch/vi',
                                '<span class="flag-icon flag-icon-vn"></span> Tiếng Việt',
                                ['class' => 'dropdown-item']) ?>
                        </li>
                    </ul>
                </div>
            </div>

            <?php if (\Auth::check()): ?>
                <div class="d-flex align-items-center">
                    <span class="me-3">
                        <?= \Lang::get('app.hello') ?>, <strong><?= e(\Auth::get_screen_name()) ?></strong>
                    </span>
                    <?= Html::anchor('login/profile', '<i class="bi bi-person-circle"></i> ' . \Lang::get('app.change_password'), [
                        'class' => 'btn btn-sm btn-light me-2'
                    ]) ?>

                    <?= Html::anchor('login/logout', '<i class="bi bi-box-arrow-right"></i> ' . \Lang::get('app.logout'), [
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
                        <?= Html::anchor('users/index', \Fuel\Core\Lang::get('app.users'), [
                            'class' => 'nav-link' . (\Uri::segment(1) === 'users' ? ' active' : '')
                        ]) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::anchor('post/index', \Fuel\Core\Lang::get('app.posts'), [
                            'class' => 'nav-link' . (\Uri::segment(1) === 'post' ? ' active' : '')
                        ]) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::anchor('category/index', \Fuel\Core\Lang::get('app.category'), [
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
