//Exibe ou oculta senha


//Pega o input de senha
var inputPassword = document.querySelector('input[type="password"]');

//Pega a div onde está o ícone de ocultar/mostrar senha 
var passwordShowHide = document.querySelector('.password-show-hide');

//Seleciona os ícones que simbolizam mostrar senha/ocultar senha
var eyeHide = document.querySelector('.fa-eye');
var eyeShow = document.querySelector('.fa-eye-slash');


//Mostrar senha começa sem aparecer
eyeShow.style.display = "none";

//Ao clicar na div onde estão os ícones de ocultar/mostrar senha 
passwordShowHide.onclick = function(){

	//Se o input de senha estiver com type="password"
	if(inputPassword.type == "password"){

		//Passará a ter type="text"
        inputPassword.type = "text";

        //Ícone de ocultar senha desparecerá
        eyeHide.style.display = "none";

        //Ícone de mostrar senha aparecerá
        eyeShow.style.display = "";

	}
    
    //Se o input de senha estiver com type="text"
	else{

		//Passará a ter type="password"
		inputPassword.type = "password";

		//Ícone de ocultar senha aparecerá
		eyeHide.style.display = "";

		//Ícone de mostrar senha desaparecerá
        eyeShow.style.display = "none";
	}
}