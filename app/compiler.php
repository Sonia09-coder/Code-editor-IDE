<?php
// Validate and sanitize input
$language = isset($_POST['language']) ? strtolower($_POST['language']) : '';
$code = isset($_POST['code']) ? $_POST['code'] : '';

// Validate language
$supportedLanguages = ['php', 'python', 'node', 'c', 'cpp'];
if (!in_array($language, $supportedLanguages)) {
    die('Unsupported language');
}

// Generate random filename
$random = substr(md5(mt_rand()), 0, 7);
$filePath = "temp/" . $random . "." . $language;

// Write code to file
$programFile = fopen($filePath, "w");
fwrite($programFile, $code);
fclose($programFile);

// Execute code based on language
switch ($language) {
    case 'php':
    case 'python':
    case 'node':
        $output = shell_exec("$language $filePath");
        break;
    case 'c':
        $outputExe = $random . ".exe";
        shell_exec("gcc $filePath -o $outputExe");
        $output = shell_exec("./$outputExe");
        break;
    case 'cpp':
        $outputExe = $random . ".exe";
        shell_exec("g++ $filePath -o $outputExe");
        $output = shell_exec("./$outputExe");
        break;
}

// Display output
echo $output;
?>
