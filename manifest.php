<?php 

$manifest = array(
    'acceptable_sugar_flavors' => array('ENT','ULT'),
    'acceptable_sugar_versions' => array(
        'exact_matches' => array(),
        'regex_matches' => array('7\\.*')
    ),
	'acceptable_sugar_flavors' => array(
        'CE',
        'PRO',
        'ENT',
        'CORP',
        'ULT',
    ),
    'readme'=>'',
    'key' => 'ns',
    'author' => 'Nexmo',
    'description' => 'Module that send SMS on several events.',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'NexmoSMS',
	'label' => 'NexmoSMS',
    'published_date' => '2015-10-10 12:00:00',
    'type' => 'module',
	'remove_tables' => false,
    'version' => 1.0
);

$installdefs = array(
	'copy' => array(
        array(
            'from' => '<basepath>/custom',
            'to' => 'custom'
        ),
        array(
            'from' => '<basepath>/modules/Nexmo',
            'to' => 'modules/Nexmo'
        ),
		array(
		'from'=>'<basepath>/nexmoapi.php',
		'to' => 'custom/Extension/modules/Administration/Ext/Administration/nexmoapi.php',
		),
		array(
		'from'=>'<basepath>/custom/Extension/application/Ext/LogicHooks/Nexmo.php',
		'to' => 'custom/Extension/application/Ext/LogicHooks/Nexmo.php',
		)
    ),
	'pre_uninstall' => array(    0 => '<basepath>/pre_uninstall.php',)
);
