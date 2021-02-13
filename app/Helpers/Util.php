<?php

namespace App\Helpers;

class Util {

    private static $periods = [
        'year' => 525600,
        'month' => 43800,
        'week' => 10080,
        'day' => 1440,
        'hour' => 60,
        'minute' => 1
    ];

    public static function minutesToWordsConverter($minutes) {
        if (!$minutes) {
            return '0 minutes';
        }
        $output = array();
        foreach (self::$periods as $period_name => $period) {
            $num_periods = floor($minutes / $period);
            if ($num_periods > 1) {
                $output[] = "$num_periods {$period_name}s";
            }
            elseif ($num_periods > 0) {
                $output[] = "$num_periods {$period_name}";
            }
            $minutes -= $num_periods * $period;
        }
        return implode(' : ', $output);
    }

}