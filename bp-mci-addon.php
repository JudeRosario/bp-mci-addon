<?php
/**
 * Plugin Name: MailChimp + BuddyPress Profile Integration
 * Version: 1.0.0
 * Description: This code snippet pulls data from BuddyPress profiles and bundles it in a call to the MailChimp 2.0 API 
 * Author: Jude (WPMU DEV)
 * Author URI: http://premium.wpmudev.org/
 */


// When a user is updated
add_action( 'xprofile_updated_profile', 'integrate_profile_fields' );


// When a user signs up or is activated 
add_action( 'bp_core_signup_user',      'integrate_profile_fields' );
add_action( 'bp_core_activated_user',   'integrate_profile_fields' );




function integrate_profile_fields ($user_id) {

require_once( MAILCHIMP_PLUGIN_DIR.'mailchimp-sync.php' );
require_once( MAILCHIMP_PLUGIN_DIR.'helpers.php' );

		$mailchimp_mailing_list = get_site_option('mailchimp_mailing_list');
		$mailchimp_auto_opt_in = get_site_option('mailchimp_auto_opt_in');

		// Gets Name from sign up form
		if(isset($_POST['field_1']))
			$name = explode(" ", $_POST['field_1']) ;

		// Gets Name from xProfile Field
		if(is_null($name))
			$name = explode(" ", xprofile_get_field_data( 1, $user_id)) ;

		$autopt = $mailchimp_auto_opt_in == 'yes' ? true : false;
		
		$user = get_userdata($user_id);
		
		$merge_vars = array( 'FNAME' => $name[0]
						   , 'LNAME' => $name[1]." ".$name[2]." ".$name[3]
						   );
		
		$merge_groups = mailchimp_get_interest_groups();
		
		if ( ! empty( $merge_groups ) )
			$merge_groups = array( 'groupings' => $merge_groups );

		$merge_vars = array_merge( $merge_vars, $merge_groups );

		mailchimp_subscribe_user( $user->user_email, $mailchimp_mailing_list, $autopt, $merge_vars, true );
}

?>