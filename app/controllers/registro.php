<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller {

	public function __construct(){ 
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->model('registros', 'modelo_registro'); 
		$this->load->model('admin/catalogo', 'catalogo');  
		$this->load->library(array('email')); 
		$this->tiempo_comienzo      = "0:10";
	}




	function correo(){  

		$this->load->library('email');

		$this->email->from('info@cinepremios.com', 'probando');
		$this->email->to('osmel.calderon@gmail.com');
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		if ($this->email->send()) 
		{
			echo 'ok' ;
		}
		else {
			echo 'bad';
		}


	}	

 // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_registro(){
		if($this->session->userdata('session_participante') === TRUE ){   //si esta logueado  ir al home
				  redirect('');
		} else {  //nuevo registro
			  //$data['premios']   = $this->catalogo->listado_premios();
			  $data['estados']   = $this->modelo_registro->listado_estados();
			  $this->load->view( 'registros/registro',$data );   
		}    
	}


function validar_registros(){
		if ($this->session->userdata('session_participante') == TRUE) {
			redirect('');
		} else {


			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'fecha_nac', 'Fecha de Nacimiento', 'trim|required|callback_valid_nacimiento[fecha_nac]|xss_clean');
			$this->form_validation->set_rules('id_estado', 'Ciudad de compra', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'celular', 'Celular', 'trim|required|numeric|min_length[10]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');
			
			$this->form_validation->set_rules( 'pass_1', 'La contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');
							
			
			$this->form_validation->set_rules('coleccion_id_aviso', 'Aviso de privacidad', 'callback_accept_terms[coleccion_id_aviso]');	
			$this->form_validation->set_rules('coleccion_id_base', 'Bases legales', 'callback_accept_terms[coleccion_id_base]');	
			$this->form_validation->set_rules('coleccion_id_newsletter', 'Recibir Promociones', 'callback_accept_terms[coleccion_id_base]');	
			
			
			$mis_errores=array(
						"exito" => false,
						"general" => '',
					    "nombre" =>  '',
					    "apellidos" =>  '',
					    "fecha_nac" =>  '',

					    "id_estado" =>  '',
					    "celular" =>  '',
					    "email" =>  '',

					    'pass_1'=> '',
					    'pass_2'=>  '',

					    "coleccion_id_aviso" =>  '',
					    "coleccion_id_base" =>  '',
					    "coleccion_id_newsletter" =>  '',
				);
			


			if ($this->form_validation->run() === TRUE){

				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$data['email']			=	$this->input->post('email');
					$data['contrasena']		=	$this->input->post('pass_1');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo_registro->check_correo_existente($data);

					if ( $login_check != FALSE ){		
						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );

						$usuario['fecha_nac']   		= $this->input->post( 'fecha_nac' );
						$usuario['id_estado']   		= $this->input->post( 'id_estado' );

						$usuario['celular']   		= $this->input->post( 'celular' );
						$usuario['email']   			= $this->input->post( 'email' );
						$usuario['contrasena']				= $this->input->post( 'pass_1' );

						$usuario['id_perfil']   		= 3; //significa participante

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo_registro->anadir_registro( $usuario );

						
						if ( $guardar !== FALSE ){  

									$dato['email']   			    = $usuario['email'];   			
									$dato['contrasena']				= $usuario['contrasena'];				

									
									//envio de correo para notificar alta en usuarios del sistema
									/*
									$desde = $this->session->userdata('c1');
									$esp_nuevo = $usuario['email'];
									$this->email->from('admin@vamonosaespanaconcalimax.com', 'Información Calimax');
									$this->email->to( $esp_nuevo );
									$this->email->subject('Vamonos a españa con Calimax'); //.$this->session->userdata('c2')
									$this->email->message( $this->load->view('admin/correos/alta_usuario', $dato, TRUE ) );
									*/

										 
									//if ($this->email->send()) 
										//{	//si se notifico al usuario, que envie a los administradores un correo
										/*
										$dato['email']   			    = $usuario['email'];   			
										$dato['contrasena']				= $usuario['contrasena'];				
										$dato['nombre']   			    = $usuario['nombre'];   			
										$dato['apellidos']				= $usuario['apellidos'];
										$dato['celular']   			    = $usuario['celular'];   			

											
										$this->load->library('email');
										$this->email->from('admin@vamonosaespanaconcalimax.com', 'Información Calimax');
										$this->email->to('guerreroadrian1111@gmail.com,carlos.ramirez@lostres.mx');	

										$this->email->subject('Nuevo usuario en Vamonos a España Calimax');
										$this->email->message( $this->load->view('admin/correos/alta_usuarios', $dato, TRUE ) );
										$this->email->send();*/

									
									//checar el loguin y recoger datos de usuario registrado
									$login_checkeo = $this->modelo_registro->check_login($usuario);
									//agrega al historico de acceso de participantes
									$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  

									$this->session->set_userdata('session_participante', TRUE);
									$this->session->set_userdata('email_participante', $usuario['email']);

									
									
									if (is_array($login_checkeo))  //si existe el usuario
										foreach ($login_checkeo as $element) {
											$this->session->set_userdata('id_participante', $element->id);
											$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
											$this->session->set_userdata('tarjeta_participante', $element->tarjeta);
											$this->session->set_userdata('juego_participante', $element->juego);
										}


										//cantidad de ; para saber a donde redirigir
										if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<5) {
											$mis_errores['redireccion'] = 'tarjetas';		
										} else if  ( strlen($this->session->userdata('juego_participante'))!=3){
											$mis_errores['redireccion'] = 'juegos';		
										} else {
											$mis_errores['redireccion'] = '';	
										}
										
										$mis_errores['exito'] = true;	



										//$mis_errores = true;
								
									/*} else {
										 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
									}*/
									
									/*
						} else {
							
							 	 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
							 
						}*/
						
					} else {  //if ( $guardar !== FALSE ){  
						
							 	 
							 
						
					}
				} else { //if ( $login_check != FALSE ){
					
					$mis_errores["general"] = '<span class="error">El <b>Correo electrónico</b> ya se encuentra registrado.</span>';		 	
							 
						
					
				}
			} else {	//if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){		
				
					$mis_errores["general"] = '<span class="error">No coinciden la Contraseña </b> y su <b>Confirmación</b> </span>';


		} ////if ($this->form_validation->run() === TRUE){

			//$mis_errores = true;


	} //fin del else if ($this->session->userdata('session_participante') == TRUE) {


