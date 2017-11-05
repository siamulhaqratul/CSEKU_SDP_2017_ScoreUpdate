<?php include'core/init.php';?>
<?php
if (!Session::exists('id') && !Session::exists('name') )
{
	header('Location: ' . 'login.php');	
}
if(Session::get('role')!='admin')
{
   header('Location: ' . 'index.php');  
}
$id=Session::get('id');
//echo $id;
$sql="SELECT match_id FROM m_atch WHERE adminid=$id";
$result=DB::getConnection()->select($sql);
//var_dump($result);
if(!$result)
{
	header('Location: ' . 'index.php');
}
 class freeAdmin
 {
 	public function free()
 	{
 		//$sql="UPDATE admin SET isActive=0";
 		//$result=DB::getConnection()->update($sql);
 		$sql="UPDATE m_atch SET isActive=0,adminid=NULL,isSelect=0 WHERE isFinished=1";
 		$result=DB::getConnection()->update($sql);
 		header("Location:numbofmatch.php");
 	}
 }
 $fAdmin=new freeAdmin();
 $fAdmin->free();

?>