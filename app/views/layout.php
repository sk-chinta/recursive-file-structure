<?php
function startLayout($title) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>{$title}</title>
        <link rel='stylesheet' href='./public/assets/styles.css'>
    </head>
    <body>";
}

function endLayout() {
    echo "</body></html>";
}
?>