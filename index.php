<?php
$files = scandir('src');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo '<a href="src/' . $file . '">' . $file . '</a><br>';
    }
}