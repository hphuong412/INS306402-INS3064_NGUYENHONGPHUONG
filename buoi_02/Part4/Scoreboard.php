<?php
// Scoreboard - Process array of scores to find stats and top performers

// Input: Array of random integers
$scores = [45, 78, 92, 56, 88, 73, 95, 61, 87, 69];

// Calculate: Average, Max, Min
$average = array_sum($scores) / count($scores);
$max = max($scores);
$min = min($scores);

// Filter: Create new array of scores > Average
$topScores = array_filter($scores, function($score) use ($average) {
    return $score > $average;
});

// Sort top scores in descending order for better presentation
$topScores = array_values(array_reverse(sort($topScores) ? $topScores : []));
sort($topScores);
rsort($topScores);

// Output
$output = "Avg: " . round($average, 2) . ", Max: " . $max . ", Min: " . $min . ", Top: [" . implode(", ", $topScores) . "]";
echo $output;
?>
