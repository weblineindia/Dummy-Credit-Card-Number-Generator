<?php



class Credit_Card_Number_Generator_Admin {



	public function __construct() {



		// Add Admin CSS & JS

		add_action( 'admin_enqueue_scripts', array($this, 'ccng_admin_enqueue_CSS_JS'));



		// Add JS Files

		add_action('wp_head', array($this, 'ccng_hook_js'));



		// Add menu in admin setting

		add_action( 'admin_menu', array($this, 'ccng_dummy_card_plugin_menu' ));



		// Action for form edit Ajax

		add_action('wp_ajax_nopriv_wli_credit_card_edit', array($this, 'ccng_credit_card_edit_callback'));



		add_action('wp_ajax_wli_credit_card_edit', array($this, 'ccng_credit_card_edit_callback'));



		// Filter for add plugin settings link

		add_filter( 'plugin_action_links_credit-card-number-generator/credit-card-number-generator.php',  array($this,'ccng_add_action_links'));

 

		// Admin ajax variable

		add_action( 'admin_head', array($this, 'ccng_admin_global_js_vars' ));



		// Admin footer text.

		add_filter( 'admin_footer_text', array( $this, 'ccng_admin_footer' ), 1, 2 );





	}



      

	// General section callback function.

	public function ccng_general_section_callback() {

		?>

		<div class="wliplugin-cta-wrap">

			<h1 class="head">We're here to help !</h1>

			<p>Our plugin comes with free, basic support for all users. We also provide plugin customization in case you want to customize our plugin to suit your needs.</p>

			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Credit%20Card%20Number%20Generator&utm_campaign=Free%20Support" target="_blank" class="button">Need help?</a>

			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Credit%20Card%20Number%20Generator&utm_campaign=Plugin%20Customization" target="_blank" class="button">Want to customize plugin?</a>

		</div>

		<div class="wliplugin-cta-upgrade">

			<p class="note">Want to hire Wordpress Developer to finish your wordpress website quicker or need any help in maintenance and upgrades?</p>

			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Credit%20Card%20Number%20Generator&utm_campaign=Hire%20WP%20Developer" target="_blank" class="button button-primary">Hire now</a>

		</div>

		<?php

	}



	// Function For Include Color Picker CSS in Admin

	public function ccng_admin_enqueue_CSS_JS($hook_suffix ){



		if( is_admin() ) { 

     

        	// Add the color picker CSS file       

        	wp_enqueue_style( 'wp-color-picker' );



        	// Add the color picker JS file       

        	wp_enqueue_script( 'wp-color-picker' );



        	// Add Admin CSS

			wp_enqueue_style( 'ccng-admin-css',CCNG_CARD_GENERATOR_ASSESTS_URL.'admin/admin_style.css',false,null,'all');

        }

	}



	//Function For Include Plugin JS and CSS

	public function ccng_hook_js() {	



		global $wpdb;



		$wli_plugin_status = esc_attr(get_option( 'CCNG_DUMMY_CARD_status' ));



		if( "true" == $wli_plugin_status){



				// Enqueue Clipboard JS

				wp_enqueue_script("wli-clipboard-js",CCNG_CARD_GENERATOR_ASSESTS_URL.'js/clipboard.min.js',array('jquery'),null,true);



				// Enqueue Card JS

				wp_enqueue_script("wli-card-js",CCNG_CARD_GENERATOR_ASSESTS_URL.'js/wli_card.js',array('jquery'),null,true);  



				// Enqueue Card CSS

				wp_enqueue_style( 'wli-card-css',CCNG_CARD_GENERATOR_ASSESTS_URL.'css/style.css',false,null,'all');



		}



	}





	// Function for define ajax variables

	public function ccng_admin_global_js_vars() {



	    $ajax_url = 'var admin_ajax_params = {"ajax_url":"'. admin_url( 'admin-ajax.php' ) .'"};';



	    echo "<script type='text/javascript'>\n";



	    echo "/* <![CDATA[ */\n";



	    echo $ajax_url;



	    echo "\n/* ]]> */\n";



	    echo "</script>\n";



	}



	// Function for add setting menu

	public function ccng_dummy_card_plugin_menu() {



		add_options_page( __('Credit Card Number Generator','credit-card-number-generator'), 



			__('Credit Card Number Generator','credit-card-number-generator'), 'manage_options', 'wli-credit-card-generator', array($this, 'ccng_card_plugin_menu_option') );



	}



	// Function for admin settings page

