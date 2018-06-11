<?php

/**
 * Reads from a file
 *
 * @param [string] $filePath Path to the file
 * 
 * @return string/boolean File content, if file exists. False otherwise
 */
function read_file($filePath) {
    if (!file_exists($filePath))
        return false;

    $str = file_get_contents($filePath);

    return $str;
}

/**
 * Writes a json to a file
 *
 * @param [string] $filePath Path to the file
 * @param [array]  $content  File content
 * 
 * @return boolean True in case of success. False otherwise
 */
function write_file($filePath, $content) {
    if (!file_exists($filePath))
        return false;

    $fp = fopen($filePath, 'w');

    if (flock($fp, LOCK_EX)) { // do an exclusive lock
        fwrite($fp, json_encode($content));
        flock($fp, LOCK_UN); // release the lock
    } else {
        return false;
    }
    fclose($fp);

    return true;
}

/**
 * Generates a random code 
 *
 * @param integer $size The size of the code
 * @return string the generated code
 */
function generateCode($size=10) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $size; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 * Creates a log file
 * 
 * @param [String] The log's content
 * @param [String] The file's name
 * 
 * @return void
 */
function criaLog($content, $file = 'log.txt') {
    // Logging class initialization
    $log = new Logging();
    // set path and name of log file (optional)
    $log->lfile($file);
    // write message to the log file
    $log->lwrite($content);
    // close log file
    $log->lclose();
}