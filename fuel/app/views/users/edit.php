<?php
// Ensure Bootstrap CSS is loaded in your template layout
?>
<style>
    body {
        background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
        min-height: 100vh;
    }

    .signup-card {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        padding: 2rem 2rem 1.5rem 2rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .signup-card .card-header {
        border-radius: 1.5rem 1.5rem 0 0;
        background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.15);
    }

    .signup-card .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
    }

    .signup-card .btn-primary {
        background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
        border: none;
        border-radius: 2rem;
        font-weight: 600;
        transition: background 0.2s;
    }

    .signup-card .btn-primary:hover {
        background: linear-gradient(90deg, #60a5fa 0%, #6366f1 100%);
    }

    .signup-card .card-body form {
        display: flex;
        flex-direction: column;
        gap: 2rem; /* Increased spacing between fields */
    }
</style>
<div class="container mt-5">
    <div class="px-3 pt-3">
        <a href="/users" class="text-decoration-none text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left"
                 viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            Back to Users
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card signup-card shadow-lg">
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= e($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form id="editUserForm" method="post" autocomplete="off">
                        <?php echo \Form::csrf(); ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">UserName</label>
                            <input type="text" class="form-control" id="username" name="username"
                                   value="<?= e(isset($input['username']) ? $input['username'] : (isset($user) ? $user->username : '')) ?>"
                                   required
                                   readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= e(isset($input['email']) ? $input['email'] : (isset($user) ? $user->email : '')) ?>"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to
                                    keep current password)</small></label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>