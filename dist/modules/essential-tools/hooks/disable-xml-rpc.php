<?php
// disable-xml-rpc.php

// Check if XML-RPC should be disabled
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );