<?php
/**
 * Displays the admin interface for Notify For Wordpress.
 *
 * This is a partial template that is included by the Notify For Wordpress
 *
 *
 * @package NFWP
 */

$plugin_version = $this->version;
$change_over_year = $this->query_db_unchanged_posts();

echo "<h1>Notify dashboard</h1>";
echo "<h4>Set notifications to keep track of page updates and keep your content up-to-date</h4>";
echo "<br>";

echo '<pre>';
print_r($change_over_year);
echo '</pre>';

echo "<br>";
echo "<p>Notify for Wordpress plugin</p>";
echo "Version: " . $plugin_version;
