<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 * Community Auth - Home View
 *
 * Community Auth is an open source authentication application for CodeIgniter 2.1.3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2013, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */
?>

<h1>Application Framework</h1>

<?php

	if( isset( $auth_level ) )
	{
		echo '
			<p>
				You are seeing this version of the home page because you are logged in.
			</p>
		';
	}
	else
	{
		?>

		You are seeing this version of the home page because you are not logged in. 

		<?php
	}

?>

<p style="padding-top:18px;font-size:85%;color:#777;">
	Page rendered in {elapsed_time} seconds
</p>

<?php

/* End of file home.php */
/* Location: /application/views/home/home.php */