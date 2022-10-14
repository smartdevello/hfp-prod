<?php
/**
 * if you want to use creiden main assets loader create object from this class 
 */
class creiden_asset_init{
    protected $_config;
    protected $_styles;
    protected $_scripts;
    
    public function __construct(){
            $this->start_enqueue_assets();;
            add_filter( 'init', array( $this , '_creiden_themeoptions_filter_google_fonts') );
    }

    /**
     * start enqeue styles and scripts
     */
    public function start_enqueue_assets(){
           $this->_config = new Creiden_Config( trailingslashit( ASSETS_CLASSES ) . 'creiden-asset-config.php' );

           // setup styles
           $styles = $this->_config->get( 'assets.styles', array() );
           foreach ( $styles as $handle => $item ) {
                    $styles[ $handle ]['id'] = $handle;
           }
           $this->_styles = new Creiden_Assets_Styles( $styles, 'edialoug' );
    }

    public function _creiden_themeoptions_filter_google_fonts() {
            $fonts = creiden_google_fonts_concat();
            if ( ! empty( $fonts ) ) {
                    $this->_styles->add( array(
                            'id'         => 'extra-fonts',
                            'src'        => $fonts,
                            'conditions' => array( ! is_admin() ),
                    ) );
            }
    }

}
