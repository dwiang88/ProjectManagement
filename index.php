<?php

$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."public";
header("Location: $link");
die();