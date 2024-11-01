<?php
/**
 * Plugin Name: WP E-Commerce Search Widget (Grid View)
 * Plugin URI: http://salespagehost.com
 * Description: A fullfledged search widget for wp e-commerce with grid view. NO GOLD CART REQUIRED. if you found this plugin useful, please consider making a small donation towards my hardwork and to cover development cost. <a href="http://www.unlimitedhub.com/paypal_donation.php">Donate Now</a> 
 * Version: 1.0
 * Author: Thushar Baby
 * Author URI: http://salespagehost.com/
 */

/*

Copyright (c) 2010  Thushar Baby  (email : thusharbaby@gmail.com)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/
 
$wp_e_commerce_domain = 'wp-e-commerce-search-widget';

 

function wp_e_commerce_search_widget ( $argv )
{
	global $wp_e_commerce_domain;
    extract($argv);
    $options = get_option('wp_e_commerce_search_widget');
    
    $title   = $options['title']/* ? $options['title'] : __('default_title',$wp_e_commerce_domain)*/;
    $button  = $options['button'] ? $options['button'] : __('default_button',$wp_e_commerce_domain);
    $length  = ctype_digit($options['length']) ? $options['length'] : 15;
    
    $default = $options['default'] ? addslashes($options['default']) : '';
    $script  = $default ? $options['script'] : false;

	$focus   = $options['focus'] ? $options['focus'] : '#000';
	$blur    = $options['blur'] ? $options['blur'] : '#999';
?>
    <?php echo $before_widget; ?>
        <?php if($title) echo $before_title,$title,$after_title; ?>
	<form id="wp-e-commerce-search-form" method="get" action="<?php bloginfo('home'); ?>">
	<div>
		<input type="text" name="wp-e-commerce-search" id="wp-e-commerce-search" size="<?php echo $length; ?>" <?php if($_GET['wp-e-commerce-search']) echo "value='{$_GET['wp-e-commerce-search']}'"; else if($default) echo "value='$default'"; ?> <?php if($script) echo "onfocus='this.style.color=\"$focus\";if(\"$default\"==this.value)this.value=\"\";' onblur='if(\"\"==this.value){this.style.color=\"$blur\";this.value=\"$default\";}' style='color:$blur'"; ?> />
		<input type="submit" value="<?php echo attribute_escape($button); ?>" />
	</div>
	</form>
    <?php echo $after_widget; ?>
<?php
}

/**
 * The widget options form.
 * 
 * Displays the form for changing the widget settings
 * on the widget admin page.
 */
