<?php
class Mark
{
    private $_rule;
    private $_vote;

    public function __construct($rule, $vote)
    {
        $this->_rule = $rule;
        $this->_vote = $vote;
    }
    /**
     * 返回判定是否可投票逻辑结果
     * @return bool
     */
    public function Result()
    {
        return $this->_doCheck();
    }

    private function _doCheck()
    {
        //check vote count
        if( $this->_getProjectVoteCnt() > $this->_rule['limit'] )
            return false;

        if( $this->_isProjectEnabledVote() )
            return true;
    }

    /**
     * 获取单元表中对指定专题中项目的投票次数
     * @return mixed
     */
    private function _getProjectVoteCnt()
    {
        return Vote::model()->getProjectVoteCnt();
    }

    /**
     * 检测是否开启了Vote
     * @return bool
     */
    private function _isProjectEnabledVote()
    {
        $sid = $this->_vote['Vote']['sid'];
        $pid = $this->_vote['Vote']['pid'];
        return VoteConfig::model()->isProjectEnabledVote($sid, $pid);
    }
}
