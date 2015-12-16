<?php 
require_once('include/MVC/View/SugarView.php');

class NexmoViewConfig extends SugarView {


    public function __construct() {
        parent::SugarView();

    }


    public function preDisplay() {
		?><link rel="stylesheet" href="modules/Nexmo/views/style.css" /><?php
		if(isset($this->view_object_map['val_error'])) SugarApplication::appendErrorMessage($this->view_object_map['val_error']);
    }
    public function display() {
		
		
		require_once('modules/Administration/Administration.php');
		$administration = new Administration();
		$administration->retrieveSettings();
		global $current_user;
		
		$prefered_currency = $current_user->getPreference('currency');
		
		$currency_symbol="";
		if($prefered_currency==-99 or $prefered_currency=="")
		{
			$currency_symbol="$";
		}else{
			global $db;
			$row= $db->query("SELECT SYMBOL FROM CURRENCIES WHERE ID = '".$prefered_currency."'");
			$currency_symbol=$db->fetchByAssoc($row)['SYMBOL'];
		}
		
		
	?>
	<div class="body">
	<div class="pageWrapper">
		<div class="logoWraper"><img src="modules/Nexmo/views/nexmo-logo.png" alt="Nexmo" width="180"></div>
		<h1 class="heading1" style="font-family:'Segoe UI';margin-top: 20px;margin-bottom: 20px;font-size: 2em;">Configuration Settings</h1>
		<div class="mainContent" >
		<form name="NexmoSettings" id="EditView" method="POST" action="index.php?module=Nexmo&action=config">
			<div class="mb-20">
				<div class="fieldLabel">Nexmo Key<span class="handCursor"></div>
				<div>
					<input type="text" style="width:100%;<?php if($this->view_object_map['error_1']==true) { ?> border-style: solid;border-color: #ff0000;<?php } ?>" class="customTxtBox" name="api_key" value="<?php if(isset($administration->settings['Nexmo_api_key']) && !(empty($administration->settings['Nexmo_api_key']))) echo $administration->settings['Nexmo_api_key'];?>" size="35"/>
				</div>
			</div>
			<div class="mb-20">
				<div class="fieldLabel">Nexmo Secret <span class="handCursor"></span></div>
				<div>
					<input type="text" style="width:100%;<?php if($this->view_object_map['error_2']==true) { ?> border-style: solid;border-color: #ff0000;<?php } ?>" class="customTxtBox" name="api_secret" value="<?php if(isset($administration->settings['Nexmo_api_secret']) && !(empty($administration->settings['Nexmo_api_secret']))) echo $administration->settings['Nexmo_api_secret'];?>" size="35"/>
				</div>
			</div>
			<div class="mb-20">
				<div class="fieldLabel">Threshold Amount <?php if($currency_symbol !="")?>(<?php echo $currency_symbol;?>) <span class="handCursor"></span></div>
				<div>
					<input type="text" style="width:100%;<?php if($this->view_object_map['error_3']==true) { ?>border-style: solid;border-color: #ff0000;<?php } ?>" class="customTxtBox" name="budget" value="<?php if(isset($administration->settings['Nexmo_budget']) && !(empty($administration->settings['Nexmo_budget']))) echo $administration->settings['Nexmo_budget'];?>" size="35"/>
				</div>
			</div>
			<div class="mb-20">
				<div class="font16">Enable SMS <input type="checkbox" name="send_msg" style="width:20px; height:20px; position:relative;top:3px;" class="customCheckBox"
				<?php if(isset($administration->settings['Nexmo_send_msg']) && $administration->settings['Nexmo_send_msg']==true)echo "checked=true value=true"; ?>
			/></div>
			</div>
			
			<div><button id="saveDefaults" class="blueBtn">
                            Save</button>
			</div>
			
			</div>
		</form>
    </div>
	</div>
</div>     
    
 
		
	<?php
	}


}