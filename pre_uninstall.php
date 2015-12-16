<?php

require_once('modules/Administration/Administration.php');
$administration = new Administration();
$administration->saveSetting('Nexmo', 'api_key', '');
$administration->saveSetting('Nexmo', 'api_secret', '');
$administration->saveSetting('Nexmo', 'budget', '');
$administration->saveSetting('Nexmo', 'send_msg', false);