	public function ccng_card_plugin_menu_option() {



		if ( !current_user_can( 'manage_options' ) )  {



			wp_die( __( 'Opps... You do not have sufficient permissions to access this page.' ) );



		}



		?>



		<h1 style="line-height: 32px;"><?php _e("Credit Card Number Generator",'credit-card-number-generator'); ?></h1>



		<div class="wrap">



			<form id="wli_frm_update" method="post" action="">



				<!-- Call General CTA section -->

				<?php $this->ccng_general_section_callback(); ?>



				<table class="form-table">



					<tbody>



						<!-- Enable Field Start -->

						<tr>



							<th scope="row"><label for="WLI_plugin_status"><?php _e("Enable Plugin",'credit-card-number-generator'); ?></label></th>



							<td><input name="WLI_plugin_status" type="checkbox" id="WLI_plugin_status" value="enable" <?php if("true" == esc_attr(get_option( 'CCNG_DUMMY_CARD_status' ))){ echo 'checked'; } ?> >



								<p class="description" id="wli_enable_desc"><?php _e("Uncheck this check box to disable the plugin.",'credit-card-number-generator'); ?></p>



							</td>



						</tr><!-- Enable Field End -->



						<!-- Generate button Text Field Start -->

						<tr>



							<th scope="row"><label for="wli_generate_btn_txt"><?php _e("Generate Button Link Text",'credit-card-number-generator'); ?></label></th>



							<td><input name="wli_generate_btn_txt" type="text" id="wli_generate_btn_txt" value="<?php echo esc_attr(get_option( 'CCNG_generate_btn_link_text' )); ?>" class="regular-text">



								<p class="description" id="btn_text_desc"><?php _e("Text for generate button link.",'credit-card-number-generator'); ?></p>



							</td>



						</tr><!-- Generate button Text Field End -->



						<!-- Generate button Text Color Start -->

						<tr>



							<th scope="row"><label for="ccng_generate_btn_txt_color"><?php _e("Generate Button Text Color",'credit-card-number-generator'); ?></label></th>



							<td><input name="ccng_generate_btn_txt_color" type="text" id="ccng_generate_btn_txt_color" value="<?php echo esc_attr(get_option( 'CCNG_generate_btn_txt_color' )); ?>" class="regular-text wli-color">



								<p class="description" id="btn_text_desc"><?php _e("Color for generate button text.",'credit-card-number-generator'); ?></p>



							</td>



						</tr><!-- Generate button Text Color End -->



						<!-- Generate button Color Field Start -->

						<tr>



							<th scope="row"><label for="wli_generate_btn_color"><?php _e("Generate Button Background Color",'credit-card-number-generator'); ?></label></th>



							<td><input name="wli_generate_btn_color" type="text" id="wli_generate_btn_color" value="<?php echo esc_attr(get_option( 'CCNG_generate_btn_link_color' )); ?>" class="regular-text wli-color">



								<p class="description" id="btn_color_desc"><?php _e("Background Color for generate button.",'credit-card-number-generator'); ?></p>



							</td>



						</tr><!-- Generate button Color Field End -->



						<!-- Copy button Text Field Start -->

						<tr>



							<th scope="row"><label for="wli_copy_btn_txt"><?php _e("Copy Button Link Text",'credit-card-number-generator'); ?></label></th>



							<td><input name="wli_copy_btn_txt" type="text" id="wli_copy_btn_txt" value="<?php echo esc_attr(get_option( 'CCNG_copy_btn_link_text' )); ?>" class="regular-text">



								<p class="description" id="btn_text_desc"><?php _e("Text for copy button link.",'credit-card-number-generator'); ?></p>



							</td>



						</tr><!-- Copy button Text Field End -->





						

						<!-- Copy button text color Field Start -->

						<tr>



							<th scope="row"><label for="WLI_copy_text_color"><?php _e("Copy Button Text Color",'credit-card-number-generator'); ?></label></th>



							<td><input name="WLI_copy_text_color" type="text" id="WLI_copy_text_color" value="<?php echo esc_attr(get_option( 'CCNG_cpy_btn_txt_color' )); ?>" class="regular-text wli-color">



								<p class="description" id="btn_color_desc"><?php _e("Color for copy button text.",'credit-card-number-generator'); ?></p>



							</td>



						</tr><!-- Copy button text color Field End -->



						<!-- Copy button Color Field Start -->

						<tr>



							<th scope="row"><label for="wli_copy_btn_color"><?php _e("Copy Button Background Color",'credit-card-number-generator'); ?></label></th>



							<td><input name="wli_copy_btn_color" type="text" id="wli_copy_btn_color" value="<?php echo esc_attr(get_option( 'CCNG_copy_btn_link_color' )); ?>" class="regular-text wli-color">



								<p class="description" id="btn_color_desc"><?php _e("Background Color for copy button.",'credit-card-number-generator'); ?></p>



							</td>



						</tr><!-- Copy button Color Field End -->



						<!-- Shortcode Info. Start -->

						<tr>

							<th scope="row"><label><?php _e("Shortcode:",'credit-card-number-generator'); ?></label></th>

							<td>

								<code>[ccng_credit_cards]</code>

								<p class="description"><?php _e("Use this shortcode in posts and pages.",'credit-card-number-generator'); ?></p>

							</td>

						</tr> <!-- Shortcode Info. End -->



					</tbody>



				</table>



				<?php $wli_img_loader = CCNG_CARD_GENERATOR_ASSESTS_URL.'images/settings.gif'; ?>



				<img src="<?php echo esc_url($wli_img_loader); ?>" alt="Updating..." height="42" width="50" id="wli_loder_img" style="display:none;" />



				<div class="col span_12" id="WLI_form_success" style="display: none;font-size: 14px; color:#0073aa;"></div>

				

				<p class="submit"><input type="button" name="wli_frm_submit" id="wli_frm_submit" class="button button-primary" value="<?php _e("Save Changes",'credit-card-number-generator'); ?>"></p>



			</form>



		</div>



		<?php



		$this->ccng_add_script();



	}



