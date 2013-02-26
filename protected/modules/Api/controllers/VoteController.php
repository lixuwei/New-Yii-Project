<?php
class VoteController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }
    public function actionVote()
    {
        $rules = array(
            'mark' => array(
                'limit' => 1,
                'name' => 'mark',
            ),
            'count' => array(
                'limit' => 2,
                'name' => 'count'
            ),
        );

        $vote_request = Yii::app()->request->getParam('Vote');
        $vote = new RuleChain($rules[$vote_request['type']], $vote_request);
        if( $vote->doCheck() !== true)
            $this->renderJSON(false, $vote);
        else
        {
            if( !$vote->doVote() )
                $this->renderJSON(false, 'Vote Save Failed!');
        }

        $this->renderJSON(true, 'OK-vote-end');
    }
}
