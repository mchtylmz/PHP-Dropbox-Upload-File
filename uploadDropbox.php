<?php
error_reporting(0);
$result = array('status' => 'error');
$fileName = date('dmY') . '-backup';
if (file_exists($fileName.'.zip')) {

	$path = $fileName.'.zip';
	$fp = fopen($path, 'rb');
	$size = filesize($path);
	$AccessToken = 'IdfRWdcw8xAAAAAAAAAAf9E168N5RhW7Qyv6JqvP7RRelWM75KkZAVl0m_NmuM62';

	$cheaders = array('Authorization: Bearer '.$AccessToken,
	                  'Content-Type: application/octet-stream',
	                  'Dropbox-API-Arg: {"path":"/'.$_SERVER['HTTP_HOST'].'/'.$path.'", "mode":"add"}');
	$ch = curl_init('https://content.dropboxapi.com/2/files/upload');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $cheaders);
	curl_setopt($ch, CURLOPT_PUT, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_INFILE, $fp);
	curl_setopt($ch, CURLOPT_INFILESIZE, $size);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	$response = json_decode($response,true);
	//print_r($response);
	curl_close($ch);
	fclose($fp);
	if (isset($response['id'])) {
		unlink($fileName.'.zip');
	$result = array('status' => 'success');
	
	} 
}
echo json_encode($result);
?>
