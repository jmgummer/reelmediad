<?php

/**
* UserIdentity represents the data needed to identity a user.
* It contains the authentication method that checks if the provided
* data can identity the user.
*
* @package     Reelmedia
* @subpackage  Components
* @category    Reelforge Client Systems
* @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
* @author      Steve Ouma Oyugi - Reelforge Developers Team
* @version     v.1.0
* @since       July 2008
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
		$client = ClientUsers::model()->find('username=:a AND password=:b AND user_status=1', array(':a'=>$this->username,':b'=>md5($this->password)));

		/* Agency Clients Login */
		$sql_activate = "SELECT * from agency_users,agency where agency_users.username='$this->username' and agency_users.password=md5('$this->password') and agency_users.agency_id=agency.agency_id  and agency_users.user_status=1";
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
				$company_country = 'SELECT * from company_country where company_id ='.$company_id;
				if($company_country = CompanyCountry::model()->findBySql($company_country)){
					$country_id = $company_country->country_id;
				}else{
					$country_id = 1;
				}
				// Check if the client is set for education content
				$checksql = "SELECT * FROM company WHERE education_plan=1 AND company_id=$company_id";
				if($codata = Yii::app()->db2->createCommand($checksql)->queryRow()){
					$this->setState('education_plan',1);
				}else{
					$this->setState('education_plan',0);
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
				$this->setState('education_plan',0);
				$this->setState('country_id',$country_id);
				$this->setState('usertype','agency');
				$this->errorCode=self::ERROR_NONE;
			}
			
		}

		return !$this->errorCode;
	}
}