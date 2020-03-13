<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/*
|--------------------------------------------------------------------------
| For Twilio msg api
|--------------------------------------------------------------------------
|
	* Name:  Twilio
	* Author: Ben Edmunds
	*		  ben.edmunds@gmail.com
	*         @benedmunds
	*
	* Location:
	*
	* Created:  03.29.2011
	*
	* Description:  Twilio configuration settings.
	
	 * Mode ("sandbox" or "prod")
	 */
	$config['mode']   = 'sandbox';

	/*  Account SID */
	//$config['account_sid']   = 'AC735e20672396f84463507220741dbe0e';//'AC48c9c4aa358e1768c8288660f404dc4c';
	$config['account_sid']   = 'ACd36be8171b8f2d96dd8dbea0569e044a';
	/*  Auth Token  */
	///$config['auth_token']    = '335ad284e91061f891dce44d6b3c90b6';//'cb1f9c65eae20b057763800825c5b11e';
	$config['auth_token']    = 'a4dd3526aaa7a7a4a54680b8761311c6';//'cb1f9c65eae20b057763800825c5b11e';

	/* API Version */
	$config['api_version']   = '2010-04-01';

	/*  Twilio Phone Number
	 **/
		$config['number']        = '+12013659534';

/* End of file twilio.php */