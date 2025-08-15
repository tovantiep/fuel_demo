<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h2 class="mb-0 me-3">Category List</h2>
                <?php if (\Util\AuthUtil::isAdmin()): ?>
                    <?= Html::anchor('category/create', '<i class="bi bi-plus-lg"></i> Create Category', [
                        'class' => 'btn btn-primary',
                    ]) ?>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <?php if (\Util\AuthUtil::isAdmin()): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= e($category->id) ?></td>
                                <td><?= e($category->name) ?></td>
                                <?php if (\Util\AuthUtil::isAdmin()): ?>
                                    <td>
                                        <?= Html::anchor('category/update/' . $category->id, '<i class="bi bi-pencil-square"></i>', [
                                            'class' => 'btn btn-sm btn-outline-secondary me-1',
                                            'title' => 'Update'
                                        ]) ?>

                                        <?php if (!in_array($category->id, [1,2,3,4,5,6,7,8])): ?>
                                            <?= Html::anchor('category/delete/' . $category->id, '<i class="bi bi-trash"></i>', [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'title' => 'Delete',
                                                'onclick' => "return confirm('Are you sure you want to delete this category?');"
                                            ]) ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= \Util\AuthUtil::isAdmin() ? 3 : 2 ?>" class="text-center text-muted">
                                No Categories found.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                <form method="get" action="<?= Uri::create('post/index') ?>" class="d-flex align-items-center mb-3 mb-md-0">
                    <label for="per_page" class="me-2 mb-0">Show:</label>
                    <select name="per_page" id="per_page" class="form-select form-select-sm me-2" onchange="this.form.submit()">
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