//tratamiento de errores
				$error = validation_errors();
				
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "nombre" => 'Nombre',
				    "apellidos" => 'Apellido(s)',
				  	"fecha_nac" => 'Fecha de Nacimiento',  

					"id_estado" => 'Ciudad de compra',
					"celular" => 'Celular',
					"email" => 'Correo',

				    'pass_1'=>'La Contraseña',
				    'pass_2'=>'Confirmación',
				    
				    "coleccion_id_aviso" => 'Aviso de privacidad',
				    "coleccion_id_base" => 'Bases legales',
				    "coleccion_id_newsletter" => 'Recibir Promociones',
				  
				);


				    foreach ($errores as $elemento) {
				    	//echo $elemento.'<br/>';
						foreach ($campos as $clave => $valor) {
								
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }
				    
			}

			echo json_encode($mis_errores);
			self::configuraciones_imagenes();

}		




  
 function ingresar_usuario(){
		if ($this->session->userdata( 'session_participante' ) == TRUE )    { //(no registrado) o (registrado y completado)
			 redirect('');
		} else {
			$this->load->view( 'registros/login');
		}
 }



	function validar_login_participante(){
				$mis_errores=array(
					"exito" => false,
				    "email" => '',
				    "contrasena" => '',
				    'general'=> '',
				);

		$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');

		if ( $this->form_validation->run() == TRUE ){
				$data['email']		=	$this->input->post('email');
				$data['contrasena']		=	$this->input->post('contrasena');
				$data 				= 	$this->security->xss_clean($data);  

				$login_checkeo = $this->modelo_registro->check_login($data);
				
				if ( $login_checkeo != FALSE ){

					$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  //agrega al historico de acceso de participantes

					$this->session->set_userdata('session_participante', TRUE);
					$this->session->set_userdata('email_participante', $data['email']);


					if (is_array($login_checkeo))  //si existe el usuario
					
						foreach ($login_checkeo as $element) {
							$this->session->set_userdata('id_participante', $element->id);
							$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
							$this->session->set_userdata('tarjeta_participante', $element->tarjeta);
							$this->session->set_userdata('juego_participante', $element->juego);
						}					

										
					//cantidad de ; para saber a donde redirigir
					if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<5) {
						$mis_errores['redireccion'] = 'tarjetas';		
					} else if  ( strlen($this->session->userdata('juego_participante'))!=3){
						$mis_errores['redireccion'] = 'juegos';		
					} else {
						$mis_errores['redireccion'] = '';	
					}
					
					

					$mis_errores['exito'] = true;	
				} else {
					//$mis_errores['exito'] = true;	
					$mis_errores["general"] = '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		} else {		
				//tratamiento de errores
				$error = validation_errors();
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "email" => 'Correo',
				    "contrasena" => 'Contraseña',
				);
				    foreach ($errores as $elemento) {

						foreach ($campos as $clave => $valor) {
							
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="Requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }

		}	

		echo json_encode($mis_errores);
		self::configuraciones_imagenes();
	}	





//recuperar constraseña OK
	function recuperar_participante(){ //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$this->load->view('registros/recuperar_password');
	}
	
	
	function validar_recuperar_participante(){  //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$mis_errores=array(
				    'general'=> '',
		);

		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');

		if ( $this->form_validation->run() == FALSE ){
			$mis_errores["general"] =  validation_errors('<span class="error">','</span>');

		} else {
				$data['email']		=	$this->input->post('email');
				$correo_enviar      =   $data['email'];
				$data 				= 	$this->security->xss_clean($data);  
				$usuario_check 		=   $this->modelo_registro->recuperar_contrasena($data);

				if ( $usuario_check != FALSE ){
						$data= $usuario_check[0]; 	
						$desde = $this->session->userdata('c1');
						$this->email->from($desde,$this->session->userdata('c2'));
						$this->email->to($correo_enviar);
						$this->email->subject('Recuperación de contraseña de '.$this->session->userdata('c2'));
						$this->email->message($this->load->view('registros/correos/envio_contrasena', $data, true));
						
						if ($this->email->send()) {
						
							$mis_errores = true;					
						} else 
							//$mis_errores = false;
							$mis_errores["general"] = '<span class="error">Su correo no ha podido salir, error conexión.</span>';
				} else {
					//echo '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
					$mis_errores["general"] = '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		}

		echo json_encode($mis_errores);
	}		









	public function desconectar_participante(){
		$this->session->sess_destroy();
		redirect('');
	}	




	public function configuraciones_imagenes(){
			    $configuraciones = $this->modelo_registro->listado_imagenes();
				if ( $configuraciones != FALSE ){
					if (is_array($configuraciones)){
						$this->session->set_userdata('cantimagen', count($configuraciones) ) ;	
						foreach ($configuraciones as $configuracion) {
							$this->session->set_userdata('i'.$configuracion->id, $configuracion->valor);
							$this->session->set_userdata('ip'.$configuracion->id, $configuracion->puntos);
						}

					}
				} 

						//crear los ptos
						$uno =1; //mt_rand(1, $this->session->userdata('cantimagen'));
						$dos =1; //mt_rand(1, $this->session->userdata('cantimagen'));
						$tres =1; // mt_rand(1, $this->session->userdata('cantimagen'));

						$uno =mt_rand(1, $this->session->userdata('cantimagen'));
						$dos =mt_rand(1, $this->session->userdata('cantimagen'));
						$tres =mt_rand(1, $this->session->userdata('cantimagen'));
						

						$ticket['puntos'] = base64_encode($uno. $dos. $tres);
						//print_r($ticket['puntos']);die;


						$this->session->set_userdata('cripto', $ticket['puntos'] );

						//indicar que ya registro su ticket						
						//$this->session->set_userdata('registro_ticket', true );

						//cuando entra 3 posibilidades de barajear
						$this->session->set_userdata('numImage', 3 );  //para poder ir descontando imagenes

						//tiempo comienzo
						$this->session->set_userdata('tiempo', $this->tiempo_comienzo);  //para poder ir descontando tiempo


						//la pregunta que va a salir
						$datos = $this->modelo_registro->listado_preguntas();
						foreach ($datos as $row) {
							$misdatos[]=$row->id;
						}	
						shuffle($misdatos);
						
						$this->session->set_userdata('pregunta1', $misdatos[0] );
						$this->session->set_userdata('pregunta2', $misdatos[1] );
						$this->session->set_userdata('pregunta3', $misdatos[2] );
						$this->session->set_userdata('pregunta4', $misdatos[3] );
						$this->session->set_userdata('pregunta5', $misdatos[4] );



	}


	public function num_conteo(){
		   if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		   		$data['started']		=	$this->input->post('started');
		   		
		   		if  ( isset($_POST["started"]) ) {
		   			$this->session->set_userdata('numImage', $this->input->post('started') );
		   		} else {

		   			//no se establece 	numImage
		   		}

		   		$data['tiempo'] = 	$this->session->userdata('tiempo'); 
		   		$data['tiempo_comienzo'] = $this->tiempo_comienzo; 
			   	$data['num'] = $this->session->userdata('numImage'); 

			   	//$data['registro_ticket'] = $this->session->userdata('registro_ticket'); 
			   	$this->session->set_userdata('tiempo', "0:00");
			   	echo  json_encode($data);
		   }	
			
    }	

    /*
		data.num
		data.registro_ticket
		data.tiempo
		data.tiempo_comienzo

    */


////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////record personal///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

function record($id_participante){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		$data["id_participante"] = $id_participante;
		$dato 		=   $this->modelo_registro->record_personal($data);

 		//$objeto = $this->modelo->listado_imagenes();


				
				$dato->c1 =  (int) ($dato->juego / 100);
                $dato->c2 =   (int) (($dato->juego % 100) / 10 );
                $dato->c3 =   (int) (($dato->juego % 10)  );

		$this->load->view( 'juegos/record',$dato );
	}	
}	

