<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images, 
sidebars, comments, ect.
*/
session_start();
// Get Bones Core Up & Running!
require_once('library/bones.php');            // core functions (don't remove)
require_once('library/plugins.php');          // plugins & extra functions (optional)

// Options panel
require_once('library/options-panel.php');

// Shortcodes
require_once('library/shortcodes.php');

// mbl
global $wpdb;
$site_url = site_url();
global $site_url;


// Admin Functions (commented out by default)
// require_once('library/admin.php');         // custom admin functions

// Custom Backend Footer
add_filter('admin_footer_text', 'bones_custom_admin_footer');
function bones_custom_admin_footer() {
	echo '<span id="footer-thankyou">Developed by <a href="http://320press.com" target="_blank">320press</a></span>. Built using <a href="http://themble.com/bones" target="_blank">Bones</a>.';
}

// adding it to the admin area
add_filter('admin_footer_text', 'bones_custom_admin_footer');

// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'wpbs-featured', 638, 300, true );
add_image_size( 'wpbs-featured-home', 970, 311, true);
add_image_size( 'wpbs-featured-carousel', 970, 400, true);
add_image_size( 'bones-thumb-600', 600, 150, false );
add_image_size( 'bones-thumb-300', 300, 100, true );
/* 
to add more sizes, simply copy a line from above 
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image, 
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'Main Sidebar',
    	'description' => 'Used on every page BUT the homepage page template.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => 'Homepage Sidebar',
    	'description' => 'Used only on the homepage page template.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
      'id' => 'footer1',
      'name' => 'Footer 1',
      'before_widget' => '<div id="%1$s" class="widget span4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));

    register_sidebar(array(
      'id' => 'footer2',
      'name' => 'Footer 2',
      'before_widget' => '<div id="%1$s" class="widget span4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));

    register_sidebar(array(
      'id' => 'footer3',
      'name' => 'Footer 3',
      'before_widget' => '<div id="%1$s" class="widget span4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));
    
    
    /* 
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call 
    your new sidebar just use the following code:
    
    Just change the name to whatever your new
    sidebar's id is, for example:
    
    
    
    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php
    
    */
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<div class="comment-author vcard row-fluid clearfix">
				<div class="avatar span2">
					<?php echo get_avatar($comment,$size='75',$default='<path_to_url>' ); ?>
				</div>
				<div class="span10 comment-text">
					<?php printf(__('<h4>%s</h4>','bonestheme'), get_comment_author_link()) ?>
					<?php edit_comment_link(__('Edit','bonestheme'),'<span class="edit-comment btn btn-small btn-info"><i class="icon-white icon-pencil"></i>','</span>') ?>
                    
                    <?php if ($comment->comment_approved == '0') : ?>
       					<div class="alert-message success">
          				<p><?php _e('Your comment is awaiting moderation.','bonestheme') ?></p>
          				</div>
					<?php endif; ?>
                    
                    <?php comment_text() ?>
                    
                    <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
                    
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
			</div>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

// Display trackbacks/pings callback function
function list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
?>
        <li id="comment-<?php comment_ID(); ?>"><i class="icon icon-share-alt"></i>&nbsp;<?php comment_author_link(); ?>
<?php 

}

// Only display comments in comment count (which isn't currently displayed in wp-bootstrap, but i'm putting this in now so i don't forget to later)
add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
	    $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
	    return count($comments_by_type['comment']);
	} else {
	    return $count;
	}
}

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search the Site..." />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search','bonestheme') .'" />
    </form>';
    return $form;
} // don't remove this bracket!

/****************** password protected post form *****/

add_filter( 'the_password_form', 'custom_password_form' );

function custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o = '<div class="clearfix"><form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
	' . __( "<p>This post is password protected. To view it please enter your password below:</p>" ,'bonestheme') . '
	<label for="' . $label . '">' . __( "Password:" ,'bonestheme') . ' </label><div class="input-append"><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" class="btn btn-primary" value="' . esc_attr__( "Submit",'bonestheme' ) . '" /></div>
	</form></div>
	';
	return $o;
}

/*********** update standard wp tag cloud widget so it looks better ************/

add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );

function my_widget_tag_cloud_args( $args ) {
	$args['number'] = 20; // show less tags
	$args['largest'] = 9.75; // make largest and smallest the same - i don't like the varying font-size look
	$args['smallest'] = 9.75;
	$args['unit'] = 'px';
	return $args;
}



// filter tag clould output so that it can be styled by CSS
function add_tag_class( $taglinks ) {
    $tags = explode('</a>', $taglinks);
    $regex = "#(.*tag-link[-])(.*)(' title.*)#e";
        foreach( $tags as $tag ) {
        	$tagn[] = preg_replace($regex, "('$1$2 label tag-'.get_tag($2)->slug.'$3')", $tag );
        }
    $taglinks = implode('</a>', $tagn);
    return $taglinks;
}

add_action('wp_tag_cloud', 'add_tag_class');

add_filter('wp_tag_cloud','wp_tag_cloud_filter', 10, 2);

function wp_tag_cloud_filter($return, $args)
{
  return '<div id="tag-cloud">'.$return.'</div>';
}

// Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

// Disable jump in 'read more' link
function remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');

// Remove height/width attributes on images so they can be responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

// Add the Meta Box to the homepage template
function add_homepage_meta_box() {  
	global $post;
	// Only add homepage meta box if template being used is the homepage template
	// $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : "");
	$post_id = $post->ID;
	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
	if ($template_file == 'page-homepage.php')
	{
	    add_meta_box(  
	        'homepage_meta_box', // $id  
	        'Optional Homepage Tagline', // $title  
	        'show_homepage_meta_box', // $callback  
	        'page', // $page  
	        'normal', // $context  
	        'high'); // $priority  
    }
}  
add_action('add_meta_boxes', 'add_homepage_meta_box');

// Field Array  
$prefix = 'custom_';  
$custom_meta_fields = array(  
    array(  
        'label'=> 'Homepage tagline area',  
        'desc'  => 'Displayed underneath page title. Only used on homepage template. HTML can be used.',  
        'id'    => $prefix.'tagline',  
        'type'  => 'textarea' 
    )  
);  

// The Homepage Meta Box Callback  
function show_homepage_meta_box() {  
global $custom_meta_fields, $post;  
// Use nonce for verification  
  wp_nonce_field( basename( __FILE__ ), 'wpbs_nonce' );
    
    // Begin the field table and loop  
    echo '<table class="form-table">';  
    foreach ($custom_meta_fields as $field) {  
        // get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);  
        // begin a table row with  
        echo '<tr> 
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
                <td>';  
                switch($field['type']) {  
                    // text  
                    case 'text':  
                        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="60" /> 
                            <br /><span class="description">'.$field['desc'].'</span>';  
                    break;
                    
                    // textarea  
                    case 'textarea':  
                        echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="80" rows="4">'.$meta.'</textarea> 
                            <br /><span class="description">'.$field['desc'].'</span>';  
                    break;  
                } //end switch  
        echo '</td></tr>';  
    } // end foreach  
    echo '</table>'; // end table  
}  

// Save the Data  
function save_homepage_meta($post_id) {  
    global $custom_meta_fields;  
  
    // verify nonce  
    if (!isset( $_POST['wpbs_nonce'] ) || !wp_verify_nonce($_POST['wpbs_nonce'], basename(__FILE__)))  
        return $post_id;  
    // check autosave  
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
        return $post_id;  
    // check permissions  
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }  
  
    // loop through fields and save the data  
    foreach ($custom_meta_fields as $field) {  
        $old = get_post_meta($post_id, $field['id'], true);  
        $new = $_POST[$field['id']];  
        if ($new && $new != $old) {  
            update_post_meta($post_id, $field['id'], $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id, $field['id'], $old);  
        }  
    } // end foreach  
}  
add_action('save_post', 'save_homepage_meta');  

// Add thumbnail class to thumbnail links
function add_class_attachment_link($html){
    $postid = get_the_ID();
    $html = str_replace('<a','<a class="thumbnail"',$html);
    return $html;
}
add_filter('wp_get_attachment_link','add_class_attachment_link',10,1);

// Add lead class to first paragraph
function first_paragraph($content){
    global $post;

    // if we're on the homepage, don't add the lead class to the first paragraph of text
    if( is_page_template( 'page-homepage.php' ) )
        return $content;
    else
        return preg_replace('/<p([^>]+)?>/', '<p$1 class="lead">', $content, 1);
}
add_filter('the_content', 'first_paragraph');

// Menu output mods
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			
			$class_names = $value = '';
			
			// If the item has children, add the dropdown class for bootstrap
			if ( $args->has_children ) {
				$class_names = "dropdown ";
			}
			
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			
			$class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="'. esc_attr( $class_names ) . '"';
           
           	$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           	$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           	$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           	$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           	$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
           	// if the item has children add these two attributes to the anchor tag
           	if ( $args->has_children ) {
				$attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
			}

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            // if the item has children add the caret just before closing the anchor tag
            if ( $args->has_children ) {
            	$item_output .= '<b class="caret"></b></a>';
            }
            else{
            	$item_output .= '</a>';
            }
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
            
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
        }
            
      	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
      	    {
      	        $id_field = $this->db_fields['id'];
      	        if ( is_object( $args[0] ) ) {
      	            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
      	        }
      	        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
      	    }
      	
            
}

add_editor_style('editor-style.css');

// Add Twitter Bootstrap's standard 'active' class name to the active nav link item

add_filter('nav_menu_css_class', 'add_active_class', 10, 2 );
function add_active_class($classes, $item) {
	if($item->menu_item_parent == 0 && in_array('current-menu-item', $classes)) {
        $classes[] = "active";
	}
    return $classes;
}

// enqueue styles

function theme_styles()  
{ 
    // This is the compiled css file from LESS - this means you compile the LESS file locally and put it in the appropriate directory if you want to make any changes to the master bootstrap.css.
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/library/css/bootstrap.css', array(), '1.0', 'all' );
    wp_register_style( 'bootstrap-responsive', get_template_directory_uri() . '/library/css/responsive.css', array(), '1.0', 'all' );
    wp_register_style( 'wp-bootstrap', get_template_directory_uri() . '/style.css', array(), '1.0', 'all' );
    
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'bootstrap-responsive' );
    wp_enqueue_style( 'wp-bootstrap');
}
add_action('wp_enqueue_scripts', 'theme_styles');

// enqueue javascript

function theme_js(){
  // wp_register_script('less', get_template_directory_uri().'/library/js/less-1.3.0.min.js');

  wp_deregister_script('jquery'); // initiate the function  
  wp_register_script('jquery', get_template_directory_uri().'/library/js/libs/jquery-1.7.1.min.js', false, '1.7.1');
  //wp_register_script('jquery', get_template_directory_uri().'/library/js/libs/jquery-1.10.1.min.js', false, '1.10.1');
  // wp_register_script('jquery', get_template_directory_uri().'/library/js/libs/jquery-migrate-1.1.1.min.js');
  
  wp_register_script('bootstrap', get_template_directory_uri().'/library/js/bootstrap.min.js');
  // wp_register_script('bootstrap-button', get_template_directory_uri().'/library/js/bootstrap-button.js');
  // wp_register_script('bootstrap-carousel', get_template_directory_uri().'/library/js/bootstrap-carousel.js');
  // wp_register_script('bootstrap-collapse', get_template_directory_uri().'/library/js/bootstrap-collapse.js');
  // wp_register_script('bootstrap-dropdown', get_template_directory_uri().'/library/js/bootstrap-dropdown.js');
  // wp_register_script('bootstrap-modal', get_template_directory_uri().'/library/js/bootstrap-modal.js');
  // wp_register_script('bootstrap-popover', get_template_directory_uri().'/library/js/bootstrap-popover.js');
  // wp_register_script('bootstrap-scrollspy', get_template_directory_uri().'/library/js/bootstrap-scrollspy.js');
  // wp_register_script('bootstrap-tab', get_template_directory_uri().'/library/js/bootstrap-tab.js');
  // wp_register_script('bootstrap-tooltip', get_template_directory_uri().'/library/js/bootstrap-tooltip.js');
  // wp_register_script('bootstrap-transition', get_template_directory_uri().'/library/js/bootstrap-transition.js');
  // wp_register_script('bootstrap-typeahead', get_template_directory_uri().'/library/js/bootstrap-typeahead.js');

  wp_register_script('wpbs-scripts', get_template_directory_uri().'/library/js/scripts.js');
  wp_register_script('modernizr', get_template_directory_uri().'/library/js/modernizr.full.min.js');

  // wp_enqueue_script('less', array(''), '1.3.0', true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('bootstrap', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-button', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-carousel', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-collapse', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-dropdown', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-modal', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-tooltip', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-popover', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-scrollspy', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-tab', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-transition', array('jQuery'), '1.1', true);
  // wp_enqueue_script('bootstrap-typeahead', array('jQuery'), '1.1', true);
  wp_enqueue_script('wpbs-scripts', array('jQuery'), '1.1', true);
  wp_enqueue_script('modernizr', array('jQuery'), '1.1', true);
}
add_action('wp_enqueue_scripts', 'theme_js');

