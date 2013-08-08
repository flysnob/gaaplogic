function testNode (target, nodeId){					
	$('#ah' + nodeId).addClass('alert-success');				
	$('#cc' + nodeId).removeClass('hidden');				
	switch (target){				
		case 10: // target node is 10; evaluate previous three answers			
			ans7 = $('span[id="7"]').parent().parent().parent().find('li.selected').html();		
			ans8 = $('span[id="8"]').parent().parent().parent().find('li.selected').html();		
			ans9 = $('span[id="9"]').parent().parent().parent().find('li.selected').html();		
			if (ans7 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '31';	
				evaluateNode(target, nodeId);

				break;	
			} else if (ans8 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '31';	
				evaluateNode(target, nodeId);	

				break;	
			} else if (ans9 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '31';	
				evaluateNode(target, nodeId);	

				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '11';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 13: // target node is 13; evaluate previous three answers			
			ans11 = $('span[id="11"]').parent().parent().parent().find('li.selected').html();		
			ans12 = $('span[id="12"]').parent().parent().parent().find('li.selected').html();		
			if (ans11 == 'Yes'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans12 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is indexed	
				$('#no-' + nodeId).addClass('hidden');	
				target = '14';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 30: // target node is 30; evaluate previous three answers			
			ans22 = $('span[id="22"]').parent().parent().parent().find('li.selected').html();		
			ans23 = $('span[id="23"]').parent().parent().parent().find('li.selected').html();		
			ans24 = $('span[id="24"]').parent().parent().parent().find('li.selected').html();		
			ans25 = $('span[id="25"]').parent().parent().parent().find('li.selected').html();		
			ans26 = $('span[id="26"]').parent().parent().parent().find('li.selected').html();		
			ans27 = $('span[id="27"]').parent().parent().parent().find('li.selected').html();		
			ans28 = $('span[id="28"]').parent().parent().parent().find('li.selected').html();		
			ans29 = $('span[id="29"]').parent().parent().parent().find('li.selected').html();		
			if (ans22 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans23 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans24 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans25 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans26 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans27 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans28 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans29 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '51';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is equity	
				$('#no-' + nodeId).addClass('hidden');	
				target = '92';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 33: // target node is 33; evaluate previous three answers			
			ans31 = $('span[id="31"]').parent().parent().parent().find('li.selected').html();		
			ans32 = $('span[id="32"]').parent().parent().parent().find('li.selected').html();		
			if (ans31 == 'Yes'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '107';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans32 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '107';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is indexed	
				$('#no-' + nodeId).addClass('hidden');	
				target = '34';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 50: // target node is 50; evaluate previous three answers			
			ans42 = $('span[id="42"]').parent().parent().parent().find('li.selected').html();		
			ans43 = $('span[id="43"]').parent().parent().parent().find('li.selected').html();		
			ans44 = $('span[id="44"]').parent().parent().parent().find('li.selected').html();		
			ans45 = $('span[id="45"]').parent().parent().parent().find('li.selected').html();		
			ans46 = $('span[id="46"]').parent().parent().parent().find('li.selected').html();		
			ans47 = $('span[id="47"]').parent().parent().parent().find('li.selected').html();		
			ans48 = $('span[id="48"]').parent().parent().parent().find('li.selected').html();		
			ans49 = $('span[id="49"]').parent().parent().parent().find('li.selected').html();		
			if (ans42 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans43 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans44 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans45 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans46 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans47 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans48 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans49 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '108';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is equity	
				$('#no-' + nodeId).addClass('hidden');	
				target = '109';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 56: // target node is 56; evaluate previous three answers			
			ans53 = $('span[id="53"]').parent().parent().parent().find('li.selected').html();		
			ans54 = $('span[id="54"]').parent().parent().parent().find('li.selected').html();		
			ans55 = $('span[id="55"]').parent().parent().parent().find('li.selected').html();		
			if (ans53 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '81';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans54 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '81';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans55 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '81';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '57';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 60: // target node is 60; evaluate previous three answers			
			ans58 = $('span[id="58"]').parent().parent().parent().find('li.selected').html();		
			ans59 = $('span[id="59"]').parent().parent().parent().find('li.selected').html();		
			if (ans58 == 'Yes'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '98';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans59 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '98';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '61';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 77: // target node is 77; evaluate previous three answers			
			ans69 = $('span[id="69"]').parent().parent().parent().find('li.selected').html();		
			ans70 = $('span[id="70"]').parent().parent().parent().find('li.selected').html();		
			ans71 = $('span[id="71"]').parent().parent().parent().find('li.selected').html();		
			ans72 = $('span[id="72"]').parent().parent().parent().find('li.selected').html();		
			ans73 = $('span[id="73"]').parent().parent().parent().find('li.selected').html();		
			ans74 = $('span[id="74"]').parent().parent().parent().find('li.selected').html();		
			ans75 = $('span[id="75"]').parent().parent().parent().find('li.selected').html();		
			ans76 = $('span[id="76"]').parent().parent().parent().find('li.selected').html();		
			if (ans69 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans70 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans71 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans72 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans73 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans74 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans75 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans76 == 'Yes') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals is not equity	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '78';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is equity	
				$('#no-' + nodeId).addClass('hidden');	
				target = '80';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 311: // target node is 311; evaluate previous six answers			
			ans305 = $('span[id="305"]').parent().parent().parent().find('li.selected').html();		
			ans306 = $('span[id="306"]').parent().parent().parent().find('li.selected').html();		
			ans307 = $('span[id="307"]').parent().parent().parent().find('li.selected').html();		
			if (ans305 == 'Yes') {		
				if (ans306 == 'Yes' || ans307 == 'Yes') {	
					part = 'No';
				} else {	
					part = "Yes";
				}	
			} else {		
				part = 'No';	
			}		
			ans308 = $('span[id="308"]').parent().parent().parent().find('li.selected').html();		
			ans309 = $('span[id="309"]').parent().parent().parent().find('li.selected').html();		
			ans310 = $('span[id="310"]').parent().parent().parent().find('li.selected').html();		
			if (part == 'Yes'){		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '312';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans308 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '312';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans309 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '312';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans310 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '312';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2302';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 347: // target node is 347; evaluate previous five answers			
			ans342 = $('span[id="342"]').parent().parent().parent().find('li.selected').html();		
			ans351 = $('span[id="351"]').parent().parent().parent().find('li.selected').html();		
			ans352 = $('span[id="352"]').parent().parent().parent().find('li.selected').html();		
			ans353 = $('span[id="353"]').parent().parent().parent().find('li.selected').html();		
			ans354 = $('span[id="354"]').parent().parent().parent().find('li.selected').html();		
			if (ans342 == 'No'){		
				$('#yes-' + nodeId).removeClass('hidden'); 
				$('#no-' + nodeId).addClass('hidden');	
				target = '356';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans351 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); 
				$('#no-' + nodeId).addClass('hidden');	
				target = '356';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans352 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); 
				$('#no-' + nodeId).addClass('hidden');	
				target = '356';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans353 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); 
				$('#no-' + nodeId).addClass('hidden');	
				target = '356';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans354 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); 
				$('#no-' + nodeId).addClass('hidden');	
				target = '356';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#no-' + nodeId).removeClass('hidden'); 	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2312';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 361: // target node is 361; evaluate previous two answers			
			ans359 = $('span[id="359"]').parent().parent().parent().find('li.selected').html();		
			ans360 = $('span[id="360"]').parent().parent().parent().find('li.selected').html();		
			if (ans359 == 'No'){		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is indexed	
				$('#no-' + nodeId).addClass('hidden');	
				target = '362';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans360 == 'No') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is indexed	
				$('#no-' + nodeId).addClass('hidden');	
				target = '362';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2313';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 364: // target node is 364; evaluate previous two answers			
			ans362 = $('span[id="362"]').parent().parent().parent().find('li.selected').html();		
			ans363 = $('span[id="363"]').parent().parent().parent().find('li.selected').html();		
			if (ans362 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2314';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans363 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2314';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is indexed	
				$('#no-' + nodeId).addClass('hidden');	
				target = '365';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 408: // target node is 408; evaluate previous five answers			
			ans403 = $('span[id="403"]').parent().parent().parent().find('li.selected').html();		
			ans404 = $('span[id="404"]').parent().parent().parent().find('li.selected').html();		
			ans405 = $('span[id="405"]').parent().parent().parent().find('li.selected').html();		
			ans406 = $('span[id="406"]').parent().parent().parent().find('li.selected').html();		
			ans407 = $('span[id="407"]').parent().parent().parent().find('li.selected').html();		
			if (ans403 == 'No'){		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '409';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans404 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '409';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans405 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '409';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans406 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '409';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans407 == 'Yes') {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is a derivative	
				$('#no-' + nodeId).addClass('hidden');	
				target = '409';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not a derivative	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2320';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 412: // target node is 412; evaluate previous two answers			
			ans410 = $('span[id="410"]').parent().parent().parent().find('li.selected').html();		
			ans411 = $('span[id="411"]').parent().parent().parent().find('li.selected').html();		
			if (ans410 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '413';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans411 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '413';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is indexed	
				$('#no-' + nodeId).addClass('hidden');	
				target = '2321';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		case 415: // target node is 415; evaluate previous three answers			
			ans413 = $('span[id="413"]').parent().parent().parent().find('li.selected').html();		
			ans414 = $('span[id="414"]').parent().parent().parent().find('li.selected').html();		
			if (ans413 == 'No'){		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2322';	
				evaluateNode(target, nodeId);	
				break;	
			} else if (ans414 == 'No') {		
				$('#no-' + nodeId).removeClass('hidden'); // 'no' equals not indexed	
				$('#yes-' + nodeId).addClass('hidden');	
				target = '2322';	
				evaluateNode(target, nodeId);	
				break;	
			} else {		
				$('#yes-' + nodeId).removeClass('hidden'); // 'yes' equals is indexed	
				$('#no-' + nodeId).addClass('hidden');	
				target = '416';	
				evaluateNode(target, nodeId);	
				break;	
			}		
		default:			
			break;		
	}				
}					
