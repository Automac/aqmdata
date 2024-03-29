<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 * Community Auth - Recover Form View
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

<h1>Account Recovery</h1>

<?php
if( isset( $disabled ) )
{
	echo '
		<div class="feedback error_message">
			<p class="feedback_header">
				Account recovery is disabled.
			</p>
			<p style="margin:.4em 0 0 0;">
				If you have exceeded the maximum login attempts, or exceeded
				the allowed number of password recovery attempts, account recovery 
				will be disabled for a short period of time. 
				Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' 
				minutes, or ' . secure_anchor('contact','Contact') . ' ' . WEBSITE_NAME . ' 
				if you require assistance gaining access to your account.
			</p>
		</div>
	';
}
else if( isset( $user_banned ) )
{
	echo '
		<div class="feedback error_message">
			<p class="feedback_header">
				Account locked by ' . WEBSITE_NAME . '.
			</p>
			<p style="margin:.4em 0 0 0;">
				You have attempted to use the password recovery system using 
				an email address that belongs to an account that has been 
				purposely denied access to the authenticated areas of this website. 
				If you feel this is an error, you may ' . secure_anchor('contact','Contact') . ' ' . WEBSITE_NAME . ' 
				to make an inquiry regarding the status of the account.
			</p>
		</div>
	';
}
else if( isset( $confirmation ) )
{
	echo '
		<div class="feedback confirmation">
			<p>
				We have sent you an email with instructions on how 
				to recover your username and/or password.
			</p>
		</div>
	';
}
else if( isset( $no_match ) )
{
	echo '
		<div class="feedback error_message">
			<p class="feedback_header">
				Supplied email did not match any record.
			</p>
		</div>
	';

	$show_form = 1;
}
else
{
	echo '
		<p>
			If you\'ve forgotten your password and/or username, 
			enter the email address used for your account, 
			and ' . WEBSITE_NAME . ' will send you an e-mail 
			with instructions on how to access your account.
		</p>
	';

	$show_form = 1;
}
if( isset( $show_form ) )
{
	?>

		 <?php echo form_open( '', array( 'class' => 'std-form', 'style' => 'margin-top:20px;' ) ); ?>
			<div class="form-column-left">
				<fieldset>
					<legend>Enter your account's email address:</legend>
					<div class="form-row">

						<?php
							// EMAIL ADDRESS *************************************************
							echo form_label('Email Address','user_email',array('class'=>'form_label'));

							$input_data = array(
								'name'		=> 'user_email',
								'id'		=> 'user_email',
								'class'		=> 'form_input',
								'maxlength' => 255
							);
							echo form_input($input_data);
						?>

					</div>
				</fieldset>
				<div class="form-row">
					<div id="submit_box">

						<?php
							// SUBMIT BUTTON **************************************************************
							$input_data = array(
								'name'  => 'submit',
								'id'    => 'submit_button',
								'value' => 'Send Email'
							);
							echo form_submit($input_data);
						?>

					</div>
				</div>
			</div>
		</form>

	<?php
}
/* End of file recover_form.php */
/* Location: /application/views/recover_form.php */