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
	

		$wodrno=$_REQUEST["odrno"];//伝票no引継ぎ
		$yourmail=$_REQUEST['s_tx2'];
		$yourname=$_REQUEST['s_tx1'];

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
		
		mb_language("ja");
		mb_internal_encoding("sjis-win");

		$mailto=$yourmail;
		$subject="ご注文ありがとうございます";
		$content=$yourname."様"."\n";
		$content=$content."ご注文ありがとうございました"."\n\n";
		$content=$content."-----------------------------"."\n";
		$content=$content."   ".$thinnm[1]."  単価 ".$tttpric[1]."円  ".$thinvol[1]."個 ".$tamt[1]."円 "."\n";
//商品名　単価　個数　金額出す		
		$headers="From:hiroabe.ops@gmail.com";

		$rtn=mb_send_mail($mailto, $subject, $content, $headers);//(送信先、題名、内容)headers=送り主(サーバーによっては適当なメアドを指定できない)
		//mb_send_mailはサーバーで時に変わる
		if (!$rtn)	{
			die("メール送信不可");
		}
	}

?>
<body>
<h1>完了画面</h1>
<form name="f1" method="post" action="./shohin1002_3.php">
<table border=1>

<hr>
注文確認メールを送信しましたのでお確かめください。

<hr>


<td><input type="submit" name="act1" value="戻る"></td>
<td><input type="submit" name="act2" value="決定"></td>
</table>
</body>
</html>