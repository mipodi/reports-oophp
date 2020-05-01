<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Dice 100</h1>

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

    <input class="rollBtn" type="submit" name="doRoll" value="Roll">
    <input class="saveBtn" type="submit" name="doSave" value="Save">
    <input class="restartBtn" type="submit" name="doInit" value="Start over">

</form>


</div>

<?php if ($res) : ?>
    <p>Your thrown dices: <?= implode(", ", $res) ?></p>
    <p>Your points: <?= array_sum($res) ?>.</p>
<?php endif; ?>

<!-- <p>Average is: <?#= round(array_sum($res)/$rolls) ?>.</p> -->
