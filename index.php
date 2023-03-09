<?php include("fonksiyonlar/fonksiyonlar.php"); $sistem=new sistem;
$veri=$sistem->benimsorgum2($db,"select * from garson where durum=1",1)->num_rows;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<script src="dosya/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="dosya/boots.css">
<link rel="stylesheet" type="text/css" href="dosya/stiller.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<title>Restaurant Sipariş Sistemi
	</title>
	<script >
		$(document).ready(function(){
			var deger="<?php echo $veri;?>";

			if(deger==0){
			$('#girismodal').modal({
				backdrop:'static',
				keyboard:false
			})
			$('body').on('hidden.bs.modal','.modal',function(){
				$(this).removeData('bs.modal');
		});

			}
			else{
				$('#girismodal').modal('hide');
			}
			$('#girisbak').click(function(){
				$.ajax({
					type:"POST",
					url: 'islemler.php?islem=kontrol',
					data:$('#garsonform').serialize(),
					success:function(donen_veri){
						$('#garsonform').trigger("reset");
						$('.modalcevap').html(donen_veri);
					},
				})
			

		})
		})
			


	</script>
<style>
	#rows {
		height: 40px;
		background-color: black;
		color: white;
		border-right: darkred;
	}
	#masa{
		height: 140px;
		margin: 10px;
		font-size: 30px;
		border-radius: 10px;
		
	}
	 #boy{
	 	font-size: 14px;
	 	color: black;
	 	background-color: white;
	 }
	#btn1{
		border-radius:50px;
		font-size: 10px;


	}
	#renkk{
		font-size: 20px;
		color:#000000;
	}
	
	#mas a:link,#mas a:visited {
		text-decoration: none;
		background-color: #a04e2b;
	}
	#renk1{
		color:#6b4a2b;
	}
	#btn{
		height: 60px;
		margin: 10px;
		weight:60px;

	}
</style>
</head>
<body>
<div class="container-fluid">
		<div class="row" id="rows">
		<div class="col-md-2 border-right  "><i class="fa fa-cutlery fa-2x" aria-hidden="true"></i> Toplam Sipariş : <a class="text-warning"><?php $sistem->siparistoplam($db);?></a></div>
		<div class="col-md-3 border-right " id="rows"><i class="fa fa-pie-chart fa-2x" aria-hidden="true"></i>Doluluk : <a class="text-warning"><?php $sistem->doluluk($db);?></a></div>
		<div class="col-md-2 border-right" id="rows"><i class="fa fa-table fa-2x" aria-hidden="true"></i> Toplam Masa: <a class="text-warning"><?php $sistem->masatoplam($db);?></a></div>
		<div class="col-md-2 border-right" id="rows"><i class="fa fa-calendar fa-2x" aria-hidden="true"></i> Tarih : <a class="text-warning"><?php echo date('d/m/Y '); ?></a></div>
		<div  class="col-md-3 border-right" id="rows"><i class="fa fa-child fa-2x" aria-hidden="true"></i> Aktif Garson: <a class="text-warning"><?php $sistem->garsonbak($db);?></a></div>
	    </div>

	    <div class="row">
 <?php  $sistem->masacheck($db); ?></div>
	    <!-- The Modal -->
  <div class="modal fade" id="girismodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header text-center">
          <h4 class="modal-title">Garson Girişi</h4>
          
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        
        
         <form id="garsonform">
         
         <div class="row mx-auto text-center">
         
         
         
         		<div class="col-md-12">Garson Ad</div>
        		 <div class="col-md-12"><select name="ad" class="form-control mt-2">
                  <option value="0">Seç</option>
                  <?php
                  $b=$sistem->benimsorgum2($db,"select * from garson",1);
                  while ($garsonlar=$b->fetch_assoc()):
                 
                 	echo'<option value="'.$garsonlar["ad"].'">'.$garsonlar["ad"].'</option>';
                 endwhile;

                  ?>
              
                </select></div>
        
        		<div class="col-md-12">Şifre </div>         
                <div class="col-md-12">
                <input name="sifre" type="password" class="form-control  mt-2" />                
                </div>  
                 
                
                <div class="col-md-12">
               <input type="button" id="girisbak" value="GİRİŞ" class="btn btn-info mt-4"/>                
                </div>
         
         </div>
         
         
         </form>
        </div>
        
        
         <div class="modalcevap">
          
        </div>
     
        
      </div>
    </div>
  </div>

	
</div>

</body>
</html>