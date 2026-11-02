<?php
class RecruiterController {
    public function dashboard(): void {
        require_role('recruiter');
        $company=Company::forUser(user()['id']);
        $jobs=$company?Job::forCompany($company['id']):[];
        $applications=$company?Application::forRecruiter($company['id']):[];
        require BASE_PATH.'/app/Views/recruiter/dashboard.php';
    }
    public function company(): void {
        require_role('recruiter');
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            verify_csrf();
            $d=[
              'company_name'=>trim($_POST['company_name']??''),
              'description'=>trim($_POST['description']??''),
              'website'=>trim($_POST['website']??''),
              'location'=>trim($_POST['location']??'')
            ];
            if ($d['company_name']==='') { flash('error','Company name is required.'); redirect('recruiter/company'); }
            Company::createOrUpdate(user()['id'],$d);
            if (!empty($_FILES['logo']['name'])) { $logo=UploadService::saveImage($_FILES['logo'],'companies',800,800); if (!$logo) { flash('error','Company logo must be JPG, PNG or WebP and under 5 MB. PHP GD must be enabled.'); redirect('recruiter/company'); } Company::setLogo((int)user()['id'],$logo); }
            flash('success','Company profile saved.');
            redirect('recruiter/dashboard');
        }
        $company=Company::forUser(user()['id']);
        require BASE_PATH.'/app/Views/recruiter/company.php';
    }
    public function createJob(): void {
        require_role('recruiter');
        $company=Company::forUser(user()['id']);
        if (!$company) { flash('error','Create your company profile first.'); redirect('recruiter/company'); }
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            verify_csrf();
            $d=[
              'category_id'=>(int)($_POST['category_id']??0),
              'title'=>trim($_POST['title']??''),
              'description'=>trim($_POST['description']??''),
              'requirements'=>trim($_POST['requirements']??''),
              'location'=>trim($_POST['location']??''),
              'job_type'=>$_POST['job_type']??'',
              'salary_min'=>$_POST['salary_min']??null,
              'salary_max'=>$_POST['salary_max']??null,
              'deadline'=>$_POST['deadline']??null
            ];
            if (!$d['title']||!$d['description']||!$d['location']||!in_array($d['job_type'],['Full-time','Part-time','Internship','Contract'],true)) {
                flash('error','Complete all required fields with valid values.'); redirect('recruiter/create-job');
            }
            Job::create($company['id'],$d);
            flash('success','Job submitted. It will appear after admin approval.');
            redirect('recruiter/dashboard');
        }
        $categories=Job::categories();
        require BASE_PATH.'/app/Views/recruiter/create-job.php';
    }
    public function updateApplication(): void {
        require_role('recruiter'); verify_csrf();
        $id=(int)($_POST['application_id']??0); $status=$_POST['status']??'';
        if (!in_array($status,['Shortlisted','Rejected','Hired'],true)) { flash('error','Invalid status.'); redirect('recruiter/dashboard'); }
        $company=Company::forUser(user()['id']);
        $s=db()->prepare("UPDATE applications a JOIN jobs j ON j.id=a.job_id SET a.status=? WHERE a.id=? AND j.company_id=?");
        $s->execute([$status,$id,$company['id']??0]);
        flash('success',$s->rowCount()?'Application status updated.':'No matching application found.');
        redirect('recruiter/dashboard');
    }
    public function downloadResume(): void {
        require_role('recruiter');
        $id=(int)($_GET['id']??0); $company=Company::forUser(user()['id']);
        $s=db()->prepare("SELECT a.resume_path FROM applications a JOIN jobs j ON j.id=a.job_id WHERE a.id=? AND j.company_id=?");
        $s->execute([$id,$company['id']??0]); $row=$s->fetch();
        if (!$row) { http_response_code(404); exit('Resume not found.'); }
        $path=BASE_PATH.'/storage/uploads/resumes/'.$row['resume_path'];
        if (!is_file($path)) { http_response_code(404); exit('File not found.'); }
        header('Content-Type: application/pdf'); header('Content-Disposition: attachment; filename="candidate-resume.pdf"');
        header('Content-Length: '.filesize($path)); readfile($path); exit;
    }
}
