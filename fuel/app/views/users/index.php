<div class="container-fluid">
    <div class="row">
        <!-- Sidebar/Navbar Left -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <?php echo Html::anchor('users/index', 'User List', ['class' => 'nav-link active']); ?>
                    </li>
                    <!-- Removed Create User from nav -->
                </ul>
            </div>
        </nav>
        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">User List</h2>
                <?php echo Html::anchor('users/create', '<i class="bi bi-plus-lg"></i> Create User', [
                    'class' => 'btn btn-primary',
                    'id' => 'openCreateUserModal'
                ]); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $i => $user): ?>
                            <tr>
                                <td><?= e($user->id) ?></td>
                                <td><?= e($user->name) ?></td>
                                <td><?= e($user->email) ?></td>
                                <td>
                                    <?php echo Html::anchor('users/update/'.$user->id, '<span class="visually-hidden">Update</span><i class="bi bi-pencil-square"></i>', [
                                        'class' => 'btn btn-sm btn-outline-secondary me-1',
                                        'title' => 'Update',
                                        'aria-label' => 'Update'
                                    ]); ?>
                                    <?php echo Html::anchor('users/delete/'.$user->id, '<span class="visually-hidden">Delete</span><i class="bi bi-trash"></i>', [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'title' => 'Delete',
                                        'aria-label' => 'Delete',
                                        'onclick' => "return confirm('Are you sure you want to delete this user?');"
                                    ]); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No users found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>