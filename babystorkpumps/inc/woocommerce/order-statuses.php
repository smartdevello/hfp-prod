<?php

add_filter('woocommerce_register_shop_order_post_statuses', function ( $statuses ) {
    
    $statuses['wc-data-needed'] = [
            'label'                     => _x( 'Data needed from mother', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Data needed from mother <span class="count">(%s)</span>', 'Data needed from mother<span class="count">(%s)</span>', 'woocommerce' ),
        ];
        $statuses['wc-verifying-data'] = [
            'label'                     => _x( 'Verifying Data', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Verifying Data <span class="count">(%s)</span>', 'Verifying Data <span class="count">(%s)</span>', 'woocommerce' ),
        ];
        $statuses['wc-wait-eligibility'] = [
            'label'                     => _x( 'Wait for Eligibility', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Wait for Eligibility<span class="count">(%s)</span>', 'Wait for Eligibility <span class="count">(%s)</span>', 'woocommerce' ),
        ];
        $statuses['wc-authorized'] = [
            'label'                     => _x( 'Authorized', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Authorized<span class="count">(%s)</span>', 'Authorized <span class="count">(%s)</span>', 'woocommerce' ),
        ];
        $statuses['wc-wait-prescription'] = [
            'label'                     => _x( 'Waiting on Prescription', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Waiting on Prescription<span class="count">(%s)</span>', 'Waiting on Prescription <span class="count">(%s)</span>', 'woocommerce' ),
        ];
        $statuses['wc-sent-to-warehouse'] = [
            'label'                     => _x( 'Sent to Warehouse', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Sent to Warehouse <span class="count">(%s)</span>', 'Sent to Warehouse <span class="count">(%s)</span>', 'woocommerce' ),
        ];
        $statuses['wc-shipped'] = [
            'label'                     => _x( 'Shipped', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'woocommerce' ),
        ];
        $statuses['wc-delivered'] = [
            'label'                     => _x( 'Delivered', 'Order status', 'woocommerce' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'      => true,
            'show_in_admin_status_list'   => true,
            'label_count'               => _n_noop( 'Delivered <span class="count">(%s)</span>', 'Delivered <span class="count">(%s)</span>', 'woocommerce' ),
        ];
        
        // Rename status
        $statuses['wc-pending']['label'] = _x( 'Pending Import', 'Order status', 'woocommerce' );
        $statuses['wc-pending']['label_count'] = _n_noop( 'Pending Import <span class="count">(%s)</span>', 'Pending Import <span class="count">(%s)</span>', 'woocommerce' );
   
        return $statuses;
});

add_filter( 'wc_order_statuses', function ( $order_statuses ) {
     
    $order_statuses['wc-data-needed'] = _x( 'Data needed from mother', 'Order status', 'woocommerce' );
    $order_statuses['wc-verifying-data'] = _x( 'Verifying Data', 'Order status', 'woocommerce' );
    $order_statuses['wc-wait-eligibility'] = _x( 'Wait for Eligibility', 'Order status', 'woocommerce' );
    $order_statuses['wc-authorized'] = _x( 'Authorized', 'Order status', 'woocommerce' );
    $order_statuses['wc-wait-prescription'] = _x( 'Waiting on Prescription', 'Order status', 'woocommerce' );
    $order_statuses['wc-sent-to-warehouse'] = _x( 'Sent to Warehouse', 'Order status', 'woocommerce' );
    $order_statuses['wc-shipped'] = _x( 'Shipped', 'Order status', 'woocommerce' );
    $order_statuses['wc-delivered'] = _x( 'Delivered', 'Order status', 'woocommerce' );
    // Rename status
    $order_statuses['wc-pending'] = _x( 'Pending Import', 'Order status', 'woocommerce' );
    
    return $order_statuses;
    
});
