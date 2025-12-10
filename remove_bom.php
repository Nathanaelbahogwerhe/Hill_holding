<?php

function removeBOM($filename) {
    $contents = file_get_contents($filename);
    $bom = "\xEF\xBB\xBF";

    if (strpos($contents, $bom) === 0) {
        file_put_contents($filename, substr($contents, 3));
        echo "BOM removed from: $filename\n";
    }
}

$directory = new RecursiveDirectoryIterator(__DIR__, RecursiveDirectoryIterator::SKIP_DOTS);
$iterator = new RecursiveIteratorIterator($directory);

foreach ($iterator as $file) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    // Extensions à corriger
    $allowed = ['php','js','json','css','scss','vue','html','md','blade.php'];

    foreach ($allowed as $a) {
        if (str_ends_with($file, $a)) {
            removeBOM($file);
            break;
        }
    }
}

echo "\n✔ Correction terminée ! Tous les BOM trouvés ont été supprimés.\n";
