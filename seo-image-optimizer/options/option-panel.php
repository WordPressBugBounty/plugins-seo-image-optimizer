<?php
defined( 'ABSPATH' ) || die();

/**
 * Image Optimization For Seo Admin Menu
 */

add_action( 'admin_menu', 'wsio_admin_menu_pannel' );
function wsio_admin_menu_pannel() {
	 $page = add_menu_page( WSIO_PLUGIN_NAME, esc_html__( 'Images Seo', WSIO_TEXT_DOMAIN ), 'manage_options', 'wsio-weblizar', 'wsio_option_panal_function', 'dashicons-format-image', 65 );
	add_action( 'admin_print_styles-' . $page, 'wsio_admin_enqueue_script' ); // add_action function for adding the js and css files
}
/**
 * Weblizar Admin Menu CSS
 */
// for Adding css and js files of plugin
function wsio_admin_enqueue_script() {
	// Enqueue Scripts
	wp_enqueue_script( 'jQuery' );
	wp_enqueue_script( 'popper', plugin_dir_url( __FILE__ ) . 'js/popper.min.js' );
	wp_enqueue_script( 'weblizar-tab-js', plugin_dir_url( __FILE__ ) . 'js/option-js.js', array( 'media-upload', 'jquery-ui-sortable' ) );
	wp_enqueue_script( 'weblizar-bt-toggle', plugin_dir_url( __FILE__ ) . 'js/bt-toggle.js' );
	wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js' );
	wp_enqueue_script( 'multiselectjs', plugin_dir_url( __FILE__ ) . 'js/jquery.multiselect.js' );

	// Enqueue Styles
	wp_enqueue_style( 'weblizar-option-style', plugin_dir_url( __FILE__ ) . 'css/option-style.css' );
	wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/all.min.css' );
}

/**
 * Weblizar Plugin Option Form
 */
function wsio_option_panal_function() {
	?>
	<div class="msg-overlay">
		<img id="loading-image" src="<?php echo plugin_dir_url( __FILE__ ); ?>images/loader.gif" alt="Weblizar" height="200" style="margin-top:-10px; margin-right:10px;" alt="Loading..." />
		<div class="success-msg">
			<div class="alert alert-success">
				<strong><?php esc_html_e( 'Success!', WSIO_TEXT_DOMAIN ); ?></strong> <?php esc_html_e( 'Data Save Successfully.', WSIO_TEXT_DOMAIN ); ?>
			</div>
		</div>
		<div class="reset-msg">
			<div class="alert alert-danger">
				<strong><?php esc_html_e( 'Success!', WSIO_TEXT_DOMAIN ); ?></strong> <?php esc_html_e( 'Data Reset Successfully.', WSIO_TEXT_DOMAIN ); ?>
			</div>
		</div>
	</div>
	<header>
		<div class="container-fluid row top">
			<div class="col-md-8 col-sm-8">
				<h2><img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/logo.png" alt="Weblizar" height="50" style="margin-top:-10px; margin-right:10px;" /> <span style="font-weight:bold; font-size:20px;"><?php esc_html_e( WSIO_PLUGIN_NAME, WSIO_TEXT_DOMAIN ); ?></span></h2>
			</div>
			<div class="col-md-4 col-sm-4 search1">
				<a href="https://wordpress.org/support/plugin/seo-image-optimizer/" target="_blank"><span class="far fa-comment"></span><?php esc_html_e( ' Support Forum', WSIO_TEXT_DOMAIN ); ?></a>
				<a href="https://weblizar.com/plugins/seo-image-optimizer-pro/" target="_blank"><span class="far fa-edit"></span> <?php esc_html_e( ' View Documentation', WSIO_TEXT_DOMAIN ); ?></a>
			</div>
		</div>
	</header>

	<div class="container-fluid support">
		<div class="row left-sidebar">
			<div class="col-md-12 menu">
				<!-- tabs left -->
				<div id="options_tabs" class="ui-tabs col-xs-12 tabbable tabs-left">
					<ul class="options_tabs ui-tabs col-xs-2 nav nav-tabs collapsible collapsible-accordion ui-tabs-nav" role="tablist" id="nav">

						<?php
						$wl_naf_options = get_option( 'weblizar_naf_options' ); // get option settings from saved database
						?>
						<li title="<?php esc_attr_e( 'General Settings Option', WSIO_TEXT_DOMAIN ); ?>"><a href="#" id="general-option" data-toggle="tab"><i class="fas fa-image icon"></i> <?php esc_html_e( 'Genral Settings', WSIO_TEXT_DOMAIN ); ?></a></li>
						<li title="<?php esc_attr_e( 'Image Size Settings Option', WSIO_TEXT_DOMAIN ); ?>"><a href="#" id="image-size-option" data-toggle="tab"><i class="fa fa-magic icon"></i> <?php esc_html_e( 'Image Settings', WSIO_TEXT_DOMAIN ); ?></a></li>
						<li title="<?php esc_attr_e( 'How Does it Work?', WSIO_TEXT_DOMAIN ); ?>"><a href="#" id="how-work-option" data-toggle="tab"><i class="fas fa-info-circle icon"></i></a></li>

					</ul>
					<!-- Option Data saving  -->
					<?php require_once 'option-data.php'; ?>
					<!-- Option Settings form  -->
					<?php require_once 'option-settings.php'; ?>
					<a class="back-to-top back-top" href="#" style="display: inline;"><i class="fas fa-angle-up"></i></a>
				</div>
			</div>
		</div>
	</div>
	<?php
}
// add_filter(the_content) to replaced the content image attributes with options values
add_filter( 'the_content', 'weblizar_wsio_img_attribute_replaced', 100 );
// add_filter(post_thumbnail_html) to the replaced post featured thumbnail image attributes with options values
add_filter( 'post_thumbnail_html', 'weblizar_wsio_img_attribute_replaced', 100 );

