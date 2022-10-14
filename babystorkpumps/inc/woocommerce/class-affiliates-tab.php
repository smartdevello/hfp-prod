<?php

class AffiliatesTab {
    private static $instance = null;

    public static function getInstance()
    {
      if (self::$instance == null)
      {
        self::$instance = new AffiliatesTab();
      }
   
      return self::$instance;
    }

    private function __construct()
    {
        add_action( "init", array( $this, "add_endpoint" ) );
        add_filter( "woocommerce_account_menu_items", array( $this, "link_my_account" ) );
        add_action( 'woocommerce_account_affiliates_endpoint', array( $this, "endpoint_content" ) );
    }

    function add_endpoint() {
        add_rewrite_endpoint( 'affiliates', EP_PAGES );
    }
  
    function link_my_account( $items ) {
    	$items = array_slice( $items, 0, 5, true ) + array( 'affiliates' => 'Referal Links' ) + array_slice( $items, 5, NULL, true );
        return $items;
    }
  
    function endpoint_content() {   

        echo do_shortcode('[affiliate_area_urls]');
        
    }
}

AffiliatesTab::getInstance();