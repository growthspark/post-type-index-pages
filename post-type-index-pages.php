<?php
/*
Plugin Name: Post Type Index Pages
Description: Adds the ability to set specific pages as the "index" page of any post type.
Version: 0.1
Author: Sean Butze
Author URI: http://seanbutze.com
*/

class Post_Type_Index_Pages {

    private $plugin_path;
    private $plugin_url;
    private $l10n;
    private $wpsf;
    private $settings_objects = array();

    function __construct() {	
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url = plugin_dir_url( __FILE__ );
        $this->l10n = 'wp-settings-framework';
        add_action( 'admin_menu', array(&$this, 'admin_menu'), 99 );
        add_action('init', array(&$this, 'settings_init'), 9999);
        require_once( $this->plugin_path .'functions.php' );
        require_once( $this->plugin_path .'settings.php' );
        add_action('admin_notices', array(&$this, 'admin_notices'));
    }

    function settings_init() {

        $post_types = get_post_types(array('public' => true)); 
        foreach ( $post_types as $post_type ) {
            $obj = get_post_type_object($post_type);
            $post_type_id = $obj->name;
            $post_type_name = $obj->labels->name;

            $options = array();
            $pages = get_posts(array('post_type' => 'page', 'orderby' => 'title', 'order' => 'ASC'));
            foreach ($pages as $page) {
                $options[$page->ID] = $page->post_title;
            }

            $settings = array();
            $settings[] = array(
                'section_id' => 'index',
                'section_title' => '',
                'section_description' => '',
                'section_order' => 5,
                'fields' => array(
                    array(
                        'id' => 'page',
                        'title' => 'Index Page',
                        'type' => 'select',
                        'choices' => $options
                    )
                )
            );

            $this->settings_objects[$post_type_id] = new PTIP_WordPressSettingsFramework( $settings, 'ptip-'.$post_type_id );
        }


        //add_filter( $this->wpsf->get_option_group() .'_settings_validate', array(&$this, 'validate_settings') );
    }
    
    function admin_menu() {
      
        $post_types = get_post_types(array('public' => true)); 
        foreach ( $post_types as $post_type ) {
            $obj = get_post_type_object($post_type);
            $post_type_id = $obj->name;
            $slug = 'edit.php';
            if ($post_type_id != 'post') $slug = 'edit.php?post_type='.$post_type_id;
            add_submenu_page( $slug, __( 'Index Page', $this->l10n ), __( 'Index Page', $this->l10n ), 'update_core', 'post-type-index-'.$post_type_id, array(&$this, 'settings_page') );
        }
       
    }
    
    function settings_page() {
	    // Your settings page
      $post_type_name = 'Posts';
      $post_type = 'post';
      if (isset($_GET['post_type'])) {
        $post_type_object = get_post_type_object($_GET['post_type']);
        $post_type_name = $post_type_object->labels->name;
        $post_type = $post_type_object->name;
      }
      $settings_group = 'ptip-'.$post_type;
      ?>
      <div class="wrap">
      <div id="icon-options-general" class="icon32"><br></div>
      <h2>Index Page: <?php echo $post_type_name; ?></h2>
      <?php
	  $this->settings_objects[$post_type]->settings();
      ?>
      </div><?php
		
	}
	
	function validate_settings( $input ) {
		$output = $input;
		//$output['coinbase_general_api_key'] = base64_encode($input['coinbase_general_api_key']);
    return $output;
	}

    /**
     * Displays any errors from the WordPress settings API
     */
    function admin_notices()
    {
        settings_errors();
    }
    

}
new Post_Type_Index_Pages();


?>