////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
 
//new ok
function registrar_facebook($puntos){ //nuevo
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$ticket['total'] = (int) ($puntos);
		if  ($ticket['total']>0) { //si compartio el total>0

			$ticket['ticket']			=	'fac-'.$this->session->userdata('id_participante');
			$ticket['compra']   			= "08/24/17";
			$ticket['cantidad']   			= 0;
			$ticket['monto']				= $ticket['total']; //cantidad
			$ticket['transaccion']			= 0;
			$ticket['clave_producto']		= 0;
			$uno = mt_rand(1, 1);
			$ticket['puntos'] = base64_encode($uno. $uno. $uno);
			$ticket['total'] = $ticket['total'];	
			$ticket 						= $this->security->xss_clean( $ticket );
			$guardar 						= $this->modelo_registro->anadir_tickets( $ticket );        	
		} 
		 redirect('/registro_ticket');  //comparta o no va a ir al registro de ticket
	}	

}

//new ok
 public function proc_modal_facebook(){ //nuevo
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
               $this->load->view( 'registros/modal_face' );
		   }   			
}



 public function compartir_imagen(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
               $this->load->view( 'imagen/imagen' );
		   }   			

}


 public function proc_modal_instrucciones(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
               $this->load->view( 'tickes/modal_instrucciones' );
		   }   			

}


 public function proc_modal_cero_puntos(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		    	//indicar que ya concluyo tarea con su ticket

		    	//actualizar ticket
				$data["num_ticket_participante"] =	$this->session->userdata( 'num_ticket_participante' );
				        $data["id_participante"] = $this->session->userdata( 'id_participante' );
				$data['total'] = 0;

				$data 						= $this->security->xss_clean( $data );
				$guardar 				    = $this->modelo_registro->actualizar_tickets( $data );

				//indicar que ya concluyo tarea con su ticket
		       $this->session->set_userdata('registro_ticket', false );
               $this->load->view( 'tickes/modal_cero_puntos' );
		   }   			
}


