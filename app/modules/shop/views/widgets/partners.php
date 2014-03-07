<?
  if ($this->view->partnerlist) {
?>
  <div class="partners">
    <table class="jreel">
    <tr>
      <?
        if (count($this->view->partnerlist)<3) {
      ?>
          <td class="jreel-gap"><i></i></td>
      <?
        }
      ?>
      <?
        $cnt=1;
        foreach($this->view->partnerlist as $partner) {
      ?>
          <td class="jreel-frame"><a href="<?=$partner['link'];?>" target="_blank"><img src="<?=$partner['url'];?>" alt="" /></a></td>
      <?
          if (count($this->view->partnerlist)>$cnt) {
      ?>
            <td class="jreel-gap"><i></i></td>
      <?
          }
          $cnt++;
        }
      ?>
      <?
        if (count($this->view->partnerlist)<3) {
      ?>
          <td class="jreel-gap"><i></i></td>
      <?
        }
      ?>
    </tr>
    </table>
  </div>
<?
  }
?>