// Get theme options
function get_wpbs_theme_options(){
  $theme_options_styles = '';
    
      $heading_typography = of_get_option('heading_typography');
      if ( $heading_typography['face'] != 'Default' ) {
        $theme_options_styles .= '
        h1, h2, h3, h4, h5, h6{ 
          font-family: ' . $heading_typography['face'] . '; 
          font-weight: ' . $heading_typography['style'] . '; 
          color: ' . $heading_typography['color'] . '; 
        }';
      }
      
      $main_body_typography = of_get_option('main_body_typography');
      if ( $main_body_typography['face'] != 'Default' ) {
        $theme_options_styles .= '
        body{ 
          font-family: ' . $main_body_typography['face'] . '; 
          font-weight: ' . $main_body_typography['style'] . '; 
          color: ' . $main_body_typography['color'] . '; 
        }';
      }
      
      $link_color = of_get_option('link_color');
      if ($link_color) {
        $theme_options_styles .= '
        a{ 
          color: ' . $link_color . '; 
        }';
      }
      
      $link_hover_color = of_get_option('link_hover_color');
      if ($link_hover_color) {
        $theme_options_styles .= '
        a:hover{ 
          color: ' . $link_hover_color . '; 
        }';
      }
      
      $link_active_color = of_get_option('link_active_color');
      if ($link_active_color) {
        $theme_options_styles .= '
        a:active{ 
          color: ' . $link_active_color . '; 
        }';
      }
      
      $topbar_position = of_get_option('nav_position');
      if ($topbar_position == 'scroll') {
        $theme_options_styles .= '
        .navbar{ 
          position: static; 
        }
        body{
          padding-top: 0;
        }
        ' 
        ;
      }
      
      $topbar_bg_color = of_get_option('top_nav_bg_color');
      if ( $topbar_bg_color ) {
        $theme_options_styles .= '
        .navbar-inner, .navbar .fill { 
          background-color: '. $topbar_bg_color . ';
        }' . $topbar_bg_color;
      }
      
      $use_gradient = of_get_option('showhidden_gradient');
      if ($use_gradient) {
        $topbar_bottom_gradient_color = of_get_option('top_nav_bottom_gradient_color');
      
        $theme_options_styles .= '
        .navbar-inner, .navbar .fill {
          background-image: -khtml-gradient(linear, left top, left bottom, from(' . $topbar_bg_color . '), to('. $topbar_bottom_gradient_color . '));
          background-image: -moz-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          background-image: -ms-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ' . $topbar_bg_color . '), color-stop(100%, '. $topbar_bottom_gradient_color . '));
          background-image: -webkit-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . '2);
          background-image: -o-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          background-image: linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $topbar_bg_color . '\', endColorstr=\''. $topbar_bottom_gradient_color . '2\', GradientType=0);
        }';
      }
      else{
      } 
      
      $topbar_link_color = of_get_option('top_nav_link_color');
      if ($topbar_link_color) {
        $theme_options_styles .= '
        .navbar .nav li a { 
          color: '. $topbar_link_color . ';
        }';
      }
      
      $topbar_link_hover_color = of_get_option('top_nav_link_hover_color');
      if ($topbar_link_hover_color) {
        $theme_options_styles .= '
        .navbar .nav li a:hover { 
          color: '. $topbar_link_hover_color . ';
        }';
      }
      
      $topbar_dropdown_hover_bg_color = of_get_option('top_nav_dropdown_hover_bg');
      if ($topbar_dropdown_hover_bg_color) {
        $theme_options_styles .= '
          .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover {
            background-color: ' . $topbar_dropdown_hover_bg_color . ';
          }
        ';
      }
      
      $topbar_dropdown_item_color = of_get_option('top_nav_dropdown_item');
      if ($topbar_dropdown_item_color){
        $theme_options_styles .= '
          .dropdown-menu a{
            color: ' . $topbar_dropdown_item_color . ' !important;
          }
        ';
      }
      
      $hero_unit_bg_color = of_get_option('hero_unit_bg_color');
      if ($hero_unit_bg_color) {
        $theme_options_styles .= '
        .hero-unit { 
          background-color: '. $hero_unit_bg_color . ';
        }';
      }
      
      $suppress_comments_message = of_get_option('suppress_comments_message');
      if ($suppress_comments_message){
        $theme_options_styles .= '
        #main article {
          border-bottom: none;
        }';
      }
      
      $additional_css = of_get_option('wpbs_css');
      if( $additional_css ){
        $theme_options_styles .= $additional_css;
      }
          
      if($theme_options_styles){
        echo '<style>' 
        . $theme_options_styles . '
        </style>';
      }
    
      $bootstrap_theme = of_get_option('wpbs_theme');
      $use_theme = of_get_option('showhidden_themes');
      
      if( $bootstrap_theme && $use_theme ){
        if( $bootstrap_theme == 'default' ){}
        else {
          echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/admin/themes/' . $bootstrap_theme . '.css">';
        }
      }
} // end get_wpbs_theme_options function

/*
	Allocation updates on new, edit and delete(?)
*/

/* 
	Accumulate selling price,and discounts by category
*/
	
function update_sp_accum($project_id){
	global $wpdb;

	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	$projects = $wpdb->get_results( "SELECT * FROM wp_gl_proj WHERE gl_proj_id = $project_id", ARRAY_A );
	
	$fv_sp_accum = 0;
	$gu_sp_accum = 0;
	$em_sp_accum = 0;
	$sw_sp_accum = 0;
	$fr_sp_accum = 0;
	$fm_sp_accum = 0;
	$ls_sp_accum = 0;
	$hv_sp_accum = 0;
	$other_sp_accum = 0;
	$swsu_accum = 0;
	$sfp_amt_accum = 0;
	$sfp_disc_accum = 0;
	$ufp_disc_accum = 0;
	$ufp_max_rate = 0;
	
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			$category = $element['rr_el_meth_cat'];
			$disc_category = $element['rr_el_disc_cat'];
			switch ($category){
				case 1:
					switch ($disc_category){
						case 1:
							$sfp_amt_accum = $sfp_amt_accum + $element['rr_el_sfp_amt'];
							$sfp_disc_accum = $sfp_disc_accum + $element['rr_el_disc_amt'];
							break;
						case 2:
							$ufp_disc_accum = $ufp_disc_accum + $element['rr_el_disc_amt'];
							if ($element['rr_el_disc_rate'] > $ufp_max_rate){
								$ufp_max_rate = $element['rr_el_disc_rate'];
							}
							break;
						default:
							$other_sp_accum = $other_sp_accum + $element['rr_el_sell_price'];
							break;
					}
					break;
				case 2: 
					switch ($disc_category){
						case 1:
							$sw_sfp_amt_accum = $sw_sfp_amt_accum + $element['rr_el_sfp_amt'];
							$sw_sfp_disc_accum = $sw_sfp_disc_accum + $element['rr_el_disc_amt'];
							break;
						case 2:
							$sw_ufp_disc_accum = $sw_ufp_disc_accum + $element['rr_el_disc_amt'];
							if ($element['rr_el_disc_rate'] > $sw_ufp_max_rate){
								$sw_ufp_max_rate = $element['rr_el_disc_rate'];
							}
							break;
						case 3:
							$sw_su_accum = $sw_su_accum + $element['rr_el_sell_price'];
							break;
						default:
							$sw_sp_accum = $sw_sp_accum + $element['rr_el_sell_price'];
							break;
					}
					break;
				case 3: 
					$ls_sp_accum = $ls_sp_accum + $element['rr_el_sell_price'];
					break;
				case 4: 
					$fr_sp_accum = $fr_sp_accum + $element['rr_el_sell_price'];
					break;
				case 5: 
					$gu_sp_accum = $gu_sp_accum + $element['rr_el_sell_price'];
					break;
				case 6: 
					$fm_sp_accum = $fm_sp_accum + $element['rr_el_sell_price'];
					break;
				case 7: 
					$em_sp_accum = $em_sp_accum + $element['rr_el_sell_price'];
					break;
				case 8: 
					$fv_sp_accum = $fv_sp_accum + $element['rr_el_sell_price'];
					break;
				case 9: 
					$hv_sp_accum = $hv_sp_accum + $element['rr_el_sell_price'];
					break;
				default:
					$other_sp_accum = $other_sp_accum + $element['rr_el_sell_price'];
					break;
			}
		}
	}
	
	$sp_accum_array = array( 'other' => $other_sp_accum, 'other_sfp_amt' => $sfp_amt_accum, 'other_sfp_disc_amt' => $sfp_disc_accum,
		'other_ufp_disc_amt' => $ufp_disc_accum, 'other_ufp_disc_rate' => $ufp_max_rate, 'sw_sfp_amt' => $sw_sfp_amt_accum, 
		'sw_sfp_disc_amt' => $sw_sfp_disc_accum, 'sw_ufp_disc_amt' => $sw_ufp_disc_accum, 'sw_ufp_disc_rate' => $sw_ufp_max_rate, 'sw' => $sw_sp_accum, 
		'swsu' => $sw_su_accum, 'ls' => $ls_sp_accum, 'fr' => $fr_sp_accum, 'gu' => $gu_sp_accum, 'fm' => $fm_sp_accum, 'em' => $em_sp_accum, 
		'fv' => $fv_sp_accum, 'hv' => $hv_sp_accum );
	
	return $sp_accum_array;
}

