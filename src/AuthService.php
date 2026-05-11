<?php
class AuthService
{
    private UserInterface $userDB;
    public function __construct(UserInterface $db)
    {
        $this->userDB = $db;
    }
    public function login($username, $password): bool
    {
        $user = $this->userDB->cariUsername($username);
        if (!$user) {
            return false;
        }
        return password_verify($password, $user['password']);
    }
}
