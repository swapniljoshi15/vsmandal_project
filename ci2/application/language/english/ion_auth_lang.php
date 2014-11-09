<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Account Successfully Created';
$lang['account_creation_unsuccessful'] 	 	 = 'Unable to Create Account';
$lang['account_creation_duplicate_email'] 	 = 'Email Already Used or Invalid';
$lang['account_creation_duplicate_username'] = 'Username Already Used or Invalid';

// Password
$lang['password_change_successful'] 	 	 = 'Password Successfully Changed';
$lang['password_change_unsuccessful'] 	  	 = 'Unable to Change Password';
$lang['forgot_password_successful'] 	 	 = 'Password Reset Email Sent';
$lang['forgot_password_unsuccessful'] 	 	 = 'Unable to Reset Password';

// Activation
$lang['activate_successful'] 		  	     = 'Account Activated';
$lang['activate_unsuccessful'] 		 	     = 'Unable to Activate Account';
$lang['deactivate_successful'] 		  	     = 'Account De-Activated';
$lang['deactivate_unsuccessful'] 	  	     = 'Unable to De-Activate Account';
$lang['activation_email_successful'] 	  	 = 'Activation Email Sent';
$lang['activation_email_unsuccessful']   	 = 'Unable to Send Activation Email';

// Login / Logout
$lang['login_successful'] 		  	         = 'Logged In Successfully';
$lang['login_unsuccessful'] 		  	     = 'Incorrect Login';
$lang['login_unsuccessful_not_active'] 		 = 'Account is inactive';
$lang['login_timeout']                       = 'Temporarily Locked Out.  Try again later.';
$lang['logout_successful'] 		 	         = 'Logged Out Successfully';

// Account Changes
$lang['update_successful'] 		 	         = 'Account Information Successfully Updated';
$lang['update_unsuccessful'] 		 	     = 'Unable to Update Account Information';
$lang['delete_successful']               = 'User Deleted';
$lang['delete_unsuccessful']           = 'Unable to Delete User';

// Groups
$lang['group_creation_successful']  = 'Group created Successfully';
$lang['group_already_exists']       = 'Group name already taken';
$lang['group_update_successful']    = 'Group details updated';
$lang['group_delete_successful']    = 'Group deleted';
$lang['group_delete_unsuccessful'] 	= 'Unable to delete group';
$lang['group_name_required'] 		= 'Group name is a required field';

// Activation Email
$lang['email_activation_subject']            = 'Account Activation';
$lang['email_activate_heading']    = 'Activate account for %s';
$lang['email_activate_subheading'] = 'Please click this link to %s.';
$lang['email_activate_link']       = 'Activate Your Account';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Forgotten Password Verification';
$lang['email_forgot_password_heading']    = 'Reset Password for %s';
$lang['email_forgot_password_subheading'] = 'Please click this link to %s.';
$lang['email_forgot_password_link']       = 'Reset Your Password';

// New Password Email
$lang['email_new_password_subject']          = 'New Password';
$lang['email_new_password_heading']    = 'New Password for %s';
$lang['email_new_password_subheading'] = 'Your password has been reset to: %s';

//user management
$lang['index_logout_user_link'] = 'Logout User';

//raw material
$lang['raw_material_add_successful']  = 'Raw Material added successfully';
$lang['raw_material_add_unsuccessful']       = 'Some error occured while adding raw material';
$lang['raw_material_edit_successful']  = 'Raw Material edited successfully';
$lang['raw_material_edit_unsuccessful']       = 'Some error occured while changing raw material';
$lang['raw_material_delete_successful']  = 'Raw Material deletd successfully';
$lang['raw_material_delete_unsuccessful']       = 'Some error occured while deleting raw material';
$lang['raw_material_fetch_unsuccessful']       = 'Some error occured while fetching raw material';

//packet management
$lang['packet_management_add_successful']  = 'Packet Information added successfully';
$lang['packet_management_add_unsuccessful']       = 'Some error occured while adding packet information';
$lang['packet_management_edit_successful']  = 'Packet Information edited successfully';
$lang['packet_management_edit_unsuccessful']       = 'Some error occured while editing packet information';
$lang['packet_management_delete_successful']  = 'Packet Information removed successfully';
$lang['packet_management_delete_unsuccessful']       = 'Some error occured while removing packet information';
$lang['packet_management_fetch_unsuccessful']  = 'Some error occured while packet information';

