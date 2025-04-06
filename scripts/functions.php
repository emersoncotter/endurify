<?php

function getLevelInfo($totalXP, $step = 75) {
    $level = 1;
    
    // Find current level
    while ($totalXP >= getXPForLevel($level + 1, $step)) {
        $level++;
    }

    $xpForCurrent = getXPForLevel($level, $step);
    $xpForNext = getXPForLevel($level + 1, $step);
    $xpIntoLevel = $totalXP - $xpForCurrent;
    $xpNeeded = $xpForNext - $xpForCurrent;

    return [
        'level' => $level,
        'xp_current_level_start' => $xpForCurrent,
        'xp_needed' => $xpNeeded,
        'xp_into' => $xpIntoLevel,
        'progress_percent' => round(($xpIntoLevel / $xpNeeded) * 100)
    ];
}

function getXPForLevel($level, $step = 100) {
    return ($step * ($level - 1) * $level) / 2;
}

function getStreakWeek($streak_start_date) {
    $streakStart = new DateTime($streak_start_date);
    $now = new DateTime();

    $interval = $streakStart->diff($now);

    $streakWeeks = floor($interval->days / 7);

    return $streakWeeks;
}

function getStreakDays($streak_start_date) {
    $streakStart = new DateTime($streak_start_date);
    $now = new DateTime();

    $interval = $streakStart->diff($now);
    return $interval->days;
}


?>