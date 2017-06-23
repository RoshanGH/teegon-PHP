<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>checkout</title>
    <script>
    var TEE_API_URL="<?php echo constant('TEE_API_URL')?>";
    var client_id =  "<?php echo constant('TEE_CLIENT_ID')?>";
    </script>

    <script src="<?php echo constant('TEE_SITE_URL')?>jslib/t-charging.min.js"></script>

    <script src="<?php echo constant('TEE_SITE_URL')?>static/js/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>支付方式</h1>
        <hr />

        <h4>第一步: 生成订单</h4>

        <h4>第二步: 生成支付单, 并调用天工接口.  将接口返回数据传给页面SDK</h4>

        <h5>PC</h5>
        <ul>
            <li><button class="pb" channel="alipay">支付宝支付</button></li>
            <li><button class="pb" channel="*">弹出页面支付</button></li>
        </ul>

        <h5>移动端</h5>
        <ul>
            <li><button class="pb" channel="alipay_wap">支付宝支付(手机)</button></li>
            <li><button class="pb" channel="wxpay_jsapi">微信支付(手机)</button></li>
            <li><button class="pb" channel="*:wap:alipay_wap,wxpay_jsapi">弹出控件支付</button></li>
        </ul>

        <script>
//        $('.pb').on('click',function(){
//            tee.ChargeWizard({
//              "charge_id":'<?php //echo $charge->id ?>//',
//              "platform":"mobile",
//              "payments":["alipay_wap","wxpay_jsapi"]
//            })
//        });

        $('.pb').click(function(e){
            $.ajax({
                // data: "goods_id=123131&channel="+$(e.target).attr('channel')+"&action=pay&return="+window.location+"&wx_openid=o0W-Ds8FgZnkkGXHoc5VJJ7n8FQQ",
                data: "goods_id=123131&channel=wxpay&action=pay&return="+window.location+"&wx_openid=o0W-Ds8FgZnkkGXHoc5VJJ7n8FQQ",
                method:'post'
            }).done(tee.charge);

        });
        </script>
        <h5>php代码</h5>
        <pre><?php echo $code; ?></pre>
        <h4>第三步: 处理回调</h4>

    </div>
</body>
</html>
