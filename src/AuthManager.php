<?php
class AuthManager{
    public function passwordAman(string $password): bool{
        if (strlen($password)< 8){
            return false;
        }
        if (!preg_match('/[0-9]/', $password)){
            return false;
        }
        return true;
    }
}