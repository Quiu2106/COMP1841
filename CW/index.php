<?php
session_start();
$title = 'Coursework 1841';
ob_start();
include 'tem/home.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
