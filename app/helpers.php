<?php

function active_link($request, $link) {
    $res = $request()->is($link) ? 'active' : '';
    return $res;
}   