	// Function for handle admin form submission

	public function ccng_add_script() { ?>



		<script type="text/javascript">



			jQuery(document).ready(function(){



				// Initilize WP color picker

				jQuery('.wli-color').wpColorPicker();



				// Handle Admin Form Submission

				jQuery('#wli_frm_submit').click(function(e){



					e.preventDefault();



					jQuery('#WLI_form_success').css('display', 'none');



					jQuery('#wli_loder_img').css('display','block');



					if (jQuery('input#WLI_plugin_status').is(':checked')) { 



						var wli_plguin_state = "true";



					}else{



						var wli_plguin_state = "false";



					}



					var wli_generate_btn_link_text = jQuery("#wli_generate_btn_txt").val();



					var wli_generate_btn_link_color = jQuery("#wli_generate_btn_color").val();



					var wli_copy_btn_link_text = jQuery("#wli_copy_btn_txt").val();



					var wli_copy_btn_link_color = jQuery("#wli_copy_btn_color").val();



					var ccng_generate_btn_txt_color = jQuery("#ccng_generate_btn_txt_color").val();



					var ccng_copy_btn_txt_color = jQuery("#WLI_copy_text_color").val();

 

					var data_string = "action=wli_credit_card_edit&WLI_plugin_status="+wli_plguin_state+"&WLI_btn_title="+wli_generate_btn_link_text+"&WLI_btn_color="+wli_generate_btn_link_color+"&WLI_copy_title="+wli_copy_btn_link_text+"&WLI_copy_color="+wli_copy_btn_link_color+"&WLI_gen_text_color="+ccng_generate_btn_txt_color+"&WLI_cpy_text_color="+ccng_copy_btn_txt_color;



					var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';



					jQuery.ajax({



						type:    "POST",



						url:     admin_ajax_params.ajax_url,



						dataType: 'json',



						data:    data_string,



						// async : false,



						success: function(data){



							jQuery('#wli_loder_img').css('display','none');



							jQuery('#WLI_form_success').css('display', 'block');



							jQuery('#WLI_form_success').text('Settings Updated Successfully!');



						}



					}); 



				});



			});



		</script>



	<?php }



	// Function for handle ajax

	public function ccng_credit_card_edit_callback() {



		if( isset($_POST) ) {

			

			update_option( 'CCNG_DUMMY_CARD_status', sanitize_text_field($_POST['WLI_plugin_status']) );



			update_option( 'CCNG_generate_btn_link_text', sanitize_text_field($_POST['WLI_btn_title']) );



			update_option( 'CCNG_generate_btn_link_color', sanitize_hex_color($_POST['WLI_btn_color']) );



			update_option( 'CCNG_generate_btn_txt_color', sanitize_hex_color($_POST['WLI_gen_text_color']) );



			update_option( 'CCNG_copy_btn_link_text', sanitize_text_field($_POST['WLI_copy_title']) );



			update_option( 'CCNG_copy_btn_link_color', sanitize_hex_color($_POST['WLI_copy_color']) );



			update_option( 'CCNG_cpy_btn_txt_color', sanitize_hex_color($_POST['WLI_cpy_text_color']) );

	    }



		die();



	}



	// Function for add action link

	public function ccng_add_action_links( $links_array ){



		array_unshift( $links_array, '<a href="' . admin_url( 'options-general.php?page=wli-credit-card-generator' ) . '">Settings</a>' );

		

		return $links_array;

	}



	// When user is on a Credit Card Number Generator related admin page, display footer 

	public function ccng_admin_footer( $text ) {



		global $current_screen;



		if ( ! empty( $current_screen->id ) && strpos( $current_screen->id, 'wli-credit-card-generator' ) !== false ) {

			

			$url  = 'https://wordpress.org/plugins/credit-card-number-generator/';

			$wpdev_url  = 'https://www.weblineindia.com/wordpress-development.html?utm_source=WP-Plugin&utm_medium=Credit%20Card%20Number%20Generator&utm_campaign=Footer%20CTA';

			$text = sprintf(

				wp_kses(

					'Please rate our plugin %1$s <a href="%2$s" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%3$s" target="_blank" rel="noopener">WordPress.org</a> to help us spread the word. Thank you from the <a href="%4$s" target="_blank" rel="noopener noreferrer">WordPress development</a> team at WeblineIndia.',

					array(

						'a' => array(

							'href'   => array(),

							'target' => array(),

							'rel'    => array(),

						),

					)

				),

				'<strong>"Credit Card Number Generator"</strong>',

				$url,

				$url,

				$wpdev_url

			);

		}



		return $text;

	}



}



// Class Obj.

new Credit_Card_Number_Generator_Admin;

?>