<?php

echo "<h1>SUP</h1>";

$url_components = parse_url($url);
parse_str($url_components['query'], $params);