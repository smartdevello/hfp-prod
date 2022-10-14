<?php

abstract class Creiden_Assets {

	protected $_data = array();
	protected $_prefix = '';

	/**
	 *
	 * @param array $initial predefined assets
	 * @param string $prefix
	 */
	public function __construct( $initial = array(), $prefix = '' ) {
		$this->_prefix = $prefix;
		// add initial assets
		$this->init( $initial );
		// wait for init to register assets
		add_action( 'init', array( $this, '_register_all' ) );
		// (wp|admin)_enqueue_scripts
		add_action( $this->enqueue_action(), array( $this, '_enqueue_all' ) );
	}


	public function _register_all() {
		foreach ( $this->_data as $item ) {
			$this->register( $item );
		}
	}

	public function _enqueue_all() {
		foreach ( $this->_data as $item ) {
			$this->enqueue( $item );
		}
	}

	/** Register an asset
	 *
	 * @param array $item {
	 *		@type string $id Asset handle.
	 *		@type string $src Asset URL.
	 *		@type array $deps array of dependencies.
	 *		@type string $version asset version number.
	 *		@type array $extra
	 *		@type array $localize data to localize for asset
	 *		@type array $conditions array of callables, if all return true asset
	 *					is enqueued, false nothing happens
	 * }
	 */
	public function add( $item ) {
		// hold the unprefixed id
		$handle = $item['id'];
		// use provided prefix
		$key = sanitize_key( ($this->_prefix ? $this->_prefix . '-' : '') . $handle );
		// sanitize $item, still using the unprefixed id
		$this->_data[ $key ] = $this->parse( $item );
		// override with the prefixed id
		$this->_data[ $key ]['id'] = $key;
		if ( did_action( 'init' ) ) {
			// init already fired, register now
			$this->register( $this->get( $handle ) );
		}
	}

	/** Deregister an asset
	 *
	 * @param string $handle
	 * @return void
	 */
	public function remove( $handle ) {
		if ( ! $this->has( $handle ) ) {
			return;
		}
		$item = $this->get( $handle );
		$this->deregister( $item );
		unset( $this->_data[ $item['id'] ] );
	}

	/** Localize data for an asset
	 *
	 * @param string $handle
	 * @param string $key
	 * @param array $i18n
	 * @return void
	 */
	public function localize( $handle, $key = '', $i18n = array() ) {
		if ( ! $this->has( $handle ) ) {
			return;
		}
		$item = $this->get( $handle );
		// if script is already done, we can't do anything
		// TODO: add support for late localization
		if ( ! $this->_query( $item['id'], 'done' ) ) {
			$this->_localize( $item['id'], $key, $i18n );
		}
	}

	/** parse an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	protected function parse( $item ) {
		$item = wp_parse_args( $item, array(
			'id'		 => '',
			'src'		 => '',
			'deps'		 => array(),
			'version'	 => '',
			'extra'		 => array(),
			'localize'	 => array(),
			'conditions' => array(),
		) );
		$item = array(
			'id'		 => $item['id'],
			'src'		 => esc_url( $item['src'] ),
			'deps'		 => is_array( $item['deps'] ) ? $item['deps'] : null,
			'version'	 => ! empty( $item['version'] ) ? $item['version'] : null,
			'extra'		 => is_array( $item['extra'] ) ? $item['extra'] : array(),
			'localize'	 => is_array( $item['localize'] ) ? $item['localize'] : array(),
			'conditions' => is_array( $item['conditions'] ) ? $item['conditions'] : array(),
		);
		return $this->_parse( $item );
	}

	/** Register an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	protected function register( $item ) {
		if ( $this->_query( $item['id'], 'registered' ) ) {
			return;
		}
		$this->_register( $item );
		if ( did_action( $this->enqueue_action() ) ) {
			$this->enqueue( $item );
		}
	}

	/** Register an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	protected function enqueue( $item ) {
		// start with "all green"
		$ok = true;
		if ( ! empty( $item['conditions'] ) ) {
			foreach ( $item['conditions'] as $cond ) {
				if ( ! is_callable( $cond ) ) {
					// maybe this is already evaluated
					$ok = $ok && (bool) $cond;
					continue;
				}
				$ok = $ok && call_user_func( $cond );
			}
		}
		// stop if we are not supposed to be here, or already enqueued
		if ( ! $ok || $this->_query( $item['id'], 'enqueued' ) ) {
			return;
		}
		$this->_enqueue( $item );
		// make sure the asset isn't done, before we localize
		if ( ! empty( $item['localize'] ) && ! $this->_query( $item['id'], 'done' ) ) {
			foreach ( (array) $item['localize'] as $key => $i18n ) {
				// TODO: why not use __CLASS__::localize()
				$this->_localize( $item['id'], $key, $i18n );
			}
		}
	}

	/** Deregister an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	protected function deregister( $item ) {
		if ( ! $this->_query( $item['id'], 'registered' ) ) {
			return;
		}
		$this->_deregister( $item );
	}

	/** Dequeue an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	protected function dequeue( $item ) {
		if ( ! $this->_query( $item['id'], 'enqueued' ) ) {
			return;
		}
		$this->_dequeue( $item );
	}

	/** initialize an array of assets
	 *
	 * @param array $initial
	 */
	protected function init( $initial ) {
		foreach ( (array) $initial as $item ) {
			$this->add( $item );
		}
	}

	/** get the enqueue action
	 *
	 * returns the corrent enqueue action for admin & fron-end pages
	 *
	 * @return string admin_enqueue_scripts if is_admin(), wp_enqueue_scripts otherwise
	 */
	protected function enqueue_action() {
		return is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
	}

	/** is handled registered
	 *
	 * @param string $handle
	 * @return bool
	 */
	protected function has( $handle ) {
		return ! is_null( $this->get( $handle ) );
	}

	/** get registered item by handle
	 *
	 * @param string $handle
	 * @return array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	protected function get( $handle ) {
		$key = sanitize_key( ($this->_prefix ? $this->_prefix . '-' : '') . $handle );
		if ( $this->_data[ $key ] ) {
			$item = $this->_data[ $key ];
			// don't bother if there is no prefix
			if ( ! empty( $item['deps'] ) && $this->_prefix ) {
				// replace registered deps with prefiexed ones
				foreach ( $item['deps'] as $index => $dep ) {
					$dep_key = sanitize_key( $this->_prefix . '-' . $dep );
					if ( isset( $this->_data[ $dep_key ] ) ) {
						// this dependency was registered through us, replace it
						$item['deps'][ $index ] = $dep_key;
					}
				}
			}
			return $item;
		}
		return null;
	}

	/** parse asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 * @return array $item
	 */
	abstract protected function _parse( $item );

	/** localize an object for asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	abstract protected function _localize( $handle, $key, $i18n );

	/** Register an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	abstract protected function _register( $item );

	/** deregsiter an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	abstract protected function _deregister( $item );

	/** enqueue an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	abstract protected function _enqueue( $item );

	/** Dequeue an asset
	 *
	 * @param array $item {
	 * 		@type string $id Asset handle.
	 * 		@type string $src Asset URL.
	 * 		@type array $deps array of dependencies.
	 * 		@type string $version asset version number.
	 * 		@type array $extra
	 * 		@type array $localize data to localize for asset
	 * 		@type array $conditions array of callables, if all return true asset
	 * 					is enqueued, false nothing happens
	 * }
	 */
	abstract protected function _dequeue( $item );

	/** Query asset status
	 *
	 * @param string $handle
	 * @param string $list
	 * @return bool
	 */
	abstract protected function _query( $handle, $list = 'enqueued' );
}
