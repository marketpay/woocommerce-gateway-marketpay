(function($) {

	var url = window.location.href;
	
	$(document).ready(function() {
		
		if (url.indexOf('user-new') > 0 || url.indexOf('user-edit') > 0) {
	        
			/** Initialization **/
	        test_role();
	            
			/** Retest when changed **/
	        $('#role').change(function() {
	            test_role();
	        });
	        
	        $('#user_mp_status').change(function() {
	            test_mpstatus();
	        });
		}
	});
	
	/**
	 * Will be called upon page init, and when #apply_for_vendor field changes
	 * 
	 */
	function test_role() {
		
		var actual_user_mp_status = $('#actual_user_mp_status').val();
		if (actual_user_mp_status != undefined && actual_user_mp_status != "") {
			/** Do nothing **/
			
		} else {
			/** What is the selected role? **/
			var selected_role = $('#role').val();
			var default_status = '';
			var value_to_validate = '';

			/** If anything else than VENDOR **/
			if (selected_role != translate_object.vendor_role && selected_role != 'pending_vendor') { //'customer'
				default_status = $('#actual_default_buyer_status').val();
			}
			
			/** If VENDOR **/
			if (selected_role == translate_object.vendor_role || selected_role == 'pending_vendor') {
				default_status = $('#actual_default_vendor_status').val();
			}
            
			/** If status is either open the selector **/
			if(default_status == 'either'){                
				/** Show **/
				interchange_status_fields(true);
				//$('#user_mp_status').prop('disabled', false);
				$('#user_mp_status').val('');
				$('#hidden_user_mp_status').val('');

			} else {
				/** Preselect the value and keep it hidden **/
				interchange_status_fields(false);
				//$('#user_mp_status').prop('disabled', true);

				if(default_status == 'individuals'){
					value_to_validate = "individual";
				}
				if(default_status == 'businesses'){
					value_to_validate = "business";
				}

				$('#user_mp_status').val(value_to_validate);
				$('#hidden_user_mp_status').val(value_to_validate);
			}
		}

		/**
		 * In any case 
		 * After all that, we test for the user_business_type
		 * 
		 */
		test_mpstatus();
	}

	function interchange_status_fields(enable){
        if(enable){
            //enable select field
            $('#user_mp_status').prop('disabled', false);
            //disable hidden field
            $('#hidden_user_mp_status').prop('disabled', true);
        }else{
            //disable select field
            $('#user_mp_status').prop('disabled', true);
            //enable hidden field
            $('#hidden_user_mp_status').prop('disabled', false);
        }
    }
       
    function interchange_business_fields(enable){
        if(enable){
            //enable select
            $('#user_business_type').prop('disabled', false);
            //disable hidden field
            $('#hidden_user_business_type').prop('disabled', true);
        }else{
            //disable select
            $('#user_business_type').prop('disabled', true);
            //enable hidden field
            $('#hidden_user_business_type').prop('disabled', false);            
        }        
    }
    
	/**
     * Will be called when the #reg_user_mp_status changes
     * 
     */
	function test_mpstatus(){

		var value_to_validate_btype = '';
		var selected_mp_status = $('#user_mp_status').val();
       
		if(selected_mp_status == "business"){ // We use the field
			$('#block_tr_user_business_type').show();
			var actual_default_business_type = $('#actual_default_business_type').val();               
			if(actual_default_business_type == "either" || $('#business_type_edit').val() == 1){
				/** Show it **/
                interchange_business_fields(true);
				//$('#user_business_type').prop('disabled', false);
				
           }else{
               interchange_business_fields(false);
        	   //$('#user_business_type').prop('disabled', true);
               
        	   if($('#user_business_type').val() != undefined && $('#user_business_type').val() != ''){
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
            	   $('#user_business_type').val(value_to_validate_btype);
                   $('#hidden_user_business_type').val(value_to_validate_btype);
               }
           }
           
       } else {
    	   /** Is not business: should not be here neither have a value **/
    	   $('#block_tr_user_business_type').hide();
    	   $('#user_business_type').val('');
           $('#hidden_user_business_type').val('');
       }
	}

})( jQuery );