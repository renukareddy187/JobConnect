<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<div class="form-card card mx-auto"><div class="card-body p-4"><h1 class="h3">Company profile</h1>
<form method="post" enctype="multipart/form-data"><?= csrf_field() ?>
<?php if(!empty($company['logo'])): ?><img src="<?= e(url('media/image&kind=company&file='.$company['logo'])) ?>" alt="Company logo" width="80" height="80" class="rounded mb-3" style="object-fit:cover"><?php endif; ?>
<div class="mb-3"><label class="form-label">Company logo (JPG, PNG or WebP, max 5 MB)</label><input type="file" class="form-control" name="logo" accept="image/jpeg,image/png,image/webp"></div>
<div class="mb-3"><label class="form-label">Company name *</label><input class="form-control" name="company_name" required value="<?= e($company['company_name']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="4"><?= e($company['description']??'') ?></textarea></div>
<div class="mb-3"><label class="form-label">Website</label><input type="url" class="form-control" name="website" value="<?= e($company['website']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Location</label><input class="form-control" name="location" value="<?= e($company['location']??'') ?>"></div>
<button class="btn btn-primary">Save company</button></form></div></div>
<?php require BASE_PATH.'/app/Views/layouts/footer.php'; ?>
