<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile - Change Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery & Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-card {
            max-width: 450px;
            margin: 50px auto;
            padding: 25px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }
        .profile-card h2 {
            margin-bottom: 25px;
            font-size: 22px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-card">
        <h2>Change Password</h2>

        <?php if (\Session::get_flash('successMessage')): ?>
            <div class="alert alert-success">
                <strong>Success!</strong> <?= \Session::get_flash('successMessage') ?>
            </div>
        <?php endif; ?>

        <?php if (\Session::get_flash('errorMessage')): ?>
            <div class="alert alert-danger">
                <strong>Error!</strong> <?= \Session::get_flash('errorMessage') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/login/change_password">
            <div class="form-group">
                <label for="old_password">Old Password</label>
                <input type="password" id="old_password" name="old_password" class="form-control" placeholder="Enter old password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Password</button>
            <br>
            <a href="/users/index" class="btn btn-default btn-block">Back to Dashboard</a>
        </form>
    </div>
</div>

</body>
</html>
