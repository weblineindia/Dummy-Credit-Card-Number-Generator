<?php

// Shortcode for widget
function ccng_get_credit_cards_number() {

	ob_start();

	$instance = array(
    	'title' => __('Credit Card Number Generator', ' credit-card-number-generator'),
    );
    
    the_widget('Credit_Card_Number_Generator_Widget', $instance, array(
        'before_widget' => '<div class="shortcode-wrapper">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));
    
    $contents = ob_get_contents();
    
    ob_get_clean(); 

    return $contents;
}

add_shortcode('ccng_credit_cards', 'ccng_get_credit_cards_number');

?>