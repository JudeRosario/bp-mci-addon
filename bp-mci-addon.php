<?php
/**
 * Plugin Name: MailChimp + BuddyPress Profile Integration
 * Version: 1.0.0
 * Description: This code snippet pulls data from BuddyPress profiles and bundles it in a call to the MailChimp 2.0 API 
 * Author: Jude (WPMU DEV)
 * Author URI: http://premium.wpmudev.org/
 */


if(!class_exists('BuddyPress_MailChimp_Integration')):
	class BuddyPress_MailChimp_Integration {

		function __construct () { }

	// The starting point to this addon/class
		public static function serve () {
			$me = new self;
			$me->add_hooks();
		}

	// Hooks into psts_setting_checkout_url and fixes the url
		private function add_hooks () {
			// When a user is updated
				add_action( 'xprofile_updated_profile', array($this,'integrate_profile_fields') );

			// When a user signs up or is activated 
				add_action( 'bp_core_signup_user',      array($this,'integrate_profile_fields') );
				add_action( 'bp_core_activated_user',   array($this,'integrate_profile_fields') );
		}

	// Code to check if the record exists, update otherwise create a new entry 

		function integrate_profile_fields( $setting, $default ) {
			
			// Get profile data from BuddyPress
			$name = explode(" ", xprofile_get_field_data( 1 , $user_id )) ;
			$user = get_userdata($user_id);
		
		
			// Get groups and Auto optin settings from MailChimp
			$merge_groups = mailchimp_get_interest_groups();
			$autopt = $mailchimp_auto_opt_in == 'yes' ? true : false;

			
			// Add name and groups to final array
			$merge_vars = array(  'FNAME' => $name[0] ,
						   	 	  'LNAME' => $name[1]." ".$name[2]." ".$name[3] );	

			if ( ! empty( $merge_groups ) )
				$merge_groups = array( 'groupings' => $merge_groups );
			$merge_vars = array_merge( $merge_vars, $merge_groups );

			// Make an API call
			mailchimp_subscribe_user( $user->user_email, $mailchimp_mailing_list, $autopt, $merge_vars, true );

		return ; 
		}

	}
endif;

// Check if the base plugin is installed before activating the addon 
add_action('plugins_loaded', 'init_bp_mci') ;

	function init_bp_mci () {
		if (class_exists('WPMUDEV_MailChimp_Sync'))
			BuddyPress_MailChimp_Integration::serve() ; 
	}
?>