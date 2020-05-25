<?php

class Credit_Card_Number_Generator_Widget extends WP_Widget {

	// Class Constructor
	function __construct() {
		parent::__construct(
			// widget ID
			'Credit_Card_Number_Generator_Widget',
			// widget name
			__('Credit Card Number Generator', ' credit-card-number-generator'),
			// widget description
			array( 'description' => __( 'Simple widget for Credit Card Number Generate', 'credit-card-number-generator' ), )
		);
	}

	// Function for widget output
	public function widget( $args, $instance ) {
	
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		//if title is present
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		//output
		echo __( 'Please select card type to get credit card number.', 'credit-card-number-generator' );

		// Get Generate button link
		if( "" == get_option( "CCNG_generate_btn_link_text" ) ){

			$wli_btn_link_text = __('Generate', 'credit-card-number-generator');

		}else{

			$wli_btn_link_text = get_option( "CCNG_generate_btn_link_text" );

		}

		// Get Generate button color
		if( "" == get_option( "CCNG_generate_btn_link_color" ) ){

			$bgcolor = sanitize_hex_color("#ffbd33");

		}else{

			$bgcolor = get_option( "CCNG_generate_btn_link_color" );

		}

		// Get Copy button link
		if( "" == get_option( "CCNG_copy_btn_link_text" ) ){

			$wli_cpy_link_text = __('Copy to Clipboard', 'credit-card-number-generator');

		}else{

			$wli_cpy_link_text = get_option( "CCNG_copy_btn_link_text" );

		}

		// Get Copy button color
		if( "" == get_option( "CCNG_copy_btn_link_color" ) ){

			$cpycolor = sanitize_hex_color("#ffbd33");

		}else{

			$cpycolor = get_option( "CCNG_copy_btn_link_color" );

		}

		// Get Generate button text vcolor
		if( "" == get_option( "CCNG_generate_btn_txt_color" ) ){

			$txtgencolor = sanitize_hex_color("#000000");

		}else{

			$txtgencolor = get_option( "CCNG_generate_btn_txt_color" );

		}

		// Get Copy button text color
		if( "" == get_option( "CCNG_cpy_btn_txt_color" ) ){

			$txtcpycolor = sanitize_hex_color("#000000");

		}else{

			$txtcpycolor = get_option( "CCNG_cpy_btn_txt_color" );

		}
		
		?>
		<div class="wli-footer-wrapper">
			<ul class="cards list-unstyled">
				<li><span class="card v" title="Visa"><?php _e('Visa', ' credit-card-number-generator'); ?></span></li>
				<li><span class="card m" title="Master Card"><?php _e('Master Card', ' credit-card-number-generator'); ?></span></li>
				<li><span class="card a" title="American Express"><?php _e('American Express', ' credit-card-number-generator'); ?></span></li>
				<li><span class="card d" title="Discover"><?php _e('Discover', ' credit-card-number-generator'); ?></span></li>
				<li><span class="card j" title="JCB"><?php _e('JCB', ' credit-card-number-generator'); ?></span></li>
				<li><span class="card di" title="Diners"><?php _e('Diners', ' credit-card-number-generator'); ?></span></li>
			</ul>
			<select class='wli-cards' id="cards-type" name="cards-type" type="text">
				<option><?php _e('Select Card Type', ' credit-card-number-generator'); ?></option>                
	          	<option value="amex"><?php _e('American Express', ' credit-card-number-generator'); ?></option>
	          	<option value="disc"><?php _e('Discover', ' credit-card-number-generator'); ?></option> 
	          	<option value="mc"><?php _e('Master Card', ' credit-card-number-generator'); ?></option> 
	          	<option value="visa"><?php _e('Visa', ' credit-card-number-generator'); ?></option>
	          	<option value="visae"><?php _e('Visa Electron', ' credit-card-number-generator'); ?></option>
	          	<option value="maes"><?php _e('Maestro', ' credit-card-number-generator'); ?></option>
	          	<option value="jcb"><?php _e('JCB', ' credit-card-number-generator'); ?></option>
	          	<option value="dcus"><?php _e('Diners Club - USA & Canada', ' credit-card-number-generator'); ?></option>
	          	<option value="dcin"><?php _e('Diners Club - International', ' credit-card-number-generator'); ?></option>
	        </select>

	        <button style="background-color:<?php echo esc_html($bgcolor); ?>; color:<?php echo esc_html($txtgencolor); ?>" class="btn-generate" data-clipboard-target="#wli-output-footer" title="Get Number"><?php echo esc_html($wli_btn_link_text); ?></button>

	        <div class="output-wrapper"></div>
	        
	        <div class="wli-tooltip">
	        	<button style="background-color:<?php echo esc_html($cpycolor); ?>; color:<?php echo esc_html($txtcpycolor); ?>" class="btn-copy-footer" title="Click to Copy" data-clipboard-target="#wli-output-footer"><?php echo esc_html($wli_cpy_link_text); ?></button>
	        	<button style="background-color:<?php echo esc_html($cpycolor); ?>; color:<?php echo esc_html($txtcpycolor); ?> " class="btn-copy-short" title="Click to Copy" data-clipboard-target="#wli-output-short"><?php echo esc_html($wli_cpy_link_text); ?></button>
	        </div>

    	</div>
        <?php
		echo $args['after_widget'];
	}

	// Function for Widget form
	public function form( $instance ) {
	
		if ( isset( $instance[ 'title' ] ) )
			$title = $instance[ 'title' ];
		else
			$title = __( 'Credit Card Number Generator', 'credit-card-number-generator' );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php
	}

	// Function for Update widget
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

	return $instance;
	}
}

// Function for Register Widget.
function ccng_register_widget() {
	register_widget( 'Credit_Card_Number_Generator_Widget' );
}

// Add action for widget register
add_action( 'widgets_init', 'ccng_register_widget' );