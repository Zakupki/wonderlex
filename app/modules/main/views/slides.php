<!-- slides -->
<ul class="sliderkit-panels">
    <? foreach($this->view->sites as $site) { ?>
    <li class="sliderkit-panel">
        <a href="http://<?=$site['domain'];?>" target="_blank">
            <img src="<?=$site['detail'];?>" />
            <span class="sliderkit-panel-textbox">http://<?=$site['domain'];?></span>
            <span class="name"><span class="nameCont"><span><?=$site['name'];?></span> <img src="http://wonderlex.com<?=$site['flag'];?>"><?=$site['country'];?></span></span>
        </a>
    </li>
    <? } ?>
</ul>
<!-- / slides -->