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
        .news-desc {
            font-size: 18px;
            font-style: italic;
            color: #555;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<!-- Banner -->
<div id="banner">
    <img src="https://cdn.dtadnetwork.com/creatives/img/202508/1754210829.jpg" class="header-banner active" alt="Banner">
    <img src="https://cdn.dtadnetwork.com/creatives/img/202508/1754998918.jpg" class="header-banner" alt="Banner">
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
<div class="container">
    <div class="section-title">
        <?= e($post->title) ?>
    </div>
    <div class="news-time">
        <?php
        $date = new DateTime('@' . $post->created_at);
        $date->modify('+7 hours');
        echo $date->format('H:i d/m/Y');
        ?>
    </div>
    <div class="news-desc"><?= e($post->description) ?></div>

    <div class="news-content mt-3">
        <?php
        $html = $post->summary ?? '';

        $html = preg_replace_callback('/<img[^>]*>/i', function ($matches) {
            $tag = $matches[0];
            $title = '';

            if (preg_match('/title="([^"]*)"/i', $tag, $m)) {
                $title = $m[1];
            }

            if (preg_match('/data-original="([^"]+)"/i', $tag, $m)) {
                $src = $m[1];
            } elseif (preg_match('/data-src="([^"]+)"/i', $tag, $m)) {
                $src = $m[1];
            } elseif (preg_match('/src="([^"]+)"/i', $tag, $m)) {
                $src = $m[1];
            } else {
                $src = '';
            }

            return '<img'
                . ($title ? ' title="' . htmlspecialchars($title) . '"' : '')
                . ' src="' . htmlspecialchars($src) . '" style="max-width:100%;height:auto;">';
        }, $html);

        $html = preg_replace('/<br\s*\/?>/i', "\n", $html);
        $html = preg_replace('/<\/p>\s*<p>/i', "\n\n", $html);

        // Loại bỏ tag HTML khác ngoài img
        $html = strip_tags($html, '<img>');
        $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
        $html = trim($html);
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        echo nl2br($html);
        ?>
    </div>

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
    }, 10000);
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
