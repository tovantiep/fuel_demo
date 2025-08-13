<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin mới nhất</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
        }
        .header-banner {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .navbar {
            border-bottom: 1px solid #ddd;
            background: #fff;
        }
        .section-title {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
        }
        .news-item {
            display: flex;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .news-time {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .news-thumb img {
            width: 150px;
            height: 100px;
            object-fit: cover;
        }
        .news-content {
            flex: 1;
            padding-left: 15px;
        }
        .news-title {
            font-weight: bold;
            font-size: 18px;
            color: #000;
            text-decoration: none;
        }
        .news-title:hover {
            color: #007bff;
        }
        .news-desc {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

<!-- Banner -->
<div>
    <img src="https://cdn.dtadnetwork.com/creatives/img/202508/1754210829.jpg" class="header-banner" alt="Banner">
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="<?= Uri::create('post/index') ?>">DÂN TRÍ</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <?php foreach ($categories as $category): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= (int)\Input::get('category_id') === $category->id ? 'active' : '' ?>"
                           href="<?= Uri::create('') . '?category_id=' . $category->id ?>">
                            <?= e($category->name) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container">

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="news-item">
                <div class="news-content">
                    <div class="news-time"><?= date('H:i d/m/Y', $post->created_at) ?></div>
                    <a href="<?= e($post->content_link) ?>" class="news-title" target="_blank"><?= e($post->title) ?></a>
                    <div class="news-desc"><?= e($post->description ?? mb_substr($post->description, 0, 100) . '...') ?></div>
                </div>
                <?php if (!empty($post->image_link)): ?>
                    <div class="news-thumb">
                        <img src="<?= e($post->image_link) ?>" alt="<?= e($post->title) ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không có bài viết nào.</p>
    <?php endif; ?>
</div>

</body>
</html>