/* 
	Allocate arrangement fee by category
*/

function update_cat_alloc($project_id, $sp_accum_array){
	global $wpdb; 
	
	$projects = $wpdb->get_results( "SELECT * FROM wp_gl_proj WHERE gl_proj_id = $project_id", ARRAY_A );
	$project_fee = $projects[0]['gl_proj_fee'];
	
	$fv_sp_accum = $sp_accum_array['fv'];
	$gu_sp_accum = $sp_accum_array['gu'];
	$em_sp_accum = $sp_accum_array['em'];
	$sw_sp_accum = $sp_accum_array['sw'];
	$fr_sp_accum = $sp_accum_array['fr'];
	$fm_sp_accum = $sp_accum_array['fm'];
	$ls_sp_accum = $sp_accum_array['ls'];
	$hv_sp_accum = $sp_accum_array['hv'];
	$other_sp_accum = $sp_accum_array['other'];
	$sw_su_accum = $sp_accum_array['swsu'];
	
	// Fair value financial instruments
	if ($fv_sp_accum <= $project_fee){ 
		$fv_alloc = $fv_sp_accum;
		$rem_fee = $project_fee - $fv_alloc;
	} else {
		$fv_alloc = $project_fee;
		$rem_fee = 0;
	}
	
	// Guarantees
	if ($gu_sp_accum <= $rem_fee){
		$gu_alloc = $gu_sp_accum;
		$rem_fee = $rem_fee - $gu_alloc;
	} else {
		$gu_fee = $rem_fee;
		$rem_fee = 0;
	}

	// Extended maintenance agreements
	if ($em_sp_accum <= $rem_fee){
		$em_alloc = $em_sp_accum;
		$rem_fee = $rem_fee - $em_alloc;
	} else {
		$em_fee = $rem_fee;
		$rem_fee = 0;
	}
	
	// Categories based on relative selling price
	$combined_sp_accum = $sw_sp_accum + $fr_sp_accum + $fm_sp_accum + $ls_sp_accum + $hv_sp_accum + $other_sp_accum;
	echo '$combined_sp_accum: ' .$combined_sp_accum;
	
	$sw_alloc = $rem_fee * $sw_sp_accum / $combined_sp_accum;
	$fr_alloc = $rem_fee * $fr_sp_accum / $combined_sp_accum;
	$fm_alloc = $rem_fee * $fm_sp_accum / $combined_sp_accum;
	$ls_alloc = $rem_fee * $ls_sp_accum / $combined_sp_accum;
	$hv_alloc = $rem_fee * $hv_sp_accum / $combined_sp_accum;
	$other_alloc = $rem_fee - $sw_alloc - $fr_alloc - $fm_alloc - $ls_alloc - $hv_alloc;
	
	$cat_alloc_array = array();
	$cat_alloc_array = array( 'other' => $other_alloc, 'sw' => $sw_alloc,
		'ls' => $ls_alloc, 'fr' => $fr_alloc, 'gu' => $gu_alloc, 'fm' => $fm_alloc, 'em' => $em_alloc, 'fv' => $fv_alloc,
		'hv' => $hv_alloc );
	
	return $cat_alloc_array;
}

/* 
	Accumulate selling price and discounts to each element within category
*/

