<?php
class Application {
    public static function apply(int $jobId, int $userId, string $resume, string $letter): void {
        $s=db()->prepare("INSERT INTO applications(job_id,user_id,resume_path,cover_letter) VALUES(?,?,?,?)");
        $s->execute([$jobId,$userId,$resume,$letter]);
    }
    public static function forSeeker(int $userId): array {
        $s=db()->prepare("SELECT a.*,j.title,j.location,c.company_name FROM applications a JOIN jobs j ON j.id=a.job_id JOIN companies c ON c.id=j.company_id WHERE a.user_id=? ORDER BY a.applied_at DESC");
        $s->execute([$userId]); return $s->fetchAll();
    }
    public static function forRecruiter(int $companyId): array {
        $s=db()->prepare("SELECT a.*,u.name,u.email,j.title FROM applications a JOIN jobs j ON j.id=a.job_id JOIN users u ON u.id=a.user_id WHERE j.company_id=? ORDER BY a.applied_at DESC");
        $s->execute([$companyId]); return $s->fetchAll();
    }
}
