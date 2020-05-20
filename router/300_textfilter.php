<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("textfilter", function () use ($app) {
    $data = [
        "textfilter" => new Mipodi\MyTextFilter\TextFilter(),
    ];

    $app->page->add("textfilter/index", $data);
    return $app->page->render();
});
