<?php
class JobController {
    public function index(): void {
        $jobs = Job::browse(
            trim($_GET['q'] ?? ''),
            trim($_GET['location'] ?? ''),
            trim($_GET['type'] ?? ''),
            trim($_GET['category'] ?? '')
        );
        $categories = Job::categories();
        require BASE_PATH.'/app/Views/jobs/index.php';
    }

    public function show(): void {
        $job = Job::find((int)($_GET['id'] ?? 0));
        if (!$job || $job['status'] !== 'Approved') {
            http_response_code(404);
            exit('Job not found.');
        }
        require BASE_PATH.'/app/Views/jobs/show.php';
    }
}
