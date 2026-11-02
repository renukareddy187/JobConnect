<?php
function user(): ?array { return $_SESSION['user'] ?? null; }
function logged_in(): bool { return user() !== null; }
function require_login(): void {
    if (!logged_in()) {
        flash('error', 'Please sign in to continue.');
        redirect('auth/login');
    }
}
function require_role(string $role): void {
    require_login();
    if ((user()['role'] ?? '') !== $role) {
        http_response_code(403);
        exit('403 – You do not have permission to access this page.');
    }
}
function login_user(array $record): void {
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int)$record['id'],
        'name' => $record['name'],
        'email' => $record['email'],
        'role' => $record['role']
    ];
}
function logout_user(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], '', $params['secure'], $params['httponly']);
    }
    session_destroy();
}
