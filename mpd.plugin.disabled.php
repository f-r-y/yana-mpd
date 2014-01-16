<?php
/*
@name MPD
@author Aymeric HM aka fry <f_r_y_@hotmail.com>
@link https://github.com/f-r-y/yana-mpd
@licence CC by nc sa
@version 1.0.0
@description plugin de controle de musique du lecteur mpc / daemon mpd
*/


function mpd_vocal_command(&$response,$actionUrl){
	$response['commands'][] = array('command'=>VOCAL_ENTITY_NAME.', morceau suivant','url'=>$actionUrl.'?action=mpd_next&webservice=true','confidence'=>'0.9');
	$response['commands'][] = array('command'=>VOCAL_ENTITY_NAME.', morceau précédent','url'=>$actionUrl.'?action=mpd_previous&webservice=true','confidence'=>'0.9');
	$response['commands'][] = array('command'=>VOCAL_ENTITY_NAME.', musique!','url'=>$actionUrl.'?action=mpd_play&webservice=true','confidence'=>'0.9');
	$response['commands'][] = array('command'=>VOCAL_ENTITY_NAME.', silence','url'=>$actionUrl.'?action=mpd_pause&webservice=true','confidence'=>'0.9');
	$response['commands'][] = array('command'=>VOCAL_ENTITY_NAME.', qu\'est-ce qu\'on entend?','url'=>$actionUrl.'?action=mpd_info&webservice=true','confidence'=>'0.9');
	
}

function mpd_action_mpd(){
	global $_,$conf,$myUser;

	switch($_['action']){
		case 'mpd_next':
			global $_,$myUser;
			
			if($myUser->can('lecteur mpd','u')){
				$cmd = 'mpc next';
				ob_start();
				system($cmd,$out);
				$affirmation = preg_replace("/[\r|\n].*/i", '', ob_get_contents());
				ob_end_clean();
				
				if(!isset($_['webservice'])){
					//header('location:index.php?module=room&id='.$DHT->getRoom());
				}else{
					$response = array('responses'=>array( array('type'=>'talk','sentence'=>$affirmation) ) );

					$json = json_encode($response);
					echo ($json=='[]'?'{}':$json);
				}
			} else {
				$response = array('responses'=>array( array('type'=>'talk','sentence'=>'Je ne vous connais pas, je refuse de faire ça!') ) );
				echo json_encode($response);
			}
		break;
		case 'mpd_previous':
			global $_,$myUser;
			
			if($myUser->can('lecteur mpd','u')){
				$cmd = 'mpc prev';
				ob_start();
				system($cmd,$out);
				$affirmation = preg_replace("/[\r|\n].*/i", '', ob_get_contents());
				ob_end_clean();
				
				if(!isset($_['webservice'])){
					//header('location:index.php?module=room&id='.$DHT->getRoom());
				}else{
					$response = array('responses'=>array( array('type'=>'talk','sentence'=>$affirmation) ) );

					$json = json_encode($response);
					echo ($json=='[]'?'{}':$json);
				}
			} else {
				$response = array('responses'=>array( array('type'=>'talk','sentence'=>'Je ne vous connais pas, je refuse de faire ça!') ) );
				echo json_encode($response);
			}
		break;
		case 'mpd_play':
			global $_,$myUser;
			
			if($myUser->can('lecteur mpd','u')){
				$cmd = 'mpc toggle';
				ob_start();
				system($cmd,$out);
				$affirmation = preg_replace("/[\r|\n].*/i", '', ob_get_contents());
				ob_end_clean();
				
				if(!isset($_['webservice'])){
					//header('location:index.php?module=room&id='.$DHT->getRoom());
				}else{
					$response = array('responses'=>array( array('type'=>'talk','sentence'=>$affirmation) ) );

					$json = json_encode($response);
					echo ($json=='[]'?'{}':$json);
				}
			} else {
				$response = array('responses'=>array( array('type'=>'talk','sentence'=>'Je ne vous connais pas, je refuse de faire ça!') ) );
				echo json_encode($response);
			}
		break;
		case 'mpd_pause':
			global $_,$myUser;
			
			if($myUser->can('lecteur mpd','u')){
				$cmd = 'mpc pause';
				
				exec($cmd,$out);
				
				if(!isset($_['webservice'])){
					//header('location:index.php?module=room&id='.$DHT->getRoom());
				}else{
					$affirmations = array(	'A vos ordres!',
								'Bien!',
								'Oui commandant!',
								'Avec plaisir!',
								'J\'aime vous obéir!',
								'Avec plaisir!',
								'Certainement!',
								'Je fais ça sans tarder!',
								'Avec plaisir!',
								'Oui chef!');
					$affirmation = $affirmations[rand(0,count($affirmations)-1)];
					$response = array('responses'=>array( array('type'=>'talk','sentence'=>$affirmation) ) );

					$json = json_encode($response);
					echo ($json=='[]'?'{}':$json);
				}
			} else {
				$response = array('responses'=>array( array('type'=>'talk','sentence'=>'Je ne vous connais pas, je refuse de faire ça!') ) );
				echo json_encode($response);
			}
		break;
		case 'mpd_info':
			global $_,$myUser;
			
			if($myUser->can('lecteur mpd','u')){
				$cmd = 'mpc';
				

				ob_start();
				system($cmd,$out);
				$affirmation = preg_replace("/[\r|\n].*/i", '', ob_get_contents());
				ob_end_clean();
				
				if(!isset($_['webservice'])){
					//header('location:index.php?module=room&id='.$DHT->getRoom());
				}else{
					$response = array('responses'=>array( array('type'=>'talk','sentence'=>$affirmation) ) );

					$json = json_encode($response);
					echo ($json=='[]'?'{}':$json);
				}
			} else {
				$response = array('responses'=>array( array('type'=>'talk','sentence'=>'Je ne vous connais pas, je refuse de faire ça!') ) );
				echo json_encode($response);
			}
		break;
	}
}


Plugin::addCss("/css/style.css"); 

Plugin::addHook("action_post_case", "mpd_action_mpd"); 
Plugin::addHook("vocal_command", "mpd_vocal_command");

?>