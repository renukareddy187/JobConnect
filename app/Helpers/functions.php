<?php
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function redirect(string $path): never {
    header('Location: ' . url($path));
    exit;
}
function url(string $path = ''): string {
    $base = rtrim((string)env_value('APP_URL', '/'), '/');
    if ($path === '') return $base . '/';
    // Keep route parameters separate from the encoded route name.
    $parts = explode('&', $path, 2);
    $result = $base . '/?url=' . rawurlencode($parts[0]);
    if (isset($parts[1])) $result .= '&' . $parts[1];
    return $result;
}
function flash(string $key, ?string $message = null): ?string {
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }
    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $value;
}
function old(string $key, string $default = ''): string {
    return e((string)($_SESSION['_old'][$key] ?? $default));
}
function remember_old_input(): void {
    $_SESSION['_old'] = $_POST;
}
function clear_old_input(): void {
    unset($_SESSION['_old']);
}
function money(?string $amount): string {
    return $amount === null || $amount === '' ? 'Not specified' : '₹' . number_format((float)$amount);
}
