<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h2 class="mb-0 me-3">Post List</h2>

                <?php if (\Util\AuthUtil::isAdmin()): ?>
                    <div class="d-flex gap-2">
                        <?= Html::anchor('post/create', '<i class="bi bi-plus-lg"></i> Create Post', [
                            'class' => 'btn btn-primary',
                        ]) ?>
                    </div>
                <?php endif; ?>
            </div>

            <form method="get" action="<?= Uri::create('post/index') ?>" class="row g-2 mb-3" id="searchForm">
                <div class="col-auto">
                    <select name="category_id" class="form-select">
                        <option value="">-- All Categories --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>"
                                <?= Input::get('category_id') == $category->id ? 'selected' : '' ?>>
                                <?= e($category->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-auto">
                    <input type="text" name="keyword"
                           class="form-control"
                           placeholder="Search keyword..."
                           value="<?= e(Input::get('keyword')) ?>">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
                <div class="col-auto">
                    <?= Html::anchor('#', '<i></i> Crawl Post', [
                        'class' => 'btn btn-secondary',
                        'id' => 'btnCrawlPost'
                    ]) ?>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <?php if (\Util\AuthUtil::isAdmin()): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?= e($post->id) ?></td>
                                <td><?= e($post->category ? $post->category->name : ' ') ?></td>
                                <td><?= e($post->title) ?></td>
                                <td><?= e($post->description) ?></td>
                                <?php if (\Util\AuthUtil::isAdmin()): ?>
                                    <td>
                                        <?= Html::anchor('post/update/' . $post->id, '<i class="bi bi-pencil-square"></i>', [
                                            'class' => 'btn btn-sm btn-outline-secondary me-1',
                                            'title' => 'Update'
                                        ]) ?>
                                        <?php
                                        $currentQuery = $_SERVER['QUERY_STRING'];
                                        $deleteUrl = 'post/delete/' . $post->id;
                                        if (!empty($currentQuery)) {
                                            $deleteUrl .= '?' . $currentQuery;
                                        }
                                        ?>

                                        <?= Html::anchor($deleteUrl, '<i class="bi bi-trash"></i>', [
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'title' => 'Delete',
                                            'onclick' => "return confirm('Are you sure you want to delete this post?');"
                                        ]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= \Util\AuthUtil::isAdmin() ? 4 : 3 ?>" class="text-center text-muted">No
                                Posts found.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                <!-- Per page dropdown -->
                <form method="get" action="<?= Uri::create('post/index') ?>"
                      class="d-flex align-items-center mb-3 mb-md-0">
                    <label for="per_page" class="me-2 mb-0">Show:</label>
                    <select name="per_page" id="per_page" class="form-select form-select-sm me-2"
                            onchange="this.form.submit()">
                        <?php foreach ([10, 20, 50] as $limit): ?>
                            <option value="<?= $limit ?>" <?= $per_page == $limit ? 'selected' : '' ?>><?= $limit ?></option>
                        <?php endforeach; ?>
                    </select>
                    <noscript><input type="submit" value="Apply" class="btn btn-sm btn-secondary"></noscript>
                </form>

                <div class="pagination-wrapper">
                    <?= $pagination ?>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    document.getElementById('searchForm').addEventListener('submit', function (e) {
        const elements = this.querySelectorAll('input, select');
        elements.forEach(el => {
            if (!el.value.trim()) el.removeAttribute('name');
        });
    });
    document.getElementById('btnCrawlPost').addEventListener('click', function (e) {
        e.preventDefault();

        const categoryId = document.querySelector('select[name="category_id"]').value;

        let url = '<?= Uri::create("crawl/crawl_dantri") ?>';
        if (categoryId) {
            url += '?category_id=' + encodeURIComponent(categoryId);
        }
        fetch(url)
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(err => {
                alert("Có lỗi xảy ra khi crawl bài viết.");
                location.reload();
            });
    });
</script>
