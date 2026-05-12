<?php
class StringHelper
{
    public function slugify(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]/', '-', $text);
        return trim($text, '-');
    }
    public function truncate(string $text, int $limit = 20): string
    {
        if (strlen($text) <= $limit) return $text;
        return substr($text, 0, $limit) . "...";
    }
    public function sanitize(string $text): string
    {
        return htmlspecialchars(strip_tags($text));
    }
}
