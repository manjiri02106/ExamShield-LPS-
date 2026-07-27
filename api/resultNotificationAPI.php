<?php

require_once "../controllers/ResultController.php";

    $controller = new ResultController();

    $response = $controller->sendResult(
        $student["email"],
        $student["name"],
        $result["subject"],
        $result["grade"],
        $result["marks"]
    );

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

?>