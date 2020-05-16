<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// if (!$res) {
//     return;
// }
?>

<form method="get">
    <fieldset>
    <legend>Search</legend>
    <!-- <input type="hidden" name="route" value="search-title"> -->
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= htmlentities($searchTitle) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <a href="<?= url("movies/index") ?>">Show all</a>
    </fieldset>
</form>
