<?php

// mavrick.id.au

ob_start();
session_start();

if($_POST['output']) 
{

	ob_start();
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	
	// We'll be outputting a PDF
	header('Content-type: text/plain');
	
	// It will be called downloaded.pdf
	header('Content-Disposition: attachment; filename="maps.cfg"');
	
	die(stripslashes($_POST['output']));

}

$types = array(
	'dm' => 'Deathmatch',
	'war' => 'Team Deathmatch',
	'sab' => 'Sabotage',
	'dom' => 'Domination',
	'koth' => 'Headquarters',
	'sd' => 'Search &amp; Destroy'
);

$maps = array(

	'mp_carentan' => 'China Town',
	'mp_convoy' => 'Ambush',
	'mp_backlot' => 'Backlot',
	'mp_bloc' => 'Bloc',
	'mp_bog' => 'Bog',
	'mp_broadcast' => 'Broadcast',
	'mp_countdown' => 'Countdown',
	'mp_crash' => 'Crash',
	'mp_crash_snow' => 'Crash Snow',
	'mp_creek' => 'Creek',
	'mp_crossfire' => 'Crossfire',
	'mp_citystreets' => 'Citystreets',
	'mp_farm' => 'Downpour',
	'mp_killhouse' => 'Killhouse',
	'mp_overgrown' => 'Overgrown',
	'mp_pipeline' => 'Pipleline',
	'mp_shipment' => 'Shipment',
	'mp_showdown' => 'Showdown',
	'mp_strike' => 'Strike',
	'mp_vacant' => 'Vacant',
	'mp_cargoship' => 'Wetworks'

);

asort($maps);

if($_POST['manageMaps']) 
{

if(($_POST['ssid']!=session_id())||(!$_POST['ssid'])) die('Hacking Attempt!');

ob_get_clean();
ob_start();

$data = $_COOKIE['fb_userData'];
$data = unserialize(base64_decode($data));

$gt = $data['maps'];

if($_POST['fb_submit']) 
{

	$id = $_POST['id'];
	
	$tmp = $gt[$id];
	
	unset($gt[$id]);
	
	$data['maps'] = $gt;
	
	setcookie('fb_userData',base64_encode(serialize($data)),time()+860000);
	
	?>
    $$('select[name^=rotationmap]').each(function(el) { el.getElements('option').each(function(e) { if(e.getProperty('value')=='<?=$tmp['value']?>') { e.remove(); } }); });
    <?php

	die(ob_get_clean());

}
?>
<div class="info">
To remove a custom map from the list simply click on the 'trash' icon!
</div>
<div style="clear:both;padding:2px;"></div>
<?php

if(!empty($gt)) 
{

foreach($gt as $k => $v) 
{

?>
<div class="item" id="item_<?=$k?>">
<div style="float:left;display:inline;width:16px;"><img src="/images/icons/icon_delete.gif" alt="Delete" title="Delte" style="cursor:pointer" rel="<?=$k?>" class="fb_delete" /></div>
<div style="float:left;display:inline;width:200px;"><?=$v['label']?></div>(<div class="info" style="display:inline;"><?=$v['value']?></div>)
<div style="clear:both;padding:2px;"></div>
</div>
<?php

}

} 
else 
{

?>
It looks like you haven't added any Custom Maps yet or you haven't selected the option to remember your settings.<br /><br />If you wish to manage your Custom Maps make sure to select the 'Rember your settings' option when adding a new Custom Gametype!
<div style="clear:both;padding:2px;"></div>
<?php

}

?>
<div style="clear:both;padding:2px;"></div>
<img src="/images/btn/close.gif" alt="Close Window" title="Close Window" style="cursor:pointer" id="fb_close" />
<script type="text/javascript" language="javascript">
//<![CDATA[
$('fb_close').addEvent('click',function() { $('fb_overlay').fireEvent('click'); });
$$('.fb_delete').each(function(el) {
	el.addEvent('click',function() {
		new Ajax( '?xhr', { 
			method: 'post',
			data: Object.toQueryString({'manageMaps':'1','fb_submit':'1','id':el.getProperty('rel'),'ssid':'<?=session_id()?>'}),
			evalResponse: true,
			onRequest: function() { $('overlayTitle').setHTML('Processing...'); },
			onComplete: function() { $('overlayTitle').setHTML('Manage Your Custom Maps'); $('item_' + el.getProperty('rel')).remove(); }
		}).request();
	});
});
//]]>
</script>
<?php

die(ob_get_clean());

}

if($_POST['manageGameType']) 
{

if(($_POST['ssid']!=session_id())||(!$_POST['ssid'])) die('Hacking Attempt!');

ob_get_clean();
ob_start();

$data = $_COOKIE['fb_userData'];
$data = unserialize(base64_decode($data));

$gt = $data['gametypes'];

if($_POST['fb_submit']) {

	$id = $_POST['id'];
	
	$tmp = $gt[$id];
	
	unset($gt[$id]);
	
	$data['gametypes'] = $gt;
	
	setcookie('fb_userData',base64_encode(serialize($data)),time()+860000);
	
	?>
    $$('.gameTypes').each(function(el) { el.getElements('option').each(function(e) { if(e.getProperty('value')=='<?=$tmp['value']?>') { e.remove(); } }); });
    <?php

	die(ob_get_clean());

}

?>
<div class="info">
To remove a custom gametype from the list simply click on the 'trash' icon!
</div>
<div style="clear:both;padding:2px;"></div>
<?php

if(!empty($gt)) {

foreach($gt as $k => $v) {

?>
<div class="item" id="item_<?=$k?>">
<div style="float:left;display:inline;width:16px;"><img src="/images/icons/icon_delete.gif" alt="Delete" title="Delte" style="cursor:pointer" rel="<?=$k?>" class="fb_delete" /></div>
<div style="float:left;display:inline;width:200px;"><?=$v['label']?></div>(<div class="info" style="display:inline;"><?=$v['value']?></div>)
<div style="clear:both;padding:2px;"></div>
</div>
<?php

}

} 
else 
{

?>
It looks like you haven't added any Custom Gametypes yet or you haven't selected the option to remember your settings.<br /><br />If you wish to manage your Custom Gametypes make sure to select the 'Rember your settings' option when adding a new Custom Gametype!
<div style="clear:both;padding:2px;"></div>
<?php

}

?>
<div style="clear:both;padding:2px;"></div>
<img src="/images/close.gif" alt="Close Window" title="Close Window" style="cursor:pointer" id="fb_close" />
<script type="text/javascript" language="javascript">
//<![CDATA[
$('fb_close').addEvent('click',function() { $('fb_overlay').fireEvent('click'); });
$$('.fb_delete').each(function(el) {
	el.addEvent('click',function() {
		new Ajax( '?xhr', { 
			method: 'post',
			data: Object.toQueryString({'manageGameType':'1','fb_submit':'1','id':el.getProperty('rel'),'ssid':'<?=session_id()?>'}),
			evalResponse: true,
			onRequest: function() { $('overlayTitle').setHTML('Processing...'); },
			onComplete: function() { $('overlayTitle').setHTML('Manage Your Custom Gametypes'); $('item_' + el.getProperty('rel')).remove(); }
		}).request();
	});
});
//]]>
</script>
<?php

die(ob_get_clean());

}