function update_allocation($project_id, $cat_alloc_array, $sp_accum_array){
	global $wpdb;
	
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	$projects = $wpdb->get_results( "SELECT * FROM wp_gl_proj WHERE gl_proj_id = $project_id", ARRAY_A );
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	
	$project_fee = $projects[0]['gl_proj_fee'];
	
	foreach ($project_metas as $project_meta){
		$key = $project_meta['gl_proj_meta_key'];
		switch ($key){
			case '_proj_sfp_amt':
				$proj_sfp_amt = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_ufp_disc_amt':
				$proj_ufp_disc_amt = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_ufp_disc_rate':
				$proj_ufp_disc_rate = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sfswp_amt':
				$proj_swsfp_amt = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_ufswp_disc_amt':
				$proj_swufp_disc_amt = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_ufswp_disc_rate':
				$proj_swufp_disc_rate = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_undeliv_vsoe_amt':
				$proj_sw_undeliv_vsoe_amt = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_undeliv_vsoe_flag':
				$proj_sw_undeliv_vsoe_flag = $project_meta['gl_proj_meta_value'];
				break;
			default:
				break;
		}
	}
	
	// allocate category fee to each category element
	
	$elements_array = array();
	
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			$category = $element['rr_el_meth_cat'];
			$disc_category = $element['rr_el_disc_cat'];
			switch ($category){
				case 1: 
					switch ($disc_category){
							// specified future purchase discount
						case 1:
							$el_amt = $element['rr_el_disc_amt'] - $element['rr_el_sfp_amt'] / ($sp_accum_array['other'] + $sp_accum_array['other_sfp_amt']) * $element['rr_el_disc_amt'];
							$el_contingent = 0;
							break;
							
							// unspecified future purchase discount
						case 2:
							if ($element['rr_el_disc_amt'] > 0){
								$el_amt = $element['rr_el_disc_amt'];
							} else if ($element['rr_el_disc_rate'] > 0 && $element['rr_el_disc_rate'] >= $sp_accum_array['other_ufp_disc_rate']){
								$el_amt = ($cat_alloc_array['other'] - $sp_accum_array['other_ufp_disc_amt']) * $sp_accum_array['other_ufp_disc_rate'];
							} else {
								$el_amt = 0;
							}
							$el_contingent = 0;
							break;
						
						default:
							$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['other'];
							$el_amt = $cat_alloc_array['other'] * $el_percent;
							$el_amt = $el_amt - $sp_accum_array['other_ufp_disc_amt'] * $el_percent;
							$el_amt = $el_amt * (1 - $other_ufp_disc_rate);
							$el_amt = $el_amt - $element['rr_el_sell_price'] / ($sp_accum_array['other'] + $other_sfp_amt) * $sp_accum_array['other_sfp_disc_amt'];
							if ($element['rr_el_sp_cont'] <= $el_amt){
								$el_contingent = $element['rr_el_sp_cont'];
							} else {
								$el_contingent = $el_percent * $element['rr_el_sp_cont'];
							}
							break;
						}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				case 2: 
					switch ($disc_category){
							// specified future purchase discount // add conditions to handle VSOE status
						case 1:
						
							$el_amt = $element['rr_el_disc_amt'] - $element['rr_el_sfp_amt'] / ($sp_accum_array['sw'] + $sp_accum_array['sw_sfp_amt'] - $proj_sw_undeliv_vsoe_amt) * $element['rr_el_disc_amt'];
							$el_contingent = 0;
							break;
							
							// unspecified future purchase discount
						case 2:
							if ($element['rr_el_disc_amt'] > 0){
								$el_amt = $element['rr_el_disc_amt'];
							} else if ($element['rr_el_disc_rate'] > 0 && $element['rr_el_disc_rate'] >= $sp_accum_array['sw_ufp_disc_rate']){
								$el_amt = ($cat_alloc_array['sw'] - $sp_accum_array['sw_ufp_disc_amt']  - $sw_undeliv_vsoe_amt) * $sp_accum_array['sw_ufp_disc_rate'];
							} else {
								$el_amt = 0;
							}
							$el_contingent = 0;
							break;
							
							// specified software upgrade
						case 3:
							$el_amt = $element['rr_el_sell_price'];
							$el_contingent = 0;
							break;							
						default:
							if ($sw_undeliv_vsoe_flag == 1 && $element['rr_el_odt_2'] < 1 && $element['rr_el_dt_2'] < 1){ // if residual method and undelivered element
								$el_amt = $element['rr_el_sell_price'];	
							} else {
								$el_percent = $element['rr_el_sell_price'] / ($sp_accum_array['sw'] - $sw_undeliv_vsoe_amt);
								$el_amt = ($cat_alloc_array['sw'] - $sp_accum_array['swsu'] - $sw_undeliv_vsoe_amt) * $el_percent;
								$el_amt = $el_amt - $sp_accum_array['sw_ufp_disc_amt'] * $el_percent;
								$el_amt = $el_amt - (($cat_alloc_array['sw'] - $sp_accum_array['sw_ufp_disc_amt'] - $sw_undeliv_vsoe_amt) * $sp_accum_array['sw_ufp_disc_rate']) * $el_percent;
								$el_amt = $el_amt - $element['rr_el_sell_price'] / ($sp_accum_array['sw'] - $sw_undeliv_vsoe_amt + $sp_accum_array['sw_sfp_amt']) * $sp_accum_array['sw_sfp_disc_amt'];
							}
							break;
						}
						if ($element['rr_el_sp_cont'] <= $el_amt){
							$el_contingent = $element['rr_el_sp_cont'];
						} else {
							$el_contingent = $el_percent * $element['rr_el_sp_cont'];
						}
						$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
							'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
							'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
						array_push( $elements_array, $el_array);
						break;
				case 3: 
					$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['ls'];
					$el_amt = $cat_alloc_array['ls'] * $el_percent;
					if ($element['rr_el_sp_cont'] <= $el_amt){
						$el_contingent = $element['rr_el_sp_cont'];
					} else {
						$el_contingent = $el_percent * $element['rr_el_sp_cont'];
					}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				case 4: 
					$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['fr'];
					$el_amt = $cat_alloc_array['fr'] * $el_percent;
					if ($element['rr_el_sp_cont'] <= $el_amt){
						$el_contingent = $element['rr_el_sp_cont'];
					} else {
						$el_contingent = $el_percent * $element['rr_el_sp_cont'];
					}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				case 5: 
					$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['gu'];
					$el_amt = $cat_alloc_array['gu'] * $el_percent;
					if ($element['rr_el_sp_cont'] <= $el_amt){
						$el_contingent = $element['rr_el_sp_cont'];
					} else {
						$el_contingent = $el_percent * $element['rr_el_sp_cont'];
					}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				case 6: 
					$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['fm'];
					$el_amt = $cat_alloc_array['fm'] * $el_percent;
					if ($element['rr_el_sp_cont'] <= $el_amt){
						$el_contingent = $element['rr_el_sp_cont'];
					} else {
						$el_contingent = $el_percent * $element['rr_el_sp_cont'];
					}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				case 7: 
					$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['em'];
					$el_amt = $cat_alloc_array['em'] * $el_percent;
					if ($element['rr_el_sp_cont'] <= $el_amt){
						$el_contingent = $element['rr_el_sp_cont'];
					} else {
						$el_contingent = $el_percent * $element['rr_el_sp_cont'];
					}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				case 8: 
					$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['fv'];
					$el_amt = $cat_alloc_array['fv'] * $el_percent;
					if ($element['rr_el_sp_cont'] <= $el_amt){
						$el_contingent = $element['rr_el_sp_cont'];
					} else {
						$el_contingent = $el_percent * $element['rr_el_sp_cont'];
					}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				case 9: 
					$el_percent = $element['rr_el_sell_price'] / $sp_accum_array['hv'];
					$el_amt = $cat_alloc_array['hv'] * $el_percent;
					if ($element['rr_el_sp_cont'] <= $el_amt){
						$el_contingent = $element['rr_el_sp_cont'];
					} else {
						$el_contingent = $el_percent * $element['rr_el_sp_cont'];
					}
					$el_array = array('element_id' => $element['rr_el_id'], 'element_sep_flag' => $element['rr_el_sep'],
						'element_selling_price' => $element['rr_el_sell_price'], 'element_allocation' => $el_amt,
						'element_percent' => $el_percent, 'element_contingent' => $el_contingent);
					array_push( $elements_array, $el_array);
					break;
				default:
					break;
			}
		}
	}
	return $elements_array;
}

