<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>



<div class="container mecanica">
<br><br><br>
<div class="col-md-12 text-center">
    <h1>Gira cada una de las cartas y responde correctamente en el menor tiempo posible</h1>
</div>
<br><br><br><br>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card1"> 
	  <div class="front"> 
        <?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'1+')>=1) ? '' : 'data-target="#lightbox"'; 
            $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'1+')>=1) ? 'card11.png' : 'card1.png';
        ?>
	  	<a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
    	   <img src="<?php echo base_url()?>img/card11.png">
	  </div> 
	</div>		
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card2"> 
	  <div class="front"> 
	  	        <?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'2+')>=1) ? '' : 'data-target="#lightbox2"'; 
                $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'2+')>=1) ? 'card22.png' : 'card2.png';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/card22.png">
	  </div> 
	</div>		
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card3"> 
	  <div class="front">
	  	<?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'3+')>=1) ? '' : 'data-target="#lightbox3"'; 
        $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'3+')>=1) ? 'card33.png' : 'card3.png';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/card33.png">
	  </div> 
	</div>		
</div>

<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
	<div id="card4"> 
	  <div class="front"> 
	  	<?php $destino =  ( substr_count($this->session->userdata('tarjeta_participante'),'4+')>=1) ? '' : 'data-target="#lightbox4"'; 
        $imagen = ( substr_count($this->session->userdata('tarjeta_participante'),'4+')>=1) ? 'card44.png' : 'card4.png';
        ?>
        <a href="#" class="" data-toggle="modal" <?php echo $destino; ?> >
	    	<img src="<?php echo base_url()?>img/<?php echo $imagen; ?>">
	    </a>
	  </div> 
	  <div class="back">
	    <img src="<?php echo base_url()?>img/card44.png">
	  </div> 
	</div>		
</div>



<!--imagen 1 -->
<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
        		Verdadera Identidad de CYBORG
        	</span>
        	<ul class="listapop">
        		<li>A) Victor stone</li>
        		<li>B) Barry Allen</li>
        		<li>C) Bruce Wayne</li>
        	</ul>
        	<div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="1" resp="1"><img src="<?php echo base_url()?>img/btn1.png"></button>
        	</div>
        	<div class="col-md-4 text-center">
        		<button class="btn_respuesta" fig="1" resp="2"><img src="<?php echo base_url()?>img/btn2.png"></button>
        	</div>
        	<div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="1" resp="3"><img src="<?php echo base_url()?>img/btn3.png"></button>
        	</div>
        	<div class="col-md-12 text-center">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-md-5">
        	<img src="<?php echo base_url()?>img/card11.png" class="cartelm">
        </div>

    </div> 
</div>

<div id="lightbox2" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
        		¿En que complejo CINEMEX se encuentra la réplica de la mujer maravilla?
        	</span>
        	<ul class="listapop">
        		<li>A) CINEMEX&#174; PARQUE DELTA</li>
        		<li>B) CINEMEX&#174; WTC</li>
        		<li>C) CINEMEX&#174; ARAGÓN</li>
        	</ul>
        	
            <div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="2" resp="1"><img src="<?php echo base_url()?>img/btn1.png"></button>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="2" resp="2"><img src="<?php echo base_url()?>img/btn2.png"></button>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="2" resp="3"><img src="<?php echo base_url()?>img/btn3.png"></button>
            </div>

        	<div class="col-md-12 text-center">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-md-5">
        	<img src="<?php echo base_url()?>img/card22.png" class="cartelm">
        </div>

    </div> 
</div>

<div id="lightbox3" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
        		Nombre del actor que interpreta a Flash
        	</span>
        	<ul class="listapop">
        		<li>A) Jason Momoa</li>
        		<li>B) Ezra Miller</li>
        		<li>C) Henry Cavill</li>
        	</ul>

            <div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="3" resp="1"><img src="<?php echo base_url()?>img/btn1.png"></button>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="3" resp="2"><img src="<?php echo base_url()?>img/btn2.png"></button>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn_respuesta" fig="3" resp="3"><img src="<?php echo base_url()?>img/btn3.png"></button>
            </div>

        	<div class="col-md-12 text-center">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-md-5">
        	<img src="<?php echo base_url()?>img/card33.png" class="cartelm">
        </div>

    </div> 
</div>

