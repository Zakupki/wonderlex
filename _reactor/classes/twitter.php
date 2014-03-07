<?
require_once 'modules/main/models/Social.php';
Class Twitter {
	
	public function disconnect($id){
		$db=db::init();
		$db->exec('delete from z_social_account where id='.tools::int($id).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
	}
}
?>