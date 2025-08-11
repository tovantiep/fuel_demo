<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <?= Html::anchor('users/index', 'User List', ['class' => 'nav-link active']) ?>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h2 class="mb-0 me-3">User List</h2>
                <?php if (\Util\AuthUtil::isAdmin()): ?>
                    <?= Html::anchor('users/create', '<i class="bi bi-plus-lg"></i> Create User', [
                        'class' => 'btn btn-primary',
                        'id'    => 'openCreateUserModal'
                    ]) ?>
                <?php endif; ?>
            </div>

            <!-- User Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>UserName</th>
                        <th>Email</th>
                        <?php if (\Util\AuthUtil::isAdmin()): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= e($user->id) ?></td>
                                <td><?= e($user->username) ?></td>
                                <td><?= e($user->email) ?></td>
                                <?php if (\Util\AuthUtil::isAdmin()): ?>
                                    <td>
                                        <?= Html::anchor('users/update/' . $user->id, '<i class="bi bi-pencil-square"></i>', [
                                            'class' => 'btn btn-sm btn-outline-secondary me-1',
                                            'title' => 'Update'
                                        ]) ?>
                                        <?= Html::anchor('users/delete/' . $user->id, '<i class="bi bi-trash"></i>', [
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'title' => 'Delete',
                                            'onclick' => "return confirm('Are you sure you want to delete this user?');"
                                        ]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= \Util\AuthUtil::isAdmin() ? 4 : 3 ?>" class="text-center text-muted">No users found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                <!-- Per page dropdown -->
                <form method="get" action="<?= Uri::create('users/index') ?>" class="d-flex align-items-center mb-3 mb-md-0">
                    <label for="per_page" class="me-2 mb-0">Show:</label>
                    <select name="per_page" id="per_page" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                        <?php foreach ([3, 10, 20, 50] as $limit): ?>
                            <option value="<?= $limit ?>" <?= $per_page == $limit ? 'selected' : '' ?>><?= $limit ?></option>
                        <?php endforeach; ?>
                    </select>
                    <noscript><input type="submit" value="Apply" class="btn btn-sm btn-secondary"></noscript>
                </form>

                <!-- Pagination links -->
                <div class="pagination-wrapper">
                    <?= $pagination ?>
                </div>
            </div>
        </main>
    </div>
</div>
