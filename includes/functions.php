<?php
function dd($errors){
    echo '<pre>';
    print_r($errors);
    echo '</pre>';
    die();
}