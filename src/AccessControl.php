<?php
class AccessControl
{
    public function adminDashboard(array $user): bool
    {
        return isset($user['role']) && $user['role'] === 'admin';
    }
    public function adminHapusProduk(array $user): bool
    {
        return isset($user['role']) && $user['role'] === 'admin';
    }
}
