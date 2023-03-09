

<?php include("fonksiyonlar/fonksiyonlar.php"); 
@$masaid=$_GET["masaid"];?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

<script src="dosya/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="dosya/boots.css">
<link rel="stylesheet" type="text/css" href="dosya/stiller.css">

<script >
	$(document).ready(function(){
		$('#degistirform').hide();
		$('#birlestirform').hide();
		$('#parcaform').hide();
		$('#btnn').click(function(){
			$.ajax({
				type:"POST",
				url:'islemler.php?islem=hesap',
				data:$('#hesapform').serialize(),
				success:function(donen_veri){
				$('#hesapform').trigger("reset");
				window.location.reload();
			
				},
			})
		});
		
		$('#yakala a').click(function(){
			var sectionId=$(this).attr('sectionId');
			$.post("islemler.php?islem=sil",{"urunid":sectionId},function(post_veri){
				
				window.location.reload();

			})

		})
		$('#parcaHesapAc a').click(function(){
			$('#parcaform').toggle();
		});
		
		$('#degistir a').click(function() { 
			$('#birlestirform').slideUp();
			$('#degistirform').slideDown();
			
		 });
		
		$('#birlestir a').click(function() { 
			$('#degistirform').slideUp();
			$('#birlestirform').slideDown();
			
		 });
		$('#parcabuton').click(function(){
			$.ajax({
				type:"POST",
				url:'islemler.php?islem=parcaHesapOde',
				data:$('#parcaformveri').serialize(),
				success:function(donen_veri){
				$('#parcaformveri').trigger("reset");
				window.location.reload();
			
				},
			})
		});

		$('#degistirbuton').click(function(){
			$.ajax({
				type:"POST",
				url:'islemler.php?islem=masaislem',
				data:$('#degistirformveri').serialize(),
				success:function(donen_veri){
				$('#degistirformveri').trigger("reset");
				window.location.reload();
			
				},
			})
		});
		$('#birlestirbuton').click(function(){
			$.ajax({
				type:"POST",
				url:'islemler.php?islem=masaislem',
				data:$('#birlestirformveri').serialize(),
				success:function(donen_veri){
				$('#birlestirformveri').trigger("reset");
				window.location.reload();
			
				},
			})
		});
		
		
		
	});
		



var popupWindow=null;
function ortasayfa (url,winName,w,h,scroll){
	LeftPosition=(screen.width) ? (screen.width-w)/2:0;
	TopPosition=(screen.height) ? (screen.height-h)/2:0;
	settings='height='+h+',width='+w+',top='+TopPosition+',Left='+LeftPosition+',scrollbars='+scroll+',resizable'
	popupWindow=window.open(url,winName,settings)
}
</script>
	<title>Restaurant Sipariş Sistemi
	</title>
<style>
	
</style>
</head>
<body>
	<?php
function benimsorgum2($vt,$sorgu,$tercih){

	    $a=$sorgu;
		$b=$vt->prepare($a);
		$b->execute();
		if($tercih==1):
		return $c=$b->get_result();
	    endif;}
function degistirgetir($masaid,$db){
		echo '<div class="card border-success m-2" style="max-width:19rem; heigth:40rem;">
		<div class="card-header">Masa Değiştir</div> 
		<div class="card-body text-success">
		<form id="degistirformveri">
			<input type="hidden" name="mevcutmasaid" value="'.$masaid.'" />
			<select name="hedefmasa" class="form-control">';
			
			$masadeg=benimsorgum2($db,"select * from masalar where durum=0",1);
			while($son=$masadeg->fetch_assoc()):
				if($masaid!=$son["id"]):
				echo'<option value="'.$son["id"].'">'.$son["ad"].'</option>';
				endif;
			endwhile;


			echo'</select> <input type="button" id="degistirbuton"value="DEĞİŞTİR"  class="btn btn-success btn-block mt-2"/></form></div';
				}
