# 天工收银 API
#####  天工收银目前支持 alipay_pinganpay  wxpaynative_pinganpay jdh5_pinganpay(京东) besth5_pinganpay(翼支付)  wxpaymp_pinganpay(jsapi)       alipay_wap
#####  其中alipay_wap 没有return_url  这个受限于支付宝  wxpaymp_pinganpay(jsapi) 使用curl方式提交交易数据 详情在相应代码中

-----------------------

最新更新
- 支持翼支付【2017 06 22】

---------


* [自有支付方式](#自有支付方式)

#### 支付回调参数

```php
amount=0.01                         //金额
bank=                               //银行
buyer=134%2A%2A%2A%2A0087           //账号所有人
buyer_openid=                       //支付方open_id
channel=alipay_pinganpay            //支付方式
charge_id=s3jrnfdvgwagn35mvvkdmo7c  //订单唯一标识
code=123                            //
domain_id=                          //
device_info=                        //
is_success=true                     //是否支付成功
metadata=                           //备注信息
order_no=7baf7cd34f71733ba1946fc6   //
pay_time=1477580832                 //支付时间
payment_no=2016102723064902010072479276   //
real_amount=0.01                    //真实金额（扣去费率)
sign=101C1CE110CCCC61A553028BA1F54AA1   //验签
status=                             //
timestamp=1477580832                //支付时间
```

###天工收银skd说明文档
#####简介
>首先感谢大家对天工收银的支持，在大量用户的线上平台与天工收银对接后我们现在补充一个给技术人员的对接是提供帮助的说明文档。对对接的模式以及参数说明进行更多的文本补充

#####对接准备工作
```
PHP : 	https://github.com/RoshanGH/teegon-PHP
JAVA:	https://github.com/RoshanGH/Teegon-JavaSDK
```
此git地址只是临时的代码地址，之后会迁移到天工收银的官方地址。
目前只有PHP 和 JAVA 的实例（以后会进行补充不过对接说明使用于各种语言）

#####模式说明
经常有对接方拿着代码来询问如何对接，对于这种情况的出现。一来是纯代码试的实例的确补充说明不是很充足，也有很多的程序员对外界依赖过多而忽视仔细阅读代码本身。所以在此对对接的模式进行一个语言描述，便于理解。

整个的天工的支付方式对接是一个纯接口调用的API模式。用规定好的方式，提交规定好的参数，到规定的API地址就结束了

下面来实例介绍：
（以PHP为例不管你用的是什么语言请仔细看调用方式是一样的）
######PC端：
包含： `支付宝` `微信支付` `银联快捷` `银联网银` alipay  wxpay   chinapay   chinapay_b2c
```PHP
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
$param['channel'] = 'wxpaynative_pinganpay'; //表单提交的方式支持  alipay  wxpay   chinapay_b2c  chinapay  需要哪个就替换哪个
$param['amount'] = 0.01;     //金额
$param['subject'] = "测试";  //商品名
$param['metadata'] = "";     //备注
$param['return_url'] = 'http://www.baidu.com';  //同步跳转页面    同步通知
$param['notify_url'] = 'http://www.jinxiushanhehao.com/index.php';//支付成功后天工支付网关通知   异步通知
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

<div  style="margin-left:40%; width:410px; height:50px; border-radius: 15px; border:0px #FE6714 solid; cursor: pointer;    font-size:26px;">天工收银支付宝扫码支付</div><br/>

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
    <div style="margin-left:2%;">同步回调地址：</div><br/>
    <input type="text" style="width:30%;height:35px;margin-left:2%;" name="return_url" value="<?php echo $param['return_url']?>" />
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
```
其中$param 就是需要 提交的参数，注意这些参数可以为空但不能没有
其中有一个sign方法在代码里已经分装好了如果是PHP或者JAVA直接去找就好了，如果是其他的语言下面有验签的规则
PC端统一是提交给  charge/pay  接口，这个接口在接收到正确的参数后会自动跳转到扫码页面（这个页面由天工提供）
如果对接方不想用天工提供的扫码页面，想用自己的可以post形式把上面的参数达到v1/charge这个接口，会返回如下json
```
{
  "result": {
    "id": "etzr36jzity66tdruggifnff",
    "domain_id": "a8b14e7e",
    "orderno": "b216d755bc1b77315622c1b1",
    "channel": "wxpaynative_pinganpay",
    "amount": 0.01,
    "real_amount": 0.01,
    "client_ip": "",
    "currency": "RMB",
    "subject": "测试",
    "body": "",
    "time_expire": 1480329257,
    "return_url": "http://www.baidu.com",
    "notify_url": "http://www.jinxiushanhehao.com/index.php",
    "device_id": "",
    "charge_type": "",
    "account_id": "",
    "auth_code": "",
    "sale_channel": "",
    "buyer_account": "",
    "seller_account": "",
    "description": "wxpay",
    "paid": false,
    "livemode": false,
    "refunded": false,
    "amountsettle": 0,
    "time_paid": 0,
    "time_settle": 0,
    "created": 1480328657,
    "updated": 0,
    "transaction_no": "",
    "amount_refunded": 0,
    "failure_code": "",
    "failure_msg": "",
    "metadata": "",
    "wx_openid": "",
    "buyer_openid": "",
    "action": {
      "type": "js",
      "url": "",
      "params": "var img = window.document.createElement(\"img\");\n    img.src = \"http://paysdk.weixin.qq.com/example/qrcode.php?data=weixin://wxpay/bizpayurl?pr=5CjUpWd\";\n    document.getElementById('native').appendChild(img);"
      //这里是二维码  这里是二维码  这里是二维码  重要的事情说三遍    这段js怎么用就不用我说了吧  这样你们就可以把二维码放在自己的页面里了  注意这时支付完成的页面跳转也要自己写了
    },
    "profit_error": "",
    "profit_apply_time": 0,
    "profit_result": "",
    "pay_rate": 1,
    "subsidy_rate": 0,
    "manual_journal": 0
  }
}
```
```
签名方法如下
1、排序
对所有 API 请求参数(包括系统级参数和业务参数，但除去 sign 参数和 byte[]类型的参数)，
根据参数名称的 ASCII 码表的顺序排序。如:foo=1, bar=2, foo_bar=3, foobar=4 排序后的顺 序是 bar=2, foo=1, foo_bar=3, foobar=4。
2、拼接
将排序好的参数名和参数值以<key1><value1><key2><value2>...<keyn><valuen>方式首 尾相椄成连续字符串，根据上面的示例得到的结果为: bar2foo1foo_bar3foobar4。
3、签名
在排序字符串首尾分别拼接 client_secret 后，进行 Md5 计算所得字符串进行大写处理得到最 终的 sign
```

PC端的就这样结束了

######关于验签：
有很多的对接方，找到我说验签总是失败，我只能说仔细检查，验签不比其他，它是一个别规定死的一个要求，要什么参数怎么样处理怎么样加密都是死的，你找我也是只能说让你仔细检查一下。不过在pc端由于可以用form表单的形式提交，这样会牵扯到在页面上时你的参数如果有汉字有可能出现乱码导致眼前失败所以要小心汉字的处理。
回掉的验签和支付的规则一样，代码里可以找到


######关于回调
所有的支付方式都有return_url和notify_url当支付成功以后，扫码页面或者银联的支付页面都会带着参数跳转到return_url中填写的页面，当然如果是用的自己的页面套的二维码，就自己写支付成功后的跳转。但是不管是何种情况，支付成功后我们都会向notify_url以post的形式回调给你支付成功的信息。如果你支付成功了但没有接到回调，请检查自己的地址是否填对了，而且要可以访问的到，也可以自己模拟get  post 数据。数据我们是一定会打出去的。

`注意事项`

当notify_url 接到了回调通知且程序执行完后必须打印输出“uccess”(不包含引号)



#####手机端/H5
手机端分两类：
1. 像 `银联快捷` `银联网银`  `手机端支付包`（注意手机端支付包的channel参数是alipay_wap且支付成功后不能跳转回去）
这几种支付方式手机端的调用模式和PC端是一样没有区别
2. 微信的手机端 channel 为 `wxpay_jsapi`  。这个支付方式有两点要求。
- 首先要使用这个支付方式需要在微信的浏览器中，就是说现在没有办法在手机端的其他浏览器中直接调用微信app。
- 其次就是这个支付方式需要用 curl post 的模式将参数提交到  v1/charge 这个接口，具体的参数参考wxpay_jsapi.php中的$param不管是什么语言这个是一定能看懂的。而且curl 的相应的方法也已经封装好了，不管是什么语言看就好了，别给我说你看不懂哦。提交成功后会返回一段js，将这段js放在html里就会自动的跳转唤起微信钱包进行支付。

自有支付方式
----------

在客户天工收银的开发配置中可以看到`自有支付宝账号` `自有微信账号` 的两个配置。这两个配置是用来让客户直接使用其在支付宝和微信申请的支付方式。

![自有支付](ziyoupay.jpeg)

只需要填写上客户自己从支付宝或者微信得到的支付开发配置即可。

```
当客户在此开启了自有的支付方式，通过天工收到的款项就直接进入了相应的支付宝和微信的收款账户中并不在天工的账号中
```

那么为什么有了自有的支付配置还要通过天工收银来使用而非自行对接支付宝和微信呢？原因十分简单也极为重要。使用天工收银聚合对接支付宝微信非常的`简单` `方便` `快捷` 。