if($_POST['newGameType']) 
{

if(($_POST['ssid']!=session_id())||(!$_POST['ssid'])) die('Hacking Attempt!');

ob_get_clean();
ob_start();

if($_POST['fb_submit']) 
{

	$cmd = array();
	
	if(!$_POST['fb_label']) $cmd[] = 'Gametype Title is Required!';
	if(!$_POST['fb_value']) $cmd[] = 'Gametype Command is Required!';
	
	if(empty($cmd)) {
	
		?>
        
        <?php
		
		if($_POST['fb_remember']) 
		{
		
			if(!$_COOKIE['fb_userData']) 
			{
				
				$data = array();
				$data['gametypes'] = array();
				
				$data['gametypes'][] = array(
					'label' => $_POST['fb_label'],
					'value' => $_POST['fb_value']
				);
				
				setcookie('fb_userData',base64_encode(serialize($data)),time()+860000);
				
			} 
			else 
			{
			
				$data = $_COOKIE['fb_userData'];
				$data = unserialize(base64_decode($data));
				
				$data['gametypes'][] = array(
					'label' => $_POST['fb_label'],
					'value' => $_POST['fb_value']
				);
				
				setcookie('fb_userData',base64_encode(serialize($data)),time()+860000);
			
			}
			
		}
		
		?>
<script type="text/javascript" language="javascript" type="text/javascript">
//<![CDATA[
$$('.gameTypes').each(function(el) {
	new Element('option',{'value':'<?=$_POST['fb_value']?>'}).setText('<?=$_POST['fb_label']?>').injectInside(el);
});
$('fb_overlay').fireEvent('click');
alert('<?=$_POST['fb_label']?> Custom Gametype has been added!');
//]]>
</script><?php
	
	} 
	else 
	{
	
		$error = 'There was an error:\n\n';		
		foreach($cmd as $v) { $error .= '- '.$v.'\n'; }
		
	?>
<script type="text/javascript" language="javascript" type="text/javascript">
//<![CDATA[
alert('<?=$error?>');
//]]>
</script><?php
	
	}

	die(ob_get_clean());

}

?>
<div id="fb_newGameTypeForm">
<div class="info">The following fields will allow you to enter in your own custom gametypes.<br /><br />If you have a mod that has custom gametypes you can add them here.<br /><br />If you are unsure of the Gametype and Command please contact the Mod developer first!</div>
<div style="padding: 4px;">
<label for="fb_label"><strong>Gametype Title:</strong></label><br />
<input type="text" id="fb_label" name="fb_label" value="" style="width:80%;" /><br />
<div class="info">e.g. Capture The Flag</div>
</div>
<div style="padding: 4px;">
<label for="fb_value"><strong>Gametype Command:</strong></label><br />
<input type="text" id="fb_value" name="fb_value" value="" /><br />
<div class="info">e.g. ctf = Capture The Flag</div>
</div>
<div style="padding: 4px;">
<label for="fb_remember"><input type="checkbox" id="fb_remember" name="fb_remember" value="1"<?=($_COOKIE['fb_userData'] ? ' checked="checked"' : false)?> /> Remember my custom settings</label>
<div class="info">If you want this site to remember your custom gametypes and custom maps tick this box!</div>
</div>
<input type="hidden" name="fb_submit" value="1" />
<input type="hidden" name="newGameType" value="1" />
<input type="hidden" name="ssid" value="<?=session_id()?>" />
<div style="float:left;">
<img src="/images/btn/cancel.gif" title="Cancel and Close Window" alt="Cancel and Close Window" border="0" id="fb_cancel" style="cursor:pointer;" />
</div>
<div style="float:right;">
<img src="/images/btn/add.gif" title="Add Gametype" alt="Add Gametype" border="0" id="fb_add" style="cursor:pointer;" />
</div>
</div>
<div style="clear:both;"></div>
<script type="text/javascript" language="javascript">
//<![CDATA[
$('fb_label').focus();
$('fb_cancel').addEvent('click',function() { $('fb_overlay').fireEvent('click'); });
$('fb_add').addEvent('click',function() {
	new Ajax( '?xhr', { 
		method: 'post',
		data: $('fb_newGameTypeForm').toQueryString(),
		evalScripts: true,
		onRequest: function() { $('overlayTitle').setHTML('Processing...'); },
		onComplete: function() { $('overlayTitle').setHTML('Add Custom Gametype'); }
	}).request();
});
//]]>
</script>
<?php

die(ob_get_clean());

}