function publico($puntos){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$data["num_ticket_participante"] =	$this->session->userdata( 'num_ticket_participante' );
		        $data["id_participante"] = $this->session->userdata( 'id_participante' );

		$data['total'] = (int) ($puntos) ;

		$data 						= $this->security->xss_clean( $data );
		$guardar 				    = $this->modelo_registro->actualizar_tickets( $data );

		
        
		redirect('/record/'.$data["id_participante"]);
	}	

}	


function tabla_general(){
		$data["records"] 		=  $this->modelo_registro->record_general();
		$this->load->view( 'dashboard/tabla_general',$data );

}	


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function cadena_noacepta( $str ){
		$regex = "/(uefa|pepsi|champio)/i";
		if ( preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'cadena_noacepta',"<b class='requerido'>*</b> La información introducida en <b>%s</b> no está permitida." );
			return FALSE;
		} else {
			return TRUE;
		}
	}



	function valid_fecha( $str, $campo ){
		if ($this->input->post($campo)){
			
			
			$fecha_inicial =  strtotime( date("Y-m-d", strtotime("03/15/2017") ) );
		    $fecha_compra  =  strtotime( date("Y-m-d", strtotime($this->input->post($campo)) ) );
			          $hoy =   strtotime(date("Y-m-d") );
			if ( ($fecha_compra>=$fecha_inicial) && ($fecha_compra<=$hoy) ) {
				return true;
			} else {
				$this->form_validation->set_message( 'valid_fecha',"<b class='requerido'>*</b> Su <b>%s</b> es incorrecta." );	
				return false;
			}

		} else {
			$this->form_validation->set_message( 'valid_fecha',"<b class='requerido'>*</b> Es obligatorio <b>%s</b>." );
			return false;
		}	

	}







	


