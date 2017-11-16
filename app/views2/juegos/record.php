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
			foreach ($matriz as $key => $value) {
				$ma1=explode( "+",$value);
				$ma2=explode( "-",$ma1[1]);
				//print_r($ma2[0]);
				$ma3=explode( "-",$ma2[1]);
				if ($ma1[0]==$ma2[0]) {
					$cant++;
				}
				
				$suma = ($suma==0) ? (strtotime($ma3[0])) : $suma+strtotime($ma3[0]) ; 

				//$ma4=date_format(date_create($ma3[0]), 'H:i:s');
				
				//$suma =  strtotime($ma3[0]);
				//echo '<br/>';
				
	

				
				//isasaga. benotto
				//print_r($ma2[0]); //->respuestas


					
			} 
			echo '<h3>Respuestas acertadas: '.$cant.'<br/></h3>';
			echo "<h3>Tu tiempo: ".date("i:s", $suma). "seg<br />"; //H:i:s//01:57:48
			echo "<h3>Tu juego: <br /></h3>"; //H:i:s//01:57:48
	
			/*echo $c1.'<br/>';
			echo $c2.'<br/>';
			echo $c3.'<br/>';
			echo $c3.'<br/>';*/
			//echo $this->session->userdata('i'.$c1);
			
			echo '<div class="col-xs-4 col-sm-4 col-md-4 resultadoimagen"><img src="'.base_url().$this->session->userdata("i".$c1).'" ></div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-4 resultadoimagen"><img src="'.base_url().$this->session->userdata("i".$c2).'" ></div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-4 resultadoimagen"><img src="'.base_url().$this->session->userdata("i".$c3).'" ></div>';

			

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