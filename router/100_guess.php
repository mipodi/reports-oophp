<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the game start.
    $game = new Mipodi\Guess\Guess();
    $_SESSION["game"] = $game;
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});


/**
 * Play the game.
 */
$app->router->get("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play the game";

    $game = $_SESSION["game"];
    $number = $_SESSION["number"];
    $tries = $_SESSION["tries"];

    $guess      = $_SESSION["guess"] ?? null;
    $doInit     = $_SESSION["doInit"] ?? null;
    $doGuess    = $_SESSION["doGuess"] ?? null;
    $doCheat    = $_SESSION["doCheat"] ?? null;
    $res        = $_SESSION["res"] ?? null;


    $data = [
        "guess" => $guess,
        "tries" => $tries,
        "number" => $number,
        "doGuess" => $doGuess,
        "doCheat" => $doCheat,
        "res" => $res
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game.
 */
$app->router->post("guess/make-guess", function () use ($app) {
    $game       = $_SESSION["game"];
    $guess      = $_POST["guess"] ?? null;
    $doInit     = $_POST["doInit"] ?? null;
    $doGuess    = $_POST["doGuess"] ?? null;
    $doCheat    = $_POST["doCheat"] ?? null;

    if ($doInit) {
        $game->resetGame();

        $guess      = null;
        $doInit     = null;
        $doGuess    = null;
        $doCheat    = null;

    } elseif ($doGuess) {
        try {
            $res = $game->makeGuess($guess);
        } catch ( Mipodi\Guess\GuessException $e) {
                // echo "Got exception: " . get_class($e) . "<hr>";
            $res = "INVALID. Please enter above 1 or below 100.";
        }
    }

    $number = $game->number();
    $tries = $game->tries();

    $_SESSION["res"] = $res;
    $_SESSION["guess"] = $guess;
    $_SESSION["doInit"] = $doInit;
    $_SESSION["doGuess"] = $doGuess;
    $_SESSION["doCheat"] = $doCheat;
    $_SESSION["number"] = $number;
    $_SESSION["tries"] = $tries;

    return $app->response->redirect("guess/play");
});
