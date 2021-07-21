<?php
// menu.php
// inclure  l'autoloader
require dirname(__DIR__) . '../vendor/autoload.php';

try {
    // le dossier ou on trouve les templates
    $loader = new Twig\Loader\FilesystemLoader('template');

    // initialiser l'environement Twig
    $twig = new Twig\Environment($loader);

    // load template
    $template = $twig->load('heritage.twig');

    // set template variables
    // render template
    echo $template->render(array(
        'title'=>'test',
    ));

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}