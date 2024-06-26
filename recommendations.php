<?php
function getBookRecommendations($preferences, $page = 1, $booksPerPage = 3) {
    $recommendedBooks = [];
    foreach ($preferences as $term) {
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($term);
        $response = file_get_contents($url);
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['items'])) {
                $recommendedBooks = array_merge($recommendedBooks, array_slice($data['items'], 0, $booksPerPage));
            }
        }
    }

    // Implement pagination
    $totalBooks = count($recommendedBooks);
    $totalPages = ceil($totalBooks / ($booksPerPage * count($preferences)));
    $offset = ($page - 1) * ($booksPerPage * count($preferences));
    $paginatedBooks = array_slice($recommendedBooks, $offset, $booksPerPage * count($preferences));

    return ['books' => $paginatedBooks, 'totalPages' => $totalPages];
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
