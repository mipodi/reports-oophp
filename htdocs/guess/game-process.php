<pre>
<?php
/**
 * Process page
 */
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");

// var_dump($_SESSION);
// echo "hello";

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

    $number = $game->number();
    $tries = $game->tries();
} elseif ($doGuess) {
    try {
        $res = $game->makeGuess($guess);
    } catch (GuessException $e) {
            // echo "Got exception: " . get_class($e) . "<hr>";
        $res = "INVALID. Please enter above 1 or below 100.";
    }
}

    $_SESSION["res"] = $res;
    $_SESSION["guess"] = $guess;
    $_SESSION["doInit"] = $doInit;
    $_SESSION["doGuess"] = $doGuess;
    $_SESSION["doCheat"] = $doCheat;


header("Location: index.php");
