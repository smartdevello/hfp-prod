<?php

add_action('init', 'schedule_sync_item_dmez');

function schedule_sync_item_dmez () {
    $scheduled = wp_next_scheduled( 'get_items_sync_dmez' );
    if ( ! $scheduled ) {
        wp_schedule_event( time(), 'daily', 'get_items_sync_dmez' );
    }
}


function get_items_sync_dmez() {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://dmez.us-east-1.elasticbeanstalk.com/api/payers.json?api_key=2c00cd3434f14892b5372c24a9581946',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
        ),
        CURLOPT_COOKIEJAR => 'dmez_cookies.txt',
        CURLOPT_COOKIEFILE => 'dmez_cookies.txt'
      ));
  
    $response = curl_exec($curl);
    curl_close($curl);
    // update_option('payer_json', $response, false);
    
    $data = json_decode($response);
    
    for($index = count($data) - 1; $index >=0; $index --) 
    {
        $payer = $data[$index];
  
        if ($payer->is_active !== true) {
            unset($data[$index]);
            continue;
        }
        for ($i = count($payer->items) -1; $i>=0; $i--) {
            $item = $payer->items[$i];
            $initial_order_max = $item->{'_joinData'}->initial_order_max;
            //if (isset($initial_order_max) && $initial_order_max > 0) {
            if (isset( $item->{'_joinData'}->displayinwc ) && $item->{'_joinData'}->displayinwc == true) {
                $sku = $item->sku;
                $hcpcs_code = $item->hcpcs_code;
    
            } else {
                unset($payer->items[$i]);
            }
        }
        if (isset($payer->kits)) {
            foreach($payer->kits as $key => $item) {
              if ($item->{'_joinData'}->displayinwc != true) continue;
              $item->sku = $item->woocommercesku;
              $payer->items[] = $item;
            }
        }
  
        if (count($payer->items) == 0)  {
            unset($data[$index]);
        }
  
    }
    $data = array_values($data);
    foreach($data as $payer){
        $payer->items = array_values($payer->items);
    }
    return $data;
}

function get_product_by_sku( $sku ) {

    global $wpdb;

    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

    if ( $product_id ) return new WC_Product( $product_id );

    return null;
}
