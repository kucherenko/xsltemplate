<?php
/**
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   13.12.11
 *
 */
if (false === class_exists('Symfony\Component\ClassLoader\UniversalClassLoader', false)) {
    require_once __DIR__.'/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';
}

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'XSLTemplate'   => __DIR__.'/src',
));
$loader->register();