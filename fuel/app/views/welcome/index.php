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
        .banner-container {
            position: relative;
            width: 100%;
            height: auto;
        }
        .banner-container img {
            width: 100%;
            height: auto;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .banner-container img.active {
            opacity: 1;
            position: relative;
        }
        body {
            padding-top: 0;
        }
        .navbar.fixed-top {
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }
        #banner {
            position: relative;
            width: 100%;
            height: auto;
            overflow: hidden;
        }
        #banner img {
            width: 100%;
            height: auto;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        #banner img.active {
            opacity: 1;
            position: relative;
        }
    </style>
</head>
<body>

<!-- Banner -->
<div id="banner">
    <img src="https://cdn.dtadnetwork.com/creatives/img/202508/1754210829.jpg" class="header-banner active" alt="Banner">
    <img src="https://cdn.dtadnetwork.com/creatives/img/202508/1754998918.jpg" class="header-banner" alt="Banner">
    <img src="https://cdn.dtadnetwork.com/creatives/img/202508/1754406583.png" class="header-banner" alt="Banner">
</div>

<!-- Navbar -->
<nav id="mainNavbar" class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="<?= Uri::create('') ?>">DÂN TRÍ</a>
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
<div class="container mt-4">
    <?php if (empty($posts)): ?>
        <div class="alert alert-info text-center">
            Không có bài viết nào, sang Dân Trí trộm đi =))).
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Cột trái: 2 bài nhỏ -->
            <div class="col-md-3">
                <?php foreach (array_slice($posts, 0, 2) as $post): ?>
                    <div class="mb-3">
                        <a href="<?= !empty($post['summary'])
                            ? \Fuel\Core\Uri::create('detail/'.$post['id'])
                            : $post['content_link'] ?>" class="text-decoration-none">
                            <?php if (!empty($post['image_link'])): ?>
                                <img src="<?= e($post['image_link']) ?>"
                                     class="img-fluid mb-2"
                                     alt="<?= e($post['title']) ?>">
                            <?php endif; ?>
                            <h6 class="fw-bold"><?= e($post['title']) ?></h6>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cột giữa: 1 bài nổi bật -->
            <div class="col-md-6">
                <?php if (!empty($posts[2])): $post = $posts[2]; ?>
                    <div class="card border-0">
                        <?php if (!empty($post['image_link'])): ?>
                            <img src="<?= e($post['image_link']) ?>"
                                 class="card-img-top"
                                 alt="<?= e($post['title']) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title fw-bold">
                                <a href="<?= !empty($post['summary'])
                                    ? \Fuel\Core\Uri::create('detail/'.$post['id'])
                                    : $post['content_link'] ?>"
                                   class="text-dark text-decoration-none">
                                    <?= e($post['title']) ?>
                                </a>
                            </h3>
                            <?php if (!empty($post['description'])): ?>
                                <p class="card-text text-muted">
                                    <?= e($post['description']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cột phải: danh sách ngắn -->
            <div class="col-md-3">
                <?php foreach (array_slice($posts, 3, 5) as $post): ?>
                    <div class="d-flex mb-3 border-bottom pb-2">
                        <?php if (!empty($post['image_link'])): ?>
                            <img src="<?= e($post['image_link']) ?>"
                                 class="me-2"
                                 style="width:80px; height:60px; object-fit:cover;"
                                 alt="<?= e($post['title']) ?>">
                        <?php endif; ?>
                        <div>
                            <a href="<?= !empty($post['summary'])
                                ? \Fuel\Core\Uri::create('detail/'.$post['id'])
                                : $post['content_link'] ?>"
                               class="fw-bold text-dark small text-decoration-none">
                                <?= e($post['title']) ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Các bài còn lại hiển thị bên dưới -->
        <?php if (count($posts) > 8): ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <?php foreach (array_slice($posts, 8) as $post): ?>
                        <div class="d-flex mb-4 border-bottom pb-3">
                            <?php if (!empty($post['image_link'])): ?>
                                <img src="<?= e($post['image_link']) ?>"
                                     style="width:120px; height:80px; object-fit:cover;"
                                     class="me-3"
                                     alt="<?= e($post['title']) ?>">
                            <?php endif; ?>
                            <div>
                                <a href="<?= !empty($post['summary'])
                                    ? \Fuel\Core\Uri::create('detail/'.$post['id'])
                                    : $post['content_link'] ?>"
                                   class="fw-bold text-dark text-decoration-none">
                                    <?= e($post['title']) ?>
                                </a>
                                <?php if (!empty($post['description'])): ?>
                                    <p class="text-muted small mb-0">
                                        <?= e(\Str::truncate($post['description'], 150)) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-white border-top mt-4 pt-4 pb-4">
    <div class="container">
        <div class="row">
            <!-- Thông tin tòa soạn -->
            <div class="col-md-6">
                <h5 class="fw-bold text-success">DÂN TRÍ</h5>
                <p>Cơ quan của Bộ Nội vụ</p>
                <p>Tổng biên tập: Phạm Tuấn Anh</p>
                <p>Giấy phép hoạt động báo điện tử Dân trí số 15/GP-BVHTTDL Hà Nội, ngày 14-4-2025</p>
                <p>Địa chỉ tòa soạn: Số 48 ngõ 2 phố Giảng Võ, phường Giảng Võ, thành phố Hà Nội</p>
                <p>Điện thoại: 024-3736-6491. Hotline HN: 0973-567-567</p>
                <p>Văn phòng đại diện miền Nam: Số 51-53 Võ Văn Tần, phường Xuân Hòa, thành phố Hồ Chí Minh</p>
                <p>Hotline TPHCM: 0974-567-567</p>
                <p>Email: info@dantri.com.vn</p>
            </div>

            <!-- Liên hệ và RSS -->
            <div class="col-md-3">
                <h6>RSS</h6>
                <p><a href="#">Liên hệ tòa soạn</a></p>
                <p>Liên hệ quảng cáo: 0945.54.03.03</p>
                <p>Email: quangcao@dantri.com.vn</p>
                <p><a href="#">Chính sách bảo mật dữ liệu cá nhân</a></p>
            </div>

            <!-- App & mạng xã hội -->
            <div class="col-md-3">
                <h6>Đọc báo Dân trí trên mobile:</h6>
                <p>
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/6/67/App_Store_%28iOS%29.svg" alt="App Store" style="height:40px;"></a>
                    <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" style="height:40px;"></a>
                </p>
            </div>
        </div>
        <div class="text-center mt-3" style="font-size: 13px; color: #777;">
            © 2005-2025 Bản quyền thuộc về Báo điện tử Dân trí. Cấm sao chép dưới mọi hình thức nếu không có sự chấp thuận bằng văn bản.
        </div>
    </div>
</footer>

</body>
</html>

<script>
    let banners = document.querySelectorAll('#banner img');
    let currentIndex = 0;

    setInterval(() => {
        banners[currentIndex].classList.remove('active');
        currentIndex = (currentIndex + 1) % banners.length;
        banners[currentIndex].classList.add('active');
    }, 5000);
    const navbar = document.getElementById('mainNavbar');
    const bannerHeight = document.getElementById('banner').offsetHeight;

    window.addEventListener('scroll', function () {
        if (window.scrollY >= bannerHeight) {
            if (!navbar.classList.contains('fixed-top')) {
                navbar.classList.add('fixed-top');
                document.body.style.paddingTop = navbar.offsetHeight + 'px';
            }
        } else {
            if (navbar.classList.contains('fixed-top')) {
                navbar.classList.remove('fixed-top');
                document.body.style.paddingTop = '0';
            }
        }
    });
</script>
