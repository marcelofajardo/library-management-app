<?php

if (!function_exists('active_link')) {
    function active_link($request, $link) {
        return $request->is($link) ? 'active' : '';
    }   
}