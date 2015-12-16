<?php
    if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    class NexmoAPI
    {
        function send_nexmo_msg($bean, $event, $arguments)
        {
			
			if($bean->object_name=="Opportunity"){
				$account = new Account(); 	
				$account->retrieve($bean->account_id);
				$current_opportunity = new Opportunity();
				$current_opportunity->retrieve($bean->id);
				
				$account_name=$account->retrieve($bean->account_id)->name;//getting account name 
				$opportunity_name=$bean->name;//getting opportunity name
				$saved_opportunity_amount = round($current_opportunity->amount_usdollar*$bean->base_rate,2);//getting already opportunity amount
				$opportunity_amount=round($bean->amount_usdollar*$bean->base_rate,2);//getting opportunity amount
				$saved_opportunity_amount=number_format($saved_opportunity_amount, 2);
				$opportunity_amount=number_format($opportunity_amount, 2);
				
				$currency_symbol=$bean->currency_symbol;
				if($currency_symbol=="") $currency_symbol="$";
				
				$administration = new Administration();
				$administration->retrieveSettings();
				$api_key = $administration->settings['Nexmo_api_key'];// getting saved api key
				$api_secret = $administration->settings['Nexmo_api_secret'];// getting saved api secret
				if(isset($administration->settings['Nexmo_budget'])){
					$min_budget = $administration->settings['Nexmo_budget'];// getting saved minimum budget
				}else{
					$min_budget=0;	
				}
				$send_msg = $administration->settings['Nexmo_send_msg'];// getting saved send msg flag
				$msg_from=file_get_contents('https://rest.nexmo.com/account/numbers/'.$api_key.'/'.$api_secret);//fetching from number
				$msg_from=(array)json_decode($msg_from);
				$msg_from=$msg_from['numbers'][0]->msisdn;
				
				
				$sms_text ="A new opportunity '".$opportunity_name."' for ".$account_name." with probable value ".$currency_symbol.$opportunity_amount." has been added.";
				if($saved_opportunity_amount > $min_budget) $sms_text="An opportunity '".$opportunity_name."' for ".$account_name." has been updated with probable value ".$currency_symbol.$opportunity_amount;
				
				if(isset($opportunity_amount) && ($opportunity_amount>0) && ($opportunity_amount>$min_budget) && ($send_msg==true)){
					global $current_user;
					
					$reports_to_id="";
					if(isset($current_user->reports_to_id)) $reports_to_id = $current_user->reports_to_id;
					if($reports_to_id!=""){
						$manager = new User();
						$manager->retrieve($reports_to_id);
						$to_number="";
						if(isset($manager->phone_mobile)) $to_number = $manager->phone_mobile;
						if($to_number!="" && ($saved_opportunity_amount != $opportunity_amount)){ // send message only if amount is udpated
							//error_log('http://rest.nexmo.com/sms/xml?api_key='.$api_key.'&api_secret='.$api_secret.'&from='.$msg_from.'&to='.$to_number.'&text='.urlencode($sms_text));
							$response = file_get_contents('http://rest.nexmo.com/sms/xml?api_key='.$api_key.'&api_secret='.$api_secret.'&from='.$msg_from.'&to='.$to_number.'&text='.urlencode($sms_text));
							
						}
					}
				}
			}
		}
    }
   

?>