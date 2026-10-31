<?php
require_once 'includes/fungsi.php';

$_SESSION = [];
session_destroy();
arahkan('index.php');
