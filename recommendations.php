<?php
function getBookRecommendations($preferences, $page = 1, $booksPerPage = 12, $conn) {
    $recommendedBooks = [];

    // Fetch up to 3 books per preference term
    foreach ($preferences as $term) {
        // Modify the URL or API call as per your actual implementation
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($term);
        $response = file_get_contents($url);
        
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['items'])) {
                // Add up to 3 recommended books for this term
                $recommendedBooks = array_merge($recommendedBooks, array_slice($data['items'], 0, 3));
            }
        }
    }

    // Calculate total books and pages
    $totalBooks = count($recommendedBooks);
    $totalPages = ceil($totalBooks / $booksPerPage);

    // Implement pagination
    $offset = ($page - 1) * $booksPerPage;
    $paginatedBooks = array_slice($recommendedBooks, $offset, $booksPerPage);

    return [
        'books' => $paginatedBooks,
        'totalBooks' => $totalBooks
    ];
}

function getUserPreferences($userId, $conn) {
    $stmt = $conn->prepare("SELECT search_query FROM search_history WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $searchTerms = [];

    while ($row = $result->fetch_assoc()) {
        $searchTerms[] = $row['search_query'];
    }

    $stmt->close();
    
    // Analyze the search terms to find the most frequent ones
    $searchFrequencies = array_count_values($searchTerms);
    arsort($searchFrequencies);
    
    // Return top 5 search terms
    return array_keys(array_slice($searchFrequencies, 0, 15));
}
?>
