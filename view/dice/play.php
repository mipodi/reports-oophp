<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Dice 100</h1>

<p>Player is <?= $who ?>  </p>

<h3>Rolling <?= $rolls ?> graphic dices </h3>

<p>
<?php foreach ($class as $value) : ?>
    <i class="dice-sprite <?= $value ?>"></i>
<?php endforeach; ?>
</p>


<p class="dice-utf8">
<?php foreach ($class as $value) : ?>
    <i class="<?= $value ?>"></i>
<?php endforeach; ?>
</p>

<p><?= implode(", ", $res) ?></p>
<p>Sum is: <?= array_sum($res) ?>.</p>
<p>Average is: <?= round(array_sum($res)/$rolls) ?>.</p>
