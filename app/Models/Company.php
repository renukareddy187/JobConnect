<?php
class Company {
    public static function forUser(int $userId): ?array {
        $s=db()->prepare("SELECT * FROM companies WHERE user_id=?"); $s->execute([$userId]); return $s->fetch() ?: null;
    }
    public static function setLogo(int $userId, string $logo): void {
        $s=db()->prepare('UPDATE companies SET logo=? WHERE user_id=?'); $s->execute([$logo,$userId]);
    }
    public static function createOrUpdate(int $userId, array $d): void {
        $existing=self::forUser($userId);
        if ($existing) {
            $s=db()->prepare("UPDATE companies SET company_name=?,description=?,website=?,location=? WHERE user_id=?");
            $s->execute([$d['company_name'],$d['description'],$d['website'],$d['location'],$userId]);
        } else {
            $s=db()->prepare("INSERT INTO companies(user_id,company_name,description,website,location) VALUES(?,?,?,?,?)");
            $s->execute([$userId,$d['company_name'],$d['description'],$d['website'],$d['location']]);
        }
    }
}
