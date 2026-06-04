<?php
session_start();
require_once 'Storage.php';

class Auth {
    private $storage;

    public function __construct() {
        $this->storage = new Storage();
    }

    public function register($email, $password) {
        $users = $this->storage->read('users.json');
        foreach ($users as $user) {
            if ($user['email'] === $email) return false;
        }
        
        $role = (count($users) === 0) ? 'admin' : 'user';
        
        $users[] = [
            'id' => time() . rand(10, 99),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role
        ];
        $this->storage->write('users.json', $users);
        return true;
    }

    public function login($email, $password) {
        $users = $this->storage->read('users.json');
        foreach ($users as $user) {
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                setcookie('last_login', date("Y-m-d H:i:s"), time() + (86400 * 30), "/");
                return true;
            }
        }
        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function logout() {
        session_destroy();
        setcookie('last_login', '', time() - 3600, "/");
    }
}
?>