<?php
class RegisterValidator
{
    public function validate(string $username, string $email, string $password, string $confirm): array
    {
        $errors = [];
        if (empty($email)) $errors[] = "Email tidak boleh ksosong";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Gunakan @ untuk email";
        if (str_contains($email, ' ')) $errors[] = "Email tidak boleh pakai spasi";
        if (strlen($username) < 4) $errors[] = "Username terlalu pendek";
        if (strlen($username) > 20) $errors[] = "Username terlalu panjang";
        if (preg_match('/[^a-zA-Z0-9]/', $username)) $errors[] = "Username hanya boleh huruf dan angka";
        if ($password !== $confirm) $errors[] = "Konfirmasi password tidak cocok";
        if (strlen($password) < 6) $errors[] = "Password minimal 6 karakter";
        return $errors;
    }
}
