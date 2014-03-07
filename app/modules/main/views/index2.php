    <div class="content">
        <div class="list">
            <?
            $tcnt=0;
            $cnt=0;
            foreach($this->view->sites as $site) { ?>
                <div class="li">
                    <a href="http://<?=$site['domain'];?>" target="_blank">
                        <img src="<?=$site['preview'];?>" alt="" />
                        <span class="name"><?=$site['name'];?><i class="flag" style="background-image: url(<?=$site['flag'];?>);"></i></span>
                        <i class="frame"></i>
                    </a>
                </div>
                <?
                $cnt++;
                $tcnt++;
                if($cnt==4 && $tcnt<count($this->view->sites)){
                    $cnt=0;
                    echo '<div class="br"></div>';
                }
            }?>



        </div>
    </div>
