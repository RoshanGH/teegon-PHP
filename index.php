<?php
header("Content-type: text/html; charset=UTF-8");
include('config.php');
include('lib/teegon.php');
$srv = new TeegonService(TEE_API_URL);

if(!empty($_POST['action']) && $_POST['action'] == 'pay'){
    $param['order_no'] = substr(md5(time().print_r($_SERVER,1)), 0, 24); //订单号
    $param['channel'] = $_POST['channel'];
    $param['return_url'] = $_POST['return'];
    $param['amount'] = 0.01;
    $param['subject'] = '测试支付';
    $param['metadata'] = json_encode(array('sub_account'=>'xxxxxxxxx'));//没有给空
    $param['notify_url'] = $_POST['return']."?notify=1";//支付成功后天工支付网关通知
    $param['wx_openid'] = $_POST['wx_openid'];//没有给空
    echo $srv->pay($param,false);
    exit;
}
elseif(!empty($_GET['notify'])){

    $now = time();
    $amount = 0.01;
    $arr = array(
            //array("source_account"=>"hkvwdvkr","target_account"=>"main","amount"=>0),
            array("source_account"=>"main","target_account"=>"main","amount"=>"0.01"),
        );
    $return = json_encode($arr);
    $sign = md5($return.TEE_CLIENT_SECRET);
    header('Teegon-Rsp-Sign: '.$sign);
    echo $return;
    file_put_contents("./log/2.log", $return);
    file_put_contents("./log/0.log", TEE_CLIENT_SECRET);
    file_put_contents("./log/1.log", var_export($_POST,true));
    exit;
}elseif(!empty($_GET['charge_id'])){

    file_put_contents(filename, var_export($_POST,true));
    echo "<h1>支付成功, 返回信息如下</h1><hr ><pre>";
    /**
    order_no   订单id
    charge_id  天工交易号id
    buyer      购买用户email 或者oppen_id
    payment_no 交易平台返回的交易号
    amount     订单金额
    channel    天工的支付类型   wxpay 微信支付  alipay 阿里支付
    metadata   额外的参数  在调用支付接口的时候传过来的参数  json格式，调用支付接口传的什么返回的时候就返回什么
    **/

    $s = $srv->verify_return();
    if($s == 0){

        echo "<h1>支付成功, 返回信息如下</h1><hr ><pre>";
    }
    else{
        echo $s['error_msg'];
        print_r($s['param']);
    }


    exit;
}else{
    $param['order_no'] = substr(md5(time().print_r($_SERVER,1)), 0, 24);
    $param['return_url'] = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
    $param['amount'] = 0.01;
    $param['subject'] = '测试支付';
    $param['metadata'] = json_encode(array('sub_account'=>'xxxxxxxxx'));
    $param['notify_url'] = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]."?notify=1";
    $rst = $srv->pay($param);
    $charge = $rst->result;

    $code = implode(array_slice(file(__FILE__), 7, 10), "");
    //include('checkout.tpl.php');
    include('list.php');
    exit;
}


