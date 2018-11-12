<?php
/**
 * Created by PhpStorm.
 * User: chaselaw
 * Date: 2018/7/6
 * Time: 下午3:37
 */



if (! function_exists('dd')) {

    function dd($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

