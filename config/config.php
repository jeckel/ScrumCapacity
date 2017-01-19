<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 10/01/17
 * Time: 13:27
 */
$config = include __DIR__ . '/config.global.php';
if (is_file(__DIR__ . '/config.local.php')) {
    $config = array_replace_recursive($config, include __DIR__ . '/config.local.php');
}
return $config;
