<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice/init", function () use ($app) {
    // $_SESSION["diceGame"]   = null;
    // $_SESSION["doRoll"]     = null;
    // $_SESSION["doSave"]     = null;
    // $_SESSION["doInit"]     = null;
    // $_SESSION["res"]        = null;
    // $app->session->destroy();

    $app->session->set("diceGame", null);
    $app->session->set("doRoll", null);
    $app->session->set("doSave", null);
    $app->session->set("doInit", null);
    $app->session->set("res", null);


    $diceGame = null;
    $diceGame = new Mipodi\Dice\DiceGame();

    // $_SESSION["diceGame"] = $diceGame;
    $app->session->set("diceGame", $diceGame);

    return $app->response->redirect("dice/play");
});


/**
 * Play the game.
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";
    // $computerLatestRoll = null;
    $humanLatestRoll = null;

    // $diceGame = $_SESSION["diceGame"];
    $diceGame = $app->session->get("diceGame");

    // $gameStatus = $_SESSION["doRoll"] ?? $_SESSION["doSave"] ?? null;
    $gameStatus = $app->session->get("doRoll") ?? $app->session->get("doSave");

    $diceGame->play($gameStatus);

    // $doInit = $_SESSION["doInit"] ?? null;
    $doInit = $app->session->get("doInit");

    if ($doInit) {
        return $app->response->redirect("dice/init");
    }

    $tempScore = $diceGame->tempScore();
    $humanScore = $diceGame->humanScore();
    $computerScore = $diceGame->computerScore();
    $humanLatestRoll = $diceGame->getHumanLatestRoll() ?? null;
    $computerLatestRoll = $diceGame->getComputerLatestRoll() ?? null;
    $winner = $diceGame->isWinner() ?? null;

    $data = [
        // "class" => $class,
        // "rolls" => $rolls,
        // "res" => $res,
        "humanScore" => $humanScore,
        "computerScore" => $computerScore,
        "tempScore" => $tempScore,
        "computerLatestRoll" => $computerLatestRoll,
        "humanLatestRoll" => $humanLatestRoll,
        "winner" => $winner
    ];

    $app->page->add("dice/play", $data);
    // $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game.
 */
$app->router->post("dice/play", function () use ($app) {
    // $_SESSION["doSave"] = $_POST["doSave"];
    // $_SESSION["doRoll"] = $_POST["doRoll"];
    // $_SESSION["doInit"] = $_POST["doInit"];

    // $doSave = $_POST["doSave"];
    // $doRoll = $_POST["doRoll"];
    // $doInit = $_POST["doInit"];

    // $request = $app->request;

    $doSave = $app->request->getPost("doSave");
    $doRoll = $app->request->getPost("doRoll");
    $doInit = $app->request->getPost("doInit");

    $app->session->set("doSave", $doSave);
    $app->session->set("doRoll", $doRoll);
    $app->session->set("doInit", $doInit);

    return $app->response->redirect("dice/play");
});
