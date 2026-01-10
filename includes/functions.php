<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

// Layout function to include layout files
function layout($layoutName, $data = []) {
    // Check if the layout file exists
    if(file_exists(PATH_URL_TEMPLATES . '/layouts/'.$layoutName. '.php')){
        require_once(PATH_URL_TEMPLATES . '/layouts/'.$layoutName. '.php');// Include the layout file
    }
}