/////////////////validaciones/////////////////////////////////////////	




	function accept_terms($str,$campo) {
        if ($this->input->post($campo)){
			return TRUE;
		} else {
			$this->form_validation->set_message( 'accept_terms',"<b class='requerido'>*</b> Favor lee y acepta tu <b>%s</b>." );
			return FALSE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', "<b class='requerido'>*</b> El <b>%s</b> no tiene un formato válido." );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_nacimiento( $str, $campo ){
		if ($this->input->post($campo)){
			$hoy =  new DateTime (date("Y-m-d", strtotime(date("d-m-Y"))) );
			$fecha_nac = new DateTime ( date("Y-m-d", strtotime($this->input->post($campo)) ) );
			$fecha = date_diff($hoy, $fecha_nac);
			if ( ($fecha->y>=18) && ($fecha->y<=150) ) {
				return true;
			} else {
				$this->form_validation->set_message( 'valid_nacimiento',"<b class='requerido'>*</b> Su <b>%s</b> debe ser mayor a 18 años." );	
				return false;
			}

		} else {
			$this->form_validation->set_message( 'valid_nacimiento',"<b class='requerido'>*</b> Es obligatorio <b>%s</b>." );
			return false;
		}	

	}



	public function valid_cero($str) {
		return (  preg_match("/^(0)$/ix", $str)) ? FALSE : TRUE;
	}

	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido',"<b class='requerido'>*</b> La información introducida en <b>%s</b> no es válida." );
			return FALSE;
		} else {
			return TRUE;
		}
	}



	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', "<b class='requerido'>*</b> Es necesario que selecciones una <b>%s</b>.");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_date( $str ){

		$arr = explode('-', $str);
		if ( count($arr) == 3 ){
			$d = $arr[0];
			$m = $arr[1];
			$y = $arr[2];
			if ( is_numeric( $m ) && is_numeric( $d ) && is_numeric( $y ) ){
				return checkdate($m, $d, $y);
			} else {
				$this->form_validation->set_message('valid_date', "<b class='requerido'>*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.");
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', "<b class='requerido'>*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD/MM/YYYY.");
			return FALSE;
		}
	}

	public function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

	////Agregado por implementacion de registro insitu para evento/////
	public function opcion_valida( $str ){
		if ( $str == '0' ){
			$this->form_validation->set_message('opcion_valida',"<b class='requerido'>*</b>  Selección <b>%s</b>.");
			return FALSE;
		} else {
			return TRUE;
		}
	}


}

/* End of file main.php */
/* Location: ./app/controllers/main.php */
