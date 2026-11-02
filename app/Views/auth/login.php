<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<div class="auth-card card mx-auto"><div class="card-body p-4 p-md-5">
<h1 class="h3 fw-bold">Welcome back</h1><p class="text-muted">Sign in to continue to JobConnect.</p>
<form method="post" action="<?= e(url('auth/login')) ?>">
<?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
<div class="mb-4"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
<button class="btn btn-primary w-100">Sign in</button>
</form><p class="mt-3 mb-0 small">New here? <a href="<?= e(url('auth/register')) ?>">Create an account</a></p>
</div></div>
<?php require BASE_PATH.'/app/Views/layouts/footer.php'; ?>
