<?php
class Job {
    public static function browse(string $q = '', string $location = '', string $type = '', string $category = ''): array {
        $sql = "SELECT j.*, c.company_name, c.logo, cat.name AS category
                FROM jobs j JOIN companies c ON c.id=j.company_id
                JOIN categories cat ON cat.id=j.category_id
                WHERE j.status='Approved' AND (j.deadline IS NULL OR j.deadline >= CURDATE())";
        $params = [];
        if ($q !== '') {
            $sql .= " AND (j.title LIKE ? OR j.description LIKE ? OR j.requirements LIKE ? OR c.company_name LIKE ?)";
            $like = "%$q%";
            array_push($params, $like, $like, $like, $like);
        }
        if ($location !== '') { $sql .= " AND j.location LIKE ?"; $params[] = "%$location%"; }
        if ($type !== '') { $sql .= " AND j.job_type = ?"; $params[] = $type; }
        if ($category !== '') { $sql .= " AND cat.name = ?"; $params[] = $category; }
        $sql .= " ORDER BY j.created_at DESC, j.id DESC";
        $stmt = db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $stmt = db()->prepare("SELECT j.*, c.company_name,c.logo,c.location AS company_location,cat.name AS category
          FROM jobs j JOIN companies c ON c.id=j.company_id JOIN categories cat ON cat.id=j.category_id WHERE j.id=?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(int $companyId, array $d): int {
        $stmt = db()->prepare("INSERT INTO jobs(company_id,category_id,title,description,requirements,location,job_type,salary_min,salary_max,deadline)
          VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$companyId,$d['category_id'],$d['title'],$d['description'],$d['requirements'],$d['location'],$d['job_type'],$d['salary_min'] ?: null,$d['salary_max'] ?: null,$d['deadline'] ?: null]);
        return (int)db()->lastInsertId();
    }

    public static function forCompany(int $companyId): array {
        $stmt=db()->prepare("SELECT j.*,cat.name AS category FROM jobs j JOIN categories cat ON cat.id=j.category_id WHERE company_id=? ORDER BY created_at DESC");
        $stmt->execute([$companyId]);
        return $stmt->fetchAll();
    }

    public static function savedByUser(int $userId): array {
        $s=db()->prepare('SELECT j.*,c.company_name,c.logo,cat.name AS category FROM saved_jobs sj JOIN jobs j ON j.id=sj.job_id JOIN companies c ON c.id=j.company_id JOIN categories cat ON cat.id=j.category_id WHERE sj.user_id=? ORDER BY sj.created_at DESC');
        $s->execute([$userId]); return $s->fetchAll();
    }
    public static function isSaved(int $userId,int $jobId): bool { $s=db()->prepare('SELECT 1 FROM saved_jobs WHERE user_id=? AND job_id=?'); $s->execute([$userId,$jobId]); return (bool)$s->fetchColumn(); }
    public static function toggleSaved(int $userId,int $jobId): void {
        $s=db()->prepare('SELECT id FROM saved_jobs WHERE user_id=? AND job_id=?'); $s->execute([$userId,$jobId]);
        if ($s->fetchColumn()) { $d=db()->prepare('DELETE FROM saved_jobs WHERE user_id=? AND job_id=?'); $d->execute([$userId,$jobId]); }
        else { $i=db()->prepare('INSERT IGNORE INTO saved_jobs(user_id,job_id) VALUES(?,?)'); $i->execute([$userId,$jobId]); }
    }
    public static function categories(): array {
        return db()->query("SELECT * FROM categories ORDER BY name")->fetchAll();
    }
}
