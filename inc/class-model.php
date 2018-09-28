<?php

/**
 * The Notify For Wordpress model. This page collects and manages the data generated
 * by the notify feature.
 *
 * @package NFWP
 */

/**
 *
 *
 * @since 1.0.0
 */

 // Exit if file is accessed directly.
 if (! defined('ABSPATH')) {
     die();
 }

class Notify_For_Wordpress_Model
{

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @access private
     * @var string $version The current version of the plugin.
     */
    private $version;
    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    public function process_database() {

      //echo die('hello');

    }

}
