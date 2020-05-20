<?php

namespace Anax\View;

// var_dump($content);
// var_dump($content->filter);

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
        <p><i>Published: <time datetime="<?= htmlentities($content->published_iso8601) ?>" pubdate><?= htmlentities($content->published) ?></time></i></p>
    </header>
    <?= $data ?>
</article>
