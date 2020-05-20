<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
// var_dump($textfilter);



$textForBbcode = "[b]Bold text[/b] [i]Italic text[/i] [url=http://dbwebb.se]a link to dbwebb[/url]

And then an image.
[img]https://dbwebb.se/image/tema/trad/blad.jpg[/img]";
$bbcode2html = $textfilter->parse($textForBbcode, "bbcode");

$textForClickable = "<p>This link should for example be made clickable: http://dbwebb.se </p>";
$links = $textfilter->parse($textForClickable, "link");

$textForMarkdown = "Header level 1 {#id1}
=====================

Here comes a paragraph.

* Unordered list
* Unordered list again";
$markdown2html = $textfilter->parse($textForMarkdown, "markdown");

$newLine2Break = $textfilter->parse($bbcode2html, "nl2br");



?><h1>Unfiltered</h1>

<h2>Bbcode</h2>
<pre><?= wordwrap(htmlentities($textForBbcode)) ?></pre>

<h2>Unlinked text</h2>
<pre><?= wordwrap(htmlentities($textForClickable)) ?></pre>

<h2>Markdown</h2>
<pre><?= $textForMarkdown ?></pre>



<h1>Filtered</h1>
<h2>Filter BBCode applied, HTML</h2>
<?= $bbcode2html ?>

<h2>Filter BBCode AND nl2br applied, HTML</h2>
<?= $newLine2Break ?>

<h2>Filter Clickable applied, HTML</h2>
<?= $links ?>

<h2>Filter Markdown applied, HTML</h2>
<?= $markdown2html ?>
