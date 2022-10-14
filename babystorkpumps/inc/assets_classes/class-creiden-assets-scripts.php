<?php

class Creiden_Assets_Scripts extends Creiden_Assets {

	protected function _dequeue( $item ) {
		wp_dequeue_script( $item['id'] );
	}

	protected function _deregister( $item ) {
		wp_deregister_script( $item['id'] );
	}

	protected function _enqueue( $item ) {
		wp_enqueue_script( $item['id'] );
	}

	protected function _localize( $handle, $key, $i18n ) {
		wp_localize_script( $handle, $key, $i18n );
	}

	protected function _parse( $item ) {
		$item['in_footer'] = ! empty( $item['in_footer'] ) && $item['in_footer'];
		return $item;
	}

	protected function _query( $handle, $list = 'enqueued' ) {
		return wp_script_is( $handle, $list );
	}

	protected function _register( $item ) {
		wp_register_script( $item['id'], $item['src'], $item['deps'], $item['version'], $item['in_footer'] );
	}
}
