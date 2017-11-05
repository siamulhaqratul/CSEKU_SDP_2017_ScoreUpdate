<?php include'core/init.php'?>
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
class selectedAdmin
{
	private $adminid;

	public function isAdminIsSelected()
	{
		$this->adminid=Session::get('id');
		$sql="SELECT isSelect FROM m_atch WHERE adminid=$this->adminid AND isSelect=1";
		$result=DB::getConnection()->select($sql);
		if($result)
		{
		   header("Location:gameposition.php");
          // header("Location:selectopenningbatsman.php");
		}
		else
		{
			echo "<script>alert('You are not selected for any match');
			window.location = 'index.php';</script>";
			//header('Location:index.php');
		}
	}
}
$admin=new selectedAdmin();
$admin->isAdminIsSelected();
?>