function weblizar_wsio_img_attribute_replaced( $content, $alt_text = '', $title_text = '' ) {
	// preapre the alt text to get option data
	$wl_wsio_options = get_option( 'weblizar_wsio_options' );
	// Check if we need to overide the default alt and existing alt text

	// check setting for overinding alt tag
	$alt_flag = $wl_wsio_options['wsio_override_alt_value'];
	// We will set the flag 1 or 0 by on/off option.
	if ( $alt_flag == 'on' ) {
		$alt_flag = '1';
	} elseif ( $alt_flag == 'off' ) {
		$alt_flag = '0';
	}

	// check setting for overinding title tag
	$title_flag = $wl_wsio_options['wsio_override_title_value'];
	// We will set the flag 1 or 0 by on/off option.
	if ( $title_flag == 'on' ) {
		$title_flag = '1';
	} elseif ( $title_flag == 'off' ) {
		$title_flag = '0';
	}
	
	// Set the alt pattern
	// so first finds all the images in the page
	// Then we proceed to finding missing or empty alt tags

	// Step first count number of images found in content
	$count = preg_match_all( '/<img[^>]+>/i', $content, $images );

	// step second If we find images on the page then proceed to check the alt tags
	// We also need to calaculate the velue to be inserted in the tags based on user input

	if ( $count > 0 ) {
		// Here we will set the alt value to be inserted.
		// $t = "$post_title"
		// we want to output like alt = "text"
		$t = 'alt="' . $alt_text . '"';

		// we want to output like title = "text"
		$t_title = 'title="' . $title_text . '"';

		foreach ( $images[0] as $img ) {   // check if the alt tag exists in the image

			// Get the Name of Image Files.

			$output = preg_match_all( '/<img[^>]+src=[\'"]([^\'"]+)[\'"].*>/i', $img, $matches );

			$get_file_name   = pathinfo( $matches[1][0] );
			$image_file_name = $get_file_name['filename'];
		
			global $post;
			// get the post title for later use
			$post_title = esc_attr( $post->post_title );

			// Get Site Name
			$site_name = get_bloginfo();

			// Get post categories
			$postcategories = get_the_category();
			$post_category  = '';
			if ( $postcategories ) {
				foreach ( $postcategories as $category ) {
					$post_category .= $category->name . ' ';
				}
			}

			$posttags = get_the_tags();
			$tags     = '';
			if ( $posttags ) {
				foreach ( $posttags as $tag ) {
					$tags = $tag->name . ' ' . $tags;
				}
			}

			$wl_wsio_options = get_option( 'weblizar_wsio_options' );

			// fetch the values of alt and title tags from the option panel
			$alt_texts = $wl_wsio_options['wsio_alt_attribute_value'];
			if ( $alt_texts != '' ) {
				foreach ( $alt_texts as $alt_texted ) {
					$alt_text .= $alt_texted . ' ';
				}
			}

			$title_texts = $wl_wsio_options['wsio_title_tag_value'];
			if ( $title_texts != '' ) {
				foreach ( $title_texts as $title_texted ) {
					$title_text .= $title_texted . ' ';
				}
			}
			$alt_custom_text = $wl_wsio_options['wsio_override_alt_custom_value'];

			$title_custom_text = $wl_wsio_options['wsio_override_title_custom_value'];
			
			// Replace the Values for alt tag
			$alt_text = str_replace( '%title', $post_title, $alt_text );
			$alt_text = str_replace( '%site_name', $site_name, $alt_text );
			$alt_text = str_replace( '%name', $image_file_name, $alt_text );
			$alt_text = str_replace( '%category', $post_category, $alt_text );
			$alt_text = str_replace( '%tags', $tags, $alt_text );

			// Replace the Values for alt tag by custom value
			$alt      = $alt_text . ' ' . $alt_custom_text;
			
			// $alt_text = str_replace( '   ', '', $alt_text );
			$alt_text = str_replace( '   ', ' ', $alt );

			// replace the values for title tag.
			$title_text = str_replace( '%title', $post_title, $title_text );
			$title_text = str_replace( '%site_name', $site_name, $title_text );
			$title_text = str_replace( '%name', $image_file_name, $title_text );
			$title_text = str_replace( '%category', $post_category, $title_text );
			$title_text = str_replace( '%tags', $tags, $title_text );
			
			// Replace the Values for title tag by custom value
			$title      = $title_text . ' ' . $title_custom_text;
			
			// $title_text = str_replace( '   ', '', $title_text );
			$title_text = str_replace( '   ', ' ', $title );
			
			// configure tags with specified values from option panel.
			$t       = 'alt="' . $alt_text . '"';
			$t_title = 'title="' . $title_text . '"';

			// take the alt tag out from the image html markup
			$is_alt = preg_match_all( '/alt="([^"]*)"/i', $img, $alt );

			$alt_text   = '';
			$title_text = '';

			// check for alt tag /////////////////////////
			// In case there is not alt tag, create the tag and insert the value
			if ( $alt_flag == '1' ) { // if alt tag is not present than insert the tag.
				if ( $is_alt == 0 ) {
					$new_img = str_replace( '<img ', '<img ' . $t, $img );
					$content = str_replace( $img, $new_img, $content );
				}
				// if alt tag is present
				elseif ( $is_alt == 1 ) {
					$text = trim( $alt[1][0] );
					// Check if the alt text is empty.
					if ( empty( $text ) ) {
						$new_img = str_replace( $alt[0][0], $t, $img );
						$content = str_replace( $img, $new_img, $content );
					}
					// Should we override the existing alt tag
					if ( $alt_flag == '1' ) {
						$new_img = str_replace( $alt[0][0], $t, $img );
						$content = str_replace( $img, $new_img, $content );
					}
				}
			}
			// End OF code to checked for alt tag //

			// Now we check for title tag //
			// first check weither title tag needs to be overide
			if ( $title_flag == '1' ) {
				if ( ! isset( $new_img ) ) {
					$new_img = $img;
				} // when title tag is not overridden, than , use actual image markup ie $new_img.

				$is_title = preg_match_all( '/title="([^"]*)"/i', $new_img, $title );

				// check if title tag is not present in the img tag
				if ( $is_title == 0 ) { // create the title tag and insert the tag
					$final_img = str_replace( '<img ', '<img ' . $t_title, $new_img );
					$content   = str_replace( $new_img, $final_img, $content );
				} else { // you are here bcs title tags exsis and needs to be override
					$final_img = str_replace( $title[0][0], $t_title, $new_img );
					$content   = str_replace( $new_img, $final_img, $content );
				}
			}     /// End OF code to checked title tag ////////////////
		}
	}

	return $content;
}
/**
 * End of Function to replace and add new custom tag for alt and title of images
 */

