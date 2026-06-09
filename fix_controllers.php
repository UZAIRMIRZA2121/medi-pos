<?php
$dir = 'app/Http/Controllers/';
foreach(glob($dir.'*Controller.php') as $file) {
    $content = file_get_contents($file);
    if(strpos($content, 'function index(') === false && basename($file) !== 'Controller.php') {
        // Simple replacement to inject index method before the last brace
        $content = preg_replace('/}\s*$/', "\n    public function index()\n    {\n        return view('pos.index');\n    }\n}\n", $content);
        file_put_contents($file, $content);
    }
}
echo "Controllers updated.";
