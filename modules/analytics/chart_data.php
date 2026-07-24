<?php
/**
 * ==========================================
 * ExamShield LPS
 * Chart Data API
 * ==========================================
 */

header('Content-Type: application/json');

require_once("../../config/config.php");

// Dummy data (Replace with MySQL queries later)

$data = [

    "lineChart" => [

        "labels" => [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun"
        ],

        "marks" => [
            68,
            72,
            75,
            81,
            78,
            85
        ]

    ],

    "pieChart" => [

        "labels" => [
            "Pass",
            "Fail"
        ],

        "data" => [
            85,
            15
        ]

    ]

];

echo json_encode($data);

?>