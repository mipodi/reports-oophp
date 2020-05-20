<?php

namespace Anax\View;

if ($content->filter) {
    $textfilter = new \Mipodi\MyTextFilter\TextFilter();
    $filtersToApply = explode(",", $content->filter);

    // print_r($filtersToApply);

    $data = $textfilter->parse($content->data, $filtersToApply);
} elseif (!$content->filter) {
    $data = htmlentities($content->data);
}

?><article>
    <header>
        <h1><?= htmlentities($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= htmlentities($content->modified_iso8601) ?>" pubdate><?= htmlentities($content->modified) ?></time></i></p>
    </header>
    <?= $data ?>
</article>
