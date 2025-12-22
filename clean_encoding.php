<?php
$dir = __DIR__; // racine du projet

function cleanFile($file) {
    $content = file_get_contents($file);

    // Supprimer BOM UTF-8
    $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

    // Remplacements d'encodage communs
    $replacements = [
        'é' => 'é',
        'è' => 'è',
        'à'  => 'à',
        'â' => 'â',
        'ô' => 'ô',
        'û' => 'û',
        '—' => '—',
        '–' => '–',
        '‘' => '‘',
        '’' => '’,',
        '“' => '“',
        '”' => '”',
        '•' => '•',
        '©' => '©',
        '<' => '<',
        '>' => '>',
        ''   => '', // supprimer les caractères invisibles résiduels
        'û' => 'û',
        'ä' => 'ä',
        'ö' => 'ö',
        'ü' => 'ü',
        'ß' => 'ß',
        'É' => 'É',
        'À' => 'À',
        'Ü' => 'Ü',
        'Ö' => 'Ö',
        'Ä' => 'Ä',
        'Ü' => 'Ü',
        'ActionTypesScreenState' => '→',
    ];
    // Appliquer les remplacements dans le contenu
    $content = str_replace(array_keys($replacements), array_values($replacements), $content);
    
    file_put_contents($file, $content);
    echo "Nettoyé : $file\n";
}

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($rii as $file) {
    if ($file->isDir()) continue;
    $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
    if (in_array($ext, ['php','blade.php','css','js'])) {
        cleanFile($file->getPathname());
    }
}

echo "✅ Tous les fichiers Blade, CSS et JS ont été nettoyés.\n";
