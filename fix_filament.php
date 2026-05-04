<?php

$dir = __DIR__ . '/app/Filament/Resources/';
$files = glob($dir . '*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Extract property values
    preg_match('/protected static \?string \$model = ([^;]+);/', $content, $modelMatch);
    preg_match('/protected static \?string \$navigationIcon = \'([^\']+)\';/', $content, $iconMatch);
    
    $model = $modelMatch[1] ?? 'null';
    $icon = $iconMatch[1] ?? 'heroicon-o-document';
    
    // Remove the properties
    $content = preg_replace('/protected static \?string \$model = [^;]+;/', '', $content);
    $content = preg_replace('/protected static \?string \$navigationIcon = \'[^\']+\';/', '', $content);
    
    // Add the getters if they don't exist
    if (!str_contains($content, 'public static function getModel()')) {
        $getters = "
    public static function getModel(): string
    {
        return $model;
    }

    public static function getNavigationIcon(): string
    {
        return '$icon';
    }
";
        $content = preg_replace('/class [a-zA-Z]+ extends Resource\s*\{/', "$0$getters", $content);
    }
    
    file_put_contents($file, $content);
}
echo "Fixed Filament resources.\n";
