<?php declare(strict_types=1);

if (version_compare(PHP_VERSION, '5.3.0', '<')
    || !class_exists('NumberFormatter')) {
    exit('You need PHP 5.3 or above, and php_intl extension');
}

/**
 * convert array of numbers to spelled-out ordinals
 *
 * warning: not all locale might support %spellout-ordinal rule.
 *
 */
function convertNumbersToSpelledOutOrdinals(string $locale, array $numbersList) : array {
    // spell out (like 1 to "one" in English)
    $formatter = new \NumberFormatter($locale, \NumberFormatter::SPELLOUT);

    // set spell-out rule as ordinal
    $formatter->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-ordinal");

    // apply formatter to each number
    $ordinalsSpelledoutList = array_map([$formatter, 'format'], $numbersList);

    return $ordinalsSpelledoutList;
}

$numbersList = [ 1, 2, 3, 42, 50607 ]; // any numbers
$localeList = [ 'en', 'ja', 'fr', 'de', 'es', 'it', 'zh' ]; // add locales you want to check

foreach ($localeList as $locale) {
    $ordinalsList = convertNumbersToSpelledOutOrdinals($locale, $numbersList);

    // concatinate results with comma
    $cammaConcatenated = implode(', ', $ordinalsList);

    echo 'locale:' . $locale . ' - ' . $cammaConcatenated . PHP_EOL;
}


// this code tried to solve this StackOverflow question,
//   https://stackoverflow.com/questions/73538973/how-to-localize-a-list-of-items-in-php
// but the main point of the question is not spelling-out ordinals, but how to concatenate
// ordinals (or other elements) in locale specific way.
