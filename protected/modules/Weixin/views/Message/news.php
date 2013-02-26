<ArticleCount><?php echo count($data);?></ArticleCount>
<Articles>
<?php foreach( $data as $v){ ?>
    <item>
        <Title><![CDATA[<?php echo $v['title'] ?>]]></Title>
        <Description><![CDATA[<?php echo $v['desc'] ?>]]></Description>
        <PicUrl><![CDATA[<?php echo $v['pic'] ?>]]></PicUrl>
        <Url><![CDATA[<?php echo $v['url'] ?>]]></Url>
    </item>
<?php }?>
</Articles>

<?php
/*
 *         $renderInfo = array(
            'type'=>'news',
            'data'=>array(
                array(
                    'title' => 'abc1',
                    'desc' => 'descddddddddddddddddddddddddd2',
                    'pic' => 'http://jdwan.com/c.jpg',
                    'url' => 'http://www.qq.com/'
                ),
                array(
                    'title' => 'abc12',
                    'desc' => 'descddddddddddddddddddddddddddddd12',
                    'pic' => 'http://jdwan.com/c.jpg',
                    'url' => 'http://www.jdwan.com/'
                ),
            )
        );
 */
?>