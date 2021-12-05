<?php

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'fetch_contract':
            if (isset($_GET['contract_address'])) {
                echo json_encode(get_contract($_GET['contract_address']));
            } else {
                echo json_encode(array('status' => false, 'err_message' => 'contract not set'));
            }
            break;
        case 'gen_image':
            //generate_image();
            $req_name = "DEFX";
            $req_logo = "https://tools.dexfolio.org/crypto-calculator/img/favicon.svg";
            $req_msg = 'DEFX is AWESOME! Trade Now asdfasfd ';
            $req_tnc = "#FFFFFF";
            $req_lib = 'transparent';
            if (isset($_GET['name']) && !empty($_GET['name']))
                $req_name = $_GET['name'];

            if (isset($_GET['logo']) && !empty($_GET['logo']))
                $req_logo = $_GET['logo'];

            if (isset($_GET['msg']) && !empty($_GET['msg']))
                $req_msg = $_GET['msg'];

            if (isset($_GET['tnc']) && !empty($_GET['tnc']))
                $req_tnc = $_GET['tnc'];

            echo json_encode(generate_image($req_name, $req_logo, $req_msg, $req_tnc, $req_lib));
            break;
        default:
            echo json_encode(array('status' => false, 'err_message' => 'invalid action'));
    }
} else {
    echo "Dexfolio Listing Check API";
}

function fetch_contract($contract_address, $chain_id)
{
    $url = 'https://api.covalenthq.com/v1/pricing/historical_by_addresses_v2/' . $chain_id . '/USD/' . $contract_address . '/?&key=ckey_a';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);


    if ($response->error) {
        $token['status'] = false;
        $token['err_message'] = $response->error_message;
    } else if (is_null($response->data[0]->contract_ticker_symbol)) {
        $token['status'] = false;
        $token['err_message'] = 'Token not supported';
    } else {
        $token['status'] = true;
        $token['symbol'] = $response->data[0]->contract_ticker_symbol;
    }
    return $token;
}

function check_contract($contract_address)
{
    $valid_chains = array(1, 137, 56, 42, 97, 80001);
    $token = "";
    foreach ($valid_chains as $chain_id) {
        $token = fetch_contract($contract_address, $chain_id);
        if ($token['status']) {
            break;
        }
    }

    return $token;
}

function get_contract($contract_address)
{

    $token_check = check_contract($contract_address);

    if (!$token_check['status']) {
        return $token['status'] = $token_check;
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.nomics.com/v1/currencies/ticker?key=e5df6b17e4ba9cdd4998975fb863f178be4add19&interval=false&convert=USD&per-page=1&page=0&sort=rank&ids=' . strtoupper($token_check['symbol']),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response)[0];

    $token['status'] = true;
    $token['name'] = $response->name;
    $token['symbol'] = $response->symbol;
    $token['price'] = $response->price;
    $token['logo_url'] = $response->logo_url;

    return $token;
}

function generate_image($name, $logo, $msg, $tnc, $lib = 'transparent')
{
    $post_url = 'name=' . $name . '&logo=' . rawurlencode($logo) . '&msg=' . rawurlencode($msg) . '&tnc=' . rawurlencode($tnc) . '&lib=' . rawurlencode($lib);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dexfolio-image-api.herokuapp.com/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_url,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $file_name = base_convert(uniqid(), 8, 32);

    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        // $image_storage = "./";
        $image_storage = "../../i/";
    } else {
        $image_storage = "../../i/";
    }

    file_put_contents($image_storage . $file_name . '.png', $response);

    return array('status' => true, 'image_name' => $file_name);
}
