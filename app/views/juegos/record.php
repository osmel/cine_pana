<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>



<div class="container intro">

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="text-center">MI MARCADOR</h2>
		</div>
	</div>

	<div class="">								
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 mimarcador transparenciaformularios">
			<?php 	
			/*
			echo $nombre.'<br/>';
			echo $Apellidos.'<br/>'; 
			echo $email.'<br/>';
			echo $contrasena.'<br/>';
			*/

			//echo $tarjeta.'<br/>'; 
			$matriz = explode( ";",substr($tarjeta, 0, -1));
			//$matriz = explode( ";",$tarjeta);
			//print_r($matriz[3]."-");die;

			$suma =0;
			$cant=0;
			//$ma5=date_create($ma3[0]);
			foreach ($matriz as $key => $value) { //3+c-0*5|00:00:01;1+a-1*12|00:00:10;2+c-0*8|00:00:0...
				$ma1=explode( "+",$value);   //Array ( [0] => 3 [1] => c-0*5|00:00:01 )  -->fig 1,2,3,4,5
				$ma2=explode( "-",$ma1[1]);   //Array ( [0] => c [1] => 0*5|00:00:01 )   --> resp a, b o c
				$ma3=explode( "*",$ma2[1]);   //Array ( [0] => 0 [1] => 5|00:00:01 )   -->si o no
				$ma4=explode( "|",$ma3[1]);   //Array ( [0] => 5 [1] => 00:00:01 )     --> id_preg
				$ma5=explode( "|",$ma4[1]);
				//print_r($ma5);die;
				
				//if ($ma1[0]==$ma2[0]) {
				if ($ma3[0]==1) {
					$cant++;
				}
				
				$suma = ($suma==0) ? (strtotime($ma5[0])) : $suma+strtotime($ma5[0]) ; 

				//$ma4=date_format(date_create($ma3[0]), 'H:i:s');
				
				//$suma =  strtotime($ma3[0]);
				//echo '<br/>';
				
	

				
				//isasaga. benotto
				//print_r($ma2[0]); //->respuestas


					
			} 
			echo '<div class="col-md-6"><span class="textosmarcador">ACIERTOS:</span></div><div class="col-md-6"><span class="marcadorconte">'.$cant.'</span></div>';
			echo "<div class='col-md-6'><span class='textosmarcador'>TIEMPO: </span></div><div class='col-md-6'><span class='marcadorconte amarillo'>".date("i:s", $suma). "seg</span></div>"; //H:i:s//01:57:48
			// echo "<h3>Tu juego: <br /></h3>"; 
						
			// echo '<div class="col-xs-4 col-sm-4 col-md-4 resultadoimagen"><img src="'.base_url().$this->session->userdata("i".$c1).'" ></div>';
			// echo '<div class="col-xs-4 col-sm-4 col-md-4 resultadoimagen"><img src="'.base_url().$this->session->userdata("i".$c2).'" ></div>';
			// echo '<div class="col-xs-4 col-sm-4 col-md-4 resultadoimagen"><img src="'.base_url().$this->session->userdata("i".$c3).'" ></div>';

			

			/*
			echo $juego.'<br/>';	
			echo $tiempo_juego.'<br/>';
			echo $puntos.'<br/>';
			echo $redes.'<br/>';
			*/
			?>

		</div>
	</div>	

</div>


<?php $this->load->view( 'footer' ); ?>