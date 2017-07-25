<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//--------------------------------------------------------------------
// Profiler Sections
//--------------------------------------------------------------------
// Choose which sections you want to show up in your profiler bar.
//

$config['benchmarks'] = true;
$config['config'] = true;
$config['controller_info'] = true;
$config['get'] = true;
$config['http_headers'] = true;
$config['memory_usage'] = true;
$config['post'] = true;
$config['queries'] = true;
$config['eloquent'] = false;
$config['uri_string'] = true;
$config['view_data'] = true;
$config['query_toggle_count'] = 50;
