<?php
header("Content-Type: application/xml; charset=UTF-8");

$baseUrl = "https://resizely.in";
$root = realpath(__DIR__);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root)
);

$excludeFiles = [
    'send.php',
    'sitemap.php',
    'config.php'
];

$excludeFolders = [
    '/admin/',
    '/dashboard/',
    '/config/',
    '/includes/',
    '/uploads/',
    '/tmp/'
];

foreach ($iterator as $file) {

    if ($file->isDir()) continue;

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (!in_array($ext, ['html', 'php'])) continue;

    $relativePath = str_replace($root, '', $file->getPathname());
    $relativePath = str_replace("\\", "/", $relativePath);

    // Skip excluded folders
    foreach ($excludeFolders as $folder) {
        if (strpos($relativePath, $folder) !== false) continue 2;
    }

    // Skip excluded files
    if (in_array(basename($relativePath), $excludeFiles)) continue;

    // Skip files with spaces
    if (strpos($relativePath, ' ') !== false) continue;

    $url = $baseUrl . $relativePath;

    echo "<url>";
    echo "<loc>$url</loc>";
    echo "<priority>0.8</priority>";
    echo "</url>";
}

echo '</urlset>';
?>
