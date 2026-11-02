<?php require BASE_PATH.'/app/Views/layouts/header.php'; ?>
<section class="premium-hero">
<div class="hero-orb orb-one"></div><div class="hero-orb orb-two"></div>
<div class="container position-relative">
<div class="row align-items-center gy-5">
<div class="col-lg-7 hero-copy">
<div class="eyebrow-pill"><span class="pulse-dot"></span> YOUR CAREER, YOUR NEXT CHAPTER</div>
<h1>Find work that<br><span class="hero-gradient">moves you forward.</span></h1>
<p class="hero-lead">Discover opportunities at companies where your skills, ambition and ideas can make a difference.</p>
<form class="hero-search" method="get" action="<?= e(url('jobs/index')) ?>">
<input type="hidden" name="url" value="jobs/index">
<div class="search-field"><i class="bi bi-search"></i><input name="q" placeholder="Job title, skill or company"></div>
<div class="search-divider"></div>
<div class="search-field location-field"><i class="bi bi-geo-alt"></i><input name="location" placeholder="City or remote"></div>
<button class="btn btn-search">Search jobs <i class="bi bi-arrow-up-right"></i></button>
</form>
<div class="hero-trust"><div class="avatar-stack"><img src="https://i.pravatar.cc/80?img=12" alt=""><img src="https://i.pravatar.cc/80?img=32" alt=""><img src="https://i.pravatar.cc/80?img=47" alt=""><span>+</span></div><div><strong>Make your next move</strong><small>Opportunities for every ambition</small></div></div>
</div>
<div class="col-lg-5 hero-visual">
<div class="hero-image-wrap"><img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1000&auto=format&fit=crop&q=88" alt="A team collaborating in a bright modern workplace">
<div class="floating-card float-top"><span class="float-icon"><i class="bi bi-lightning-charge-fill"></i></span><div><strong>New opportunities</strong><small>Start exploring today</small></div></div>
<div class="floating-card float-bottom"><div class="mini-avatars"><img src="https://i.pravatar.cc/60?img=5" alt=""><img src="https://i.pravatar.cc/60?img=11" alt=""><img src="https://i.pravatar.cc/60?img=24" alt=""></div><div><strong>Career possibilities</strong><small>One great match away</small></div></div>
</div></div>
</div></div></section>

<section class="container stat-strip">
<div class="stat-item"><span class="stat-icon"><i class="bi bi-briefcase"></i></span><div><strong>Explore</strong><small>Curated job opportunities</small></div></div>
<div class="stat-item"><span class="stat-icon"><i class="bi bi-buildings"></i></span><div><strong>Connect</strong><small>Discover growing companies</small></div></div>
<div class="stat-item"><span class="stat-icon"><i class="bi bi-rocket-takeoff"></i></span><div><strong>Grow</strong><small>Take the next career step</small></div></div>
</section>

<section class="container section-space">
<div class="section-heading"><div><span class="section-kicker">FIND YOUR FIT</span><h2>Explore by <span>category</span></h2><p>Start with the field that inspires you.</p></div><a class="text-link" href="<?= e(url('jobs/index')) ?>">All opportunities <i class="bi bi-arrow-up-right"></i></a></div>
<div class="row g-3 category-grid">
<?php
$categoryTiles=[
 ['bi-code-slash','Technology','Build what’s next','Information Technology'],
 ['bi-megaphone','Marketing','Make ideas matter','Marketing'],
 ['bi-palette','Design','Create experiences','Design'],
 ['bi-cash-coin','Finance','Shape smart decisions','Finance'],
 ['bi-heart-pulse','Healthcare','Make a difference','Healthcare'],
 ['bi-mortarboard','Education','Inspire tomorrow','Education']
];
foreach($categoryTiles as $tile): ?>
<div class="col-6 col-md-4 col-lg-2"><a class="category-card" href="<?= e(url('jobs/index&category='.rawurlencode($tile[3]))) ?>"><span class="category-icon"><i class="bi <?= e($tile[0]) ?>"></i></span><strong><?= e($tile[1]) ?></strong><small><?= e($tile[2]) ?></small></a></div>
<?php endforeach; ?>
</div>
</section>

<section class="featured-section section-space">
<div class="container">
<div class="section-heading"><div><span class="section-kicker">HAND-PICKED FOR YOU</span><h2>Featured <span>opportunities</span></h2><p>Explore opportunities across technology, marketing, design, finance, healthcare and education.</p></div><a class="text-link" href="<?= e(url('jobs/index')) ?>">Browse all jobs <i class="bi bi-arrow-up-right"></i></a></div>
<div class="row g-4">
<?php foreach(array_slice($jobs,0,12) as $job): ?>
<div class="col-md-6 col-lg-4"><article class="premium-job-card h-100">
<div class="job-card-top"><div class="company-logo-wrap"><?php if(!empty($job['logo'])): ?><img src="<?= e($job['logo']) ?>" alt="<?= e($job['company_name']) ?> logo" loading="lazy"><?php else: ?><span><?= e(strtoupper(substr($job['company_name'],0,1))) ?></span><?php endif; ?></div><span class="job-type-pill"><?= e($job['job_type']) ?></span></div>
<div class="company-name"><?= e($job['company_name']) ?></div><h3><?= e($job['title']) ?></h3>
<div class="job-meta"><span><i class="bi bi-geo-alt"></i> <?= e($job['location']) ?></span><span><i class="bi bi-grid"></i> <?= e($job['category']) ?></span></div>
<div class="job-card-bottom"><div><small>Salary range</small><strong><?= money($job['salary_min']) ?> – <?= money($job['salary_max']) ?></strong></div><a class="round-arrow" href="<?= e(url('jobs/show&id='.$job['id'])) ?>" aria-label="View job"><i class="bi bi-arrow-up-right"></i></a></div>
</article></div>
<?php endforeach; ?>
<?php if(!$jobs): ?><div class="col-12"><div class="empty-state"><i class="bi bi-briefcase"></i><h3>Great opportunities are on their way</h3><p>Import the sample data or post your first vacancy as a recruiter.</p><a href="<?= e(url('jobs/index')) ?>" class="btn btn-dark rounded-pill px-4">Explore jobs</a></div></div><?php endif; ?>
</div></div></section>

<section class="container section-space">
<div class="career-banner"><div><span class="section-kicker text-white-50">FOR EMPLOYERS</span><h2>Meet the people who<br>will move your business forward.</h2><p>Reach motivated candidates and make your next great hire.</p><a class="btn btn-light rounded-pill px-4 py-2 fw-bold" href="<?= e(url('auth/register')) ?>">Start hiring <i class="bi bi-arrow-up-right ms-1"></i></a></div><div class="banner-art"><i class="bi bi-people-fill"></i><span class="banner-orbit"></span></div></div>
</section>
<?php require BASE_PATH.'/app/Views/layouts/footer.php'; ?>