/* 
	Allocation for combined elements (for meta table)
*/

function update_combined_allocation($project_id){ 
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
	$comb_allocation = 0;
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 1 && ($element['rr_el_sep'] !== "Yes" || $element['rr_el_dt_2'] == 0)){
				$comb_allocation = $comb_allocation + $element['rr_el_amt'];
			}
		}
	}
	return $comb_allocation;
}

/* 
	Allocation for historical value elements (for meta table)
*/

function update_hv_allocation($project_id){
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
	$hv_allocation = 0;
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 9){
				$hv_allocation = $hv_allocation + $element['rr_el_amt'];
			}
		}
	}
	return $hv_allocation;
}

/* 
	Allocation for software elements (for meta table)
*/

function update_sw_allocation($project_id){ 
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
	$sw_allocation = 0;
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 2){
				$sw_allocation = $sw_allocation + $element['rr_el_amt'];
			}
		}
	}
	return $sw_allocation;
}

/* 
	Allocation for fair value elements (for meta table)
*/

function update_fm_allocation($project_id){
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
	$fm_allocation = 0;
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 6){
				$fm_allocation = $fm_allocation + $element['rr_el_amt'];
			}
		}
	}
	return $fm_allocation;
}

/* 
	Allocation for lease elements (for meta table)
*/

function update_ls_allocation($project_id){
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
	$ls_allocation = 0;
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 3){
				$ls_allocation = $ls_allocation + $element['rr_el_amt'];
			}
		}
	}
	return $ls_allocation;
}

/* 
	Allocation for franchise elements (for meta table)
*/

function update_fr_allocation($project_id){
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
	$fr_allocation = 0;
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 4){
				$fr_allocation = $fr_allocation + $element['rr_el_amt'];
			}
		}
	}
	return $fr_allocation;
}

/* 
	Software VSOE flag (for meta table)
*/

function update_sw_vsoe($project_id){
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_sw_flag'] == 1){
				if ($element['rr_el_sp_basis'] !== 1){
					$sw_vsoe = 0;
				} else {
					$sw_vsoe = 1;
				}
			}
		}
	}
	return $sw_vsoe;
}

/*
	Evaluate conditions and rev rec method of SEPARABLE elements
*/

function update_sepdel_cond_status($element, $stats){
	if ($element['rr_el_cond_status'] == 'Met' && $element['rr_el_cond_date'] > 0){
		$sepdel_cond_stat = array('rr_stat_id' => 1, 'status_desc' => $stats[0]['rr_stat_desc'], 'status_date' => $element['rr_el_cond_date']);
	} else if ($element['rr_el_cond_status'] == 'Met' && $element['rr_el_cond_date'] == 0){
		$sepdel_cond_stat = array('rr_stat_id' => 5, 'status_desc' => $stats[4]['rr_stat_desc'], 'status_date' => '');
	} else if ($element['rr_el_cond_status'] == 'Not Met'){
		$sepdel_cond_stat = array('rr_stat_id' => 6, 'status_desc' => $stats[5]['rr_stat_desc'], 'status_date' => '');
	} else {
		$sepdel_cond_stat = array('rr_stat_id' => 4, 'status_desc' => $stats[3]['rr_stat_desc'], 'status_date' => '');
	}
	return $sepdel_cond_stat;
}

/*
	Evaluate separable delivered elements revenue recognition method status
*/

function update_sepdel_revrec_meth($value, $methods, $stats){
	$revrecmeth = array('rr_stat_id' => 10, 'status_desc' => $stats[9]['rr_stat_desc'], 'status_date' => '');
	if ($value['rr_el_sep'] == 'Yes'){
		if ($value['rr_el_meth'] !== '' || $value['rr_el_meth'] !== null){			
			foreach ($methods as $method){
				if ($method['rr_meth_id'] == $value['rr_el_meth']){
					$revrecmeth = array('rr_stat_id' => '', 'status_desc' => '', 'status_date' => $method['rr_meth_name']);
				}
			}
		}
	} else if ($value['rr_el_sep'] == 'No'){
		$revrecmeth = array('rr_stat_id' => 12, 'status_desc' => $stats[11]['rr_stat_desc'], 'status_date' => '');
	}
	return $revrecmeth;
}

/*
	Combined elements revenue recognition status flag (for meta table)
*/

function update_comb_projmeta($project_id){
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	$status_date = 0;
	$element_count = 0;
	$status_count = 0;
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 1){ // if a cat 1 element (both separable and non-separable)
				$element_count++;
				if ($element['rr_el_cond_date'] > 0){ // if condition date is not zero (if all conditions met)
					$status_count++;
				}
				if ($element['rr_el_odt_2'] > $status_date) { // selects the latest delivery date (override has priority) and sets date and method
					$status_date = $element['rr_el_odt_2'];
					$method = $element['rr_el_meth'];
				} else if ($element['rr_el_dt_2'] > $status_date) { // selects the latest delivery date and sets date and method
					$status_date = $element['rr_el_odt_2'];
					$method = $element['rr_el_meth'];
				}
			}
		}
	}
	if ($element_count !== 0){
		if ($status_count / $element_count < 1){ // if ratio of # met elements to # total elements is less than 1
			$status_flag = 0;
		} else {
			$status_flag = 1;
		}
	}
	foreach ($project_metas as $project_meta){
		if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_comb_date'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $status_date), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_comb_meth'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $method), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_comb_stat'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $status_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
	}
}

/*
	Software elements revenue recognition status flag (for meta table)
*/

