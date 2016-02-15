<?php namespace App\Core;

/**
 * Hooks middleware
 */
class Utils
{

    //
    // Format a time string according to $time_format and time zones
    //
    public static function format_time($timestamp, $date_only = false, $time_only = false, $no_text = false)
    {
        if ($timestamp == '') {
            return 'Never';
        }

        $now = time();

        $date_format = 'Y-m-d';
        $time_format = 'H:i:s';

        $date = gmdate($date_format, $timestamp);
        $today = gmdate($date_format, $now);
        $yesterday = gmdate($date_format, $now-86400);

        if (!$no_text) {
            if ($date == $today) {
                $date = 'Today';
            } elseif ($date == $yesterday) {
                $date = 'Yesterday';
            }
        }

        if ($date_only) {
            return $date;
        } elseif ($time_only) {
            return gmdate($time_format, $timestamp);
        } else {
            return $date.' '.gmdate($time_format, $timestamp);
        }
    }
}
