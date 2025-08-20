<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h2 class="mb-0 me-3"><?= \Fuel\Core\Lang::get('app.user_list') ?></h2>
                <?php if (\Util\AuthUtil::isAdmin()): ?>
                    <?= Html::anchor('users/create', '<i class="bi bi-plus-lg"></i> ' . \Lang::get('app.create'), [
                        'class' => 'btn btn-primary',
                    ]) ?>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th><?= \Lang::get('app.id') ?></th>
                        <th><?= \Lang::get('app.username') ?></th>
                        <th><?= \Lang::get('app.email') ?></th>
                        <?php if (\Util\AuthUtil::isAdmin()): ?>
                            <th><?= \Lang::get('app.actions') ?></th>
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
                                            'onclick' => "return confirm('" . \Lang::get('app.confirm_delete') . "');"
                                        ]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= \Util\AuthUtil::isAdmin() ? 4 : 3 ?>" class="text-center text-muted"><?= \Lang::get('app.no_record_found') ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                <!-- Per page dropdown -->
                <form method="get" action="<?= Uri::create('users/index') ?>" class="d-flex align-items-center mb-3 mb-md-0">
                    <?php echo \Form::csrf(); ?>
                    <label for="per_page" class="me-2 mb-0"><?= \Lang::get('app.show') ?></label>
                    <select name="per_page" id="per_page" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                        <?php foreach ([10, 20, 50] as $limit): ?>
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
