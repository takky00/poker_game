<html>
<head>
<meta charset=utf-8>
<title></title>
</head>
<body>
<h1>ポーカー</h1>
<form name="f1" method="post" action="YK0531porker.php">
<table border=1>



<?php
//関数[CardInit],[CardDisp],[CardYaku]
	function CardInit(){
		global $tcd;
			//52枚の用意
		for ($i=1;$i<=52;$i++){
			$tcd[$i]=$i;
		}
	//トランプのシャッフル
		for($i=1;$i<=52; $i++) {
			$r=mt_rand(1,52);
			$tmp=$tcd[$i];
			$tcd[$i]=$tcd[$r];
			$tcd[$r]=$tmp;
		}
		$filename='cardkey0106.txt';
		$fp=fopen($filename,'w');
		for($i=1;$i<=52;$i++){
			$wr=$tcd[$i]."\n";
			fwrite($fp,$wr);
		}
		fclose($fp);
	}
	//p1には1か2が入る　1の時自分　2の時相手
	//ループ1の場合は1から5　2の場合は6から10
	
	function CardDisp($p1){
		global $tcd;
		global $CardNo;
		global $mark;
		$CardNo=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		$mark=array(0,0,0,0,0);
		print("<tr>");
		
		if ($p1==2){
			$st=6;
			$en=10;
		}
		elseif($p1==1){
			$st=1;
			$en=5;
			
		}
		for($i=$st;$i<=$en;$i++){
		//print($tcd[$i]."<br>");
			if ($tcd[$i]<=13){
				$wnum=$tcd[$i];
				$CardNo[$wnum]=$CardNo[$wnum]+1;
				$mark[1]=$mark[1]+1;
				print("<td><img src=\"./card/card_s".$wnum.".png\" width=120></td>");	
		//		print("スペード".$wnum."<br>");
				}
			elseif (($tcd[$i]>13)&&($tcd[$i]<=26)){
				$wnum=$tcd[$i]-13;
    			$CardNo[$wnum]=$CardNo[$wnum]+1;
				$mark[2]=$mark[2]+1;
				print("<td><img src=\"./card/card_c".$wnum.".png\" width=120></td>");
			
				//print("クラブ".$wnum."<br>");
			}
			elseif (($tcd[$i]>26)&&($tcd[$i]<=39)){
				$wnum=$tcd[$i]-26;
				$CardNo[$wnum]=$CardNo[$wnum]+1;
				$mark[3]=$mark[3]+1;
				print("<td><img src=\"./card/card_h".$wnum.".png\" width=120</td>");
			//	print("ハート".$wnum."<br>");
			}
			elseif (($tcd[$i]>39)&&($tcd[$i]<=52)){
				$wnum=$tcd[$i]-39;
				$CardNo[$wnum]=$CardNo[$wnum]+1;
				$mark[4]=$mark[4]+1;
				print("<td><img src=\"./card/card_d".$wnum.".png\" width=120></td>");
				//print("ダイヤ".$wnum."<br>");
			}
		}	
		print("</tr>");	

	}
	function CardYaku(){
		global $CardNo;
		global $mark;
		global $YakuDisp;
//ワンペア　ツーペア
		for($i=1;$i<=14;$i++){
			if($CardNo[$i]==2){
				$yaku=$yaku+1;
			}
//スリーカード
			elseif($CardNo[$i]==3){
				$yaku=3;
			}
//フォーカード
			elseif($CardNo[$i]==4){
				$yaku=7;
			}
//フルハウス
			elseif(($CardNo[$i]==3)&&($CardNo[$i]==2)){
				$yaku=4;
			}	
		}

	
//ストレート
		for($i=1;$i<=14;$i++){
			if((((($CardNo[$i]==1)&&($CardNo[$i+1]==1)&&($CardNo[$i+2]==1)&&($CardNo[$i+3]==1)&&($CardNo[$i+4]==1))))){
				$yaku=6;
			}
//ストレート2
			elseif((((($CardNo[10]==1)&&($CardNo[11]==1)&&($CardNo[12]==1)&&($CardNo[13]==1)&&($CardNo[1]==1))))){
				$yaku=8;
			}

		}
//フラッシュ
		for($i=1;$i<=4;$i++){
			if($mark[$i]==5){
				if ($yaku==6){
					$yaku=9;
				}
				elseif($yaku==8){
					$yaku=10;
				}
				else{
					$yaku=5;
				}
			}
		}
		if($yaku==0){
			$YakuDisp="ブタ";
		}	
		elseif($yaku==1){
			$YakuDisp="ワンペア";
		}

		elseif($yaku==2){
			$YakuDisp="ツーペア";
		}
	
		elseif($yaku==3){	
			$YakuDisp="スリーカード";
		}
	
		elseif($yaku==4){	
			$YakuDisp="フルハウス";
		}
		
		elseif($yaku==5){	
			$YakuDisp="フラッシュ";
		}

		elseif($yaku==6){	
			$YakuDisp="ストレート";
		}

		elseif($yaku==7){	
			$YakuDisp="フォーカード";
		}

		elseif($yaku==8){	
			$YakuDisp="ストレート";
		}
	
		elseif($yaku==9){	
			$YakuDisp="ストレートフラッシュ";
		}
		elseif($yaku==10){	
			$YakuDisp="ロイヤルストレートフラッシュ";
		}
		
	}
	

//$p1に直接（値）を渡せる
	CardInit();	
	CardDisp(2);
	CardYaku();
	print("<tr><td colspan=5>　　</td></tr>");	
	print("<tr><td colspan=5>".$YakuDisp."</td></tr>");
	
//phpの中で行を変える	
//colspan=列の統合
	CardDisp(1);
?>

<?php
	CardYaku();			

	print("<tr><td></td><td></td><td></td><td></td><td></td></tr>");	
	print("<tr><td colspan=5>".$YakuDisp."</td></tr>");
	
//phpの中で行を変える	
//colspan=列の統合

?>
<form name="f1" method="post" action="./YK0531porker.php">
<input type="submit" name="sub" value="変更">
</table>
<hr>

	 



		



</body>
</html>
