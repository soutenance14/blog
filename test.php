<?php

$a = md5(bin2hex(openssl_random_pseudo_bytes(6)));

echo $a;