function update_sw_projmeta($project_id){
	global $wpdb;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	$projects = $wpdb->get_results( "SELECT * FROM wp_gl_proj WHERE gl_proj_id = $project_id", ARRAY_A );
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	
	$status_date = 0;
	$sw_count = 0;
	$vsoe_count = 0;
	$undeliv_count = 0;
	$undeliv_vsoe_count = 0;
	$undeliv_vsoe_amt = 0;
	$undeliv_pcs_count = 0;
	$undeliv_serv_count = 0;
	$latest_deliv_date = 0;
	
	foreach ($elements as $element){
		if ($element['gl_proj_id'] == $project_id){
			if ($element['rr_el_meth_cat'] == 2){ // if software
				$sw_count++;
				if ($element['rr_el_sp_basis'] == 1){ // if vsoe is yes
					$vsoe_count++;
				}
				if ($element['rr_el_odt_2'] < 1 && $element['rr_el_dt_2'] < 1){ // if not delivered
						$undeliv_count++;
						$undeliv_meth = $element['rr_el_meth'];
						if ($element['rr_el_sp_basis'] == 1){ // if vsoe is yes
							$undeliv_vsoe_count++;
							$undeliv_vsoe_amt = $undeliv_vsoe_amt + $element['rr_el_sell_price'];
						}
						
						if ($element['rr_el_del'] == 7){ //if PCS
							$undeliv_pcs_count++;
						}
					
						if ($element['rr_el_del'] == 8){ //if services
							$undeliv_serv_count++;
						}
				} else if ($element['rr_el_odt_2'] > $latest_deliv_date || $element['rr_el_dt_2'] > $latest_deliv_date){ // if not all vsoe, undel vsoe, undel PCS or undel services
					$latest_deliv_date = max($element['rr_el_odt_2'], $element['rr_el_dt_2']);
					$latest_deliv_meth = $element['rr_el_meth'];
				}
				if ($element['rr_el_last_del'] !== 0){ // user's last deliv element meth...use as override?
					$last_deliv_meth = $element['rr_el_meth'];
					$last_deliv_flag = 1;
				}
			}
		}
	}
	
	if ($sw_count !== 0){
		if ($vsoe_count / $sw_count == 1){ // if ratio of # vsoe to # elements is 1, then vsoe_flag is 1
			$vsoe_flag = 1;
			foreach ($project_metas as $project_meta){
				if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_vsoe_flag'){
					$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $vsoe_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
				}
			}
		} else {
			$vsoe_flag = 0;
			foreach ($project_metas as $project_meta){
				if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_vsoe_flag'){
					$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $vsoe_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
				}
			}
			
			if($undeliv_vsoe_count / $undeliv_count == 1){ // if all undeliverables vsoe
				foreach ($projects as $project){
					if ($project['gl_proj_id'] == $project_id){
						if ($project['gl_proj_fee'] > $undeliv_vsoe_amt){ // and if vsoe amt < total fee 
							$residual_flag = 1;
							foreach ($project_metas as $project_meta){
								if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_vsoe_flag'){
									$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $residual_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
								}
								if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_vsoe_amt'){
									$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $undeliv_vsoe_amt), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
								}
							}
						} else {
							$residual_flag = 0;
							$undeliv_vsoe_amt = 0;
							foreach ($project_metas as $project_meta){
								if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_vsoe_flag'){
									$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $residual_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
								}
								if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_vsoe_amt'){
									$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $undeliv_vsoe_amt), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
								}
							}
						}
					}
				}
			} else if ($undeliv_count !== 0){ 
				// set the pcs flag
				if ($undeliv_pcs_count / $undeliv_count == 1){ // if only undelivs are pcs
					$pcs_flag = 1;
					foreach ($project_metas as $project_meta){
						if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_pcs_flag'){
							$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $pcs_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
						}
					}
				} else {
					$pcs_flag = 0;
					foreach ($project_metas as $project_meta){
						if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_pcs_flag'){
							$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $pcs_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
						}
					}
				}
				// set the services flag
				if ($undeliv_serv_count / $undeliv_count == 1){ // if only undelivs are services
					$serv_flag = 1;
					foreach ($project_metas as $project_meta){
						if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_serv_flag'){
							$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $serv_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
						}
					}
				} else {
					$serv_flag = 0;
					foreach ($project_metas as $project_meta){
						if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_serv_flag'){
							$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $serv_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
						}
					}
				}
						
				if ($undeliv_count == 1 && $vsoe_flag == 0 && $residual_flag == 0 && $pcs_flag == 0 && $serv_flag == 0){ // if only 1 undelivered left
					$last_deliv_meth = $undeliv_meth;
					$last_deliv_flag = 1;
					foreach ($project_metas as $project_meta){	
						if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_last_del_meth'){
							$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $last_deliv_meth), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
						}
						if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_last_del_flag'){
							$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $last_deliv_flag), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
						}
					}
				}
			}
		}
	}
	
	foreach ($project_metas as $project_meta){		
		if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_latest_deliv_date'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $latest_deliv_date), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_latest_deliv_meth'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $latest_deliv_meth), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
	}
}

/*
	Software elements revenue recognition method calculation
*/

function update_sw_revrec($project_id, $stats){
	global $wpdb;
	//print_r($project_metas);
	
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	$methods = $wpdb->get_results( "SELECT * FROM wp_gl_rr_meth", ARRAY_A );
	
	foreach ($project_metas as $project_meta){
		$key = $project_meta['gl_proj_meta_key'];
		switch ($key){
			case '_proj_sw_all_vsoe_flag':
				$sw_all_vsoe_flag = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_undeliv_vsoe_flag':
				$sw_undeliv_vsoe_flag = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_undeliv_pcs_flag':
				$sw_undeliv_pcs_flag = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_undeliv_serv_flag':
				$sw_undeliv_serv_flag = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_last_del_meth':
				$sw_last_del_meth = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_last_del_flag':
				$sw_last_del_flag = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_latest_deliv_meth':
				$sw_latest_deliv_meth = $project_meta['gl_proj_meta_value'];
				break;
			case '_proj_sw_latest_deliv_date':
				$sw_latest_deliv_date = $project_meta['gl_proj_meta_value'];
				break;
			default:
				break;
		}
	}
		
	foreach ($elements as $element){
		if ($element['rr_el_meth_cat'] == 2 && ($element['rr_el_stop_flag'] == null || $element['rr_el_stop_flag'] == '' || $element['rr_el_stop_flag'] == 0)){
			// if all elements have VSOE, use individual rev rec method
			if ($sw_all_vsoe_flag == 1){ // if _proj_sw_all_vsoe_flag value is 1, then all elements have VSOE
				if ($element['rr_el_meth'] !== '' && $element['rr_el_meth'] !== null){ // if element has a method, use it
					foreach ($methods as $method){ // get the methods list
						if ($method['rr_meth_id'] == $element['rr_el_meth']){ // match the element method to the method list
							$revrecmeth = array('rr_stat_id' => 11, 'status_desc' => $stats[10]['rr_stat_desc'], 'status_date' => $element['rr_el_meth']); // return the method name
						} else {
							$revrecmeth = array('rr_stat_id' => 10, 'status_desc' => $stats[9]['rr_stat_desc'], 'status_date' => $element['rr_el_meth']);
						}
					}
				}
				
			// if all undelivereds have VSOE, use residual method
			} else if ($sw_undeliv_vsoe_flag == 1){
				if ($element['rr_el_odt_2'] > 0 || $element['rr_el_dt_2'] > 0){ // if _proj_sw_undeliv_vsoe_flag is 1, then all undelivereds have VSOE
					
					foreach ($methods as $method){ // get the methods list
						if ($method['rr_meth_id'] == $sw_latest_deliv_meth){ // match the last deliverable method to the method list
							$revrecmeth = array('rr_stat_id' => 9, 'status_desc' => $stats[8]['rr_stat_desc'], 'status_date' => $sw_latest_deliv_meth);
						}
					}
					$wpdb->update( 'wp_gl_rr', array ("rr_el_stop_flag" => 1), array ("rr_el_id" => $element['rr_el_id']) );
				} else {
					foreach ($methods as $method){ // get the methods list
						if ($method['rr_meth_id'] == $element['rr_el_meth']){ // match the last deliverable method to the method list
							$revrecmeth = array('rr_stat_id' => '', 'status_desc' => '', 'status_date' => $element['rr_meth_name']);
						}
					}
					$wpdb->update( 'wp_gl_rr', array ("rr_el_stop_flag" => 1), array ("rr_el_id" => $element['rr_el_id']) );
				}
				
			//if last undelivered is PCS, use ratably over PCS term
			} else if ($sw_undeliv_pcs_flag == 1){ // if _proj_sw_undeliv_pcs_flag is 1, then last deliverable is PCS
				$revrecmeth = array('rr_stat_id' => 8, 'status_desc' => $stats[7]['rr_stat_desc'], 'status_date' => '');
				$wpdb->update( 'wp_gl_rr', array ("rr_el_stop_flag" => 1), array ("rr_el_id" => $element['rr_el_id']) );

			// if last undelivered is services, use ratably over services term
			} else if ($sw_undeliv_serv_flag == 1){ // if _proj_sw_undeliv_serv_flag is 1, then last deliverable is services
				foreach ($methods as $method){ // get the methods list
					if ($method['rr_meth_id'] == $element['rr_el_meth']){ // match the last deliverable method to the method list
						$revrecmeth = array('rr_stat_id' => 13, 'status_desc' => $stats[12]['rr_stat_desc'], 'status_date' => '');
						$wpdb->update( 'wp_gl_rr', array ("rr_el_stop_flag" => 1), array ("rr_el_id" => $element['rr_el_id']) );
					}
				}
				
			// use method of last deliverable if available // sw_last_del_meth will be implemented in v2
			/*} else if ($sw_last_del_meth !== '' || $sw_last_del_meth !== null){ // if _proj_sw_last_del_meth is 0 or above, then last deliverable has a method
				foreach ($methods as $method){ // get the methods list
					if ($method['rr_meth_id'] == $sw_last_del_meth){ // match the last deliverable method to the method list
						$revrecmeth = 'Use method of last deliverable: ' . $method['rr_meth_name']; // return method name
					}
				}
			} else if ($sw_last_del_flag == 0){ // if _proj_sw_last_del_flag is 0, then there is no last deliverable selected
				$revrecmeth = 'Use method of last deliverable. Please select a software element as the last deliverable';*/

			// instruct to enter method for last deliverable
			} else {
				$revrecmeth = array('rr_stat_id' => 7, 'status_desc' => $stats[6]['rr_stat_desc'], 'status_date' => '');
			}
			$wpdb->update( 'wp_gl_rr', array ("rr_el_meth_calc" => $revrecmeth), array ("rr_el_id" => $element['rr_el_id']) );
		}
	}
}

