<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<h1 class="h2 fw-bold">Candidate dashboard</h1><p><a class="btn btn-outline-primary btn-sm" href="<?= e(url('seeker/profile')) ?>"><i class="bi bi-person-gear me-1"></i>Edit profile</a></p><p class="text-muted">Track your job applications.</p>
<div class="row g-3 mb-4"><div class="col-md-4"><div class="stat-card"><div class="text-muted">Applications submitted</div><div class="display-6 fw-bold"><?= $total ?></div></div></div></div>
<div class="card"><div class="card-body"><h2 class="h5">My applications</h2>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Job</th><th>Company</th><th>Location</th><th>Status</th><th>Applied</th></tr></thead><tbody>
<?php foreach($applications as $a): ?><tr><td><?= e($a['title']) ?></td><td><?= e($a['company_name']) ?></td><td><?= e($a['location']) ?></td><td><span class="badge bg-secondary"><?= e($a['status']) ?></span></td><td><?= e($a['applied_at']) ?></td></tr><?php endforeach; ?>
<?php if(!$applications): ?><tr><td colspan="5" class="text-muted">You have not applied for any jobs yet.</td></tr><?php endif; ?>
</tbody></table></div><a href="<?= e(url('jobs/index')) ?>" class="btn btn-primary btn-sm">Browse jobs</a>
</div></div>
<div class="card mt-4"><div class="card-body"><h2 class="h5">Saved jobs</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Job</th><th>Company</th><th>Category</th><th></th></tr></thead><tbody>
<?php foreach($savedJobs as $j): ?><tr><td><?= e($j['title']) ?></td><td><?= e($j['company_name']) ?></td><td><?= e($j['category']) ?></td><td><a class="btn btn-sm btn-outline-primary" href="<?= e(url('jobs/show&id='.$j['id'])) ?>">View</a></td></tr><?php endforeach; ?>
<?php if(!$savedJobs): ?><tr><td colspan="4" class="text-muted">No saved jobs yet.</td></tr><?php endif; ?></tbody></table></div></div></div>
<?php require BASE_PATH.'/app/Views/layouts/footer.php'; ?>
