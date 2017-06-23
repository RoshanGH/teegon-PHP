<?php
/**
 * Created by IntelliJ IDEA.
 * User: imo
 * Date: 16/3/10
 * Time: 下午7:24
 */
header("Content-type: text/html; charset=UTF-8");
include('config.php');
include('lib/teegon.php');

$param['order_no'] = substr(md5(time().print_r($_SERVER,1)), 0, 24); //订单号
$param['channel'] = 'alipay_wap';
$param['amount'] = 0.01;
$param['subject'] = "测试";
$param['metadata'] = "";//可以为空但是参数必须要有
$param['notify_url'] = 'http://www.baidu.com';//支付成功后天工支付网关通知 ; alipay_wap 是手机端调用支付宝app支付宝不会进行跳转所以没有return_url。
$param['client_ip'] = '127.0.0.1';
$param['client_id'] = TEE_CLIENT_ID;

$srv = new TeegonService(TEE_API_URL);
$sign = $srv->sign($param);
$param['sign'] = $sign;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支付</title>
</head>
<body>

<div  style="margin-left:40%; width:410px; height:50px; border-radius: 15px; border:0px #FE6714 solid; cursor: pointer;    font-size:26px;">天工收银支付宝手机端支付</div><br/>

<form action="<?php echo TEE_API_URL?>charge/pay" method="post">
    <div style="margin-left:2%;">订单号：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="order_no" value="<?php echo $param['order_no']?>" />
    <br>
    <div style="margin-left:2%;">支付类型：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="channel" value="<?php echo $param['channel']?>" />
    <br>
    <div style="margin-left:2%;">支付金额：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="amount" value="<?php echo $param['amount']?>" />
    <br>
    <div style="margin-left:2%;">商品名称：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="subject" value="<?php echo $param['subject']?>" />
    <br>
    <div style="margin-left:2%;">备注信息：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="metadata" value="<?php echo $param['metadata']?>" />
    <br>
    <div style="margin-left:2%;">IP：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="client_ip" value="<?php echo $param['client_ip']?>" />
    <br>
    <div style="margin-left:2%;">异步回调地址：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="notify_url" value="<?php echo $param['notify_url']?>" />
    <br>
    <div style="margin-left:2%;">验签：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="sign" value="<?php echo $param['sign']?>" />
    <br>
    <div style="margin-left:2%;">天工收银client_id：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="client_id" value="<?php echo $param['client_id']?>" />
    <br>
    <div align="center">
        <input type="submit" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" value="支付">
    </div>
</form>

</body>
</html>
