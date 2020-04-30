<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice/init", function () use ($app) {
    // Init the session for the game start.
    // $game = new Mipodi\Guess\Guess();
    // $_SESSION["game"] = $game;
    // $_SESSION["number"] = $game->number();
    // $_SESSION["tries"] = $game->tries();
    $_SESSION["dice"] = null;
    $_SESSION["diceGame"] = null;

    $_SESSION["res"] = null;
    $_SESSION["doRoll"] = null;

    $dice = null;
    $diceGame = null;

    $dice = new Mipodi\Dice\DiceGraphic();
    $diceGame = new Mipodi\Dice\DiceGame();

    $_SESSION["dice"] = $dice;
    $_SESSION["diceGame"] = $diceGame;
    $_SESSION["res"] = null;

    return $app->response->redirect("dice/play");
});


/**
 * Play the game.
 */
$app->router->get("dice/play", function () use ($app) {
    // return ["Play the game"];

    $title = "Play the game";

    $dice = $_SESSION["dice"];
    $diceGame = $_SESSION["diceGame"];



    $rolls      = 2;
    $res        = $_SESSION["res"] ?? [];
    $class      = [];
    $doInit    = $_SESSION["doInit"] ?? null;
    $doSave    = $_SESSION["doSave"] ?? null;
    $doRoll    = $_SESSION["doRoll"] ?? null;

    if ($doInit) {
       // $game->resetGame();
       $res = null;
       $_SESSION["res"] = null;
       return $app->response->redirect("dice/init");
       // $guess      = null;
       // $doInit     = null;
       // $doGuess    = null;
       // $doCheat    = null;
    } elseif ($doRoll) {
        for ($i = 0; $i < $rolls; $i++) {
            // $res[] = $dice->roll();
            $dice->roll();
            $class[] = $dice->graphic();
            // $diceGame->roll();
            // $class[] = $diceGame->graphic();
        }
        $res = $dice->results();
    } elseif ($doSave) {
        // try {
            // $dice->save();

        $diceGame->save($res);

        $_SESSION["res"] = null;
        // } catch (Mipodi\Guess\GuessException $e) {
        //         // echo "Got exception: " . get_class($e) . "<hr>";
        //     $res = "INVALID. Please enter above 1 or below 100.";
        // }
    }



    $humanScore = 0;
    $computerScore = 0;

    // $_SESSION["res"] = $res;


    // $game = $_SESSION["game"];
    // $number = $_SESSION["number"];
    // $tries = $_SESSION["tries"];
    //
    // $guess      = $_SESSION["guess"] ?? null;
    // $doInit     = $_SESSION["doInit"] ?? null;
    // $doGuess    = $_SESSION["doGuess"] ?? null;
    // $doCheat    = $_SESSION["doCheat"] ?? null;
    // $res        = $_SESSION["res"] ?? null;


    $data = [
        // "guess" => $guess,
        // "tries" => $tries,
        // "number" => $number,
        "class" => $class,
        "rolls" => $rolls,
        "res" => $res,
        "humanScore" => $humanScore,
        "computerScore" => $computerScore,
        "doInit" => $doInit,
        "doSave" => $doSave
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
    // $_SESSION["doSave"] = $request->getPost("doSave") ?? null;
    // $_SESSION["doSave"] = $request->getPost($doSave) ?? null;

    $_SESSION["doSave"] = $_POST["doSave"];
    $_SESSION["doRoll"] = $_POST["doRoll"];
    // $_SESSION["res"] = $_POST["res"];

    return $app->response->redirect("dice/play");
});