/**
 * This function will apply changes to the uploaded file size and compression level
 */

add_action( 'wp_handle_upload', 'wsio_imageupload_resize' );

function wsio_imageupload_resize( $image_attribute ) {
	// preapre the uploaded file size and compression level to get option data

	$wl_wsio_options = get_option( 'weblizar_wsio_options' );
	// check Enable file resize option
	$enabled_resizing = $wl_wsio_options['wsio_image_resize_yesno'];
	// check file resize option is ON or not
	$enabled_resizing = ( $enabled_resizing == 'on' ) ? true : false;

	// check Enable file compression option
	$img_recompression = $wl_wsio_options['wsio_image_recompress_yesno'];
	// get and check file compression option is ON or not
	$img_recompression = ( $img_recompression == 'on' ) ? true : false;

	// check compression level of file
	$compression_level = $wl_wsio_options['wsio_image_quality'];

	// check by condition and Get compression level max width
	$max_width = $wl_wsio_options['wsio_image_width'] == 0 ? false : $wl_wsio_options['wsio_image_width'];

	// check by condition and get compression level max height
	$max_height = $wl_wsio_options['wsio_image_height'] == 0 ? false : $wl_wsio_options['wsio_image_height'];

	// Both Condition checked ( enabled_resizing on/off and img_recompression on/off )
	if ( $enabled_resizing || $img_recompression ) {
		$fatal_error_reported = false;
		// check all type of image files
		$valid_types = array( 'image/gif', 'image/png', 'image/jpeg', 'image/jpg' );

		if ( empty( $image_attribute['file'] ) || empty( $image_attribute['type'] ) ) {
			$fatal_error_reported = true;
		} elseif ( ! in_array( $image_attribute['type'], $valid_types ) ) {
			$fatal_error_reported = true;
		}

		$image_editor = wp_get_image_editor( $image_attribute['file'] );
		$image_type   = $image_attribute['type'];

		if ( $fatal_error_reported || is_wp_error( $image_editor ) ) {
		} else {
			$to_save = false;
			$resized = false;

			// Perform resizing if required
			if ( $enabled_resizing ) {
				$sizes = $image_editor->get_size();
				if ( ( isset( $sizes['width'] ) && $sizes['width'] > $max_width )
					|| ( isset( $sizes['height'] ) && $sizes['height'] > $max_height )
				) {
					$image_editor->resize( $max_width, $max_height, false );
					$resized = true;
					$to_save = true;
					$sizes   = $image_editor->get_size();
				}
			}

			// Regardless of resizing, image must be saved if recompressing
			if ( $img_recompression ) {
				$to_save = true;

				// Only save image if it has been resized or need recompressing
				if ( $to_save ) {
					$image_editor->set_quality( $compression_level );
					$saved_image = $image_editor->save( $image_attribute['file'] );
				}
			}
		}
	}
	return $image_attribute;
}
/**
 * End of Function apply changes to the uploaded file size and compression level
 */
