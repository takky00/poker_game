<html>
<meta charset="SJIS">
<head>
<title>�����m�F</title>
</head>
<?php







//database�ڑ��͐�
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
	

		$wodrno=$_REQUEST["odrno"];//�`�[no���p��
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
		$subject="���������肪�Ƃ��������܂�";
		$content=$yourname."�l"."\n";
		$content=$content."���������肪�Ƃ��������܂���"."\n\n";
		$content=$content."-----------------------------"."\n";
		$content=$content."   ".$thinnm[1]."  �P�� ".$tttpric[1]."�~  ".$thinvol[1]."�� ".$tamt[1]."�~ "."\n";
//���i���@�P���@���@���z�o��		
		$headers="From:hiroabe.ops@gmail.com";

		$rtn=mb_send_mail($mailto, $subject, $content, $headers);//(���M��A�薼�A���e)headers=�����(�T�[�o�[�ɂ���Ă͓K���ȃ��A�h���w��ł��Ȃ�)
		//mb_send_mail�̓T�[�o�[�Ŏ��ɕς��
		if (!$rtn)	{
			die("���[�����M�s��");
		}
	}

?>
<body>
<h1>�������</h1>
<form name="f1" method="post" action="./shohin1002_3.php">
<table border=1>

<hr>
�����m�F���[���𑗐M���܂����̂ł��m���߂��������B

<hr>


<td><input type="submit" name="act1" value="�߂�"></td>
<td><input type="submit" name="act2" value="����"></td>
</table>
</body>
</html>