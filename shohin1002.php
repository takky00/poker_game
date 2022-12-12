<html>
<script type="text/javascript">
<!--
function OdrCalc(pric,p1){
//p1は行	{
	idx=p1*3;
	wvol= document.f1.elements[idx+1].value;
	
	document.f1.elements[idx+2].value=wvol * pric;
	
	wsum=0;
	for(i=0; i<document.f1.elements.length-1; i++)	{
		if(i%3==2)	{
			if(document.f1.elements[i].value !="")	{
				wsum=wsum+parseInt(document.f1.elements[i].value);
			}
		}
	}
	document.f1.s_tx1.value=wsum;
}

-->


</script>


<head> 
<title></title>
</head>
<?php

	$MySQL{'HOST'}='mysql471.db.sakura.ne.jp';
	$MySQL{'USER'}='qa-link';
	$MySQL{'PASSWORD'}='designxlink4649';
	$MySQL{'DATABASE'}='qa-link_d04595brdb1';
	$dbh=@mysql_connect($MySQL{'HOST'},$MySQL{'USER'},$MySQL{'PASSWORD'});
	if(!$dbh){
		echo "MESSAGE : cannot connect!<BR>";
		exit;
	}
	else{
		mysql_select_db($MySQL{'DATABASE'},$dbh);

		$wsql="select * from shohinYK order by hinno"; //echo $wsql;
		$selectResult=mysql_query($wsql); $i=0; //echo $wsql;
		while($selectData=mysql_fetch_array($selectResult,MYSQL_ASSOC))    {
			$i++;
		
			$thinno[$i]=$selectData["hinno"];
			$thinnm[$i]=$selectData["hinnm"];
			$thinpr[$i]=$selectData["pric"];
			$thinph[$i]=$selectData["photo"];
		    $thinnm[$i]=mb_convert_encoding($thinnm[$i],"SJIS","EUC");
		}
		$dcnt=$i; echo $dcnt;
	}
?>
<body>
<h1>注文画面</h1>
<form name="f1" method="post" action="./shohin1002_2.php">
　　

<table border=1>


<tr><th>商品</th><th>画像</th><th>単価</th><th>注文数</th><th>合計</th></tr>

<?php	
	for ($i=1;$i<=$dcnt;$i++)	{	
		print("<tr><td><input type=\"hidden\" name=\"hinno[]\" value=\"".$thinno[$i]."\">".$thinnm[$i]."</td><td><img src=\"./".$thinph[$i]."\" width=100></td><td>".$thinpr[$i]."</td>");
		
		$j=$i-1;
		print("<td><input type=\"text\" name=\"sodr[]\" onblur=\"OdrCalc(".$thinpr[$i].",".$j.")\" size=\"10\"></td>");
	//	print("<td><input type=\"hidden\" name=\"abc[]\" value=\"".$thinpr[$i]."\"></td>");
		print("<td><input type=\"text\" name=\"tx1[]\" size=\"10\"></td></tr>");
		
	}
?>


<tr><td colspan=4 align=right>総合計</td>

<td><input type="text" name="s_tx1" size="10"></td></tr>
</table>
<input type="submit" name="act" value="決定">


</body></form>
</html>
