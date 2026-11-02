<?php
class AuthController {
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $name=trim($_POST['name'] ?? '');
            $email=strtolower(trim($_POST['email'] ?? ''));
            $password=$_POST['password'] ?? '';
            $role=$_POST['role'] ?? 'seeker';
            $errors=[];
            if ($name==='') $errors[]='Name is required.';
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Enter a valid email.';
            if (strlen($password)<8) $errors[]='Password must contain at least 8 characters.';
            if (!in_array($role,['seeker','recruiter'],true)) $errors[]='Invalid account type.';
            if (User::findByEmail($email)) $errors[]='That email is already registered.';
            if ($errors) { flash('error',implode(' ',$errors)); remember_old_input(); redirect('auth/register'); }
            $id=User::create($name,$email,$password,$role);
            login_user(User::find($id));
            flash('success','Welcome to JobConnect!');
            redirect($role==='recruiter'?'recruiter/dashboard':'seeker/dashboard');
        }
        require BASE_PATH.'/app/Views/auth/register.php';
    }
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            verify_csrf();
            $email=strtolower(trim($_POST['email'] ?? ''));
            $password=$_POST['password'] ?? '';
            $record=User::findByEmail($email);
            if (!$record || !password_verify($password,$record['password']) || $record['status']!=='active') {
                flash('error','Invalid login details or account unavailable.');
                redirect('auth/login');
            }
            login_user($record);
            flash('success','You are signed in.');
            $dest=['admin'=>'admin/dashboard','recruiter'=>'recruiter/dashboard','seeker'=>'seeker/dashboard'][$record['role']];
            redirect($dest);
        }
        require BASE_PATH.'/app/Views/auth/login.php';
    }
    public function logout(): void {
        require_login();
        verify_csrf();
        logout_user();
        header('Location: '.url('')); exit;
    }
}
