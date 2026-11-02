<?php
class SeekerController {
    public function dashboard(): void {
        require_role('seeker');
        $s=db()->prepare("SELECT COUNT(*) FROM applications WHERE user_id=?"); $s->execute([user()['id']]); $total=(int)$s->fetchColumn();
        $applications=Application::forSeeker(user()['id']);
        $savedJobs=Job::savedByUser(user()['id']);
        require BASE_PATH.'/app/Views/seeker/dashboard.php';
    }
    public function profile(): void {
        require_role('seeker');
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            verify_csrf(); $name=trim($_POST['name']??''); $phone=trim($_POST['phone']??'');
            if ($name==='') { flash('error','Your name is required.'); redirect('seeker/profile'); }
            $image=null; if (!empty($_FILES['profile_image']['name'])) { $image=UploadService::saveImage($_FILES['profile_image'],'profiles',600,600); if (!$image) { flash('error','Choose a JPG, PNG or WebP image under 5 MB. PHP GD must be enabled.'); redirect('seeker/profile'); } }
            User::updateProfile((int)user()['id'],$name,$phone,$image); $_SESSION['user']['name']=$name; flash('success','Profile updated successfully.'); redirect('seeker/profile');
        }
        $profile=User::find((int)user()['id']); require BASE_PATH.'/app/Views/seeker/profile.php';
    }
    public function toggleSaved(): void {
        require_role('seeker'); verify_csrf(); $jobId=(int)($_POST['job_id']??0); $job=Job::find($jobId);
        if (!$job || $job['status']!=='Approved') { flash('error','Job not found.'); redirect('jobs/index'); }
        Job::toggleSaved((int)user()['id'],$jobId); flash('success',Job::isSaved((int)user()['id'],$jobId)?'Job saved.':'Job removed from saved jobs.'); redirect('jobs/show&id='.$jobId);
    }
    public function apply(): void {
        require_role('seeker'); verify_csrf();
        $jobId=(int)($_POST['job_id']??0); $job=Job::find($jobId);
        if (!$job || $job['status']!=='Approved') { flash('error','This job is not available.'); redirect('jobs/index'); }
        $existing=db()->prepare("SELECT id FROM applications WHERE job_id=? AND user_id=?");
        $existing->execute([$jobId,user()['id']]);
        if ($existing->fetch()) { flash('error','You have already applied for this job.'); redirect('jobs/show&id='.$jobId); }
        if (empty($_FILES['resume']['name'])) { flash('error','Please attach your PDF resume.'); redirect('jobs/show&id='.$jobId); }
        $resume=UploadService::saveResume($_FILES['resume']);
        if (!$resume) { flash('error','Resume must be a valid PDF up to 5 MB.'); redirect('jobs/show&id='.$jobId); }
        Application::apply($jobId,user()['id'],$resume,trim($_POST['cover_letter']??''));
        flash('success','Your application was submitted.');
        redirect('seeker/dashboard');
    }
}