if($_POST['newMap']) 
{

if(($_POST['ssid']!=session_id())||(!$_POST['ssid'])) die('Hacking Attempt!');

ob_get_clean();
ob_start();

if($_POST['fb_submit']) 
{

	$cmd = array();
	
	if(!$_POST['fb_label']) $cmd[] = 'Map Title is Required!';
	if(!$_POST['fb_value']) $cmd[] = 'Map Command is Required!';
	
	if(empty($cmd)) 
	{
	
		?>
        
        <?php
		
		if($_POST['fb_remember']) 
		{
		
			if(!$_COOKIE['fb_userData']) 
			{
				
				$data = array();
				$data['maps'] = array();
				
				$data['maps'][] = array(
					'label' => $_POST['fb_label'],
					'value' => $_POST['fb_value']
				);
				
				setcookie('fb_userData',base64_encode(serialize($data)),time()+860000);
				
			} 
			else 
			{
			
				$data = $_COOKIE['fb_userData'];
				$data = unserialize(base64_decode($data));
				
				$data['maps'][] = array(
					'label' => $_POST['fb_label'],
					'value' => $_POST['fb_value']
				);
				
				setcookie('fb_userData',base64_encode(serialize($data)),time()+860000);
			
			}
			
		}
		
		?>
<script type="text/javascript" language="javascript" type="text/javascript">
//<![CDATA[
$$('.customMaps').each(function(el) {
	new Element('option',{'value':'<?=$_POST['fb_value']?>'}).setText('<?=$_POST['fb_label']?>').injectInside(el);
});
$('fb_overlay').fireEvent('click');
alert('<?=$_POST['fb_label']?> Custom Map has been added!');
//]]>
</script><?php
	
	} 
	else 
	{
	
		$error = 'There was an error:\n\n';		
		foreach($cmd as $v) { $error .= '- '.$v.'\n'; }
		
	?>
<script type="text/javascript" language="javascript" type="text/javascript">
//<![CDATA[
alert('<?=$error?>');
//]]>
</script><?php
	
	}

	die(ob_get_clean());

}

?>
<div id="fb_newMapsForm">
<div class="info">The following fields will allow you to enter in your own custom maps.</div>
<div style="padding: 4px;">
<label for="fb_label"><strong>Map Title:</strong></label><br />
<input type="text" id="fb_label" name="fb_label" value="" style="width:80%;" /><br />
<div class="info">e.g. Ravens</div>
</div>
<div style="padding: 4px;">
<label for="fb_value"><strong>Map Command:</strong></label><br />
<input type="text" id="fb_value" name="fb_value" value="mp_" /><br />
<div class="info">e.g. mp_ravens = Ravens</div>
</div>
<div style="padding: 4px;">
<label for="fb_remember"><input type="checkbox" id="fb_remember" name="fb_remember" value="1"<?=($_COOKIE['fb_userData'] ? ' checked="checked"' : false)?> /> Remember my custom settings</label>
<div class="info">If you want this site to remember your custom maps and custom gametypes tick this box!</div>
</div>
<input type="hidden" name="fb_submit" value="1" />
<input type="hidden" name="newMap" value="1" />
<input type="hidden" name="ssid" value="<?=session_id()?>" />
<div style="float:left;">
<img src="/images/btn/cancel.gif" title="Cancel and Close Window" alt="Cancel and Close Window" border="0" id="fb_cancel" style="cursor:pointer;" />
</div>
<div style="float:right;">
<img src="/images/btn/add.gif" title="Add Gametype" alt="Add Gametype" border="0" id="fb_add" style="cursor:pointer;" />
</div>
</div>
<div style="clear:both;"></div>
<script type="text/javascript" language="javascript">
//<![CDATA[
$('fb_label').focus();
$('fb_cancel').addEvent('click',function() { $('fb_overlay').fireEvent('click'); });
$('fb_add').addEvent('click',function() {
	new Ajax( '?xhr', { 
		method: 'post',
		data: $('fb_newMapsForm').toQueryString(),
		evalScripts: true,
		onRequest: function() { $('overlayTitle').setHTML('Processing...'); },
		onComplete: function() { $('overlayTitle').setHTML('Add Custom Gametype'); }
	}).request();
});
//]]>
</script>
<?php

die(ob_get_clean());

}

