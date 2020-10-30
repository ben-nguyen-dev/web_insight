<?php
include_once '../wp-config.php';

function callNia($request, $supplierString) {
    // server settings
    $host = 'newsmachine.com';
    //$supplierString = "omx";
    $uri = '/integrate/rpc.php/' . $supplierString;
    $port = '80';
    //echo "CALL " . $host ."," .  $uri .",". $port .",". $request;
    return callXml($host, $uri, $port, $request);

}
function callXml($host, $uri, $port, $request) {

    $url = "http://" . $host . $uri;
    $header[] = "Content-type: text/xml; charset=utf-8";
    $header[] = "Content-length: ".strlen($request);

    $ch = curl_init();   
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds

    $data = curl_exec($ch);       
    if (curl_errno($ch)) {
        print curl_error($ch);
    } else {
        curl_close($ch);
        return $data;
    }
}
function getAgentResults() {
    $agentId = 264527;
    $supplierString = "publicinsight";
    $password = "QwBSgkmR5pfZe5LrKQuH";
    $custId = 7471;
    $userId = 12538;
    $auth = array('custId' => $custId, 'passwd' => $password);
    $method = 'nia.CollectResults';
    $ser = array('datehigh' => 0, 'datelow' => (365 * 24 * 3600), 'maxRes' => 20);
    $params = array($auth, 12538, $agentId, $ser);

    // this function makes the XML-RPC request
    $request = xmlrpc_encode_request($method, $params, array('encoding' => 'UTF-8', 'escaping' => 'markup'));
    $response = callNia($request, $supplierString);
    $decResp = xmlrpc_decode($response, "utf-8");    
    return formatAgentResults($decResp);
}
function formatAgentResults($decResp) {
    if (!empty($decResp)) {
        foreach ($decResp["resultSets"] as $result) {
            // TODO add second quote and make bold tags work instead of stripping away
            $quoteText = strip_tags($result['resultRows'][0]);
            $post = array(
                'post_title' => ($result["documents"][0]["title"] != '') ? $result["documents"][0]["title"] : $result["documents"][0]["sourceName"],
                'post_date' => date('Y-m-d H:i:s', strtotime($result["documents"][0]["date"])),
                'post_excerpt' => $quoteText,
                'post_status' => 'publish',
                'post_type' => 'post',
            );
                $args = [
                    'meta_key'   => 'url_link',
                    'meta_value' => $result["documents"][0]['url'],
                ];
                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    if ($post['post_title'] == $query->posts[0]->post_title && $post['post_excerpt'] == $query->posts[0]->post_excerpt) {
                      continue;  
                    }
                    $post['ID'] = $query->posts[0]->ID;
                    wp_update_post($post, true);
                } else {
                    $id_post = wp_insert_post($post,true);
                    if ($id_post) {
                        add_post_meta($id_post,'url_link',$result["documents"][0]['url']);
                    }
                }
        }
    }
}
getAgentResults();