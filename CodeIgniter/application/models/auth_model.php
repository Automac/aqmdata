<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 * Community Auth - Auth_model Model
 *
 * Community Auth is an open source authentication application for CodeIgniter 2.1.3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2013, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

class Auth_model extends MY_Model {

	/**
	 * An array of profile data to select when logging in or checking login.
	 * Anything in this array should exist in all user profile tables
	 *
	 * @var array
	 * @access protected
	 */
	protected $selected_profile_columns = array();

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->selected_profile_columns = config_item('selected_profile_columns');
	}

	/**
	 * Check the user table to see if a user exists by username or email address.
	 * If there was a matching record, combine with select profile data and 
	 * return merged object.
	 *
	 * While this query is rather limited, you could easily add specific user 
	 * profile data. Remember, however, that while encrypted by 
	 * default, the http user cookie is tranmitted via standard http requests.
	 * 
	 * @param   string  either the username or email address of a user
	 * @return  mixed   either query data as object or FALSE
	 */
	public function get_auth_data( $user_string )
	{
		// Selected user table data
		$selected_columns = array(
			'user_name',
			'user_email',
			'user_level',
			'user_pass',
			'user_salt',
			'user_id',
			'user_modified',
			'user_banned'
		);

		// User table query
		$query = $this->db->select( $selected_columns )
			->from( config_item('user_table') )
			->where( 'user_name', $user_string )
			->or_where( 'user_email', $user_string )
			->limit(1)
			->get();

		if ( $query->num_rows() == 1 )
		{
			$row = $query->row_array();

			// Profile data query
			if( ! empty( $this->selected_profile_columns ) )
			{
				// Get the role associated with the user level
				$role = $this->authentication->roles[$row['user_level']];

				$query = $this->db->select( $this->selected_profile_columns )
					->from( config_item( $role . '_profiles_table') )
					->where( 'user_id', $row['user_id'] )
					->limit(1)
					->get();

				if ( $query->num_rows() == 1 )
				{
					// Merge the user data and profile data and return
					return (object) array_merge( $row,  $query->row_array() );
				}
			}

			return $row;
		}

		return FALSE;
	}

	// --------------------------------------------------------------

	/**
	 * Update the user's user table record when they login
	 * 
	 * @param  array  the user's user table data 
	 */
	public function login_update( $user_id, $login_time )
	{
		$data = array(
			'user_last_login'   => $login_time,
			'user_login_time'   => $login_time,
			'user_agent_string' => md5( $this->input->user_agent() )
		);

		$this->db->where( 'user_id' , $user_id )
			->update( config_item('user_table') , $data );
	}

	// --------------------------------------------------------------

	/**
	 * Check user table and confirm there is a record where:
	 *
	 * 1) The last user modification date matches
	 * 2) The user ID matches
	 * 3) The user login time matches ( if multiple logins are not allowed )
	 * 
	 * If there is a matching record, return a specified subset of the record.
	 *
	 * @param   int    the last modification date
	 * @param   int    the user ID
	 * @return  mixed  either query data as an object or FALSE
	 */
	public function check_login_status( $user_last_mod, $user_id, $login_time )
	{
		// Selected user table data
		$selected_columns = array(
			'user_name',
			'user_email',
			'user_level',
			'user_agent_string',
			'user_id',
			'user_banned'
		);

		$this->db->select( $selected_columns );
		$this->db->from( config_item('user_table') );
		$this->db->where( 'user_modified', $user_last_mod );
		$this->db->where( 'user_id', $user_id );

		// If multiple devices are allowed to login at the same time, the user_login_time cannot be checked
		if( config_item('disallow_multiple_logins') === TRUE )
		{
			$this->db->where( 'user_login_time', $login_time );
		}

		$this->db->limit(1);
		$query = $this->db->get();

		if ( $query->num_rows() == 1 )
		{
			$row = $query->row_array();

			// Profile data query
			if( ! empty( $this->selected_profile_columns ) )
			{
				// Get the role associated with the user level
				$role = $this->authentication->roles[$row['user_level']];

				$query = $this->db->select( $this->selected_profile_columns )
					->from( config_item( $role . '_profiles_table') )
					->where( 'user_id', $row['user_id'] )
					->limit(1)
					->get();

				if ( $query->num_rows() == 1 )
				{
					// Merge the user data and profile data and return
					return (object) array_merge( $row,  $query->row_array() );
				}
			}

			return $row;
		}

		return FALSE;
	}

	// --------------------------------------------------------------

	/**
	 * Clear user holds that have expired
	 */
	public function clear_expired_holds()
	{
		$duration = time() - config_item('seconds_on_hold');

		$this->db->delete( config_item('IP_hold_table'), array( 'time <' => $duration ) );

		$this->db->delete( config_item('username_or_email_hold_table'), array( 'time <' => $duration ) );
	}

	// --------------------------------------------------------------

	/**
	 * Clear login errors that have expired
	 */
	public function clear_login_errors()
	{
		$duration = time() - config_item('seconds_on_hold');

		$this->db->delete( config_item('errors_table'), array( 'time <' => $duration ) );
	}

	// --------------------------------------------------------------

	/**
	 * Check that the IP address, username, or email address is not on hold.
	 * 
	 * @param   bool   if check is from recovery (FALSE if from login)
	 * @return  bool
	 */
	public function check_holds( $recovery )
	{
		$ip_hold = $this->check_ip_hold();

		$string_hold = $this->check_username_or_email_hold( $recovery );

		if( $ip_hold === TRUE OR $string_hold === TRUE )
		{
			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------

	/**
	 * Check that the IP address is not on hold
	 * 
	 * @return  bool
	 */
	public function check_ip_hold()
	{
		$ip_hold = $this->db->get_where( 
			config_item('IP_hold_table'), 
			array( 'IP_address' => $this->input->ip_address() ) 
		);

		if( $ip_hold->num_rows() > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------

	/**
	 * Check that the username or email address is not on hold
	 * 
	 * @param   bool   if check is from recovery (FALSE if from login)
	 * @return  bool
	 */
	public function check_username_or_email_hold( $recovery )
	{
		$posted_string = ( ! $recovery ) ? $this->input->post( 'login_string' ) : $this->input->post( 'user_email', TRUE );

		// Check posted string for basic validity.
		if( ! empty( $posted_string ) && strlen( $posted_string ) < 256 )
		{
			$string_hold = $this->db->get_where( 
				config_item('username_or_email_hold_table'), 
				array( 'username_or_email' => $posted_string ) 
			);

			if( $string_hold->num_rows() > 0 )
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	// --------------------------------------------------------------

	/**
	 * Insert a login error into the database
	 * 
	 * @param  array  the details of the login attempt 
	 */
	public function create_login_error( $data )
	{
		$this->db->set( $data )
			->insert( config_item('errors_table') );
	}

	// --------------------------------------------------------------

	/**
	 * Check login errors table to determine if a IP address, username, 
	 * or email address should be placed on hold.
	 * 
	 * @param  string  the supplied username or email address 
	 */
	public function check_login_attempts( $string )
	{
		$ip_address = $this->input->ip_address();

		// Check if this IP now has too many login attempts
		$count = $this->db->where( 'IP_address', $ip_address )
			->count_all_results( config_item('errors_table') );

		if( $count == config_item('max_allowed_attempts') )
		{
			// Place the IP on hold
			$data = array(
				'IP_address' => $ip_address,
				'time'       => time()
			);

			$this->db->set( $data )
				->insert( config_item('IP_hold_table') );
		}

		/**
		 * If for some reason login attempts exceed
		 * the max_allowed_attempts number, we have
		 * the option of banning the user by IP address.
		 */
		else if( 
			$count > config_item('max_allowed_attempts') && 
			$count >= config_item('deny_access') 
		)
		{
			// Send an email to 
			$this->load->library('email');
			$this->config->load('email');
			$admin_email_config = config_item('admin_email_config');

			$this->email->quick_email( array(
				'subject'        => WEBSITE_NAME . ' - Excessive Login Attempts Warning - ' . date("M j, Y"),
				'email_template' => 'email_templates/excessive-login-attempts',
				'from_name'      => 'admin_email_config',
				'to'             => $admin_email_config['from_email']
			) );

			if( config_item('deny_access') > 0 )
			{
				// Log the IP address in the denied_access database
				$data = array(
					'IP_address'  => $ip_address,
					'time'        => time(),
					'reason_code' => '1'
				);

				$this->_insert_denial( $data );

				// Output white screen of death
				header('HTTP/1.1 403 Forbidden');
				die('<h1>Forbidden</h1><p>You don\'t have permission to access ANYTHING on this server.</p><hr><address>Go fly a kite!</address>');
			}
		}

		// Check to see if this username/email-address has too many login attempts
		if( $string != '' )
		{
			$count = $this->db->where( 'username_or_email', $string )
				->count_all_results( config_item('errors_table') );

			if( $count == config_item('max_allowed_attempts') )
			{
				// Place the username/email-address on hold
				$data = array(
					'username_or_email' => $string,
					'time'              => time()
				);

				$this->db->set( $data )
					->insert( config_item('username_or_email_hold_table') );
			}
		}
	}

	// --------------------------------------------------------------

	/**
	 * Get all data from the denied access table,
	 * or set the field parameter to retrieve a single field.
	 */
	public function get_deny_list( $field = FALSE )
	{
		if( $field !== FALSE )
		{
			$this->db->select( $field );
		}

		$query = $this->db->from( config_item('denied_access_table') )->get();

		if( $query->num_rows() > 0 )
		{
			return $query->result();
		}

		return FALSE;
	}

	// --------------------------------------------------------------

	/**
	 * Validate and process the denial or removal of IP addresses
	 * in the denied access table.
	 */
	public function process_denial()
	{
		// The form validation class doesn't allow for multiple config files, so we do it the old fashion way
		$this->config->load( 'form_validation/administration/deny_access' );
		$this->validation_rules = config_item('deny_access_rules');

		if( $this->validate() )
		{
			// If form submission is adding to deny list
			if( $this->input->post('add_denial') )
			{
				$ip     = set_value('ip_address');
				$reason = set_value('reason_code');

				// Make sure that the values we need were posted
				if( ! empty( $ip ) && is_numeric( $reason ) )
				{
					$insert_data = array(
						'IP_address'  => $ip,
						'reason_code' => $reason,
						'time'        => time()
					);

					// Insert the denial
					$this->_insert_denial( $insert_data );

					// Show confirmation that denial was added
					$this->load->vars( array( 'confirm_add_denial' => 1 ) );

					// Kill set_value() since we won't need it
					$this->kill_set_value();
				}

				// Necessary values were not available
				else
				{
					// Show error message
					$this->load->vars( array( 'validation_errors' => '<li>An <span class="redfield">IP ADDRESS</span> is required.</li>' ) );
				}
			}

			// If form submission is removing from deny list
			else if( $this->input->post('remove_selected') )
			{
				// Get the IPs to remove
				$ips = set_value('ip_removals[]');

				// If there were IPs
				if( ! empty( $ips ) )
				{
					// Remove the IPs
					$this->_remove_denial( $ips );

					// Show confirmation of removal
					$this->load->vars( array( 'confirm_removal' => 1 ) );
				}

				// If there were no IPs posted
				else
				{
					// Show error message
					$this->load->vars( array( 'validation_errors' => '<li>At least one <span class="redfield">IP ADDRESS</span> must be selected for removal.</li>' ) );
				}
			}
		}
	}

	// --------------------------------------------------------------

	/**
	 * Add a record to the denied access table
	 */
	protected function _insert_denial( $data )
	{
		if( $data['IP_address'] == '0.0.0.0' )
		{
			return FALSE;
		}

		$this->db->set( $data )
				->insert( config_item('denied_access_table') );

		$this->_rebuild_deny_list();
	}

	// --------------------------------------------------------------

	/**
	 * Remove a record from the denied access table
	 */
	protected function _remove_denial( $ips )
	{
		$i = 0;

		foreach( $ips as $ip)
		{
			if( $i == 0 )
			{
				$this->db->where('IP_address', $ip );
			}
			else
			{
				$this->db->or_where('IP_address', $ip );
			}

			$i++;
		}

		$this->db->delete( config_item('denied_access_table') );

		$this->_rebuild_deny_list();
	}

	// --------------------------------------------------------------

	/**
	 * Rebuild the deny list in the local Apache configuration file
	 */
	private function _rebuild_deny_list()
	{
		// Get all of the IP addresses in the denied access database
		$query_result = $this->get_deny_list('IP_address');

		if( $query_result !== FALSE )
		{
			// Create the denial list to be inserted into the Apache config file
			$deny_list = "\n" . '<Limit GET POST>' . "\n" . 'order deny,allow';

			foreach( $query_result as $row )
			{
				$deny_list .= "\n" . 'deny from ' . $row->IP_address;
			}

			$deny_list .= "\n" . '</Limit>' . "\n";
		}
		else
		{
			$deny_list = "\n";
		}

		// Get the path to the Apache config file
		$htaccess = config_item('apache_config_file_location');

		$this->load->helper('file');

		// Store the file permissions so we can reset them after writing to the file
		$initial_file_permissions = fileperms( $htaccess );

		// Change the file permissions so we can read/write
		chmod( $htaccess, 0644);

		// Read in the contents of the Apache config file
		$string = read_file( $htaccess );

		$pattern = '/(?<=# BEGIN DENY LIST --)(.|\n)*(?=# END DENY LIST --)/';

		// Within the string, replace the denial list with the new one
		$string = preg_replace( $pattern, $deny_list, $string );

		// Write the new file contents
		if ( ! write_file( $htaccess, $string ) )
		{
		     $this->fb->log('Could not write to Apache configuration file');
		}

		// Change the file permissions back to what they were before the read/write
		chmod( $htaccess, $initial_file_permissions );
	}

	// --------------------------------------------------------------

	/**
	 * Remove the user's user_login_time time when they logout
	 * 
	 * @param  int  the user's ID 
	 */
	public function logout( $user_id )
	{
		$data = array( 'user_login_time'   => NULL );

		$this->db->where( 'user_id' , $user_id )
			->update( config_item('user_table') , $data );
	}

	// --------------------------------------------------------------

}

/* End of file auth_model.php */
/* Location: /application/models/auth_model.php */