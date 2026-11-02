<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<section class="jobs-intro"><div class="container">
<span class="section-kicker">OPPORTUNITIES AWAIT</span>
<h1>Find your next <span>opportunity.</span></h1>
<p>Search roles that match your skills, goals and ambition.</p>
<form class="jobs-filter" method="get">
<input type="hidden" name="url" value="jobs/index">
<div class="search-field"><i class="bi bi-search"></i><input name="q" placeholder="Job title, skill or company" value="<?= e($_GET['q']??'') ?>"></div>
<div class="search-field"><i class="bi bi-geo-alt"></i><input name="location" placeholder="Location" value="<?= e($_GET['location']??'') ?>"></div>
<select class="form-select" name="category">
<option value="">All categories</option>
<?php foreach($categories as $category): ?>
<option value="<?= e($category['name']) ?>" <?= (($_GET['category']??'')===$category['name']?'selected':'') ?>><?= e($category['name']==='Information Technology'?'Technology':$category['name']) ?></option>
<?php endforeach; ?>
</select>
<select class="form-select" name="type">
<option value="">All job types</option>
<?php foreach(['Full-time','Part-time','Internship','Contract'] as $t): ?>
<option value="<?= e($t) ?>" <?= (($_GET['type']??'')===$t?'selected':'') ?>><?= e($t) ?></option>
<?php endforeach; ?>
</select>
<button class="btn btn-search">Search <i class="bi bi-arrow-right"></i></button>
</form></div></section>

<section class="container py-5">
<div class="d-flex justify-content-between align-items-center mb-4">
<div><h2 class="h4 fw-bold mb-1">Available positions</h2><p class="text-muted mb-0"><?= count($jobs) ?> opportunities found</p></div>
<?php if(!empty($_GET['category'])): ?><a class="text-link" href="<?= e(url('jobs/index')) ?>">Clear category <i class="bi bi-x-circle"></i></a><?php endif; ?>
</div>
<div class="row g-4">
<?php foreach($jobs as $job): ?>
<div class="col-md-6 col-lg-4"><article class="premium-job-card h-100">
<div class="job-card-top">
<div class="company-logo-wrap"><?php if(!empty($job['logo'])): ?><img src="<?= e($job['logo']) ?>" alt="<?= e($job['company_name']) ?> logo" loading="lazy"><?php else: ?><span><?= e(strtoupper(substr($job['company_name'],0,1))) ?></span><?php endif; ?></div>
<span class="job-type-pill"><?= e($job['job_type']) ?></span>
</div>
<div class="company-name"><?= e($job['company_name']) ?></div>
<h3><?= e($job['title']) ?></h3>
<div class="job-meta"><span><i class="bi bi-geo-alt"></i> <?= e($job['location']) ?></span><span><i class="bi bi-grid"></i> <?= e($job['category']==='Information Technology'?'Technology':$job['category']) ?></span></div>
<div class="job-card-bottom"><div><small>Salary range</small><strong><?= money($job['salary_min']) ?> – <?= money($job['salary_max']) ?></strong></div><a class="round-arrow" href="<?= e(url('jobs/show&id='.$job['id'])) ?>" aria-label="View <?= e($job['title']) ?>"><i class="bi bi-arrow-up-right"></i></a></div>
</article></div>
<?php endforeach; ?>
<?php if(!$jobs): ?><div class="col-12"><div class="empty-state"><i class="bi bi-search"></i><h3>No matching jobs found</h3><p>Try another keyword, location or category.</p><a href="<?= e(url('jobs/index')) ?>" class="btn btn-dark rounded-pill px-4">Clear filters</a></div></div><?php endif; ?>
</div></section>
<?php require BASE_PATH.'/app/Views/layouts/footer.php'; ?>
