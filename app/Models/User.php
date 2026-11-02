<?php
class User {
    public static function findByEmail(string $email): ?array {
        $stmt = db()->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }
    public static function find(int $id): ?array {
        $stmt = db()->prepare("SELECT id,name,email,role,phone,profile_image,status,created_at FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    public static function updateProfile(int $id, string $name, string $phone, ?string $image): void {
        if ($image !== null) { $stmt=db()->prepare('UPDATE users SET name=?, phone=?, profile_image=? WHERE id=?'); $stmt->execute([$name,$phone,$image,$id]); }
        else { $stmt=db()->prepare('UPDATE users SET name=?, phone=? WHERE id=?'); $stmt->execute([$name,$phone,$id]); }
    }
    public static function create(string $name, string $email, string $password, string $role): int {
        $stmt = db()->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
        return (int)db()->lastInsertId();
    }
}
