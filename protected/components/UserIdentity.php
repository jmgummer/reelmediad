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
		/* Regular Clients Login */
		$client = ClientUsers::model()->find('username=:a AND password=:b', array(':a'=>$this->username,':b'=>md5($this->password)));

		/* Agency Clients Login */
		$sql_activate = "select * from agency_users,agency where agency_users.username='$this->username' and agency_users.password=md5('$this->password') and agency_users.agency_id=agency.agency_id";
		$agency = AgencyUsers::model()->findBySql($sql_activate);

		if($client==FALSE && $agency==FALSE){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}else{
			if($client==TRUE){
				$this->username = 'admin';
				$company_id = $client->co_id;
				$this->setState('user_id', $client->client_users_id);
				$this->setState('client_name',$client->UserName);
				$this->setState('company_id',$company_id);
				if(empty($client->company) || $client->company==null ){
					$this->setState('company_name', 'unknown');
				}else{
					$this->setState('company_name', $client->company);
				}
				$company_country = 'select * from company_country where company_id ='.$company_id;
				if($company_country = CompanyCountry::model()->findBySql($company_country)){
					$country_id = $company_country->country_id;
				}else{
					$country_id = 1;
				}
				$this->setState('country_id',$country_id);
				$this->setState('usertype','client');
				$this->errorCode=self::ERROR_NONE;
			}

			if($agency==TRUE){
				/* Set the Agency Username at this Stage */
				$this->setState('agencyusername',$this->username);
				$this->username = 'admin';
				$company_id = $agency->agency_id;
				$this->setState('user_id', $agency->agency_users_id);
				$this->setState('client_name',$agency->UserName);
				$this->setState('company_id',$company_id);
				$this->setState('company_name', $agency->AgencyName);

				/* This is Subject to Change */
				$country_id = 1;
				$this->setState('country_id',$country_id);
				$this->setState('usertype','agency');
				$this->errorCode=self::ERROR_NONE;
			}
			
		}

		return !$this->errorCode;
	}
}