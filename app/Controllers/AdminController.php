<?php
class AdminController {
    public function dashboard(): void {
        require_role('admin');
        $counts=[];
        foreach (['users','companies','jobs','applications'] as $table) $counts[$table]=(int)db()->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
        $jobs=db()->query("SELECT j.*,c.company_name FROM jobs j JOIN companies c ON c.id=j.company_id ORDER BY j.created_at DESC")->fetchAll();
        require BASE_PATH.'/app/Views/admin/dashboard.php';
    }
    public function updateJob(): void {
        require_role('admin'); verify_csrf();
        $id=(int)($_POST['job_id']??0); $status=$_POST['status']??'';
        if (!in_array($status,['Approved','Rejected','Closed'],true)) { flash('error','Invalid job status.'); redirect('admin/dashboard'); }
        $s=db()->prepare("UPDATE jobs SET status=? WHERE id=?"); $s->execute([$status,$id]);
        flash('success','Job status updated.'); redirect('admin/dashboard');
    }
}
