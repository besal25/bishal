<?php

// $efficiency = $row['efficiency'];
// $timeliness = $row['timeliness'];
// $accuracy = $row['accuracy'];
// $quality = $row['quality'];


$efficiency = $converted_efficiency;
$timeliness = $converted_quality;
$accuracy = $converted_timeliness;
$quality = $converted_accuracy;


// Build the decision tree
$decisionTree = buildDecisionTree($data, $criteria, $targetCategory);

// New sample for prediction
$newSample = ['Efficiency' => $efficiency, 'Timeliness' => $timeliness, 'Accuracy' => $accuracy, 'Quality' => $quality];

// Make a prediction
$prediction = predict($decisionTree, $newSample);