//utana group management
$lang['utana_group_management_add_successful']  = 'Utana group added successfully';
$lang['utana_group_management_add_unsuccessful']       = 'Some error occured while adding utana group';
$lang['utana_group_management_edit_successful']  = 'Utana group edited successfully';
$lang['utana_group_management_edit_unsuccessful']       = 'Some error occured while editing utana group';
$lang['utana_group_management_delete_successful']  = 'Utana group deleted successfully';
$lang['utana_group_management_delete_unsuccessful']       = 'Some error occured while deleting utana group';
$lang['utana_group_management_fetch_unsuccessful']  = 'Some error occured while fetching utana group';

//input raw material
$lang['input_raw_material_add_successful']  = 'Raw materials availability added successfully';
$lang['input_raw_material_add_unsuccessful']       = 'Some error occured while availability of raw materials';

//batch management
$lang['batch_management_add_successful']  = 'Batch added successfully';
$lang['batch_management_add_unsuccessful']       = 'Some error occured while adding batch';
$lang['batch_management_edit_successful']  = 'Batch edited successfully';
$lang['batch_management_edit_unsuccessful']       = 'Some error occured while editing batch';
$lang['batch_management_delete_successful']  = 'Batch deleted successfully';
$lang['batch_management_delete_unsuccessful']       = 'Some error occured while deleting batch';
$lang['batch_management_fetch_unsuccessful']       = 'Some error occured while fetching batch';

$lang['batch_management_packetinfo_add_successful']  = 'Batch packet information added successfully';
$lang['batch_management_packetinfo_add_unsuccessful']       = 'Some error occured while adding batch packet information';
$lang['batch_management_packetinfo_edit_successful']  = 'Batch packet information edited successfully';
$lang['batch_management_packetinfo_edit_unsuccessful']       = 'Some error occured while editing batch packet information';
$lang['batch_management_packetinfo_fetch_unsuccessful']       = 'Some error occured while fetching batch packet information';

//placed orders
$lang['online_order_add_successful']  = 'online order added successfully';
$lang['online_order_add_unsuccessful']       = 'Some error occured while adding online order';
$lang['online_order_edit_successful']  = 'online order edited successfully';
$lang['online_order_edit_unsuccessful']       = 'Some error occured while editing online order';
$lang['online_order_fetch_unsuccessful']       = 'Some error occured while fetching online order';

//other expenses
$lang['other_expenses_add_successful']  = 'Other expense added successfully';
$lang['other_expenses_add_unsuccessful']       = 'Some error occured while adding other expense';
$lang['other_expenses_edit_successful']  = 'Other expense edited successfully';
$lang['other_expenses_edit_unsuccessful']       = 'Some error occured while edting other expense';
$lang['other_expenses_delete_successful']  = 'Other expense deleted successfully';
$lang['other_expenses_delete_unsuccessful']       = 'Some error occured while deleting other expense';
$lang['other_expenses_fetch_unsuccessful']       = 'Some error occured while fetching other expenses';

//create new distribution batch
$lang['distribution_batch_add_successful']  = 'Distribution batch for user created successfully';
$lang['distribution_batch_add_unsuccessful']       = 'Some error occured while creating distribution batch for user';
$lang['distribution_batch_return_packet_successful']  = 'Packets return entry updated successfully';
$lang['distribution_batch_return_packet_unsuccessful']       = 'Some error occured while updating return packets';
$lang['distribution_batch_add_packet_successful']  = 'Packets added entry updated successfully';
$lang['distribution_batch_add_packet_unsuccessful']       = 'Some error occured while adding return packets';
$lang['distribution_batch_insufficient_packets']  = 'Selected type packets are not available to create new distribution batch';
$lang['distribution_batch_fetch_unsuccessful']       = 'Some error occured while fetching distribution batch';

//account management(received amount / payback amount)
$lang['account_management_update_successful']  = 'Account information(Amount) for user updated successfully';
$lang['account_management_update_unsuccessful']       = 'Some error occured while updating account information(amount) for user';
$lang['account_management_fetch_unsuccessful']       = 'Some error occured while fetching account information for user';
