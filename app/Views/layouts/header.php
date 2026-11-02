<?php $success=flash('success'); $error=flash('error'); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#101b36">
<title><?= e(env_value('APP_NAME','JobConnect')) ?> — Find work that matters</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= e(url('')) ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark jc-navbar sticky-top">
<div class="container py-1">
<a class="navbar-brand d-flex align-items-center gap-2" href="<?= e(url('')) ?>">
<span class="brand-mark"><i class="bi bi-briefcase-fill"></i></span><span>job<span class="brand-light">connect</span><small class="brand-dot">.</small></span>
</a>
<button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="mainNav">
<ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
<li class="nav-item"><a class="nav-link" href="<?= e(url('jobs/index')) ?>">Find jobs</a></li>
<?php if (!logged_in()): ?>
<li class="nav-item"><a class="nav-link" href="<?= e(url('auth/register')) ?>">For employers</a></li>
<li class="nav-item"><a class="nav-link" href="<?= e(url('auth/login')) ?>">Sign in</a></li>
<li class="nav-item"><a class="btn btn-nav-cta" href="<?= e(url('auth/register')) ?>">Get started <i class="bi bi-arrow-up-right ms-1"></i></a></li>
<?php else: ?>
<li class="nav-item"><span class="nav-link user-greeting"><i class="bi bi-person-circle me-1"></i><?= e(user()['name']) ?></span></li>
<?php if(user()['role']==='seeker'): ?><li><a class="nav-link" href="<?= e(url('seeker/dashboard')) ?>">My dashboard</a></li><li><a class="nav-link" href="<?= e(url('seeker/profile')) ?>">Profile</a></li><?php endif; ?>
<?php if(user()['role']==='recruiter'): ?><li><a class="nav-link" href="<?= e(url('recruiter/dashboard')) ?>">Recruiter</a></li><?php endif; ?>
<?php if(user()['role']==='admin'): ?><li><a class="nav-link" href="<?= e(url('admin/dashboard')) ?>">Admin</a></li><?php endif; ?>
<li class="nav-item"><form method="post" action="<?= e(url('auth/logout')) ?>"><?= csrf_field() ?><button class="btn btn-nav-outline btn-sm">Sign out</button></form></li>
<?php endif; ?>
</ul></div></div></nav>
<main>
<?php if ($success || $error): ?><div class="container pt-3"><?php if($success): ?><div class="alert alert-success alert-dismissible fade show"><?= e($success) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?><?php if($error): ?><div class="alert alert-danger alert-dismissible fade show"><?= e($error) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?></div><?php endif; ?>
