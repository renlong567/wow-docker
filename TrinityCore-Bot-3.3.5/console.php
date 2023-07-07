<?php

$soap_connection_info = array(
  'soap_uri' => 'urn:AC',
  'soap_host' => '127.0.0.1',
  'soap_port' => '7878',
  'account_name' => 'idc02',
  'account_password' => 'idc02'
);

function RemoteCommandWithSOAP($username, $password, $COMMAND)
{
    global $soap_connection_info;
    $result = '';

    try {
        $conn = new SoapClient(NULL, array(
            'location' => 'http://' . $soap_connection_info['soap_host'] . ':' . $soap_connection_info['soap_port'] . '/',
            'uri' => $soap_connection_info['soap_uri'],
            'style' => SOAP_RPC,
            'login' => $username,
            'password' => $password
        ));
        $result = $conn->executeCommand(new SoapParam($COMMAND, 'command'));
        unset($conn);
    } catch (Exception $e) {

        $result = "Have error on soap!\n";

        if (strpos($e, 'There is no such command') !== false) {
            $result = 'There is no such command!';
        }
    }
    return $result;
}

echo RemoteCommandWithSOAP($soap_connection_info['account_name'], $soap_connection_info['account_password'], ".server info");

?>