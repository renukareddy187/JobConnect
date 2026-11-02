<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<section class="container py-5"><div class="form-card card mx-auto"><div class="card-body p-4"><h1 class="h3 mb-3">My profile</h1>
<?php if(!empty($profile['profile_image'])): ?><img src="<?= e(url('media/image&kind=profile&file='.$profile['profile_image'])) ?>" alt="Profile photo" width="88" height="88" class="rounded-circle mb-3" style="object-fit:cover"><?php endif; ?>
<form method="post" enctype="multipart/form-data"><?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Full name</label><input class="form-control" name="name" required maxlength="100" value="<?= e($profile['name']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" value="<?= e($profile['email']??'') ?>" disabled></div>
<div class="mb-3"><label class="form-label">Phone</label><input class="form-control" name="phone" maxlength="30" value="<?= e($profile['phone']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Profile photo (JPG, PNG or WebP, max 5 MB)</label><input class="form-control" type="file" name="profile_image" accept="image/jpeg,image/png,image/webp"></div>
<button class="btn btn-primary">Save profile</button> <a class="btn btn-outline-secondary" href="<?= e(url('seeker/dashboard')) ?>">Cancel</a></form></div></div></section>
<?php require BASE_PATH.'/app/Views/layouts/footer.php'; ?>