<?php

namespace SSNepenthe\RecipeScraper\Formatters;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Interfaces\Formatter;

class Multi implements Formatter
{
    public function format(Crawler $crawler, array $config)
    {
        $locations = $config['locations'];

        $return = $crawler->each(function (Crawler $node, $i) use ($locations) {
            $values = $node->extract($locations);

            /**
             * Remove falsey values and normalize result...
             *
             * If 1 == count($locations), $values will contain strings,
             * otherwise $values will contain arrays.
             */
            if (is_array($values[0])) {
                $values = array_filter($values[0]);
            }


            return array_shift($values);
        });

        return array_values(array_filter($return));
    }
}
