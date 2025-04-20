<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookIds'])) {
    $ids = $_POST['bookIds'];

    if (!empty($ids)) {
        $escaped = array_map('intval', $ids);
        $idList = implode(',', $escaped);

        $sql = "DELETE FROM books WHERE id IN ($idList)";
        if ($conn->query($sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'No IDs provided']);

?>