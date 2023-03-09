<?php include("fonksiyonlar/fonksiyonlar.php"); $masam=new sistem;
@$masaid=$_GET["masaid"];?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

<script src="dosya/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="dosya/boots.css">
<link rel="stylesheet" type="text/css" href="dosya/stiller.css">
<script >
	$(document).ready(function(){
		var id="<?php echo $masaid;?>";
		$("#veri").load("islemler.php?islem=goster&id="+id);
		$('#btn').click(function(){
			$.ajax({
				type:"POST",
				url:'islemler.php?islem=ekle',
				data:$('#formum').serialize(),
				success:function(donen_veri){
					$("#veri").load("islemler.php?islem=goster&id="+id);
					$('#formum').trigger("reset");
					$("#cevap").html(donen_veri).slideUp(1400);;
				},
			})
		})
		$('#urunler a').click(function(){
			var sectionId=$(this).attr('sectionId');
			$("#sonuc").load("islemler.php?islem=urun&katid="+sectionId).fadeIn();
		})
	})
</script>
	<title>Restaurant Sipariş Sistemi
	</title>
<style>
	
</style>
</head>
<body>
<div class="container-fluid">
	<?php 
	
	if ($masaid!=""):
	$son=$masam->masagetir($db,$masaid);
	$dizi=$son->fetch_assoc();
	@$deger=$_GET["deger"];
	switch ($deger) {
		case '1':
			$masam->siparisler($db,$dizi["id"]);
			break;
	}
    endif;

	?>
		
	<div class="row ">
	<div class="col-md-3 "style="background-color:#eff1a6; " id="div2">  
			<div class="row">
				<div class="col-md-12 border-bottom bg-success border-info text-white mx-auto p-4 text-center"id="div3"style="min-height:100px; font-size: 36px"><a href="index.php" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Ana Sayfa</a><br/><?php  echo $dizi["ad"];?>
				
			</div>
				<!--burada anlık siparisler-->
				<div class="col-md-12" id="veri"></div>
				<!--burada anlık siparisler-->
				<div id="cevap"></div>
			</div>		
		
</div>

<div class="col-md-7" >
	

	<div class="row"><form id="formum">
		<div class="col-md-12" id="sonuc" style="min-height:500px;">
			
		</div>
	</div>
	<div class="row " id="div4">
		<div class="col-md-12" >
				<div class="row">
					<div class="col-md-6" >
					<input type="hidden" name="masaid" value="<?php  echo $dizi["id"];?>" />
						<input type="button" id="btn"value="EKLE " class="btn btn-success mt-2" style="height:60px;weight:90px;" /></div>
					<div class="col-md-6">
						<?php 
						for ($i=1; $i<12 ; $i++):

							echo '<label class="btn btn-success m-2"><input type="radio" name="adet" value="'.$i.'"/>'.$i.'</label>';
						endfor;

						?>
					</form>
					
					</div>
				</div>
			
		</div>
	</div>
	<!--<form id="formum">
	<input type="text" name="urunid"/>
	<input type="text" name="adet"/>
	<input type="text" name="masaid" value="" />
	<input type="button" id="btn"value="EKLE"/>
	</form>-->
</div>
<!--KATEGORİLER-->
<div class="col-md-2 "style="background-color: #eff1a6" id="urunler">

	<?php 
	$masam->urungrup($db);?>


</div>
<!--KATEGORİLER-->
</body>
</html>