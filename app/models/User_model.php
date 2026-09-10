<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model
{
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password', 'role', 'is_active'];

    public function find_by_login($login)
    {
        $user = $this->_query()->where('email', $login)->where('is_active', 1)->get();
        return $user ?: $this->_query()->where('username', $login)->where('is_active', 1)->get();
    }

    public function email_exists($email)
    {
        return $this->exists(['email' => $email]);
    }

    public function username_exists($username)
    {
        return $this->exists(['username' => $username]);
    }
}