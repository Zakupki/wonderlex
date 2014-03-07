<?
require_once 'modules/base/models/Basemodel.php';

Class Menu Extends Basemodel {

	public $registry;
	private $no_cache;
	
	public function __construct($registry){
		//parent::__construct($registry);
		$this->registry=$registry;
	}
public function getPageName($menutypeid){
	$db=db::init();
	$result=$db->queryFetchAllFirst('SELECT NAME FROM z_menu WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND languageid='.tools::int($_SESSION['langid']).' AND menutypeid='.tools::int($menutypeid).'');
	if($result[0])
	return $result[0];
}

public function getMenuItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				z_menu.name,
				z_menutype.code,
				z_menu.seotitle,
				z_menu.seodescription,
				z_menu.seotext
				FROM 
				_items
				INNER JOIN z_menu
				ON z_menu.itemid=_items.id AND z_menu.languageid='.tools::int($_SESSION['langid']).'
				INNER JOIN z_menutype
				ON z_menutype.id=z_menu.menutypeid
				WHERE _items.siteid='.tools::int($_SESSION['Site']['id']).' AND _items.datatypeid=1 AND z_menu.active=1 
				ORDER BY z_menu.sort ASC
				');
				 foreach($result as $menu) {
				 if ($this->registry->controller==$menu['code'] || $this->registry->action==$menu['code']){
    				 $this->registry->currentpage=$menu['name'];
                     $this->registry->currentseotitle=$menu['seotitle'];
                     $this->registry->currentseodescription=$menu['seodescription'];
                     $this->registry->currentseotext=$menu['seotext'];
                 }
				 $wigetmenu[$menu['code']]=$menu['name'];
				 }
				 $this->registry->wigetmenu=$wigetmenu;
	return $result;
}
public function getMenuAllItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				z_menu.name,
				z_menutype.code
				FROM 
				_items
				INNER JOIN z_menu
				ON z_menu.itemid=_items.id AND z_menu.languageid='.tools::int($_SESSION['langid']).'
				INNER JOIN z_menutype
				ON z_menutype.id=z_menu.menutypeid
				WHERE _items.siteid='.tools::int($_SESSION['Site']['id']).' AND _items.datatypeid=1 
				ORDER BY z_menu.sort ASC
				');
				$addArr=array('catalog'=>'product','blogs'=>'blog','events'=>'event','services'=>'service');
				foreach($result as $menu){
					if(array_key_exists($menu['code'],$addArr))
					$addArr2[$addArr[$menu['code']]]=$menu['name'];
					
					if ($this->registry->action==$menu['code'] || substr($menu['code'],0,-1)==$this->registry->action){
					$this->registry->currentpage=$menu['name'];
					}
					if($menu['code']=='catalog' &&  $this->registry->action=='product')
					$this->registry->currentpage=$menu['name'];
				}
				$this->registry->addtomenu=$addArr2;
	return $result;
}
public function getAdminMenuItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_menu.id,
				  z_menu.itemid,
				  z_menu.name,
				  z_menu.active,
				  z_menu.sort,
				  z_menu.languageid,
				  z_menu.menutypeid,
				  z_menutype.code,
				  z_menutype.name AS menutypename 
				FROM
				  z_menu 
				  INNER JOIN
				  z_menutype 
				  ON z_menutype.id = z_menu.menutypeid 
				WHERE z_menu.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_menu.userid = '.tools::int($_SESSION['User']['id']).'
				');
	foreach($result as $row){
					$menuArr[$row['itemid']]['menu'][$row['languageid']]=$row;
					$menuArr[$row['itemid']]['code']=$row['code'];
					$menuArr[$row['itemid']]['active']=$row['active'];
					$menuArr[$row['itemid']]['sort']=$row['sort'];
					$menuArr[$row['itemid']]['itemid']=$row['itemid'];
					$menuArr[$row['itemid']]['menutypename']=$row['menutypename'];
				}
	usort($menuArr, 'tools::sortAsc');
	return $menuArr;
}
public function updateMenu($data){
	$db=db::init();
	$cnt=0;
	foreach($data['title'] as $itemid=>$items){
		foreach($items as $menuid=>$menu){
			$db->exec('
			UPDATE z_menu 
			SET name="'.tools::str($menu).'",
			sort='.$cnt.',
			active='.tools::int($data['state'][$itemid]).'
			WHERE id='.tools::int($menuid).'
			AND itemid='.tools::int($itemid).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'');
			/*echo ('
			UPDATE z_menu 
			SET name="'.tools::str($menu).'",
			sort='.$cnt.',
			active='.tools::int($data['state'][$itemid]).'
			WHERE id='.tools::int($menuid).'
			AND itemid='.tools::int($itemid).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'');*/
		}
	$cnt++;
	}
}
public function getCategoryItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_category.id,
				  z_category.name,
				  z_category.itemid 
				FROM
				  z_category 
				WHERE z_category.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_category.languageid = '.tools::int($_SESSION['langid']).' 
				  AND z_category.active = 1
				ORDER BY z_category.sort
				');
	return $result;
}
public function getCategoryAllItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_category.id,
				  z_category.name,
				  z_category.itemid 
				FROM
				  z_category 
				WHERE z_category.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_category.languageid = '.tools::int($_SESSION['langid']).' 
				ORDER BY z_category.sort
				');
	return $result;
}
public function getAdminCategoryItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_category.id,
				  z_category.name,
				  z_category.itemid,
				  z_category.languageid,
				  z_category.active,
				  z_category.sort,
				  z_category.code
				FROM
				  z_category 
				WHERE z_category.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_category.userid = '.tools::int($_SESSION['User']['id']).'
				');
	if($result)
	foreach($result as $cat){
		$catItems[$cat['itemid']]['category'][$cat['languageid']]=$cat;
		$catItems[$cat['itemid']]['code']=$cat['code'];
		$catItems[$cat['itemid']]['itemid']=$cat['itemid'];
		$catItems[$cat['itemid']]['active']=$cat['active'];
		$catItems[$cat['itemid']]['sort']=$cat['sort'];
	}
	//tools::print_r($catItems);
	usort($catItems, 'tools::sortAsc');
	return $catItems;
}
public function updateAdminCategoryItems($data){
	$cnt=0;
	foreach($data['itemid'] as $it){
		$itemsortarr[$it]=$cnt;
		$cnt++;
	}
	
	ksort($data['itemid']);
	array_pop($data['itemid']);
	array_pop($data['itemid']);
	
	$cnt=0;
	$db=db::init();
	foreach($data['itemid'] as $key=>$item){
		if($data['remove'][$key][$item]){
			$db->exec('
			DELETE FROM _items
			WHERE id='.tools::int($item).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'');
		}
		else{
			if($item>0){
				foreach($data['title'][$key] as $langid=>$lang){
					foreach($lang as $id=>$title){
						if($id>0){
						$db->exec('
							UPDATE z_category 
							SET code="'.tools::str($data['url'][$key][$item]).'",
							name="'.tools::str($title).'",
							sort='.$itemsortarr[$item].',
							active='.tools::int($data['state'][$key][$item]).'
							WHERE id='.tools::int($id).'
							AND itemid='.tools::int($item).'
							AND siteid='.tools::int($_SESSION['Site']['id']).'
							AND userid='.tools::int($_SESSION['User']['id']).'');
						}else{
							$db->exec('
							INSERT INTO 
							z_category
							(name,code,languageid,itemid,siteid,userid,active,sort)
							VALUES("'.tools::str($title).'","'.tools::str($data['url'][$key][$item]).'",'.tools::int($langid).','.tools::int($item).',
							'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).','.tools::int($data['state'][$key][$item]).','.$itemsortarr[$item].')
							');
							
						}
					}
				}
			}else{
				$db->exec('INSERT INTO _items
				(datatypeid,siteid,userid) VALUES(10,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')
				');
				$incnt=count($itemsortarr);
				$item=$db->lastInsertId();
				foreach($data['title'][$key] as $langid=>$lang){
					foreach($lang as $id=>$title){
						$db->exec('
						INSERT INTO 
						z_category
						(name,code,languageid,itemid,siteid,userid,active,sort)
						VALUES("'.tools::str($title).'","'.tools::str($data['url'][$key][0]).'",'.tools::int($langid).','.tools::int($item).',
						'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).','.tools::int($data['state'][$key][0]).','.tools::int($incnt).')
						');
					}
					$incnt++;
				}
			}
		$cnt++;
		}
	}
}
public function getCurrency(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	z_currency.id,
	z_currency.code 
	from 
	z_currency 
	INNER JOIN z_currency_site
	ON z_currency_site.currencyid=z_currency.id AND z_currency_site.siteid='.tools::int($_SESSION['Site']['id']).'
	where z_currency.active=1');
	foreach($result as $cur)
	$curIdArr[$cur['id']]=$cur['id'];
	//echo $_SESSION['curid'];
	//tools::print_r($curIdArr);
	if(!in_array($_SESSION['curid'],$curIdArr)){
	
	$_SESSION['curid']=self::getMainCurrency();
	setcookie('curid',$_SESSION['curid'], time()+60*60);
	}
	
	if($result)
	return $result;
}
public function getMainCurrency(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
	SELECT currencyid FROM z_currency_site WHERE z_currency_site.`siteid`='.tools::int($_SESSION['Site']['id']).' AND z_currency_site.`major`=1');
	if($result[0])
	return $result[0];
}
public function checkCurrency($curid){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
	SELECT currencyid FROM z_currency_site WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND currencyid='.tools::int($curid).'');
	if($result[0])
	return $result[0];
}

}
?>