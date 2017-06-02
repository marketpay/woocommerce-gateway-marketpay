(function($) {
    
	//console.log( 'loading front-type-user.js' );		// Debug
    
	$(document).ready(function() {
		
		//console.log( 'init of front-type-user.js' );	// Debug
		
		if ($('#reg_user_mp_status').length > 0) {
	    	
			//console.log( 'activation of front-type-user.js' );
			
			/** Initialization **/
			test_role();
			    
			/** Retest when changed **/
			$('#apply_for_vendor').change(function() {
			    test_role();
			});
			
			$('#reg_user_mp_status').change(function() {
			    test_mpstatus();
			});
	    }
	});
	
	/**
	 * Will be called upon page init, and when #apply_for_vendor field changes
	 * 
	 */
	function test_role() {
    	
		//console.log( 'test_role()' );					// Debug

		var actual_user_mp_status = $('#actual_user_mp_status').val();
		if (actual_user_mp_status != undefined && actual_user_mp_status != '') {
			/** We already have a value: change nothing **/

		} else {
			/** What is the selected role? (depends on vendor checked ) **/
			var checked_vendor = $('#apply_for_vendor').is(':checked');
			var selected_role = '';
			if(checked_vendor){
				selected_role = translate_object.vendor_role;
			} else {
				selected_role = 'buyer';
			}

			var default_status = '';
			var value_to_validate = '';
			
			/** If anything else than VENDOR **/
			if( selected_role != translate_object.vendor_role ) { //'customer'
				default_status = $('#actual_default_buyer_status').val();
			}

			/** If VENDOR **/
			if( selected_role == translate_object.vendor_role ) {
				default_status = $('#actual_default_vendor_status').val();
			}

			/** If status is either open the selector **/
			if( default_status == 'either' ){
				/** show **/
				$('#block_user_mp_status').show();
				$('#reg_user_mp_status').val('');

			} else {
				/** Preselect the value and keep it hidden **/
				$('#block_user_mp_status').hide();

				if( default_status == 'individuals' ){
					value_to_validate = "individual";
				}
				if( default_status == 'businesses' ){
					value_to_validate = "business";
				}

				$('#reg_user_mp_status').val(value_to_validate);
			}
		}

		/**
		 * In any case 
		 * After all that, we test for the user_business_type
		 * 
		 */
		test_mpstatus();
	}

	/**
	 * Will be called when the #reg_user_mp_status changes
	 * 
	 */
	function test_mpstatus(){            

		//console.log( 'test_mpstatus()' );				// Debug
    	
		var value_to_validate_btype = '';
		var selected_mp_status = $('#reg_user_mp_status').val();
       
    	if(selected_mp_status == "business"){ // We use the field
    		$('#block_user_business_type').show();
    		var actual_default_business_type = $('#actual_default_business_type').val();               
    		if(actual_default_business_type == "either" || $('#actual_user_connected').val() != 0){
    			/** Show it **/
    			$('#block_user_business_type').show();
    			
    		} else {
    			$('#block_user_business_type').hide();

    			if($('#reg_user_business_type').val() != undefined && $('#reg_user_business_type').val() != ''){
    				/** Value already selected: do nothing **/
                   
    			} else {
    				/** else: force the value **/
    				if(actual_default_business_type == "organisations"){
    					value_to_validate_btype = "organisation";
    				}
    				if(actual_default_business_type == "soletraders"){
    					value_to_validate_btype = "soletrader";
    				}
    				if(actual_default_business_type == "businesses"){
    					value_to_validate_btype = "business";
    				}
    				$('#reg_user_business_type').val(value_to_validate_btype);
    			}
    		}
           
    	} else {
    		/** Is not business: should not be here neither have a value **/
    		$('#block_user_business_type').hide();
    		$('#reg_user_business_type').val('');
    	}
	}
 
})( jQuery );