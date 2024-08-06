<?php
// Set CORS headers
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Function to fetch content from a URL
function fetch_content($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'Error: ' . curl_error($ch);
    } else {
        curl_close($ch);
        return $response;
    }
}

// Function to extract viewkeys from HTML
function extract_viewkeys($html) {
    preg_match_all('/\/view_video\.php\?viewkey=([a-zA-Z0-9]+)/', $html, $matches);
    return $matches[1];  // Return only the captured view keys
}

// URL to fetch the source code from
$target_url = "https://www.pornhub.com/webmasters/hello_worlds";

// Fetch the content
$source_code = fetch_content($target_url);

if ($source_code) {
    // Extract viewkeys
    $viewkeys = extract_viewkeys($source_code);

    if (!empty($viewkeys)) {
        // Print the first matched URL
        $first_viewkey = $viewkeys[0];
        echo "https://www.pornhub.com/embed/$first_viewkey";
    } else {
        echo "No viewkeys found.";
    }
} else {
    echo "Failed to retrieve content.";
}
?>