function wp_e_commerce_search_widget_control ()
{
	global $wp_e_commerce_domain;
	
    $options = $newoptions = get_option('wp_e_commerce_search_widget');
    if ( $_POST['wp-e-commerce-search-submit'] ) {
		$newoptions['title']   = strip_tags(stripslashes($_POST['wp-e-commerce-search-title']));
		$newoptions['button']  = strip_tags(stripslashes($_POST['wp-e-commerce-search-button']));
		$newoptions['length']  = preg_replace('/\D/', '', $_POST['wp-e-commerce-search-length']);
		$newoptions['default'] = strip_tags(stripslashes($_POST['wp-e-commerce-search-default']));
		$newoptions['script']  = (1==$_POST['wp-e-commerce-search-script'])?1:0;
		$newoptions['focus']   = htmlentities(strip_tags($_POST['wp-e-commerce-search-focus']));
		$newoptions['blur']    = htmlentities(strip_tags($_POST['wp-e-commerce-search-blur']));
    }

    if ( $options != $newoptions ) {
        $options = $newoptions;
        update_option('wp_e_commerce_search_widget', $options);
    }
    $title   = $options['title'] ? $options['title'] : __('default_title', $wp_e_commerce_domain);
    $button  = $options['button'] ? $options['button'] : __('default_button', $wp_e_commerce_domain);
    $length  = $options['length'];
    $default = $options['default'];
	$script  = $options['script'];
	$focus   = $options['focus'];
	$blur    = $options['blur'];
?>
		<p><label for="wp-e-commerce-search-title"><?php _e('form_title',$wp_e_commerce_domain); ?> <input type="text" style="width: 90%;" id="wp-e-commerce-search-title" name="wp-e-commerce-search-title" value="<?php echo $title; ?>" /></label></p>
		
		<p><label for="wp-e-commerce-search-button"><?php _e('form_button',$wp_e_commerce_domain); ?> <input type="text" style="width: 90%;" id="wp-e-commerce-search-button" name="wp-e-commerce-search-button" value="<?php echo $button; ?>" /></label></p>
		
		<p><label for="wp-e-commerce-search-length"><?php _e('form_size',$wp_e_commerce_domain); ?> <input type="text" style="width: 30px;" id="wp-e-commerce-search-length" name="wp-e-commerce-search-length" value="<?php echo $length; ?>" /></label></p>
		
		<p><label for="wp-e-commerce-search-default"><?php _e('form_default',$wp_e_commerce_domain); ?> <input type="text" style="width: 90%;" id="wp-e-commerce-search-default" name="wp-e-commerce-search-default" value="<?php echo $default; ?>" /></label></p>
		
		<p><?php _e('form_script',$wp_e_commerce_domain); ?>
			<label for="wp-e-commerce-search-script-yes" style="display: block; padding-left: 15px"><input type="radio" name="wp-e-commerce-search-script" id="wp-e-commerce-search-script-yes" value="1" <?php if(1==$script) echo "checked='checked'"?> /> <?php _e('form_script_on',$wp_e_commerce_domain); ?></label>
			<label for="wp-e-commerce-search-script-no" style="display: block; padding-left: 15px"><input type="radio" name="wp-e-commerce-search-script" id="wp-e-commerce-search-script-no" value="0" <?php if(1!=$script) echo "checked='checked'"?> /> <?php _e('form_script_off',$wp_e_commerce_domain); ?></label>
		</p>

		<p><label for="wp-e-commerce-search-focus"><?php _e('form_focus_color',$wp_e_commerce_domain); ?>
			<input type="text" size="7" name="wp-e-commerce-search-focus" id="wp-e-commerce-search-focus" value="<?php echo $focus; ?>" onchange="this.style.color=this.value" style="color:<?php echo $focus; ?>" />
		</label></p>

		<p><label for="wp-e-commerce-search-blur"><?php _e('form_blur_color',$wp_e_commerce_domain); ?>
			<input type="text" size="7" name="wp-e-commerce-search-blur" id="wp-e-commerce-search-blur" value="<?php echo $blur; ?>" onchange="this.style.color=this.value" style="color:<?php echo $blur; ?>" />
		</label></p>
		
		<p> if you found this plugin useful, please consider making a small donation via paypal towards my hardwork and to cover development cost. 
		<center><a href=http://unlimitedhub.com/paypal_donation.php target=#new><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online."></a>
</center><br>
Other Releated Resources:<br><br>
Sales Page Builder Tools - <a href=http://www.SalesPageMakerPro.com target=#new>www.SalesPageMakerPro.com</a><br>

Free Webhosting & Ecommerce - <a href=http://www.SalesPageHost.com target=#new>www.SalesPageHost.com</a>

</p>
		
		<input type="hidden" id="wp-e-commerce-search-submit" name="wp-e-commerce-search-submit" value="1" />
<?php
}

/**
 * Load the l10n files and register the widget and control.
 */
function wp_e_commerce_search_widget_init ()
{
	global $wp_e_commerce_domain;
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain($wp_e_commerce_domain, 'wp-content/plugins/'.$plugin_dir.'/languages',$plugin_dir.'/languages');

	if ( function_exists('wp_register_sidebar_widget') ) {
		wp_register_sidebar_widget('wp-e-commerce-search-widget', __('widget_name',$wp_e_commerce_domain), 'wp_e_commerce_search_widget', array('description'=>__('widget_description',$wp_e_commerce_domain)), 'wp_e_commerce_search_widget');
		wp_register_widget_control('wp-e-commerce-search-widget', __('widget_name',$wp_e_commerce_domain), 'wp_e_commerce_search_widget_control', array('description'=>__('widget_description',$wp_e_commerce_domain)));
    } else if ( function_exists('register_sidebar_widget') ) {
        register_sidebar_widget(__('widget_name',$wp_e_commerce_domain), "wp_e_commerce_search_widget");
        register_widget_control(__('widget_name',$wp_e_commerce_domain), 'wp_e_commerce_search_widget_control');
    }
	
	function geotag_queryvars( $qvars )
	{	
		$qvars[] = 'test2';
		return $qvars;
	}

		add_filter('query_vars', 'geotag_queryvars' );
	
}
global $wp_query, $wpdb;
$wp_e_commerce_search_variables = $wpdb->escape(stripslashes($_GET['wp-e-commerce-search']));

