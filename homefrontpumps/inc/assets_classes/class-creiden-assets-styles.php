<?php

class Creiden_Assets_Styles extends Creiden_Assets {

	protected function _dequeue( $item ) {
		wp_dequeue_style( $item['id'] );
	}

	protected function _deregister( $item ) {
		wp_deregister_style( $item['id'] );
	}

	protected function _enqueue( $item ) {
		wp_enqueue_style( $item['id'] );
	}

	protected function _localize( $handle, $key, $i18n ) {
		wp_add_inline_style( $handle, $i18n );
	}

	protected function _parse( $item ) {
		$item['media'] = ! empty( $item['media'] ) ? esc_attr( $item['media'] ) : 'all';
		return $item;
	}

	protected function _query( $handle, $list = 'enqueued' ) {
		return wp_style_is( $handle, $list );
	}

	protected function _register( $item ) {
		wp_register_style( $item['id'], $item['src'], $item['deps'], $item['version'], $item['media'] );
		if ( ! empty( $item['extra'] ) ) {
			foreach ( $item['extra'] as $key => $value ) {
				wp_style_add_data( $item['id'], $key, $value );
			}
		}
	}
}
