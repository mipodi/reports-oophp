<?php

namespace Anax\View;


/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1 class="neon">Guess My Number</h1>

<p>Guess a number between 1 and 100 please.</p>
<p>You have <?= $tries ?> tries left.</p>

<div class="container">
<form method="post" action="make-guess">
    <input class="guessField" type="text" name="guess" placeholder="Type your guess...">
    <input type="hidden" name="number" value="<?= $number?>">
    <input type="hidden" name="tries" value="<?= $tries?>">

    <?php if ($tries > 0) : ?>
    <input class="guessBtn" type="submit" name="doGuess" value="Make a guess">
    <?php endif; ?>

    <input class="restartBtn" type="submit" name="doInit" value="Start over">
    <input class="cheatBtn" type="submit" name="doCheat" value="Cheat">
</form>

<?php if ($doGuess) : ?>
    <p>Your guess <?= $guess ?> is <b><?= $res ?></b></p>
        <?php if ($res === "CORRECT") : ?>
            <p>YOU WON!!! OMG!!!</p>
        <?php endif; ?>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>Cheat: Current number is <?= $number ?> </p>
<?php endif; ?>

</div>
