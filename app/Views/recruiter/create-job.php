<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<div class="form-card card mx-auto"><div class="card-body p-4"><h1 class="h3">Post a job</h1><p class="text-muted">New jobs require administrator approval.</p>
<form method="post"><?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Job title *</label><input class="form-control" name="title" required></div>
<div class="mb-3"><label class="form-label">Category *</label><select class="form-select" name="category_id" required><?php foreach($categories as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="mb-3"><label class="form-label">Description *</label><textarea class="form-control" name="description" rows="5" required></textarea></div>
<div class="mb-3"><label class="form-label">Requirements</label><textarea class="form-control" name="requirements" rows="3"></textarea></div>
<div class="row"><div class="col-md-6 mb-3"><label class="form-label">Location *</label><input class="form-control" name="location" required></div>
<div class="col-md-6 mb-3"><label class="form-label">Job type *</label><select class="form-select" name="job_type"><?php foreach(['Full-time','Part-time','Internship','Contract'] as $t): ?><option><?= e($t) ?></option><?php endforeach; ?></select></div></div>
<div class="row"><div class="col-md-6 mb-3"><label class="form-label">Minimum salary</label><input type="number" min="0" step="0.01" class="form-control" name="salary_min"></div><div class="col-md-6 mb-3"><label class="form-label">Maximum salary</label><input type="number" min="0" step="0.01" class="form-control" name="salary_max"></div></div>
<div class="mb-3"><label class="form-label">Application deadline</label><input type="date" min="<?= date('Y-m-d') ?>" class="form-control" name="deadline"></div>
<button class="btn btn-primary">Submit for approval</button></form></div></div>
<?php require BASE_PATH.'/app/Views/layouts/footer.php'; ?>
