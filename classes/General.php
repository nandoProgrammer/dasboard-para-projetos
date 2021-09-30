<?php

class General
{
   
	public static function alert($type, $message){

		/*ALTERAR SOMENTE SE FOR NECESSÁRIO*/
		
		//Esta função exibe um box de erro ou sucesso

		//Se o primeiro parâmetro passado for 'sucess' irá exibir um box que remete a sucesso, com a mensagem passada no segundo parâmetro
		
		//Se o primeiro parâmetro passado for 'error' irá exibir um box que remete a erro, com a mensagem passada no segundo parâmetro
	
		//É possível personalizar o estilo pelo css, editando as classes box-alert-sucess e box-alert-error

		//É possível também mudar o ícone alterando o ícone do font-awesome 

		if($type == 'sucess'){
			echo '<div class="box-alert sucess"><div class="box-circle-alert box-circle-sucess"><i class="fa fa-check center"></i></div> <span>'.$message.'</span></div>';
		}else if($type == 'error'){
			echo '<div class="box-alert error"><div class="box-circle-alert box-circle-error"><i class="fa fa-times center"></i> </div> <span>'.$message.'</span></div>';
		}

		//===================================

	}
    

	public static function redirect($addressRedirect){
		
      /*NÃO ALTERAR*/

      //Esta função faz o redirecionamento por meio de javascript para o valor da variável $addressRedirect que é passado por parâmetro

      echo '<script>window.location.href = "'.INCLUDE_PATH.$addressRedirect.'"</script>';

      //===================================

	}


	public static function daysAgo($date){

		/*ALTERAR SOMENTE SE FOR NECESSÁRIO*/

		//Esta função imprime na tela a data atual em formato de frase, com base na data passado no parâmetro

		//Ex: 1 de Janeiro de 2021

		//A data passada no parâmetro tem que ser no formato Ano - Mês - Dia


        //Separa a data passada no parâmmetro
		$parts = explode('-', $date);
        
        //Pega a parte que faz referência ao dia
        $day = $parts[2];
        
        //Pega a parte que faz referência ao mês
        $month = $parts[1];

        //Pega a parte que faz referência ao ano
        $year = $parts[0];
      

        //Array com os meses do ano, altere se quiser
        $arrMonth = ['01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'];

        //Printando a mensagem final, altere se quiser
        echo $day.' de '.$arrMonth[$month].' de '.$year;


       //===================================
	}



	public static function fileValidate($file){

        /*ALTERAR SOMENTE SE FOR NECESSÁRIO*/


        //Esta função valida se o arquivo enviado é válido ou não

        //Se for válida retorna true, se não retorna false 
        
        //Verifica se o arquivo é de um desses formatos, se for executa o bloco de código a seguir
		if(
			$file['type'] == 'image/jpeg' ||
			$file['type'] == 'image/jpg' ||
			$file['type'] == 'image/png'
		){
            
            //Verifica o tamanho do arquivo
			$fileSize = intval($file['size']/1024);
                
                //Tamanho máximo dos arquivos que podem ser feito upload, altere se for necessário
                $maxFileSize = 300;

			    //Se for menor ou igual o tamanho de $maxFileSize em kb retorna true
				if($fileSize <= $maxFileSize){
					return true;
				}

				//Se for maior que $maxFileSize retorna false
				else{
					return false;
				}
		}
        
        //Se não for de um dos formatos especificados, retorna false
		else{
			return false;
		}

		//===================================

	}

    
	public static function uploadFile($file){
		/*ALTERAR SOMENTE SE FOR NECESSÁRIO*/

        
        //Esta função faz upload dos arquivos em um diretório especificado

        //O arquivo a ser feito upload é passado no parâmetro $file


        //Pega o formato do arquivo passado no parâmetro $file
		$fileFormat = explode('.',$file['name']);

        //Renomeia o o nome do arquivo para 'id gerado.formato do arquivo'
		$imageName = uniqid().'.'.$fileFormat[count($fileFormat) - 1];

        //Move a imagem para o diretório especificado, se mover retorna $imageName
        //Altere o endereço do diretório se for necessário
		if(move_uploaded_file($file['tmp_name'],BASE_DIR.'/uploads/'.$imageName)){
			return $imageName;
		}

		//Se não conseguir mover retorna falso
		else{
			return false;
		}

		//===================================

	}


	public static function deleteFile($file){
		/*ALTERAR SOMENTE SE FOR NECESSÁRIO*/


		//Esta função deleta o arquivo passado no parâmetro $file no endereço do diretório especificado 
        
        //Altere o endereço do diretório se for necessário

		unlink('uploads/'.$file);

		//===================================
	}

	public static function charaterLimiter($text, $limit, $break = true){
	   /*NÃO ALTERAR*/
       

       //Esta função limita o número de caracteres exibidos em uma String

       //O parâmetro $text é a string a ser limitado o tamanho

       //O parâmetro limit é a qauntidade de caracteres que seão exibidos

       //Pega a quantidade de caracteres passada no parâmetro $text
	   $size = strlen($text);

       //Verifica se o tamanho do texto é menor ou igual ao limite
	   if($size <= $limit){ 

	      $newText = $text;

	   }
       
       //Se o tamanho do texto for maior que o limite
	   else{ 

	   	  //Verifica a opção de quebrar o texto
	      if($break == true){

	         $newText = trim(substr($text, 0, $limit))."...";

	      }
          
          //Se não, corta $texto na última palavra antes do limite
	      else{ 

	      	 //Localiza o útlimo espaço antes de $limite
	         $lastSpace = strrpos(substr($text, 0, $limit), " "); 

	         //Corta o $texto até a posição localizada
	         $lastSpace = trim(substr($text, 0, $lastSpace))."..."; 
	      }
	   }

	   //Retorna o valor formatado
	   return $newText; 
	}

	//===================================

}

?>
