<?php

namespace App\Base;

use App\Models\Setting;
use Illuminate\Support\Str;



class Core
{
    static private $messages = [];

    static function discern_alert_temp($message, $alert_temp = "alert-info")
    {
        if (stristr($message, "alert-danger")) {
            return "alert-danger";
        } elseif (stristr($message, "alert-warning")) {
            return "alert-warning";
        } elseif (stristr($message, "alert-success")) {
            return "alert-success";
        } elseif (stristr($message, "alert-primary")) {
            return "alert-primary";
        } elseif (stristr($message, "alert-secondary")) {
            return "alert-secondary";
        } elseif (stristr($message, "alert-dark")) {
            return "alert-dark";
        } elseif (stristr($message, "alert-light")) {
            return "alert-light";
        } elseif (stristr($message, "alert-info")) {
            return "alert-info";
        }
        return $alert_temp;
    }

    static function add_message($msg, int $alert_temp = null, string $heading = null)
    {

        $temp = [
            "info", //0
            "primary", //1
            "warning", //2
            "light", //3
            "dark", //4
            "secondary", //5
            "danger", //6
            "success", //7
        ];
        // if (empty($msg)) return self::$message;

        $temp =  (!is_int($alert_temp)) ? self::discern_alert_temp($msg) : "alert-" . $temp[$alert_temp];

        while (Str::contains($msg, 'alert-')) {
            $msg = preg_replace_array('/alert-[a-z]+/', [''], $msg);
        }
        // if ((self::discern_alert_temp($msg) != 'alert-info' && (!stristr($msg, "alert-info")))) {
        //     $msg = '<p class="alert-body alert-' . $temp[$alert_temp] . '">' . $msg . '</p>';
        // }


        self::get_smessage();

        self::$messages[] = [$temp, $heading, $msg];

        session(['app_message' => self::$messages]);
    }
    public static function sround($num, $precission = 0)
    {
        $num = (float) $num;
        $main = (int) $num;
        $numf = number_format($num, 32);
        $sl = stripos($numf, ".");
        if ($sl) {
            $dec = substr($numf, $sl, $precission + 1);
            return $main . $dec;
        } else {
            return $main;
        }
    }
    public static function with_naira($val, $cut = true)
    {
        $val =  number_format(($cut) ? self::sround($val, 2) : round($val, 2), 2);
        return "&#x20A6;{$val}";
    }
    static function get_smessage()
    {
        return Core::$messages = session()->pull('app_message', Core::$messages);
    }

    static function nav_route($route,$as_url = false){
        return (($as_url && request()->url() === $route) || request()->routeIs($route.'*'))?" active ":" collapsed ";
    }

    static function clean_string($str, $html = false)
    {
        $n_s = filter_var($str, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH);
        if ($html) {
            return trim($n_s);
        }
        return trim(strip_tags($n_s)); //??$str;
    }

    static function page_title($pg_title)
    {
        return !empty($pg_title) ? Str::title($pg_title) . ' | ' . config('app.name', 'CG') : config('app.name', 'CG');
    }

    static function meta_var(array $config = [])
    {


        $canonical = $config['canonical'] ?? request()->fullUrl();
        // if (isset($property)) {
        $desc = '';
        $og_image_alt = config('app.name');
        // }

        $default_property_logo = asset('images/assets/icon/128.png');


        $title = Core::page_title($config['pg_title'] ?? $config['title'] ?? "");
        $og_title = Core::clean_string($title);
        $og_url = $canonical;
        $og_image = $default_property_logo;
        // $og_image_alt = $og_image_alt ?? "Property Image";
        $og_desc = $desc;

        $init['canonical'] = $canonical;
        $init['pg_title'] = $title;
        $init['desc'] = $config['desc'] ?? $desc;
        $init['og_title'] = $config['og_title'] ?? $og_title;
        $init['og_image'] = $config['og_image'] ?? $og_image;
        $init['og_image_alt'] = $config['og_image_alt'] ?? $og_image_alt;
        $init['og_url'] = $config['og_url'] ?? $og_url;
        $init['og_desc'] = $config['og_desc'] ?? $og_desc;
        // dump($config, $init);
        return $init;
    }
}
