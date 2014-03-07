<div class="h1">
  <h1><?=$this->registry->currentpage;?></h1>
  <div class="search">
    <form action="" method="get">
      <label for="search-q" class="placeholder"><?=$this->view->translate['search'];?></label>
      <input name="q"<?=($_GET['q'])?' value="'.$_GET['q'].'"':'';?> id="search-q" type="text" />
      <button type="submit"><i class="i"></i></button>
    </form>
  </div>
  <div class="add button-small button"><div class="bg"><div class="r"><div class="l"><a href="/admin/product/" class="el"><?=$this->view->translate['add'];?> работу<i class="i"></i></a></div></div></div></div>
</div>

<form action="/admin/updatecatalog/" method="post">
  <div class="catalog form">
    <div class="table">
      <div class="thead">
        <div class="title"><div class="text"><?=$this->view->translate['title'];?></div></div>
        <div class="category"><div class="text"><?=$this->view->translate['categoryname'];?></div></div>
        <div class="price"><div class="text"><?=$this->view->translate['price'];?></div></div>
        <div class="date"><div class="text"><?=$this->view->translate['datecreate'];?></div></div>
      </div>
      <div class="sortable tbody">
        <?
          $cnt=0;
          $classArr=array(0=>' first', count($this->view->products)-1=>' last');
          foreach ($this->view->products as $product) {
        ?>
            <div class="tr sample <?=$classArr[$cnt];?>">
              <input name="itemid[<?=$cnt;?>]" value="<?=$product['itemid'];?>" type="hidden" />
              <div class="title"><div class="text"><a href="/admin/product/<?=$product['itemid'];?>/"><img src="/img/shopadmin/px.gif" alt="" class="featured" /><?=$product['name'];?><i class="image" style="background-image: url(<?=$product['url'];?>);"></i></a></div></div>
              <div class="category"><div class="text"><?=$product['categoryname'];?></div></div>
              <div class="price"><div class="text"><?=$product['price'];?> usd</div></div>
              <div class="date"><div class="text"><?=$product['date_create'];?> </div></div>
              <div class="edit"><a href="/admin/product/<?=$product['itemid'];?>/"><i title="Редактировать" class="i"></i></a></div>
              <div class="remove">
                <input name="remove[<?=$cnt;?>][<?=$product['itemid'];?>]" value="0" type="hidden" />
                <i class="i" title="Удалить"></i>
              </div>
              <div class="state<?=($product['active'])?'':' disabled';?>">
                <input name="state[<?=$cnt;?>][<?=$product['itemid'];?>]" value="1" type="hidden" />
                <i class="disable" title="Скрыть"></i>
                <i class="enable" title="Отобразить"></i>
              </div>
              <div class="handle"></div>
            </div>
        <?
            $cnt++;
          }
        ?>
      </div>
      <div class="trash"></div>
    </div>
    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>
</form>

<!--SEO-->
<? if($this->view->categoryid>0){?>
<form action="/admin/updatecatalogmeta/" method="post">

  <div class="h1">
    <h1>Meta</h1>
  </div>
  
  <div class="catalog-edit form">
    <input name="apply" value="0" type="hidden" />
    <input name="categoryid" value="<?=$this->view->categoryid;?>" type="hidden" />
    <div class="field">
      <div class="label"><label for="catalog-title1">Meta title</label></div>
      <div class="input-text">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->categorymenta as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->categorymenta as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><input name="seotitle[<?=$lang['languageid'];?>]" id="catalog-seotitle<?=$lang['languageid'];?>" value="<?=$lang['seotitle'];?>" type="text"/></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>

    <div class="field">
      <div class="label"><label for="account-seodescription">Meta Description</label></div>
      <div class="textarea">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->categorymenta as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->categorymenta as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><textarea name="seodescription[<?=$lang['languageid'];?>]" id="account-seodescription<?=$lang['id'];?>" rows="" cols=""><?=$lang['seodescription'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="label"><label for="account-seodescription">Seo текст внизу страницы</label></div>
      <div class="textarea">
        <div class="multiling">
          <div class="multiling-select">
            <select>
              <? foreach($this->view->categorymenta as $lang) { ?>
                <option><?=$lang['languagename'];?></option>
              <? } ?>
            </select>
          </div>
          <?
            $cnt=0;
            foreach($this->view->categorymenta as $lang) {
          ?>
              <div class="multiling-item<?=($cnt)?'':' multiling-current'?>"><textarea name="seotext[<?=$lang['languageid'];?>]" id="account-seotext<?=$lang['id'];?>" rows="" cols=""><?=$lang['seotext'];?></textarea></div>
          <?
              $cnt++;
            }
          ?>
        </div>
      </div>
    </div>
    

    <div class="submit">
      <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit"><?=$this->view->translate['save'];?></button></div></div></div></div>
    </div>
  </div>

</form>
<?}?>