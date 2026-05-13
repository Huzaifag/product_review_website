<?php

$files = glob('app/Http/Controllers/Business/Payments/*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    if (preg_match('/(public function __construct\(\)\s*\{\s*\$this->paymentGateway = paymentGateway\([^\)]+\);)(.*?)(\n    \})/s', $content, $matches)) {
        if (strpos($matches[2], 'if ($this->paymentGateway)') !== false) {
            continue;
        }
        if (trim($matches[2]) === '') {
            continue;
        }
        $inner = $matches[2];
        $inner = preg_replace('/(\n)/', '$1    ', $inner);
        $newConstruct = $matches[1]."\n        if (\$this->paymentGateway) {".$inner."\n        }".$matches[3];
        $content = str_replace($matches[0], $newConstruct, $content);
        file_put_contents($file, $content);
        echo "Patched $file\n";
    }
}
