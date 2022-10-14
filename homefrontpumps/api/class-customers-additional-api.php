<?php
// consumer key   ck_1fc1a08e85809c20d5c23da83dc5b165d2633002
//consuer secret cs_82a6d000f4d7f3bb554205e1c3c9e1aab689f7d1
class Customers_Additional_Api {

        public function __construct() {
                add_action( 'rest_api_init', function () {
                        register_rest_route( 'wc/v3', '/customers/date_modified', array(
                                'methods'  => 'POST',
                                'callback' => [ $this, 'get_customers_by_date_modified' ],
                                'permission_callback' => '__return_true',
                                'args'     => [
                                        'from' => [
                                                'required'          => true,
                                                'sanitize_callback' => 'esc_attr'
                                        ],
                                        'to'   => [
                                                'required'          => true,
                                                'sanitize_callback' => 'esc_attr'
                                        ]
                                ]
                        ) );
                } );
                add_action( 'rest_api_init', function () {
                        register_rest_route( 'wc/v3', '/customers/modified', array(
                                'methods'  => 'GET',
                                'callback' => [ $this, 'get_modified_customers' ],
                                'permission_callback' => '__return_true'
                        ) );
                } );
                add_action( 'rest_api_init', function () {
                        register_rest_route( 'wc/v3', '/customers/recently_updated', array(
                                'methods'  => 'GET',
                                'callback' => [ $this, 'get_recently_updated_customers' ],
                                'permission_callback' => '__return_true'
                        ) );
                } );

        }
        public function get_recently_updated_customers(){
                global $wpdb;
                $hours = 24;
                if ( isset($_GET['hours']) )
                        $hours = $_GET['hours'];

                $from   = date( "Y-m-d H:i:s", time() - 3600 * $hours );
                $to     = date( "Y-m-d H:i:s", time());

                $sql = "SELECT {$wpdb->users}.*, DATE_FORMAT(FROM_UNIXTIME({$wpdb->usermeta}.meta_value), '%Y-%m-%d %H:%i:%s') AS 'last_modified'  FROM {$wpdb->users} INNER JOIN  {$wpdb->usermeta} ON(
                        {$wpdb->users}.ID = {$wpdb->usermeta}.user_id) INNER JOIN {$wpdb->usermeta} AS mt1 ON {$wpdb->users}.ID = mt1.user_id WHERE
                    1 = 1 AND ( ( {$wpdb->usermeta}.meta_key = 'last_update' AND DATE_FORMAT(FROM_UNIXTIME({$wpdb->usermeta}.meta_value), '%Y-%m-%d %H:%i:%s') >= '{$from}')
                     AND ( mt1.meta_key = 'last_update' AND DATE_FORMAT(FROM_UNIXTIME({$wpdb->usermeta}.meta_value), '%Y-%m-%d %H:%i:%s') <= '{$to}') )
                    ORDER BY last_modified ASC";

                $users = $wpdb->get_results( $sql );
                return $users; 
        }
        public function get_customers_by_date_modified( $data ) {
                global $wpdb;
                $params = $data->get_params();
                $from   = date( "Y-m-d", strtotime( $params['from'] ) );
                $to     = date( "Y-m-d", strtotime( $params['to'] ) );

                $users = $wpdb->get_results( "SELECT {$wpdb->users}.*, DATE_FORMAT(FROM_UNIXTIME({$wpdb->usermeta}.meta_value), '%Y-%m-%d %H:%i:%s') AS 'last_modified'  FROM {$wpdb->users} INNER JOIN  {$wpdb->usermeta} ON(
                    {$wpdb->users}.ID = {$wpdb->usermeta}.user_id) INNER JOIN {$wpdb->usermeta} AS mt1 ON {$wpdb->users}.ID = mt1.user_id WHERE
                1 = 1 AND ( ( {$wpdb->usermeta}.meta_key = 'last_update' AND DATE_FORMAT(FROM_UNIXTIME({$wpdb->usermeta}.meta_value), '%Y-%m-%d') >= '{$from}')
                 AND ( mt1.meta_key = 'last_update' AND DATE_FORMAT(FROM_UNIXTIME({$wpdb->usermeta}.meta_value), '%Y-%m-%d') <= '{$to}') )
                ORDER BY user_login ASC" );

                return $users;
        }

        public function get_modified_customers( $request ) {
                global $wpdb;
                // Consumer Key ck_4e05e24331d43143bffa11698dbd64ac69568365
                // Consumer Secret cs_a4ff6b18aa63d91b4d7ea50b72d5564e7c356521
                    $formatted_gmt_offset = $this->get_formatted_gmt_offset();

                    $query = "SELECT u.*, "
                        . "CONVERT_TZ ( DATE_FORMAT( FROM_UNIXTIME( um2.meta_value ), '%Y-%m-%d %H:%i:%S' ), '$formatted_gmt_offset', '+00:00' ) AS date_modified_gmt "
                        . "FROM {$wpdb->users} AS u "
                        . "INNER JOIN  {$wpdb->usermeta} AS um ON( u.ID = um.user_id ) "
                        . "INNER JOIN  {$wpdb->usermeta} AS um2 ON( u.ID = um2.user_id ) "
                        . "WHERE 1 = 1 "
                        . "AND um.meta_key = 'user_modified_flag' "
                        . "AND um.meta_value = 1 "
                        . "AND um2.meta_key = 'last_update' "
                        . "ORDER BY user_login ASC ";

                    $query .= !empty( $request['limit'] ) ? "LIMIT " . $request['limit'] : "";

                $users = $wpdb->get_results( $query );

                return $users;
        }
        
        public function get_formatted_gmt_offset() {
                    $gmt_offset = get_option( 'gmt_offset' );
                    $seconds = $gmt_offset * 60 * 60;

                    if( $seconds < 0 ) { // -
                        $time = gmdate("H:i", $seconds * -1 );
                        $formatted_gmt_offset = "-" . "$time";
                    } else { // +
                        $time = gmdate("H:i", $seconds);
                        $formatted_gmt_offset = "+" . "$time";
                    }
                    
                    return $formatted_gmt_offset;
        }
        
}

new Customers_Additional_Api();
