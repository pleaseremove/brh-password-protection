<?php

class BRHPasswordProtection extends KokenPlugin {
	
	private $separator = '|';
	private $separator_eol = ',';
	private $cookie_name = "brh-koken-protected";
	private $auth_url;
	private $url;
	private $email = '';
	
	function __construct()
	{
		$this->register_filter('site.output', 'logins');		
	}
		
	function logins( $html )
	{
		// Skip admin pages
		if( strpos($_SERVER["PHP_SELF"], 'preview.php') )
		{
			return $html;
		}
		
		// Make sure we have some login values set from the plugin settings
		if( isset($this->data->pass) )
		{
			// Check credentials & cookies against URL
			if( self::is_valid_cookie() )
			{
				return $html;
			}
			else
			{
				// Here on a $_POST ?
				if( isset($_POST['password']) )
				{
					if( $this->data->pass == $_POST['password'] )
					{
						// Login successful, set cookie for two weeks
						setcookie($this->cookie_name, $_POST['password'], time()+1209600);
						return $html;
					}
					else
					{
						// Invalid, show login form again
						return self::display_login_form($html, true);
					}
				}
			}
			// Show login form
			return self::display_login_form($html);
		}
		// Made it all the way here, show the full page
		return $html;
	}
		
	function display_login_form($html, $failed=false)
	{
		
		include('simple_html_dom.php');
		$_html = str_get_html($html);
		
		// Check for PJAX call
		if( $_SERVER['HTTP_X_PJAX'] )
		{
			$_html->find('#main', 0)->innertext = self::login_form($failed);
		}
		// Write over the whole body
		else
		{
			$_html->find('body', 0)->innertext = self::login_form($failed);		
		}
		
		return $_html;
	}
	
	function is_valid_cookie()
	{	
		// Make sure cookie exists and contains the contents allow access to the current URL
		// Cookie should be set to a password, make sure that password is allowed for the current URL
		// TODO: make this work with multiple URL
		return (isset($_COOKIE[$this->cookie_name]));
	}
		
	function login_form($failed=false)
	{
		$output = '<div id="" class="container" style="padding-top:60px; margin: 0 20px;">';
		
		if( $failed )
		{
			$output .=	'<h2>Password Incorrect, Login Required</h2>';
		}
		else
		{
			$output .=	'<h2>Login Required</h2>';
		}

		$output .=
				'<form method="POST" action="'.$_SERVER["REQUEST_URI"].'">'.
				'<input type="password" name="password" placeholder="Password" />'.
				'<input type="Submit" value="Login" />'.
				'</form>';

		$output .= '</div>';
		
		return $output;
	}
}
