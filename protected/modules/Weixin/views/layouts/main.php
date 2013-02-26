<xml>
    <ToUserName><![CDATA[<?php echo $this->receiver; ?>]]></ToUserName>
    <FromUserName><![CDATA[<?php echo $this->developer; ?>]]></FromUserName>
    <CreateTime><?php echo time() ?></CreateTime>
    <MsgType><![CDATA[<?php echo $this->messageType; ?>]]></MsgType>
<?php
    echo $content;
?>
    <FuncFlag>0</FuncFlag>
</xml>