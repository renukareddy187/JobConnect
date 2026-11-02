<?php
require dirname(__DIR__).'/config/bootstrap.php';
require BASE_PATH.'/app/Models/User.php';
require BASE_PATH.'/app/Models/Job.php';
require BASE_PATH.'/app/Models/Company.php';
require BASE_PATH.'/app/Models/Application.php';
require BASE_PATH.'/app/Services/UploadService.php';
require BASE_PATH.'/app/Controllers/AuthController.php';
require BASE_PATH.'/app/Controllers/JobController.php';
require BASE_PATH.'/app/Controllers/SeekerController.php';
require BASE_PATH.'/app/Controllers/RecruiterController.php';
require BASE_PATH.'/app/Controllers/AdminController.php';

// Small JSON API examples. All write endpoints must authenticate and authorize.
if (str_starts_with(trim($_GET['url'] ?? '', '/'), 'api/')) {
    header('Content-Type: application/json; charset=utf-8');
    $apiRoute = trim(substr(trim($_GET['url'], '/'), 4), '/');
    if ($apiRoute === 'jobs' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode(['success' => true, 'data' => Job::browse(trim($_GET['q'] ?? ''), trim($_GET['location'] ?? ''), trim($_GET['type'] ?? ''))]);
        exit;
    }
    if (preg_match('#^jobs/(\d+)$#', $apiRoute, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $apiJob = Job::find((int)$matches[1]);
        if (!$apiJob || $apiJob['status'] !== 'Approved') { http_response_code(404); echo json_encode(['success'=>false,'message'=>'Job not found']); exit; }
        echo json_encode(['success'=>true,'data'=>$apiJob]);
        exit;
    }
    http_response_code(404);
    echo json_encode(['success'=>false,'message'=>'API endpoint not found']);
    exit;
}

$route=trim($_GET['url']??'','/');
if ($route==='') $route='home';
[$controller,$action]=array_pad(explode('/',$route,2),2,'');
try {
    if ($controller==='media' && $action==='image') {
        $kind=$_GET['kind']??''; $file=$_GET['file']??'';
        $folders=['profile'=>'profiles','company'=>'companies'];
        if (!isset($folders[$kind]) || !preg_match('/^[a-f0-9]{36}\\.jpg$/',$file)) { http_response_code(404); exit; }
        $path=BASE_PATH.'/storage/uploads/'.$folders[$kind].'/'.$file;
        if (!is_file($path)) { http_response_code(404); exit; }
        header('Content-Type: image/jpeg'); header('X-Content-Type-Options: nosniff'); header('Cache-Control: private, max-age=3600'); readfile($path); exit;
    } elseif ($controller==='home') {
        $jobs=Job::browse();
        require BASE_PATH.'/app/Views/home.php';
    } elseif ($controller==='auth' && in_array($action,['register','login','logout'],true)) {
        (new AuthController())->$action();
    } elseif ($controller==='jobs' && in_array($action,['index','show'],true)) {
        (new JobController())->$action();
    } elseif ($controller==='seeker' && in_array($action,['dashboard','apply','profile','toggleSaved'],true)) {
        (new SeekerController())->$action();
    } elseif ($controller==='recruiter' && in_array($action,['dashboard','company','createJob','updateApplication','downloadResume'],true)) {
        (new RecruiterController())->$action();
    } elseif ($controller==='admin' && in_array($action,['dashboard','updateJob'],true)) {
        (new AdminController())->$action();
    } else {
        http_response_code(404); echo '404 – Page not found.';
    }
} catch (Throwable $e) {
    error_log((string)$e);
    http_response_code(500);
    $debug=env_value('APP_DEBUG','false')==='true';
    echo $debug ? '<h2>Application error</h2><pre>'.e($e->getMessage()).'</pre>' : 'Something went wrong. Please try again later.';
}
