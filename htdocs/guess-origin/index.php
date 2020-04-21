<?php
/**
 * Glue for the game Guess my number
 */
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");

$title = "Hello | Guess My Number";
include(__DIR__ . "/view/header.php");

// sessionDestroy();

if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}

$game = $_SESSION["game"];

$number = $game->number();
$tries = $game->tries();

$guess      = $_SESSION["guess"] ?? null;
$doInit     = $_SESSION["doInit"] ?? null;
$doGuess    = $_SESSION["doGuess"] ?? null;
$doCheat    = $_SESSION["doCheat"] ?? null;
$res        = $_SESSION["res"] ?? null;



// Renders the page
require __DIR__ . "/view/guess-game-view.php";
