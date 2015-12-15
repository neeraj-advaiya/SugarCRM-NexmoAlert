<?php 
	class NexmoController extends SugarController{
	public function action_config()
    {
		$this->view_object_map['error_1'] = false;
		$this->view_object_map['error_2'] = false;
		$this->view_object_map['error_3'] = false;
		$api_and_secret_saved = false;
		if (isset($_POST) && !empty($_POST)) {
			require_once('modules/Administration/Administration.php');
			$administration = new Administration();
			$clean_api_key = trim($_REQUEST['api_key']);
			$clean_api_secret = trim($_REQUEST['api_secret']);
			$clean_budget = trim($_REQUEST['budget']);
			
			if($clean_api_key !="" && $clean_api_secret !=""){
				
				$response=@file_get_contents('https://rest.nexmo.com/account/numbers/'.$clean_api_key.'/'.$clean_api_secret);//fetching from number
				$msg_from=(array)json_decode($response);
				
				
				if(isset($msg_from['numbers'][0]->msisdn) && ($msg_from['numbers'][0]->msisdn!="")){
					$administration->saveSetting('Nexmo', 'api_key', $clean_api_key);
					$administration->saveSetting('Nexmo', 'api_secret', $clean_api_secret);
					$api_and_secret_saved = true;
					//SugarApplication::appendErrorMessage("<span style='color:green'>Nexmo key and secret saved successfully.</span>");
				}else{
					$this->view_object_map['error_1'] = true;
					$this->view_object_map['error_2'] = true;
					$administration->saveSetting('Nexmo', 'api_key', $clean_api_key);
					$administration->saveSetting('Nexmo', 'api_secret', $clean_api_secret);
					//$administration->saveSetting('Nexmo', 'budget', "");
					SugarApplication::appendErrorMessage("Please enter valid Nexmo Key and Secret.");
				}
			}else{
				if($clean_api_key =="" && $clean_api_secret ==""){
					$this->view_object_map['error_1'] = true;
					$this->view_object_map['error_2'] = true;
					SugarApplication::appendErrorMessage("Please enter Nexmo Key and Secret.");
				}else{
					$administration->saveSetting('Nexmo', 'api_key', $clean_api_key);
					$administration->saveSetting('Nexmo', 'api_secret', $clean_api_secret);
					$this->view_object_map['error_1'] = true;
					$this->view_object_map['error_2'] = true;
					SugarApplication::appendErrorMessage("Please enter valid Nexmo Key and Secret.");
				}
			}
			if(!(empty($clean_budget))){
				if(is_numeric($clean_budget) && $clean_budget>0) 
					{
						if($api_and_secret_saved ==true) {
							$administration->saveSetting('Nexmo', 'budget', $clean_budget);
							//SugarApplication::appendErrorMessage("<span style='color:green'>Threshold saved successfully.</span>");
							SugarApplication::appendErrorMessage("<span style='color:green'>Configuration settings saved successfully.</span>");
						}else{
							$administration->saveSetting('Nexmo', 'budget', "");
						}
					}
				else {
					$administration->saveSetting('Nexmo', 'budget', "");
					SugarApplication::appendErrorMessage("Please enter a valid Threshold.");
					$this->view_object_map['error_3'] = true;
				}
			}else{
				$this->view_object_map['error_3'] = true;
				$administration->saveSetting('Nexmo', 'budget', "");
				SugarApplication::appendErrorMessage("Please enter the Threshold value.");
				
			}
			
			
				if(isset($_REQUEST['send_msg']) && $_REQUEST['send_msg']==true && $api_and_secret_saved ==true){
					$administration->saveSetting('Nexmo', 'send_msg', true);
				}else{
					$administration->saveSetting('Nexmo', 'send_msg', false);
				}
			
			 $this->view = 'config';
			
		} else  {
		
			$this->view = 'config';
		}
        
    }
	
	public function action_display()
    {
		require_once('modules/Administration/Administration.php');
		$administration = new Administration();
		$administration->retrieveSettings();
		$api_key = $administration->settings['Nexmo_api_key'];
		echo $administration->settings['Nexmo_api_key'].'<br>';
		echo $administration->settings['Nexmo_api_secret'].'<br>';
		echo $administration->settings['Nexmo_budget'].'<br>';
		echo $administration->settings['Nexmo_send_msg'].'<br>';
	}
	
}