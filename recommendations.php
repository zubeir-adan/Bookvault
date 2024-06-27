<?php
function getBookRecommendations($preferences, $page = 1, $booksPerPage = 10) {
    $recommendedBooks = [];
    foreach ($preferences as $term) {
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($term);
        $response = file_get_contents($url);
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['items'])) {
                $recommendedBooks = array_merge($recommendedBooks, $data['items']);
            }
        }
    }

    // Calculate total books and pages
    $totalBooks = count($recommendedBooks);
    $totalPages = ceil($totalBooks / $booksPerPage);

    // Implement pagination
    $offset = ($page - 1) * $booksPerPage;
    $paginatedBooks = array_slice($recommendedBooks, $offset, $booksPerPage);

    // Limit to a maximum of 4 books
    $paginatedBooks = array_slice($paginatedBooks, 0, 4);

    return ['books' => $paginatedBooks, 'totalBooks' => min($totalBooks, 4)]; // Ensure 'totalBooks' is limited to 4
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
    return array_keys(array_slice($searchFrequencies, 0, 5)); // Return top 5 search terms
}
?>
