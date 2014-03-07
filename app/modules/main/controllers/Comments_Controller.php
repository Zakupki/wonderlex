<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/main/models/Comments.php';

Class Comments_Controller Extends BaseShop_Controller {
    private $registry;
    public $error;
    public $language=2;
    
    public function __construct($registry){
      parent::__construct($registry);
      $this->registry=$registry;
      $this->registry->token=new token;
      $this->Comments=new Comments;
    }

        function indexAction() {
    }
    function showcommentsAction() {
      if($_GET['id'])
      $itemid=$_GET['id'];
      else
      $itemid=false;
      
      $str=uniqid();
      $_SESSION['ADR_CAPTCHA']=substr($str, strlen($str)-4, strlen($str));
      
      $this->comments=$this->Comments->getComments($itemid);
      if(count($this->comments)<1)
      $display=' style="display: none;"';
      $data['content'] = '
        <div class="comments-form">
          <form action="/comments/addcomment/" method="post">
          <input name="itemid" value="'.$itemid.'" type="hidden" />
          <input name="siteid" value="'.$_SESSION['Site']['id'].'" type="hidden" />
          <input name="remove_url" value="/comments/remove/" type="hidden" />
            <h2><label for="comments-message">'.$this->registry->translate['leavecomment'].':</label></h2>
            <div class="field">
              <div class="label"><label for="comments-name">'.$this->registry->translate['name'].'</label></div>
              ';
      if($_SESSION['User']['id']){
      $data['content'] .= '
              <div class="user"><a>'.$_SESSION['User']['firstName'].'<i class="i"></i></a></div>
        ';
      }else{
      $data['content'] .= '
              <div class="input-text"><input name="name" id="comments-name" type="text" /></div>
      ';
      }
      $data['content'] .= '
            </div>
            <div class="field">
              <div class="label"><label for="comments-message">'.$this->registry->translate['message'].'</label></div>
              <div class="textarea">
                <div class="textarea"><textarea name="message" id="comments-message" rows="" cols="" class="required"></textarea></div>
              </div>
            </div>';
      if(!$_SESSION['User']['id']){
      $data['content'] .= '
            <div class="captcha-field field">
              <div class="label"><label for="comments-captcha">Спам фильтр</label></div>
              <div class="input-text input"> 
                <label for="comments-captcha"><img src="/captcha/image.php" alt="" /></label>
                <input name="user_capcha" id="comments-captcha" type="text" class="required" />
              </div>
            </div>';
      }
      $data['content'] .= ' 
            <div class="submit">
              <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit">'.$this->registry->translate['send'].'</button></div></div></div></div>
              <div class="status"></div>
              <div class="loading"></div>
            </div>
          </form>
        </div>';
      $data['content'] .= '          
        <div class="comments-list"'.$display.'>
          <h2>'.$this->registry->translate['comments'].' (<span class="total">'.count($this->comments).'</span>):</h2>
          <div class="list">';
            foreach($this->comments as $com){
              $data['content'] .= '
                <div class="li">
                  <input name="id" value="'.$com['id'].'" type="hidden" />
                  <div class="info">
                    <div class="user"><a>'.$com['firstName'].'<i class="i"></i></a></div>
                    <div class="date">'.$com['date_create'].'<i class="i"></i></div>';
          if($_SESSION['User']['id']==$_SESSION['Site']['userid'])    
             $data['content'] .= '<div class="remove"></div>';
              
             $data['content'] .= '
                  </div>
                  <div class="text">'.$com['preview_text'].'</div>
                </div>';
              }
              $data['content'] .= '
          </div>
        </div>
      ';
      
      echo json_encode($data);
      
      /* header('Content-Type: application/json; charset=utf-8'); */
    }
    function showcomments2Action() {
      
      if($_GET['id'])
      $itemid=$_GET['id'];
      else
      $itemid=false;
      
      $this->Release=new Release;
      $this->releasetype=$this->Release->getCommentReleaseType($itemid);
      $this->comments=$this->Comments->getComments($itemid,$this->releasetype['incut']);
      
      
      $data = array(
          'error' => false,
          'status' => '',
          'token' =>$this->registry->token->getToken()
      );
      if(count($this->comments) <= 0){
        $comments_disabled='comments-type-disabled ';
        $comments_tree_empty='comments-tree-empty ';
      }
      
      $comemntTree=tools::getComments($this->comments, $this->releasetype['incut'], $this->releasetype['userid']);
      
      if(!$this->releasetype['totalrate'])
        $this->releasetype['totalrate'] = 0;
      
      if ($this->Session->User['id'])
        $rateAct[$this->releasetype['rate']] = 'act ';
      else
        $rateClosed='auth-popup-link ';
      
      
       if (tools::int($_SESSION['User']['id']) < 1) { 
         
       }
       if (tools::int($_SESSION['User']['id']) > 0) {
         $submitB='<div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit">Добавить</button></div></div></div></div>';
       } else { 
         $submittext='<div class="note">Только зарегистрированые пользователи могут оставлять комментарии.</div>';
         $submitB='<div class="button"><div class="bg"><div class="r"><div class="l"><div class="auth-popup-link el">Добавить</div></div></div></div></div>';
       }
      
      if ($this->releasetype['totalrate']>0)
      $totelalrate='+'.$this->releasetype['totalrate'].'';
      else
      $totelalrate=$this->releasetype['totalrate'];
      
      if(strlen(trim($this->releasetype['pressrelease']))>0)
        $sharetitle=$this->releasetype['pressrelease'];
      else
        $sharetitle=$this->releasetype['author'].' - '.$this->releasetype['name'];
      
      $data['content'] = '
        <div class="comments-header">
          <ul class="'.$comments_disabled.' comments-type">
            <li class="all-link-act all-link"><span>Все комментарии<i class="i"></i></span></li>
            <li class="pro-link"><span>Комментарии профессионалов<i class="i"></i></span></li>
          </ul>
      
          <div class="post-share">
            <input name="url" value="/_share.php" type="hidden" />
            <input name="itemid" value="'.itemid.'" type="hidden" />
            <div class="title i"></div>
            <div class="links">
              <div class="r">
                <div class="l">
                  <ul>
                    <li class="link-twitter"><a href="http://twitter.com/home?status='.MAIN_NAME.'%20http%3A%2F%2F'.MAIN_HOST.'%2F" rel="twitter" target="_blank"><span class="total">'.tools::getTwCount(MAIN_HOST).'</span></a></li>
                    <li class="link-facebook"><a href="http://facebook.com/sharer.php?t='.$sharetitle.'&amp;u=%20http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'/release/'.$this->releasetype['id'].'/" rel="facebook" target="_blank"><span class="total">'.tools::getFbCount(MAIN_HOST).'</span></a></li>
                    <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F'.MAIN_HOST.'%2F" rel="vkontakte" target="_blank"><span class="total">'.tools::getVkCount(MAIN_HOST).'</span></a></li>
                    <li class="link-gplus"><a href="http://www.google.com/buzz/post?url=http%3A%2F%2'.MAIN_HOST.'%2F" rel="gplus" target="_blank"><span class="total">12</span></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          
          <div class="post-rate">
            <input name="url" value="/comments/rate/" type="hidden" />
            <input name="total_rate" value="'.$this->releasetype['totalrate'].'" type="hidden" />
            <input name="current_rate" value="'.$this->releasetype['rate'].'" type="hidden" />
            <input name="itemid" value="'.$itemid.'" type="hidden" />
            
            <div class="title">Рейтинг 
                        <span class="total">
                        ('.$totelalrate.')
                      </span> &nbsp;
                      <a href="/help/" target="_blank" class="help-link"><img src="/img/reactor/px.gif" alt="" /></a>
          </div>
              <div class="'.$rateAct[1].' '.$rateClosed.' like-link"><i class="i"></i></div>
              <div class="'.$rateAct[-1].' '.$rateClosed.' dislike-link"><i class="i"></i></div>
           </div>
        </div>
      
        <div class="'.$comments_tree_empty.'comments-tree">
          <input name="remove_url" value="/comments/remove/" type="hidden" />
          <input name="quote_url" value="/comments/quote/" type="hidden" />
          <input name="unquote_url" value="/comments/unquote/" type="hidden" />
          
        '.$comemntTree.'
        
        </div>
      
        <div class="comments-add">
          <div class="add-link"><span>Добавить комментарий</span></div>
          <div class="comments-form">
            <form action="/comments/addcomment/" method="post" enctype="multipart/form-data">
              <input name="parent_id" value="0" type="hidden" />
              <input name="itemid" value="'.$this->releasetype['itemid'].'" type="hidden" />
              <input name="siteid" value="'.$this->releasetype['siteid'].'" type="hidden" />
              <input name="authorid" value="'.$this->releasetype['userid'].'" type="hidden" />
              <input name="incut" value="'.$this->releasetype['incut'].'" type="hidden" />
              <input name="datatype" value="releases" type="hidden" />
              <div class="field-message field">
                <label for="comments-form-message" class="placeholder">Сообщение</label>
                <div class="textarea">
                  <textarea name="message" id="comments-form-message" cols="" rows="" title="Сообщение" class="required">Сообщение</textarea>
      <!--
                  <div class="input-file">
                    <div class="pick">
                      <div class="browse-link"><i class="i"></i></div>
                      <div class="title">Прикрепить файл (до 1 МБ) <a href="/help/" target="_blank" class="help-link"><img src="/img/reactor/px.gif" alt="" /></a></div>
                      <div class="input"><input name="attach" type="file" /></div>
                    </div>
                    <div class="hidden info">
                      <div class="name"></div>
                      <div class="clear-link"><i class="i"></i></div>
                    </div>
                  </div>
      -->
                  <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
                </div>
              </div>
              <div class="submit">
               '.$submittext.'
           '.$submitB.'
              </div>
            </form>
          </div>
        </div>
      ';
      
      echo json_encode($data);
    }
    
    function addAction() {
      $this->Comments->addComment($_POST);
	}
    function addsiteAction() {
      $this->Comments->addsiteComment($_POST);
    }
    function removeAction() {
      header('Content-type: text/plain; charset=utf-8');
      echo json_encode($this->Comments->removeComment($_POST));
    }    
}


?>