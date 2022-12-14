<html>
<meta charset="SJIS">
<head>
<title>注文確認</title>
</head>
<?php
//database接続は先
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
	//新たな注文番号を決める
		$wodrno=1;
		$wsql="select * from TestOdrYK order by odrno desc";
		$selectResult=mysql_query($wsql); //echo $wsql;
		$selectData=mysql_fetch_array($selectResult,MYSQL_ASSOC);//databaseから一件取り出しselectDataの配列に入れる
		if($selectData)	{
			$wodrno=$selectData["odrno"]+1;
		}

		$hinno=$_REQUEST["hinno"];//商品no
		$sodr=$_REQUEST["sodr"]; //数量
		//$tx1=$REQUEST["pric"]; //単価
		$tpric=$_REQUEST["tx1"]; //合計金額
		$wdt=date("Y/m/d",time());
		$wtm=date("H/i/s",time());
		$wwdt=$wdt." ".$wtm;

		for ($i=0; $i<count($sodr); $i++)	{
			if($sodr[$i]!=0){
				$wsql="insert into TestOdrYK values(".$wodrno.",'".$wwdt."',".$hinno[$i].",".$sodr[$i].",0,".$tpric[$i].")";
				mysql_query($wsql); echo $wsql;
			}
		}
		$wsql="select * from TestOdrYK where (odrno=".$wodrno.") order by hinno";
		$selectResult=mysql_query($wsql); $i=0; //echo $wsql;
		while ($selectData=mysql_fetch_array($selectResult,MYSQL_ASSOC))	{
			$i++;
			$thinno[$i]=$selectData["hinno"]; 
			$thinvol[$i]=$selectData["hinvol"];
			$ttpric[$i]=$selectData["pric"];
			$tamt[$i]=$selectData["amt"];
			
		}
		$dmax=$i;
		echo $dmax;

		for ($i=1; $i<=$dmax; $i++){
			$wsql="select * from shohinYK where (hinno=".$thinno[$i].")";
			$selectResult=mysql_query($wsql); //echo $wsql;
			$selectData=mysql_fetch_array($selectResult,MYSQL_ASSOC);
			if($selectData)	{
				$thinnm[$i]=$selectData["hinnm"];
				$tttpric[$i]=$selectData["pric"];
				$thinnm[$i]= mb_convert_encoding($thinnm[$i],"SJIS","EUC");
			}
		}
	}
?>
<body>
<h3>完了画面</h3>
<form name="f1" method="post" action="./shohin1002_3.php">
<table border=1>

<hr>
<tr><th>注文No</th><th>注文日時</th><th>商品名</th><th>数量</th><th>単価</th><th>金額</th></tr>
<?php
	for ($i=1; $i<=$dmax; $i++)		{
		if ($i%2)	{
			print("<tr style=\"background-color: #bce0f2\">");
		}
		else	{
		print("<tr>");
		}
		print("<td>".$wodrno."</td><td>".$wwdt."</td><td>".$thinnm[$i]."</td><td>".$thinvol[$i]."</td><td>".$tttpric[$i]."</td><td>".$tamt[$i]."</td></tr>");
		$topr[0]+=$tamt[$i];
	}
	
	
	print("<tr><td colspan=4 align=right></td><td>総合計:</td><td>".$topr[0]."</td></tr>");


	print("<tr><td>お名前:</td><td colspan=5 align=right><input type=\"text\" name=\"s_tx1\" size=\"25\"></td></tr>");
	print("<tr><td>メールアドレス:</td><td colspan=5 align=right><input type=\"text\" name=\"s_tx2\" size=\"25\"></td></tr>");
?>
<hr>

<?php
	print("<input type=\"hidden\" name=\"odrno\" value=\"".$wodrno."\">");
?>
<td><input type="submit" name="act1" value="戻る"></td>
<td><input type="submit" name="act2" value="決定"></td>
</table>
</form>
</body>
</html>