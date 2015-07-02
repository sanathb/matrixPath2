<?php
$sleep = isset($_GET['sleep']) ? (int) $_GET['sleep'] : 0;
sleep($sleep);

echo "Slept for ". $sleep;
