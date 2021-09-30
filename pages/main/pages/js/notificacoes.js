/*NÃO ALTERAR*/

//Seleciona onde está a tag ul que contém como atrubto na url o valor de INCLUDE_PATH
var ulAttribute = document.getElementById('home');

//Seleciona o atributo url e pega o seu valor
var includePath = ulAttribute.getAttribute('href');

//Pega a url atual
var getURL = window.location.href;

//Quando a url for igual a informada
if(getURL === (includePath + 'notificacoes')){
  
  //Seleciona todos os elmentos com a classe .box-message-type-notifications-options
	var iconsBoxNotificationOptions = document.querySelectorAll('.box-message-type-notifications-options');
  
  //Seleciona todos os ícones de opções que estão dentro dos elementos .box-message-type-notifications-options
  var iconOptionsNotifications = document.querySelectorAll('.fa-ellipsis-h');
    

    //Faz uma iteração em todos os botões de mostrar as opções que estão dentro dos elementos .box-message-type-notifications-options
    iconOptionsNotifications.forEach(function(icon, indexIcon) {
        
        //statusBoxOption começa como fechado, significa que ele começará sem aparecer
        var statusBoxOption = false;

        //Ao clicar em um botão de mostrar as opções
        icon.onclick = function(){
           
           //Ao clicar em um ícone de mostrar as opções
           iconsBoxNotificationOptions.forEach(function(boxOption, boxOptionIndex){

                
                //Se o indíce do botão for igual ao do box da notificação
                if(indexIcon === boxOptionIndex){
                  
                  //Se statusBoxOption for true, significa que está aparecendo
                   if(statusBoxOption){
                    
                    //O box de mostrar as opções vai desaparecer
                    boxOption.style.display = 'none'; 

                    //Também será removida a classe box-options-notifications-show do mesmo
                   	boxOption.classList.remove("box-options-notifications-show"); 

                    //Será adicionado a classe box-options-notifications-hide no mesmo
                    boxOption.classList.add("box-options-notifications-hide");

                    //O status de statusBoxOption passa a ser false pois está fechado
                    statusBoxOption = false;  

                   }

                   //Se statusBoxOption não estiver aparecendo
                   else{
                    
                    //O box de mostrar as opções vai aparecer
                    boxOption.style.display = 'flex'; 

                    //Será removida a classe box-options-notifications-hide no mesmo
                   	boxOption.classList.remove("box-options-notifications-hide"); 

                    //Também será adicionada a classe box-options-notifications-show do mesmo
                    boxOption.classList.add("box-options-notifications-show");

                    //O status de statusBoxOption passa a ser true pois está aparecendo
                    statusBoxOption = true;

                   }
                   

                }

           });

        }

    });

}