if (!empty($wp_e_commerce_search_variables) )
{
		add_action('get_header', 'custom_page_remove_filters');
		add_action('loop_start', 'custom_page_add_filters');
}

function custom_page_remove_filters() {
    remove_filter('the_title', 'custom_page_title');
    remove_filter('the_content', 'custom_page_content');
}


function custom_page_add_filters() {
    add_filter('the_title', 'custom_search_request_wp_title');
    add_filter('the_content', 'custom_search_request_wp');
}

function custom_search_request_wp_title($request){
return '<span>Product Search Results</span>';
}






function custom_search_request_wp($request) {
 global $wp_query, $wpdb;
  $wp_e_commerce_search_variables = $wpdb->escape(stripslashes($_GET['wp-e-commerce-search']));
  $searchArray = explode(" ", $wp_e_commerce_search_variables);
  $count = count($searchArray);
  for ($i=0; $i < $count; $i++) {
    $queryExtras .= "list.name LIKE '%".$searchArray[$i]."%' OR list.description LIKE '%".$searchArray[$i]."%' OR ";
  }
  $queryExtras = substr($queryExtras, 0, -4);
  $sql="SELECT list.id,list.name,list.price,image.image,list.special,list.special_price
        FROM ".$wpdb->prefix."wpsc_product_list AS list
        LEFT JOIN ".$wpdb->prefix."wpsc_product_images AS image
        ON list.image=image.id
        WHERE ($queryExtras)
        AND list.publish=1
        AND list.active=1
       ";
  //echo $sql;
  $product_list = $wpdb->get_results($sql,ARRAY_A);
  
  if (!$product_list) {
    $output = "<p>There are no products found which contain the search term <i>".$wp_e_commerce_search_variables."</i>.";
  }
  else  {
  ?>
	<style>
div.textcol_group_wp_search {
	float: left;
	position: relative;
	width: 150px;
	height: 200px;
	margin: 8px 4px 4px 4px; 

	border-top: 1px solid #E1DAB7; 
	border-right: 1px solid #E1DAB7; 
	border-bottom: 1px solid #E1DAB7; 
	border-left: 1px solid #E1DAB7;
	vertical-align: top;
	}

div.imagecol_group_wp_search {
	text-align: center;
	display: block;
	margin: 5px auto 5px auto;
	}

div.itemheading_wp_search {
	font-family:'Trebuchet MS',Verdana,Arial,Sans-Serif;
	font-weight: bold;
	text-align: center;
	display: block;
	margin: 0px auto 0px auto;
	
	font-size: 10pt;
	color: black;
	border: 2px solid #E1DAB7;
	background-color: #E1DAB7;
	}

span.oldprice_wp_search{
	text-decoration: line-through;
	}
 
span.oldprice_wp_search span{
	text-decoration: line-through;
	}
span.pricedisplay{
	/*  white-space: nowrap; */
	width: 80px;
	float:middle;
	font-size: 16px;
	color:black;
	font-weight:bold;
 }
	
</style>
  <?
  
    // $output = "<div class='imagecol_group'>\n\r";
    foreach((array)$product_list as $product) {
	  $output.="<div class='textcol_group_wp_search'>";
	  $output.="<div class='itemheading_wp_search'>".$product['name']."</div> ";
	  
      $output .= "<div class='imagecol_group_wp_search'>\n\r";
      $output .= "<a href='".wpsc_product_url($product['id'])."'>";
      if($product['image'] != '') {
        $output .= "<img src='".WPSC_THUMBNAIL_URL.$product['image']."' title='".$product['name']."' alt='".$product['name']."' />\n\r";
        $output .= "<p>\n\r";
        $output .= stripslashes($product['name']);
        $output .= "</a><br /><br />";
        $output .= "<span class='front_page_price'>\n\r";
        if($product['special']==1) {
          $output .= "<span class='oldprice_wp_search'>".nzshpcrt_currency_display($product['price'], $product['notax'])."</span><br />\n\r";
          $output .= nzshpcrt_currency_display(($product['price'] - $product['special_price']), $product['notax'],false,$product['id']);
        } else {
          $output .= "".nzshpcrt_currency_display($product['price'], $product['notax']);
        }
        $output .= "</span>\n\r";
        $output .= "</p>\n\r";
      }
      $output .= "</div></div>\n\r";
    }
    $output .= "<br style='clear: left;'>\n\r";
  } // else

  return $output;
}

add_action('widgets_init', 'wp_e_commerce_search_widget_init');

