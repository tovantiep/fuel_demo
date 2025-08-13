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
        <a href="<?= Uri::create('post/index') ?>" class="text-decoration-none text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                 class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            Back to posts
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

                    <form method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="<?= e($input['title'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= e($input['description'] ?? '') ?></textarea>
                        </div>

                        <div>
                            <label for="image_link" class="form-label">Image</label>
                            <input type="file" name="image_link" id="image_link" accept="image/*">
                            <br>
                            <img id="previewImage" src="" alt="Preview" style="display:none;max-width:200px;margin-top:10px;">
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->id ?>"
                                        <?= (isset($input['category_id']) && $input['category_id'] == $category->id) ? 'selected' : '' ?>>
                                        <?= e($category->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-2">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('image_link').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewImage');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
</script>


