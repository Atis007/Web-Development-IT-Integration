<?php
$now = new DateTimeImmutable('now');
$todayStart = (new DateTimeImmutable('today'))->setTime(0, 0, 0);
$todayEnd = $todayStart->modify('+1 day');

$weekStart = (new DateTimeImmutable('monday this week'))->setTime(0, 0, 0);
$weekEnd = $weekStart->modify('+1 week');

$month = (int)$now->format('n');
$year = (int)$now->format('Y');

$monthStart = new DateTimeImmutable(sprintf('%04d-%02d-01 00:00:00', $year, $month));
$monthEnd = $monthStart->modify('+1 month');

$yearStart = new DateTimeImmutable(sprintf('%04d-01-01 00:00:00', $year));
$yearEnd = $yearStart->modify('+1 year');

$todayCount = countOrdersBetween($GLOBALS['pdo'], $todayStart, $todayEnd);
$weekCount = countOrdersBetween($GLOBALS['pdo'], $weekStart, $weekEnd);
$monthCount = countOrdersBetween($GLOBALS['pdo'], $monthStart, $monthEnd);
$yearCount = countOrdersBetween($GLOBALS['pdo'], $yearStart, $yearEnd);

$todayRevenue = countRevenueBetween($GLOBALS['pdo'], $todayStart, $todayEnd);
$weekRevenue = countRevenueBetween($GLOBALS['pdo'], $weekStart, $weekEnd);
$monthRevenue = countRevenueBetween($GLOBALS['pdo'], $monthStart, $monthEnd);
$yearRevenue = countRevenueBetween($GLOBALS['pdo'], $yearStart, $yearEnd);
