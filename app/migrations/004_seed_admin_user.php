<?php

class Seed_admin_user
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
    }

    public function up()
    {
        $email = getenv('ADMIN_EMAIL');
        $password = getenv('ADMIN_PASSWORD');
        $username = getenv('ADMIN_USERNAME') ?: 'admin';

        if (!$email || !$password) {
            return;
        }

        $existing = $this->_lava->db->table('users')->where('email', $email)->get();
        if (!$existing) {
            $this->_lava->db->table('users')->insert([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => 1,
            ]);
        }
    }

    public function down() {}
}