<?php

class DecisionNode {
    public $criterion;
    public $branches;
    public $category;

    public function __construct($criterion, $branches, $category = null) {
        $this->criterion = $criterion;
        $this->branches = $branches;
        $this->category = $category;
    }
}

function buildDecisionTree($data, $criteria, $targetCategory) {
    // Base cases
    if (empty($data)) {
        return new DecisionNode(null, [], "No Data");
    }

    $targetValues = array_column($data, $targetCategory);
    if (count(array_unique($targetValues)) == 1) {
        return new DecisionNode(null, [], $targetValues[0]);
    }

    if (empty($criteria)) {
        $mostCommonCategory = array_reduce($targetValues, function ($carry, $value) {
            $carry[$value] = isset($carry[$value]) ? $carry[$value] + 1 : 1;
            return $carry;
        }, []);

        arsort($mostCommonCategory);
        $mostCommonCategory = key($mostCommonCategory);

        return new DecisionNode(null, [], $mostCommonCategory);
    }

    // Recursive splitting
    $bestCriterion = '';
    $bestCriterionInfoGain = -1;

    foreach ($criteria as $criterion) {
        $infoGain = calculateInformationGain($data, $criterion, $targetCategory);
        if ($infoGain > $bestCriterionInfoGain) {
            $bestCriterion = $criterion;
            $bestCriterionInfoGain = $infoGain;
        }
    }

    $criterionValues = array_unique(array_column($data, $bestCriterion));

    $branches = [];
    foreach ($criterionValues as $value) {
        $subset = array_filter($data, function ($row) use ($bestCriterion, $value) {
            return $row[$bestCriterion] == $value;
        });

        $newCriteria = array_diff($criteria, [$bestCriterion]);
        $branches[$value] = buildDecisionTree($subset, $newCriteria, $targetCategory);
    }

    return new DecisionNode($bestCriterion, $branches);
}

function calculateInformationGain($data, $criterion, $targetCategory) {
    // Calculate impurity before split
    $totalRows = count($data);
    $initialImpurity = calculateImpurity($data, $targetCategory);

    // Calculate impurity after split
    $criterionValues = array_unique(array_column($data, $criterion));
    $weightedImpurity = 0;

    foreach ($criterionValues as $value) {
        $subset = array_filter($data, function ($row) use ($criterion, $value) {
            return $row[$criterion] == $value;
        });

        $subsetRows = count($subset);
        $subsetImpurity = calculateImpurity($subset, $targetCategory);
        $weightedImpurity += ($subsetRows / $totalRows) * $subsetImpurity;
    }

    // Information Gain = Initial Impurity - Weighted Impurity
    return $initialImpurity - $weightedImpurity;
}

function calculateImpurity($data, $targetCategory) {
    $targetValues = array_column($data, $targetCategory);
    $valueCounts = array_count_values($targetValues);

    $impurity = 1;
    foreach ($valueCounts as $count) {
        $probability = $count / count($targetValues);
        $impurity -= $probability * $probability;
    }

    return $impurity;
}

function predict($node, $sample) {
    if ($node->category !== null) {
        return $node->category;
    }

    $criterionValue = $sample[$node->criterion];
    if (isset($node->branches[$criterionValue])) {
        return predict($node->branches[$criterionValue], $sample);
    }

    return "No improvement";
}

include 'dataSet.php';

// Criteria
$criteria = ['Efficiency', 'Timeliness', 'Accuracy', 'Quality'];

// Target category
$targetCategory = 'AppraisalCategory';