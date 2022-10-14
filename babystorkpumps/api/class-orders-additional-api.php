<?php

class Orders_Additional_Api {

	public function __construct() {
            
		add_action( 'rest_api_init', function () {
			register_rest_route( 'wc/v3', '/orders/modified', array(
				'methods'  => 'GET',
				'callback' => [ $this, 'get_modified_orders' ],
				'permission_callback' => '__return_true'
			) );
		} );
	}

	public function get_modified_orders( $request ) {
		global $wpdb;

                    $query = "SELECT p.* "
                        . "FROM {$wpdb->posts} AS p "
                        . "INNER JOIN  {$wpdb->postmeta} AS pm ON( p.ID = pm.post_id) "
                        . "WHERE 1 = 1 "
                        . "AND pm.meta_key = 'order_modified_flag' "
                        . "AND pm.meta_value = 1 ";
                        
                    $query .= !empty( $request['limit'] ) ? "LIMIT " . $request['limit'] : "";
                    
		$orders = $wpdb->get_results( $query );

		return $orders;
	}
        
}

new Orders_Additional_Api();
