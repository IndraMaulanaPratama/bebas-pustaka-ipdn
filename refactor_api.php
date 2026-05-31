<?php

$directory = new RecursiveDirectoryIterator(__DIR__ . '/app');
$iterator = new RecursiveIteratorIterator($directory);
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;

foreach ($regex as $file) {
    $filePath = $file[0];
    $content = file_get_contents($filePath);
    $originalContent = $content;

    // Pattern 1: json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $variable), true)
    // Matches both env(...) and getenv(...) and raw URL strings, and handles optional , true
    $content = preg_replace_callback(
        '/json_decode\s*\(\s*file_get_contents\s*\(\s*(?:env\([\'"]APP_PRAJA[\'"]\)|getenv\([\'"]APP_PRAJA[\'"]\)|\'https:\/\/datapraja\.ipdn\.ac\.id\/api\/\')\s*\.\s*[\'"]praja\?npp=[\'"]\s*\.\s*([^)]+)\s*\)\s*(?:,\s*(true)\s*)?\)/i',
        function ($matches) {
            $variable = trim($matches[1]);
            $asArray = isset($matches[2]) && strtolower($matches[2]) === 'true' ? 'true' : 'false';
            
            // If asArray is true, just pass true. If false, omit it since it's the default.
            $args = $asArray === 'true' ? "$variable, true" : $variable;
            return "\\App\\Helpers\\PrajaApi::getPraja($args)";
        },
        $content
    );

    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        echo "Refactored: " . $filePath . "\n";
        $count++;
    }
}

echo "Total files refactored: " . $count . "\n";
