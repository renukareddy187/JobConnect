<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<div class="auth-card card mx-auto"><div class="card-body p-4 p-md-5">
<h1 class="h3 fw-bold">Create your account</h1><p class="text-muted">Join JobConnect as a candidate or recruiter.</p>
<form method="post" action="<?= e(url('auth/register')) ?>" class="needs-validation" novalidate>
<?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Full name</label><input class="form-control" name="name" required maxlength="100" value="<?= old('name') ?>"></div>
<div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required value="<?= old('email') ?>"></div>
<div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" minlength="8" required><div class="form-text">At least 8 characters.</div></div>
<div class="mb-4"><label class="form-label">Account type</label><select class="form-select" name="role"><option value="seeker">Job seeker</option><option value="recruiter">Recruiter / Employer</option></select></div>
<button class="btn btn-primary w-100">Create account</button>
</form><p class="mt-3 mb-0 small">Already registered? <a href="<?= e(url('auth/login')) ?>">Sign in</a></p>
</div></div>
<?php clear_old_input(); require BASE_PATH.'/app/Views/layouts/footer.php'; ?>
