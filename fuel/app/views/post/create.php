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
        max-width: 100%;
        width: 900px;
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
            <?= \Fuel\Core\Lang::get('app.back_to_posts') ?>
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-10">
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
                        <?php echo \Form::csrf(); ?>
                        <div class="mb-3">
                            <label for="title" class="form-label"><?= \Fuel\Core\Lang::get('app.title') ?></label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="<?= e($input['title'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label"><?= \Fuel\Core\Lang::get('app.description') ?></label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= e($input['description'] ?? '') ?></textarea>
                        </div>

                        <div>
                            <label for="image_link" class="form-label"><?= \Fuel\Core\Lang::get('app.image') ?></label>
                            <input type="file" name="image_link" id="image_link" accept="image/*" style="display:none;">

                            <!-- nút chọn file giả -->
                            <button type="button" id="btnChooseFile" class="btn btn-secondary"><?= \Fuel\Core\Lang::get('app.choose_file') ?></button>
                            <span id="fileName" style="margin-left:10px;"><?= \Fuel\Core\Lang::get('app.no_file_chosen') ?></span>

                            <br>
                            <img id="previewImage" src="" alt="Preview" style="display:none;max-width:200px;margin-top:10px;">
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label"><?= \Fuel\Core\Lang::get('app.category') ?></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- <?= \Fuel\Core\Lang::get('app.all_categories') ?>--</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->id ?>"
                                        <?= (isset($input['category_id']) && $input['category_id'] == $category->id) ? 'selected' : '' ?>>
                                        <?= e($category->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="summary" class="form-label"><?= \Fuel\Core\Lang::get('app.summary') ?></label>
                            <textarea class="form-control" id="summary" name="summary" rows="5"><?= e($input['summary'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-2"><?= \Fuel\Core\Lang::get('app.create') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="https://cdn.tiny.cloud/1/uv866seovgmzncjuqbk90zn75t1hazvdaqcq1305y80qxfpx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Custom JS -->
<script>
    document.getElementById("btnChooseFile").addEventListener("click", function() {
        document.getElementById("image_link").click();
    });

    document.getElementById("image_link").addEventListener("change", function() {
        const fileInput = this;
        const fileNameSpan = document.getElementById("fileName");
        const previewImage = document.getElementById("previewImage");

        if (fileInput.files && fileInput.files[0]) {
            fileNameSpan.textContent = fileInput.files[0].name;

            // Hiển thị preview ảnh
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = "block";
            }
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            fileNameSpan.textContent = "<?= \Fuel\Core\Lang::get('app.no_file_chosen') ?>";
            previewImage.style.display = "none";
        }
    });

    tinymce.init({
        selector: '#summary',
        height: 300,
        menubar: false,
        plugins: 'advlist autolink lists link image charmap preview anchor ' +
            'searchreplace visualblocks code fullscreen ' +
            'insertdatetime media table code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | removeformat | help'
    });
</script>





