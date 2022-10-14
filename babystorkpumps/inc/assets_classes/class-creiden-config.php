<?php

class Creiden_Config {

	protected $_data = array();

	public function __construct( $file ) {
		if ( ! $file ) {
			return;
		}
		$this->_data = (include $file);
	}

	/**
	 * Check if a config value exists using "dot" notation.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function has( $key ) {
		return ! is_null( $this->get( $key ) );
	}

	/**
	 * Get a config value using "dot" notation.
	 *
	 * @uses avaris_array_has()
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function get( $key, $default = null ) {
		$result = creiden_array_get( $this->_data, $key, $default );
		return apply_filters( 'avaris_config_get', $result, $key, $default );
	}

	/**
	 * Set a config item to a given value using "dot" notation.
	 *
	 * If no key is given to the method, the entire array will be replaced.
	 *
	 * @uses avaris_array_set()
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return array
	 */
	public function set( $key, $value ) {
		return $this->_data = avaris_array_set( $this->_data, $key, $value );
	}

	/**
	 * Add a config value using "dot" notation if it doesn't exist.
	 *
	 * @uses avaris_array_add()
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return array
	 */
	public function add( $key, $value ) {
		return $this->_data = avaris_array_add( $this->_data, $key, $value );
	}

	/**
	 * Remove one or many config items using "dot" notation.
	 *
	 * @uses avaris_array_forget()
	 *
	 * @param  array|string  $keys
	 * @return void
	 */
	public function forget( $keys ) {
		return $this->_data = avaris_array_forget( $this->_data, $keys );
	}
}
