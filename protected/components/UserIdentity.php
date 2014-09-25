<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$client = ClientUsers::model()->find('username=:a AND password=:b', array(':a'=>$this->username,':b'=>md5($this->password)));

		if($client==FALSE){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}else{
			$this->username = 'admin';
			$company_id = $client->co_id;
			$this->setState('user_id', $client->client_users_id);
			$this->setState('client_name',$client->UserName);
			$this->setState('company_id',$company_id);
			// if(empty($client->company) || $client->company==null ){
			// 	$this->setState('company_name', 'unknown');
			// }else{
			// 	$this->setState('company_name', $client->company);
			// }
			$this->setState('company_name', 'unknown');
			
			$this->errorCode=self::ERROR_NONE;
		}

		return !$this->errorCode;
	}
}