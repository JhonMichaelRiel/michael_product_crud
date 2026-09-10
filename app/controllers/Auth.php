<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('User_model');
    }

    public function login()
    {
        if ($this->session->userdata('user_id')) {
            redirect('products');
            exit;
        }

        $error = null;
        if ($this->request->is_post()) {
            $login = trim((string) $this->request->post('login'));
            $password = (string) $this->request->post('password');
            $user = $this->User_model->find_by_login($login);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $this->session->set_userdata([
                    'user_id' => (int) $user['id'],
                    'username' => $user['username'],
                    'user_role' => $user['role'],
                ]);
                redirect('products');
                exit;
            }

            $error = 'Invalid login credentials.';
        }

        $this->call->view('auth/login', ['title' => 'Sign in', 'error' => $error, 'auth_page' => true]);
    }

    public function signup()
    {
        if ($this->session->userdata('user_id')) {
            redirect('products');
            exit;
        }

        $data = [
            'username' => '',
            'email' => '',
        ];
        $errors = [];

        if ($this->request->is_post()) {
            $data['username'] = trim((string) $this->request->post('username'));
            $data['email'] = trim((string) $this->request->post('email'));
            $password = (string) $this->request->post('password');
            $password_confirmation = (string) $this->request->post('password_confirmation');

            if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $data['username'])) {
                $errors[] = 'Username must be 3-50 characters and use only letters, numbers, or underscores.';
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Enter a valid email address.';
            }
            if (strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters.';
            }
            if ($password !== $password_confirmation) {
                $errors[] = 'Passwords do not match.';
            }
            if (!$errors && $this->User_model->username_exists($data['username'])) {
                $errors[] = 'That username is already registered.';
            }
            if (!$errors && $this->User_model->email_exists($data['email'])) {
                $errors[] = 'That email is already registered.';
            }

            if (!$errors) {
                $this->User_model->insert([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'user',
                    'is_active' => 1,
                ]);
                redirect('login');
                exit;
            }
        }

        $this->call->view('auth/signup', [
            'title' => 'Create account',
            'data' => $data,
            'errors' => $errors,
            'auth_page' => true,
        ]);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
        exit;
    }
}