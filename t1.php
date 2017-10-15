<?php
declare(strict_types=1);
function cli() {
    return defined('STDIN') || (substr(PHP_SAPI, 0, 3) === 'cgi' && getenv('TERM'));
}
$cli = cli();
scandirectory(__DIR__, 0, $cli);
function showfile(string $file, int $step, bool $cli) {
	for ($i = 0; $i < $step; $i++) {
        echo "=>";
	}
	echo $file;
	if ($cli) {
		echo "\n";
	}	
	else
		echo "<br>";
}
function findfile(string $directory) {
    $opendirectory = opendir($directory);
    while (($file = readdir($opendirectory)) !== false) {
        $array[] = $file;
    }
    closedir($opendirectory);
    return $array;
}
function scandirectory(string $directory, int $step, bool $cli) {
    $array = findfile($directory);
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i] !== '.' && $array[$i] !== '..' && $array[$i] !==false) {
            showfile($array[$i], $step, $cli);
            if (is_dir($directory.DIRECTORY_SEPARATOR.$array[$i])===true) {
                $step++;
                scandirectory($directory.DIRECTORY_SEPARATOR.$array[$i], $step, $cli);
                $step--;
            }
        }
    }
}