if($_POST) 
{

	ob_start();

	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	
	header('Content-type: text/plain');
	
	$_POST['type'] 	= explode(',',$_POST['type']);
	$_POST['map'] 	= explode(',',$_POST['map']);

	$tmp = array();
	$s = $_POST['start'];
	
	foreach($_POST['map'] as $k => $v) {
		if($v) {
			$tmp[] = 'gametype '.($_POST['type'][$k] ? $_POST['type'][$k] : (!is_numeric($k) ? $k : $_POST['gametype'])).' '.'map '.$_POST['map'][$k];
		}
	}
	
	if($_POST['randomize']) shuffle($tmp);
	
	$_POST['rotation'] = $tmp; unset($tmp);
	
	if(empty($_POST['rotation'])) die(';ERROR:'."\r\n".';Please select a few gametypes and maps to generate your map rotation code.');
	
	echo '//*************************************************'."\r\n"
	     .'// map rotation generated by mavrick.id.au'."\r\n"
		 .'//*************************************************'."\r\n";

	echo 'set g_gametype "'.$_POST['gametype'].'"'."\r\n\r\n";
	
	echo 'set sv_mapRotation "';
	
	$_POST['rotation'] = implode(" ",$_POST['rotation']);
	
	echo str_replace('  ',' ',$_POST['rotation']);
	
	echo '"';
	
	if($_POST['verbose']) {
	
		echo "\r\n\r\n";
		echo "//*************************************************\r\n";
		echo "// verbose output\r\n";
		echo "//*************************************************\r\n";
		
		foreach($_POST['map'] as $k => $v) 
		{
			if($v) 
			{
				echo "// ".($_POST['type'][$k] ? $types[$_POST['type'][$k]] : $types[$_POST['gametype']])." - ".$maps[$_POST['map'][$k]]."\r\n";
			}
		}
	
	}
	
	die(utf8_encode(ob_get_clean()));

}

