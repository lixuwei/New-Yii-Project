<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-25
 * Time: 上午10:20
 * To change this template use File | Settings | File Templates.
 */
Yii::import('Api.components.Vote.checker.*');
class RuleChain
{
    private $_checker;
    private $_vote;

    public function __construct($rule, $vote)
    {
        $checker = ucfirst(trim($rule['name']));
        $this->_vote = $vote;
        $this->_checker = new $checker($rule, $vote);
    }

    public function doCheck()
    {
        return $this->_checker->Result();
    }

    public function doVote()
    {
        $sid = $this->_vote['sid'];
        $pid = $this->_vote['pid'];
        $vote = array('sid'=>$sid, 'pid'=>$pid);
        $voter = new Vote();
        return $voter->doVote($vote);
    }
}