<div id="lightbox4" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="container preguntas" style="padding:80px">
        <div class="col-sm-7 col-md-7 text-center contenedorpregu">
        	<span class="titulopop">
        		Nombre del Mayordomo de Batman
        	</span>
        	<ul class="listapop">
        		<li>A) Bruce Wayne</li>
        		<li>B) Alfred Pennyworth</li>
        		<li>C) James gordon</li>
        	</ul>
        	
            <div class="col-sm-4 col-md-4 text-center">
                <button class="btn_respuesta" fig="4" resp="1"><img src="<?php echo base_url()?>img/btn1.png"></button>
            </div>
            <div class="col-sm-4 col-md-4 text-center">
                <button class="btn_respuesta" fig="4" resp="2"><img src="<?php echo base_url()?>img/btn2.png"></button>
            </div>
            <div class="col-sm-4 col-md-4 text-center">
                <button class="btn_respuesta" fig="4" resp="3"><img src="<?php echo base_url()?>img/btn3.png"></button>
            </div>

        	<div class="col-md-12 text-center">
	        	<span class="reloj"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="r1"></span></span>
	        </div>
        </div>
        <div class="col-sm-5 col-md-5">
        	<img src="<?php echo base_url()?>img/card44.png" class="cartelm">
        </div>

    </div> 
</div>
</div>
<script>

//https://nnattawat.github.io/flip/
    jQuery(document).ready(function($) {
        //si es la primera vez entonces
        if (!(localStorage.getItem('fondo'))) {
            localStorage.setItem('fondo',  'nada' );
        }
        
        if (!(localStorage.getItem('tiempo_fondo'))) {
            
            localStorage.setItem('tiempo_fondo', '00:00:00' );
            $('span.r1').html(localStorage.getItem('tiempo_fondo'));
        }

        jQuery("#card1,#card2,#card3,#card4").flip({
           trigger: 'manual'
        });
        
        
        jQuery(localStorage.getItem('fondo')).trigger('click');
       
        //cdo de click para abrir fondo
        //alert('aa');
        jQuery('body').on('click','a[data-toggle="modal"]', function (e) {   
            localStorage.setItem('tiempo_fondo', '00:00:00' );
             $('span.r1').html(localStorage.getItem('tiempo_fondo'));
            //$('span.r1').html('00:00:00');
            //alert('aa');
            //console.log("---"+localStorage.getItem('tiempo_fondo'));
            //$('span.r1').html(localStorage.getItem('tiempo_fondo'));
            //localStorage.setItem('tiempo_fondo',  '' );
            localStorage.setItem('fondo', ('#'+$(this).parent().parent().attr('id')+' [data-target="'+$(this).attr('data-target')+'"]'));

            
        });            


        jQuery('body').on('click','#card1 [data-target="#lightbox"]', function (e) {               
          jQuery("#card1").flip(true);          //jQuery("#card").off('flip'); //no flipear
        });
        jQuery('body').on('click','#card2 [data-target="#lightbox2"]', function (e) {       
        
          jQuery('#card2').flip(true);
        });
        jQuery('body').on('click','#card3 [data-target="#lightbox3"]', function (e) {               
          jQuery("#card3").flip(true);
        });
        jQuery('body').on('click','#card4 [data-target="#lightbox4"]', function (e) {               
          jQuery("#card4").flip(true);
        });




        jQuery('body').on('click','.btn_respuesta', function (e) {               
             //jQuery("#card4").flip(true);
             //console.log( $(this).attr('fig') );
             //console.log( $(this).attr('resp') );
             
            jQuery.ajax({ //guardar en la cookie el conteo
                    url : '/respuesta_tarjeta',
                    data : { 
                           figura: $(this).attr('fig'),
                        respuesta: $(this).attr('resp'),
                        tiempo: $('span.r1').html(), //'0:09', //$(this).attr('resp'),
                    },
                    type : 'POST',
                    dataType : 'json',
                    success : function(data) {  
                        //localStorage.setItem('fondo',  'nada' );
                        //localStorage.setItem('tiempo_fondo', '00:00:00');
                        localStorage.clear();

                          window.location.href = '/'+data.redireccion;        
                          //console.log(data);
                          return false;

                    }

            }); 
        });





        var interval = setInterval(function() {
           $('span.r1').html(localStorage.getItem('tiempo_fondo'));
            var timer = $('span.r1').html();

            timer = timer.split(':');
            var hours = parseInt(timer[0], 10);
            var minutes = parseInt(timer[1], 10);
            var seconds = parseInt(timer[2], 10);
            seconds += 1;
            if (seconds > 59) {
                minutes += 1;
                seconds = 00;
                if (minutes > 59) {
                    hours += 1;
                    minutes = 00;
                }
            }
            if (hours < 10 && hours.length != 2) hours = '0' + hours;
            if (minutes < 10 && minutes.length != 2) minutes = '0' + minutes;
            if (seconds < 10 && seconds.length != 2) seconds = '0' + seconds;
            $('span.r1').html(hours + ':' + minutes + ':' + seconds);
            localStorage.setItem('tiempo_fondo',  hours + ':' + minutes + ':' + seconds );

            //console.log(localStorage.getItem('tiempo_fondo'));

            if (hours == 0 && minutes == 0 && seconds == 0)
                clearInterval(interval);
        }, 1000);


    });
</script>

<?php $this->load->view( 'footer' ); ?>