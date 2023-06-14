<?php

$input = filter_input(
    INPUT_GET,
    "i",
    FILTER_SANITIZE_SPECIAL_CHARS
);

echo "xmlhttp: " . $input;
