<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Community Auth - Upload Library Extension
 *
 * Community Auth is an open source authentication application for CodeIgniter 2.1.3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2013, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

/**
 * This class simply extends the Session class for two reasons:
 *
 * 1) So that when autoloading Session, a cookie is not set until required 
 * to be set. In other words, we don't just create a cookie because we can.
 *
 * 2) Remember Me functionality allows the session expiration to be modified
 * if enabled in the config, and if the user selects to be remembered during login.
 */
class MY_Session extends CI_Session {

	private $sess_exists = FALSE;

	/**
	 * Session Constructor
	 *
	 * The constructor runs the session routines automatically
	 * whenever the class is instantiated.
	 */
	public function __construct($params = array())
	{
		log_message('debug', "Session Class Initialized");

		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();

		// Set all the session preferences, which can either be set
		// manually via the $params array above or via the config file
		foreach (array('sess_encrypt_cookie', 'sess_use_database', 'sess_table_name', 'sess_expiration', 'sess_expire_on_close', 'sess_match_ip', 'sess_match_useragent', 'sess_cookie_name', 'cookie_path', 'cookie_domain', 'cookie_secure', 'sess_time_to_update', 'time_reference', 'cookie_prefix', 'encryption_key') as $key)
		{
			$this->$key = (isset($params[$key])) ? $params[$key] : $this->CI->config->item($key);
		}

		if ($this->encryption_key == '')
		{
			show_error('In order to use the Session class you are required to set an encryption key in your config file.');
		}

		// Load the string helper so we can use the strip_slashes() function
		$this->CI->load->helper('string');

		// Do we need encryption? If so, load the encryption class
		if ($this->sess_encrypt_cookie == TRUE)
		{
			$this->CI->load->library('encrypt');
		}

		// Are we using a database?  If so, load it
		if ($this->sess_use_database === TRUE AND $this->sess_table_name != '')
		{
			$this->CI->load->database();
		}

		// Set the "now" time.  Can either be GMT or server time, based on the
		// config prefs.  We use this to set the "last activity" time
		$this->now = $this->_get_time();

		// Set the session length. If the session expiration is
		// set to zero we'll set the expiration two years from now.
		if ($this->sess_expiration == 0)
		{
			$this->sess_expiration = (60*60*24*365*2);
		}

		// Check if remember me effecting the session duration
		if( 
			$this->CI->config->item('allow_remember_me') && 
			$this->CI->input->cookie( $this->CI->config->item('remember_me_cookie_name') ) 
		)
		{
			// Set the expiration date to the exact same one that the remember me cookie has
			$this->sess_expiration = $this->CI->input->cookie( $this->CI->config->item('remember_me_cookie_name') ) - time();

			// If session is normally set to expire on close, make sure it doesn't
			$this->sess_expire_on_close = FALSE;
		}

		// Set the cookie name
		$this->sess_cookie_name = $this->cookie_prefix.$this->sess_cookie_name;

		/**
		 * Run the Session routine. If a session exists we'll update it.
		 * This is the main modification made to the way the Session class works.
		 * Also note that the calls to _flashdata_sweep() and _flashdata_mark()
		 * were moved here because if the session doesn't exist, there 
		 * is no reason to call them.
		 */
		if( $this->sess_read() )
		{
			$this->sess_exists = TRUE;

			$this->sess_update();

			// Delete 'old' flashdata (from last request)
			$this->_flashdata_sweep();

			// Mark all new flashdata as old (data will be deleted before next request)
			$this->_flashdata_mark();
		}

		// Delete expired sessions if necessary
		$this->_sess_gc();

		log_message('debug', "Session routines successfully run");
	}

	// --------------------------------------------------------------------

	/**
	 * Add or change data in the "userdata" array
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_userdata($newdata = array(), $newval = '')
	{
		// Check if session exists and create one if it doesn't.
		$this->_check_session_exists();

		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$this->userdata[$key] = $val;
			}
		}

		$this->sess_write();
	}

	// --------------------------------------------------------------------

	/**
	 * Add or change flashdata, only available
	 * until the next request
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_flashdata($newdata = array(), $newval = '')
	{
		// Check if session exists and create one if it doesn't.
		$this->_check_session_exists();

		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$flashdata_key = $this->flashdata_key.':new:'.$key;
				$this->set_userdata($flashdata_key, $val);
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks if session exists and creates one if it doesn't.
	 *
	 * @access	private
	 * @return	void
	 */
	private function _check_session_exists()
	{
		/**
		 * If the session doesn't exist, create it
		 */
		if( ! $this->sess_exists )
		{
			$this->sess_create();

			$this->sess_exists = TRUE;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Allow public access to session class' _serialize method
	 */
	public function serialize_data( $data )
	{
		return $this->_serialize( $data );
	}

	// ------------------------------------------------------------------------

	/**
	 * Allow public access to session class' _unserialize method
	 */
	public function unserialize_data( $data )
	{
		return $this->_unserialize( $data );
	}

	// ------------------------------------------------------------------------

}

/* End of file MY_Session.php */
/* Location: ./application/libraries/MY_Session.php */