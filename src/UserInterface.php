<?php
interface UserInterface{
    public function cariUsername(string $username): ?array;
}