	// Function for reverse string	
	function strrev(str) {
		if (!str) return '';
		var revstr='';
		for (i = str.length-1; i>=0; i--)
			revstr+=str.charAt(i)
		return revstr;
	}

	// 'prefix' is the start of the CC number as a string, any number of digits.
	// 'length' is the length of the CC number to generate. Typically 13 or 16
	
	function completed_number(prefix, length) {
		
		var ccnumber = prefix;
		
		// Generate digits
		while ( ccnumber.length < (length - 1) ) {
			ccnumber += Math.floor(Math.random()*10);
		}
		
		// Reverse number and convert to int 
		var reversedCCnumberString = strrev( ccnumber );
		var reversedCCnumber = new Array();
	    for ( var i=0; i < reversedCCnumberString.length; i++ ) {
	        reversedCCnumber[i] = parseInt( reversedCCnumberString.charAt(i) );   
	    }

	    // Calculate sum        
	    var sum = 0;
	    var pos = 0;
	    while ( pos < length - 1 ) {
	        odd = reversedCCnumber[ pos ] * 2;
	        if ( odd > 9 ) {
	            odd -= 9;
	        }
	        sum += odd;
	        if ( pos != (length - 2) ) {
	            sum += reversedCCnumber[ pos +1 ];
	        }
	        pos += 2;
		}
		    
	    // Calculate check digit
	    var checkdigit = (( Math.floor(sum/10) + 1) * 10 - sum) % 10;
	    ccnumber += checkdigit;

	    return ccnumber;    
	}


	// Function get for credit card number
	function credit_card_number(prefixList, length) {

        var randomArrayIndex = Math.floor(Math.random() * prefixList.length); 
        var ccnumber = prefixList[ randomArrayIndex ];
        return completed_number(ccnumber, length);

	}

	// Array for credit cards

	// Visa
	var visaPrefixList = new Array("4539", "4556", "4916", "4532", "4929", "40240071", "4485", "4716", "4");

	// Vis Electron
	var visaElectronPrefixList = new Array("4026", "417500", "4508", "4844", "4913", "4917");
	
	// Mastercard
	var mastercardPrefixList = new Array("51", "52", "53", "54", "55", "222100", "272099");
	
	// American Express
	var amexPrefixList = new Array("34", "37");
	
	// Discover
	var discoverPrefixList = new Array("6011");
	
	// Mastro
	var maestroPrefixList = new Array("5018", "5020", "5038", "5893", "6304", "6759", "6761", "6762", "6763", "0604");
	
	// JCB
	var jcbPrefixList = new Array("3528", "3529", "3530", "3531", "3532", "3533", "3534", "3535", "3536", "3537", "3538", "3539", "3540", "3541", "3542", "3543", "3544", "3545", "3589");
	
	// Diners International
	var dinersInternationalPrefixList = new Array("36");

	// Diners USA Canada
	var dinersNorthAmericaPrefixList = new Array("54", "55");


	// Function for getting card numbers for shortcode
	function get_card_number_output_shortcode() {

		 // Call Functions
        jQuery(".shortcode-wrapper .visa").text(credit_card_number(visaPrefixList, 16, 1));
        jQuery(".shortcode-wrapper .visae").text(credit_card_number(visaElectronPrefixList, 16, 1));
		jQuery(".shortcode-wrapper .mc").text(credit_card_number(mastercardPrefixList, 16, 1));
		jQuery(".shortcode-wrapper .amex").text(credit_card_number(amexPrefixList, 15, 1));
		jQuery(".shortcode-wrapper .disc").text(credit_card_number(discoverPrefixList, 16, 1));
		jQuery(".shortcode-wrapper .maes").text(credit_card_number(maestroPrefixList, 16, 1));
		jQuery(".shortcode-wrapper .jcb").text(credit_card_number(jcbPrefixList, 16, 1));
		jQuery(".shortcode-wrapper .dcin").text(credit_card_number(dinersInternationalPrefixList, 14, 1));
		jQuery(".shortcode-wrapper .dcus").text(credit_card_number(dinersNorthAmericaPrefixList, 16, 1));
	}

	// Function for getting card numbers for footer
	function get_card_number_output_footer() {

		 // Call Functions
        jQuery(".widget .wli-footer-wrapper .visa").text(credit_card_number(visaPrefixList, 16, 1));
        jQuery(".widget .wli-footer-wrapper .visae").text(credit_card_number(visaElectronPrefixList, 16, 1));
		jQuery(".widget .wli-footer-wrapper .mc").text(credit_card_number(mastercardPrefixList, 16, 1));
		jQuery(".widget .wli-footer-wrapper .amex").text(credit_card_number(amexPrefixList, 15, 1));
		jQuery(".widget .wli-footer-wrapper .disc").text(credit_card_number(discoverPrefixList, 16, 1));
		jQuery(".widget .wli-footer-wrapper .maes").text(credit_card_number(maestroPrefixList, 16, 1));
		jQuery(".widget .wli-footer-wrapper .jcb").text(credit_card_number(jcbPrefixList, 16, 1));
		jQuery(".widget .wli-footer-wrapper .dcin").text(credit_card_number(dinersInternationalPrefixList, 14, 1));
		jQuery(".widget .wli-footer-wrapper .dcus").text(credit_card_number(dinersNorthAmericaPrefixList, 16, 1));
	}

	// Document Ready
	jQuery(document).ready(function() {

		if ( jQuery(".widget").length ) {
			
			// Get Selected Option Value
			jQuery(".widget .wli-footer-wrapper .wli-cards").change(function(){

				jQuery(this).find("option:selected").each(function(){
					var optionValue = jQuery(this).attr("value");
		            if(optionValue){
		            	jQuery(".widget .wli-footer-wrapper .btn-copy-footer").not("." + optionValue).hide();
		             	jQuery('.widget .wli-footer-wrapper .output-wrapper').html('<div class="footer-output"><div id="wli-output-footer" class="'+optionValue+'"></div><div>');

		             	// Call Function
			        	jQuery(document).on('click', '.widget .wli-footer-wrapper .btn-generate', function(){
			        		get_card_number_output_footer();
			        		if (jQuery(".widget .wli-footer-wrapper #wli-output-footer").text().length > 0) {
			        			jQuery('.widget .wli-footer-wrapper .btn-copy-footer').show();
			        		}
			        	});
		            }
		            else
		            {
		            	jQuery('.widget .wli-footer-wrapper .btn-copy-footer').hide();
		            }

		            
		        });

		    }).change();
		}

		if ( jQuery(".shortcode-wrapper").length ) {
			// Get Selected Option Value
			
			jQuery(".shortcode-wrapper .wli-cards").change(function(){
				jQuery(this).find("option:selected").each(function(){
					var optionValue = jQuery(this).attr("value");
		            if(optionValue){
		            	jQuery(".shortcode-wrapper .btn-copy-short").not("." + optionValue).hide();
		             	jQuery('.shortcode-wrapper .output-wrapper').html('<div class="short-output"><div id="wli-output-short" class="'+optionValue+'"></div></div>');

		             	// Call Function
						jQuery(document).on('click', '.shortcode-wrapper .btn-generate', function(){
			        		get_card_number_output_shortcode();
			        		if (jQuery(".shortcode-wrapper #wli-output-short").text().length > 0) {
			        			jQuery('.shortcode-wrapper .btn-copy-short').show();
			        		}
			        	});
		            }
		            else{

		            	jQuery('.shortcode-wrapper .btn-copy-short').hide();	
		            }
		            
		            
		        });           

		    }).change();
		}

		// Copy to Clipboard Footer
		var clipboard = new ClipboardJS('.btn-copy-footer');

		clipboard.on('success', function(e) {
			return e.text;
		});

		clipboard.on('error', function(e) {
  			return "Failed";
		});

		// Copy to Clipboard Shortcode
		var clipboard = new ClipboardJS('.btn-copy-short');

		clipboard.on('success', function(e) {
			return e.text;
		});

		clipboard.on('error', function(e) {
  			return "Failed";
		});

	});