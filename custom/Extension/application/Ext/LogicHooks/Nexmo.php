<?php

$hook_array['before_save'][] = Array(
        1, 
        'Custom Logic', 
		'modules/Nexmo/NexmoAPI.php',	
        'NexmoAPI', 
        'send_nexmo_msg'
    );