function birlestirgetir($masaid,$db){
		echo '<div class="card border-success m-2" style="max-width:19rem; heigth:40rem;">
		<div class="card-header">Masa Birleştir</div> 
		<div class="card-body text-success">
		<form id="birlestirformveri">
			<input type="hidden" name="mevcutmasaid" value="'.$masaid.'" />
			<select name="hedefmasa" class="form-control">';
			
			$masadeg=benimsorgum2($db,"select * from masalar where durum=1",1);
			while($son=$masadeg->fetch_assoc()):
				if($masaid!=$son["id"]):
				echo'<option value="'.$son["id"].'">'.$son["ad"].'</option>';
				endif;
			endwhile;


			echo'</select> <input type="button" id="birlestirbuton"value="BİRLEŞTİR"  class="btn btn-success btn-block mt-2 text-center"/></form></div';}
				

				function parcagetir($masaid){
		echo '<div class="card border-success m-2 text-center" style="max-width:19rem; heigth:40rem;">
		<div class="card-header">PARÇA HESAP AL</div> 
		<div class="card-body text-success">
		<form id="parcaformveri">
			<input type="hidden" name="masaid" value="'.$masaid.'" />
			<input type="text" name="tutar" />
			


			 <input type="button" id="parcabuton"value="HESAP AL"  class="btn btn-success btn-block mt-2"/></form></div></div>';}
				
@$islem=$_GET["islem"];
switch ($islem): 
	case "parcaHesapOde":
	$tutar=$_POST["tutar"];
	$masaid=$_POST["masaid"];
	if(!empty($tutar)):
	$verilericek=benimsorgum2($db,"select * from masabakiye where masaid=$masaid",1);
	if($verilericek->num_rows==0):
		benimsorgum2($db,"insert into masabakiye  (masaid,tutar) VALUES($masaid,$tutar)",1);
	else:
		$mevcutdeger=$verilericek->fetch_assoc();
		$sontutar=$mevcutdeger["tutar"]+$tutar;
		benimsorgum2($db,"update masabakiye set tutar=$sontutar where masaid=$masaid",1);

	endif;
	endif;
	break;
	case "masaislem":
	$mevcutmasaid=$_POST["mevcutmasaid"];
	$hedefmasa=$_POST["hedefmasa"];
	benimsorgum2($db,"update anliksiparis set masaid=$hedefmasa where masaid=$mevcutmasaid",1);
	$ekleson2=$db->prepare("update masalar set durum=0 where id=$mevcutmasaid");
	$ekleson2->execute();

	//_-----------
	$ekleson2=$db->prepare("update masalar set durum=1 where id=$hedefmasa");
	$ekleson2->execute();
	break;
	case"hesap":
	if(!$_POST):
			echo "Posttan gelmiyorsun";
		else:
		$masaid=htmlspecialchars($_POST["masaid"]);
		$sorgu="select * from  anliksiparis where masaid=$masaid";
		$verilericek=benimsorgum2($db,$sorgu,1);
		while($don=$verilericek->fetch_assoc()):

			$a=$don["masaid"];
			$b=$don["urunid"];
			$c=$don["urunad"];
			$d=$don["urunfiyat"];
			$e=$don["adet"];
			$garsonid=$don["garsonid"];
			$bugun=date("Y-m-d");
			$raporekle="insert into rapor (masaid,garsonid,urunid,urunad,urunfiyat,adet,tarih) VALUES($a,$garsonid,$b,'$c',$d,$e,'$bugun')";
			$raporekle=$db->prepare($raporekle);
			$raporekle->execute();
			endwhile;
		

		//silme islemi yapılacak
		$masaid=htmlspecialchars($_POST["masaid"]);
		$sorgu="delete from  anliksiparis where masaid=$masaid";
		$silme=$db->prepare($sorgu);
		$silme->execute();

		$ekleson2=$db->prepare("update masalar set durum=0 where id=$masaid");
		$ekleson2->execute();

		
		//log kaydı
		$ekleson22=$db->prepare("update masalar set saat=0 , dakika=0 where id=$masaid");
		$ekleson22->execute();
		
		
	endif;
	break;
	case "sil":
		if(!$_POST):
			echo "Posttan gelmiyorsun";
		else:
		//silme islemi yapılacak
		$gelenId=htmlspecialchars($_POST['urunid']);
		$sorgu="delete from  anliksiparis where urunid=$gelenId";
		$silme=$db->prepare($sorgu);
		$silme->execute();
		
	endif;
	break;

	
	
	case "goster":
	$id=htmlspecialchars($_GET["id"]);
		$verilericek=benimsorgum2($db,"select * from masabakiye where masaid=$id",1);
		$a="select * from anliksiparis where masaid=$id";
		$d=benimsorgum2($db,$a,1);
		
		
		if($d->num_rows==0):
			echo '<div class="alert alert-danger mt-4 text-center">Henüz Sipariş Yok</div>';
			$ekleson2=$db->prepare("update masalar set durum=0 where id=$id");
		$ekleson2->execute();

		//log kaydı
		$ekleson2=$db->prepare("update masalar set saat=0 ,dakika=0 where id=$id");
		$ekleson2->execute();
		else:
			echo '<table class="table table-bordered table-striped" >
			<thead>
			<tr class="text-white" style="background-color:#353526; " >

			<th scope="col" id="hop1">Ürün Adı</th>
			<th scope="col" id="hop2">Adet</th>
			<th scope="col" id="hop3">Tutar</th>
			<th scope="col" id="hop4">İşlem</th>
			</tr>
			</thead>
			<tbody>

			';
			$adet=0;
			$sontutar=0;
			while($gelenson=$d->fetch_assoc()):
				$tutar=$gelenson["adet"] * $gelenson["urunfiyat"];
				$adet+=$gelenson["adet"];
				$sontutar+=$tutar;
				$masaid=$gelenson["masaid"];
				echo '<tr>
				<td class="text-center p-2">'.$gelenson["urunad"].'</td>
				<td class="text-center p-2">'.$gelenson["adet"].'</td>
				<td>'.number_format($tutar,2,'.',',').' <i class="fa fa-try" aria-hidden="true"></i></td>
				<td id="yakala"><a class="btn btn-danger mt-2 text-white"sectionId="'.$gelenson["urunid"].'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
				
				</tr>';
			endwhile;
			echo'
			<tr class="bg-dark text-white text-center">
			<td class="font-weight-bold text-white"><b>TOPLAM</td>
			<td class="font-weight-bold text-white">'.$adet.'</td>
			<td colspan="2"class="font-weight-bold text-warning ">';
			if($verilericek->num_rows!=0):
			$masabakiye=$verilericek->fetch_assoc();
			$odenentutar=$masabakiye["tutar"];
			$yenitutar=$sontutar-$odenentutar;
			echo '<p class="text-danger m-0 p-0"><del>'.number_format($sontutar,2,'.',',')." <i class='fa fa-try' aria-hidden='true'></i></del><br>
			<font class='text-warning'>KALAN: ".number_format($yenitutar,2,'.',',')." <i class='fa fa-try' aria-hidden='true'></i></font>
			</p>";

			
		else:
			echo number_format($sontutar,2,'.',',')." <i class='fa fa-try' aria-hidden='true'></i>";

			endif;
			

			echo'</tr>
			</tbody></table>
			
			
            
			<div class="col-md-12">
			<form id="hesapform">


			<input type="hidden" name="masaid" value="'.$masaid.'" />
			<input type="button" id="btnn"value="HESAP AL " style="font-weight:bold; height:40px;width:100%; " aria-hidden="true"class="btn btn-danger btn-block mt-2"  />
			</form>
			<p><a href="fisbastir.php?masaid='.$masaid.'" onclick="ortasayfa(this.href,\'mywindow\',\'350\',\'400\',\'yes\');return false" class="btn btn-dark btn-block mt-2 "style="font-weight:bold; height:40px;width:100%;"><i class="fa fa-print" aria-hidden="true"> FİŞ BASTIR</i></a></p>
			</div>
			</div>';
			echo'<div class="col-md-12">
					<div class="row">
						<div class="col-md-12" id="parcaHesapAc"><a class="btn btn-dark btn-block mt-2" style="height:40px; width:100%;"><i class="fa fa-pie-chart" aria-hidden="true"></i>PARÇA HESAP</i></a></div>
						<div class="row">
					<div class="col-md-12" id="parcaform">';parcagetir($masaid);echo'</div></div>
						</div></div>';
			echo'<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6" id="degistir"><a class="btn btn-warning  btn-block mt-1" style="height:40px;"><i class=" fa fa-exchange mt-1">Masa Değiştir</i></a></div>
						<div class="col-md-6" id="birlestir"><a class="btn btn-warning btn-block mt-1" style="height:40px;"><i class="fa fa-bars mt-1">Masa Birleştir</i></a></div>
						</div> 
						


				<div class="row">
					<div class="col-md-12" id="birlestirform">';birlestirgetir($id,$db);echo'</div></div></div></div>
				<div class="row">
					<div class="col-md-12" id="degistirform">';degistirgetir($id,$db); echo'</div>
		</div>';
		
		endif;

		break;
	
	case "ekle":
	$eskiid=$masaid;
	if($_POST):
		@$masaid=htmlspecialchars($_POST["masaid"]);
		@$urunid=htmlspecialchars($_POST["urunid"]);
		@$adet=htmlspecialchars($_POST["adet"]);
		
		if($masaid==""||$urunid==""||$adet==""):
			echo 'Boş alan bırakmamalısın';

		
		else:
			$varmi="select * from anliksiparis where  urunid=$urunid && masaid=$masaid";
			$var=benimsorgum2($db,$varmi,1);
			if($var->num_rows!=0 ):
				$urundizi=$var->fetch_assoc();
				$sonadet=$adet+$urundizi["adet"];
				$islemid=$urundizi["id"];
				$guncel="UPDATE anliksiparis set adet=$sonadet where id=$islemid";
				$guncelson=$db->prepare($guncel);
				$guncelson->execute();
				echo '<div class="alert alert-success mt-4 text-center">ADET GÜNCELLENDİ</div>';
				$saat=date("H");
			$dakika=date("i");
			//log kaydı
			$ekleson2=$db->prepare("update masalar set saat=$saat , dakika=$dakika where id=$masaid");
			$ekleson2->execute();



			else:
				$a="select * from urunler where id=$urunid";
				$d=benimsorgum2($db,$a,1);
				$son=$d->fetch_assoc();
				$urunad=$son["ad"];
				$urunfiyat=$son["fiyat"];
				//------------
				$gelen=benimsorgum2($db,"select * from garson where durum=1",1)->fetch_assoc();
				$garsonidyaz=$gelen["id"];

			$ekle="insert into anliksiparis (masaid,garsonid,urunid,urunad,urunfiyat,adet) VALUES ($masaid,$garsonidyaz,$urunid,'$urunad',$urunfiyat,$adet)";
		$ekleson=$db->prepare($ekle);
		$ekleson->execute();

		//------------------------------------Güncelleme yapılacak

		$ekleson2=$db->prepare("update masalar set durum=1 where id=$masaid");
		$ekleson2->execute();
		$saat=date("H");
		$dakika=date("i");
		//log kaydı
		$ekleson2=$db->prepare("update masalar set saat=$saat ,dakika=$dakika where id=$masaid");
		$ekleson2->execute();

		echo '<div class="alert alert-success mt-4 text-center">EKLENDİ</div>';
			endif;
				
		endif;
			else:
		echo '<div class="alert alert-danger mt-4 text-center">HATA VAR</div>';
	endif;
		break;
	case "urun":
		$katid=htmlspecialchars($_GET["katid"]);

		$a="select * from urunler where katid=$katid";
		$d=benimsorgum2($db,$a,1);
		
		while ($sonuc=$d->fetch_assoc()):
			echo '<label class=" btn btn-warning m-3" id="foto">
			<input name="urunid" type="radio"  value="'.$sonuc["id"].'"/>'.$sonuc["ad"].'</label>';
			
			
			endwhile;
				break;
	case "kontrol":
				$ad=htmlspecialchars($_POST["ad"]);
				$sifre=htmlspecialchars($_POST["sifre"]);
			if(@$ad!="" && @$sifre!=""):
					$var=benimsorgum2($db,"select * from garson where ad='$ad' and sifre='$sifre'",1);
				if ($var->num_rows==0):
					echo'<div class="alert alert-danger text-center">Bilgiler Uyuşmuyor</div>';
				else:
					$garson=$var->fetch_assoc();
					$garsonid=$garson["id"];
					benimsorgum2($db,"update garson set durum=1 where id=$garsonid",1);
					?>
					<script >
						window.location.reload();
					</script>

					<?php
				endif;
			else:
					echo'<div class="alert alert-danger text-center">Boş alan bırakma</div>';
			endif;
		break;
	case "cikis":
	benimsorgum2($db,"update garson set durum=0",1);
	header("Location:index.php");				
   endswitch;


?>
</body>
</html>