$_COOKIE['fb_userData'] = unserialize(base64_decode($_COOKIE['fb_userData']));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-au" />
<meta name="copyright" content="2013, mavrick.id.au" />
<meta name="author" content="mavrick.id.au" />
<meta name="owner" content="mavrick.id.au" />
<meta name="description" content="COD 4 Map Rotation Generator" />
<meta name="keywords" content="cod4, call of duty, call of duty 4, map rotation, cod4 map rotation, cod4 map rotation generator, <?=implode(', ',array_keys($maps))?>, <?=implode(', ',$types)?>" />
<title>COD 4 Map Rotation Generator</title>
<link href="/css/cod4.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" language="javascript" type="text/javascript">
//<![CDATA[
var fb_ssid = '<?=session_id()?>';
//]]>
</script>
</head>
<body>
<div align="left">
  <h1>COD 4 Map Rotation Generator</h1>
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Other links">Other links</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
              <strong>Updated:</strong> <a href="/cod5-map-generator.php">COD:WAW Map Rotation Generator</a><br />
              <strong>Also:</strong> <a href="/cod4.php">COD 4 Punkbuster Server Message Generator v1.4</a><br /><br />
            </div>
	  <div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Settings">Settings</div>
				<div class="right"></div>
			</div>
            <div class="contextMenu">
            	<div class="left"></div>
                <div class="right"></div>
            	<div class="menuItem" style="float:right;" title="Add Custom Gametype">
                	<div class="right"></div>
                    <div class="left"></div>
                    <div class="btn" id="newGameType">Add Custom Gametype</div>
                </div>
                <div class="divider" style="float:right;"></div>
                <div class="menuItem" style="float:right;" title="Manage Custom Gametypes">
                	<div class="right"></div>
                    <div class="left"></div>
                    <div class="btn" id="manageGameType">Manage Custom Gametypes</div>
                </div> 
            </div>
			<div class="middle" rel="middle">
              <div style="padding:6px;">
                Default Gametype:
                  <select name="gametype" id="gametype" lang="en" xml:lang="en" class="gameTypes">
                    <option value="dm">Deathmatch</option>
                    <option value="war" selected="selected">Team Deathmatch</option>
                    <option value="sab">Sabotage</option>
                    <option value="dom">Domination</option>
                    <option value="koth">Headquarters</option>
                    <option value="sd">Search &amp; Destroy</option>
                    <?php if(is_array($_COOKIE['fb_userData']['gametypes'])) { foreach($_COOKIE['fb_userData']['gametypes'] as $k => $v) { ?>
                    <option value="<?=$v['value']?>"><?=$v['label']?></option>
                    <?php } } ?>
                  </select>
              </div>
            </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <hr />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Map Rotation">Map Rotation</div>
				<div class="right"></div>
			</div>
            <div class="contextMenu">
            	<div class="left"></div>
                <div class="right"></div>
            	<div class="menuItem" style="float:right;">
                	<div class="right"></div>
                    <div class="left"></div>
                    <div class="btn" id="newMap">Add Custom Map</div>
                </div>   
                <div class="divider" style="float:right;"></div>
                <div class="menuItem" style="float:right;" title="Manage Custom Maps">
                	<div class="right"></div>
                    <div class="left"></div>
                    <div class="btn" id="manageMaps">Manage Custom Maps</div>
                </div>              
            </div>
			<div class="middle" rel="middle">
			<div class="info">To add more maps to the map rotation simply press the green plus button. You will need at least 1 map selected to generate your map rotation code. Tick the checkbox "verbose output" to display an english version of your gametype and map selection as well.</div>
  <div id="container">
	  <div class="msg" id="msg">
		  <div class="msg_title">Map 1:</div>
		  <span style="padding:6px;">
		  <select name="rotationtype[]" id="type_1" lang="en" xml:lang="en" class="gameTypes">
            <option value="" selected="selected">Default Gametype</option>
			<option value="dm">Deathmatch</option>
            <option value="war">Team Deathmatch</option>
            <option value="sab">Sabotage</option>
            <option value="dom">Domination</option>
            <option value="koth">Headquarters</option>
            <option value="sd">Search &amp; Destroy</option>
            <?php if(is_array($_COOKIE['fb_userData']['gametypes'])) { foreach($_COOKIE['fb_userData']['gametypes'] as $k => $v) { ?>
            <option value="<?=$v['value']?>"><?=$v['label']?></option>
            <?php } } ?>
          </select>&nbsp;&nbsp;
		  <select name="rotationmap[]" id="map_1" lang="en" xml:lang="en">
		  	<option value="">Select Map</option>
            <optgroup label="Default Maps" title="Default Maps">
            <?php foreach($maps as $mapCode => $mapName) { ?>
			<option value="<?=$mapCode?>"><?=$mapName?></option>
            <?php } ?>
            </optgroup>
            <optgroup label="Custom Maps" title="Custom Maps" id="customMaps_1" class="customMaps">
            <option value="mp_ravens">Ravens</option>
            <option value="mp_inferno_final">Inferno Final</option>
            <option value="mp_pk_harbor">PK Harbor</option>
            <?php if(is_array($_COOKIE['fb_userData']['maps'])) { foreach($_COOKIE['fb_userData']['maps'] as $k => $v) { ?>
            <option value="<?=$v['value']?>"><?=$v['label']?></option>
            <?php } } ?>
            </optgroup>
          </select>
		  </span> 
		  <div align="left" class="msg_add"><img src="/images/icons/icon_add.gif" title="Add New Map Row" id="msg_add" border="0" style="cursor:pointer;cursor:hand;" /></div>
	  </div>
  </div>
  <hr />
  <div style="padding-bottom:12px;">
	  <label for="randomize" title="Randomize Map Selection"><input type="checkbox" name="randomize" id="randomize" title="Randomize Map Selection" />Randomize Map Selection <div style="display:inline;" class="info">(new)</div></label>
  </div>
  <div style="padding-bottom:12px;">
	  <label for="verbose" title="Enable Verbose Output"><input type="checkbox" name="verbose" id="verbose" title="Enable Verbose Output" disabled="disabled" />Enable Verbose Output <div style="display:inline;" class="info">(currently disabled)</div></label>
  </div>
  <div>
	  <input type="button" value="Generate Output" id="generate" name="generate" />
  </div>
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <hr />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Output">Output</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
  <div class="info">Using IE 6,7,8? There can be formatting issues with the returned information, try using Firefox, Safari or Chrome.</div>
  <form name="form" id="fb_form" method="post" action="/cod4-map-generator.php">
  <div>
	  <textarea name="output" id="output" rows="15" style="width:500px;" readonly="readonly"></textarea>
	  <div class="commands">
	  	<input type="button" name="selectall" value="Select All" id="fb_select" disabled="disabled" /> - or - 
		<input type="button" name="download" value="Download maps.cfg" id="fb_download" disabled="disabled" />
	  </div>
  </div>
  </form>
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Custom Gametypes and Custom Maps?">Custom Gametypes and Custom Maps?</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
	<div>
	  <div>
      
		  If you would like a <strong>Custom Gametype</strong> or <strong>Custom Map</strong> added to the list permantly please <a href="http://mavrick.id.au/contact/" target="_blank">contact me</a> with the name and command; e.g. Capture The Flag = ctf. And a short reason why you think it should be added :) and I'll do my best to see if it can be added...<br /><br />If you do not want to go to all that trouble (lol) then I have made something just for you, you should now notice an 'Add New Gametype' and 'Add Custom Map'. You can now add your own have this site remember them so when you come back you don't need to enter in all the information again. The system is cookie based so make sure you have cookies enabled!<br /><br />&lt;3	  
          
       </div>
  </div>
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="How-To setup the maps.cfg">How-To setup the maps.cfg</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
	<div>
	  <div>
		  <strong>Step 1</strong>: Create a new file called: <strong>maps.cfg</strong> within the <strong>/main/</strong> folder.<br />
		  <strong>Step 2</strong>: Add the 'output' code in this file.<br />
		  <strong>Step 3</strong>: Save the file within the <strong>/main/</strong> folder of your COD4 <strong>dedicated server files</strong>.	  </div>
  </div>
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="How-To include the maps.cfg">How-To include the maps.cfg</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
  <div>
	  <div>
		  Add the following text: 
