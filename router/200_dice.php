<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice/init", function () use ($app) {
    $_SESSION["diceGame"]   = null;
    $_SESSION["doRoll"]     = null;
    $_SESSION["doSave"]     = null;
    $_SESSION["doInit"]     = null;
    $_SESSION["res"]        = null;

    $diceGame = null;
    $diceGame = new Mipodi\Dice\DiceGame();

    $_SESSION["diceGame"] = $diceGame;

    return $app->response->redirect("dice/play");
});


/**
 * Play the game.
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";

    $diceGame = $_SESSION["diceGame"];
    $gameStatus = $_SESSION["doRoll"] ?? $_SESSION["doSave"] ?? null;
    $res = $diceGame->play($gameStatus);

    $doInit = $_SESSION["doInit"] ?? null;

    if ($doInit) {
        return $app->response->redirect("dice/init");
    }

    $tempScore = $diceGame->tempScore();
    $humanScore = $diceGame->humanScore();
    $computerScore = $diceGame->computerScore();
    $winner = $diceGame->isWinner() ?? null;

    $data = [
        // "class" => $class,
        // "rolls" => $rolls,
        "res" => $res,
        "humanScore" => $humanScore,
        "computerScore" => $computerScore,
        "tempScore" => $tempScore,
        "winner" => $winner
    ];

    $app->page->add("dice/play", $data);
    $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game.
 */
$app->router->post("dice/play", function () use ($app) {
    $_SESSION["doSave"] = $_POST["doSave"];
    $_SESSION["doRoll"] = $_POST["doRoll"];
    $_SESSION["doInit"] = $_POST["doInit"];
    // $_SESSION["res"] = $_POST["res"];

    return $app->response->redirect("dice/play");
});
