<?php
// Handle bookmarklet rating
require_once '../includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $rating = isset($_POST['rating']) ? (float)$_POST['rating'] : 0;
    
    // Validate rating
    if ($rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Invalid rating']);
        exit;
    }
    
    // Check if user has already rated this bookmarklet
    $ip = $_SERVER['REMOTE_ADDR'];
    if (hasRated($id, $ip)) {
        echo json_encode(['success' => false, 'message' => 'You have already rated this bookmarklet']);
        exit;
    }
    
    // Add the rating
    if (rateBookmarklet($id, $rating, $ip)) {
        $bookmarklet = getBookmarkletById($id);
        echo json_encode([
            'success' => true,
            'message' => 'Rating added successfully',
            'new_rating' => $bookmarklet['rating']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding rating']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>