<pre>
exec maps.cfg
</pre> 
  to the bottom of the <strong>config.cfg</strong> file located in <strong>/main/</strong> of your COD4 <strong>dedicated server files</strong>.<br />
  <br />
  Download your main config.cfg file to your desktop. Open it up w/ notepad.<br />
  The last step is to add this line to the bottom of your config.cfg file.
  <br /><br />
  <strong>Please Note!</strong> Your main config name will vary. e.g.:<br />
<pre>
server.cfg
dedicated.cfg
etc...
</pre>
  Save it &amp; upload it to your server.<br />
  Restart your server and now your new map rotation should be in effect. </div>
  </div>  
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Map Game Types">Map Game Types</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
  <div>
<pre>
<?php
foreach($types as $k => $v) 
{
echo "\t$k => $v\n";
}
?>
</pre> 
  </div>
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Default Maps">Default Maps</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
    <div>
<pre>
<?php
foreach($maps as $k => $v) 
{
echo "\t$k => $v\n";
}
?>
</pre> 
  </div>
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div><br />
  <div class="fb_gen">
  	<div class="fb_container">
		<div class="item">
			<div class="header">
				<div class="left"></div>
				<div class="title" title="Custom Maps">Custom Maps</div>
				<div class="right"></div>
			</div>
			<div class="middle" rel="middle">
    <div>
      <p>Here is a small list of the<strong> Call of Duty 4</strong> <strong>ProMod </strong>/ <strong>ProMod Live</strong> Custom Maps from <a href="http://www.cybergamer.com.au">CyberGamer.com.au</a></p>
      <ul>
        <li><a href="http://www.cybergamer.com.au/files/656/">Inferno Final</a></li>
        <li><a href="http://www.cybergamer.com.au/files/73/">PK Harbor</a></li>
        <li><a href="http://www.cybergamer.com.au/files/209/">MP Ravens</a></li>
      </ul>
    </div>
  </div>
			<div class="bottom">
				<div class="left"></div>
				<div class="right"></div>
			</div>
		</div>
	</div>
  </div>
</div>
<div class="overlay" id="fb_overlay"></div>
<div class="fb_gen_overlay" id="fb_overlayMsg">
<div class="fb_container">
    <div class="item">
        <div class="header">
            <div class="left"></div>
            <div class="title" title="" id="overlayTitle"></div>
            <div class="right"></div>
        </div>
        <div class="middle" rel="middle" id="overlayMiddle">
          
        </div>
        <div class="bottom">
            <div class="left"></div>
            <div class="right"></div>
        </div>
    </div>
</div>
</div>
<script language="javascript" type="text/javascript" src="/js/mootools.js"></script>
<script language="javascript" type="text/javascript" src="/js/cod4maps.js"></script>
</body>
</html>