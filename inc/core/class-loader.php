<?php

namespace Notify_For_Wordpress\Inc\Core;

/**
 * The Notify For WordPress Loader is a class that is responsible for
 * coordinating all actions and filters used throughout the plugin
 *
 * @package NFWP
 */

/**
 * This class maintains two internal collections - one for actions, one for
 * hooks - each of which are coordinated through external classes that
 * register the various hooks through this class.
 *
 * @since 0.1.0
 */

class Loader
{

	/**
	 * A reference to the collection of actions used throughout the plugin.
	 *
	 * @access protected
	 * @var    array  $actions  The array of actions that are defined throughout the plugin.
	 */
	protected $actions;

	/**
	 * A reference to the collection of filters used throughout the plugin.
	 *
	 * @access protected
	 * @var    array   $actions  The array of filters that are defined throughout the plugin.
	 */
	protected $filters;

	/**
	 * Instantiates the plugin by setting up the data structures that will
	 * be used to maintain the actions and the filters.
	 */
	public function __construct() {
		$this->actions = [];
		$this->filters = [];
	}

	/**
	 * Registers the actions with WordPress and the respective objects and
	 * their methods.
	 *
	 * @param  string $hook        The name of the WordPress hook to which we're registering a callback.
	 * @param  object $component   The object that contains the method to be called when the hook is fired.
	 * @param  string $callback    The function that resides on the specified component.
	 * @param  int    $priority    Specifies the order in which the functions associated with a particular action is executed.
	 * @param  int    $args        The number of arguments the function accepts.
	 */
	public function add_action( $hook, $component, $callback, $priority = null, $args = null ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $args );
	}

	/**
	 * Registers the filters with WordPress and the respective objects and
	 * their methods.
	 *
	 * @param  string $hook        The name of the WordPress hook to which we're registering a callback.
	 * @param  object $component   The object that contains the method to be called when the hook is fired.
	 * @param  string $callback    The function that resides on the specified component.
	 * @param  int    $priority    Specifies the order in which the functions associated with a particular filter are executed.
	 * @param  int    $args        The number of arguments the function accepts.
	 */
	public function add_filter( $hook, $component, $callback, $priority = null, $args = null ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $args );
	}

	/**
	 * Registers the filters with WordPress and the respective objects and
	 * their methods.
	 *
	 * @access private
	 *
	 * @param  array  $hooks       The collection of existing hooks to add to the collection of hooks.
	 * @param  string $hook        The name of the WordPress hook to which we're registering a callback.
	 * @param  object $component   The object that contains the method to be called when the hook is fired.
	 * @param  string $callback    The function that resides on the specified component.
	 * @param  int    $priority    Order a associated particular filter/action is executed.
	 * @param  int    $args        The number of arguments the function accepts.
	 *
	 * @return array                  The collection of hooks that are registered with WordPress via this class.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority = null, $args = null ) {
		$hooks[] = [
			'hook'      => $hook,
			'component' => $component,
			'callback'  => $callback,
			'priority'  => $priority,
			'args'      => $args,
		];

		return $hooks;
	}

	/**
	 * Registers all of the defined filters and actions with WordPress.
	 */
	public function run() {
		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['args'] );
		}
	}
}
