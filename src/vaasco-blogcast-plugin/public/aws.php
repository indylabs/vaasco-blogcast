<?php

    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );

    require '../vendor/autoload.php';

    use Aws\CognitoIdentity\CognitoIdentityClient;
    use Aws\Sts\StsClient;
    use Aws\S3\S3Client;

    $options = get_option('vaasco_options');
    $identityPoolId = $options['vaasco_aws_identity_pool_id'];
    $region = explode(":", $identityPoolId)[0];

    $client = CognitoIdentityClient::factory(array(
        'region'  => $region,
        'version' => 'latest'
    ));

    $idResponse = $client->getId(array(
        'IdentityPoolId' => $identityPoolId
    ));

    $identityId = $idResponse['IdentityId'];

    echo json_encode(array('IdentityId' => $identityId));

?>