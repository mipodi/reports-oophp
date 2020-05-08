<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Dice 100 DELUXE VERSION</h1>

<!-- <h3>Rolling <?#= $rolls ?> graphic dices </h3> -->

<p>Human player: <?= $humanScore ?></p>
<p>Computer player: <?= $computerScore ?></p>


<!-- <p>
<?#php foreach ($class as $value) : ?>
    <i class="dice-sprite <?#= $value ?>"></i>
<?#php endforeach; ?>
</p> -->


<div class="container">
    <!-- eller döpa nedan action till change-turn?? -->
<form method="post" action="play">
    <!-- <input type="hidden" name="number" value="<?#= $number?>"> -->
    <!-- <input type="hidden" name="tries" value="<?#= $tries?>"> -->

<?php if (!$winner) : ?>
    <input class="rollBtn" type="submit" name="doRoll" value="Roll">
    <input class="saveBtn" type="submit" name="doSave" value="Save">
<?php endif; ?>
    <input class="restartBtn" type="submit" name="doInit" value="Restart">

</form>


</div>



<?php if ($humanLatestRoll) : ?>
    <p>Your thrown dices: <?= implode(", ", $humanLatestRoll) ?></p>
    <!-- <p>Your points: <#?= array_sum($res) ?>.</p> -->
    <?php if ($tempScore) : ?>
    <p>Your points: <?= $tempScore ?>.</p>
    <?php endif; ?>

<?php endif; ?>

<?php if ($computerLatestRoll) : ?>
    <p> Computer played: <?= implode(", ", $computerLatestRoll) ?></p>
    <?php if (!$winner) : ?>
        <p> Your turn again &rarr; </p>
    <?php endif; ?>
<?php endif; ?>

<?php if ($winner) : ?>
    <p><?= $winner ?></p>
<?php endif; ?>

<!-- <p>Average is: <?#= round(array_sum($res)/$rolls) ?>.</p> -->
