<?php
	if(isset($_POST["txt_req"]))
	{
		include("global.php");
		bddmaj($_POST["txt_req"],$pdo);
		//echo $_POST["txt_req"];
	}
?>
<form method="POST" >
	<textarea style="width:100%;height:400px;padding:5px;" name="txt_req" ></textarea>
	<br /><br />
	<input type="submit" value="Valider" />
</form>