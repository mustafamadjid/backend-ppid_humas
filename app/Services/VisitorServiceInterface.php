<?php
namespace App\Services;

interface VisitorServiceInterface
{
    public function getTotalVisitor();
    public function countVisitor(string $ip);

    public function countVisitorToday();
}
?>