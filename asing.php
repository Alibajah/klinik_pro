<?php
// Simple index/router for klinik_pro
session_start();

// Basic routing via ?page=...
$page = isset($_GET['page']) ? preg_replace('/[^a-z0-9_\-]/i', '', $_GET['page']) : 'home';
$allowed = ['home', 'about', 'contact'];

if (!in_array($page, $allowed)) {
	http_response_code(404);
	echo "<h1>404 Not Found</h1>";
	exit;
}

// Map to file path (prevent directory traversal)
$file = __DIR__ . DIRECTORY_SEPARATOR . $page . '.php';
if (is_file($file)) {
	include $file;
} else {
	// Fallback simple output
	echo "<!doctype html><html><head><meta charset=\"utf-8\"><title>".htmlspecialchars($page)."</title></head><body>";
	echo "<h1>Page: ".htmlspecialchars($page)."</h1>";
	echo "</body></html>";
}

?>