/*
	Software elements revenue status for summary
*/

function update_sw_status($element, $stats){
	global $wpdb;
	//echo $element_id;
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE rr_el_id = $element_id", ARRAY_A );
	
	if ( $element['rr_el_cond_status'] == 'Incomplete' ){ 
		$errstat = array('rr_stat_id' => 2, 'status_desc' => $stats[1]['rr_stat_desc'], 'status_date' => '');
	} else if ($element['rr_el_cond_status'] == 'Met'){
		if ($element['rr_el_cond_date'] > 0){
			$errstat = array('rr_stat_id' => 1, 'status_desc' => $stats[0]['rr_stat_desc'], 'status_date' => $element['rr_el_cond_date']);
		} else {
			$errstat = array('rr_stat_id' => 5, 'status_desc' => $stats[4]['rr_stat_desc'], 'status_date' => '');
		}
	} else if ($value['rr_el_cond_status'] == 'Not Met'){
			$errstat = array('rr_stat_id' => 6, 'status_desc' => $stats[5]['rr_stat_desc'], 'status_date' => '');
	} else {
		$errstat = array('rr_stat_id' => 4, 'status_desc' => $stats[3]['rr_stat_desc'], 'status_date' => '');
	}
	return $errstat;
}

/*
	Contingent rev rec date
*/

function update_cont_date($value){
	if ($value['rr_el_cont_date'] == 0 || $value['rr_el_cont_date'] == '' || $value['rr_el_cont_date'] == null){
		$contingent_date = 'N/A';
	} else {
		$contingent_date = $value['rr_el_cont_date'];
	}
	return $contingent_date;
}

/*
	Calculate combined rev rec method
*/

function update_comb_revrec_meth($value, $methods, $project_metas, $stats, $project_id){
	$revrecmeth = array('rr_stat_id' => 10, 'status_desc' => $stats[9]['rr_stat_desc'], 'status_date' => ''); // start rev rec method
	if ($value['rr_el_sep'] == 'Yes'){
		if ($value['rr_el_meth'] !== '' || $value['rr_el_meth'] !== null){			
			foreach ($methods as $method){
				if ($method['rr_meth_id'] == $value['rr_el_meth']){
					$revrecmeth = array('rr_stat_id' => '', 'status_desc' => '', 'status_date' => $method['rr_meth_name']);
				}
			}
		}
	} else if ($value['rr_el_sep'] == 'No'){
			foreach ($project_metas as $project_meta){
			if($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_comb_meth'){
				foreach ($methods as $method){
					if ($method['rr_meth_id'] == $project_meta['gl_proj_meta_value']){
						$revrecmeth = array('rr_stat_id' => '', 'status_desc' => '', 'status_date' => $method['rr_meth_name']);
					}
				}
			}
		}
	}
	return $revrecmeth;
}

/*
	Calculate combined elements rev rec condition status for summary
*/

function update_comb_cond_status ($element, $project_metas, $stats, $project_id){
	if ($element['rr_el_sep'] == 'Yes'){
		if ($element['rr_el_cond_date'] !== '' && $element['rr_el_cond_date'] !== null && $element['rr_el_cond_date'] !== 0){
			$revrecdate = array('rr_stat_id' => 1, 'status_desc' => $stats[0]['rr_stat_desc'], 'status_date' => $element['rr_el_cond_date']);
		} else {
			$revrecdate = array('rr_stat_id' => 2, 'status_desc' => $stats[1]['rr_stat_desc'], 'status_date' => '');
		}
	} else if ($element['rr_el_sep'] == 'No'){
		foreach ($project_metas as $project_meta){
			if($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_comb_stat'){
				$_proj_comb_stat = $project_meta['gl_proj_meta_element'];
			}
			if($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_comb_date'){
				$_proj_comb_date = $project_meta['gl_proj_meta_element'];
			}
		}
		if ($_proj_comb_stat == 1){
			$revrecdate = array('rr_stat_id' => 1, 'status_desc' => $stats[0]['rr_stat_desc'], 'status_date' => $_proj_comb_date);
		} else {
			$revrecdate = array('rr_stat_id' => 3, 'status_desc' => $stats[2]['rr_stat_desc'], 'status_date' => '');
		}
	}
	return $revrecdate;
}

?>