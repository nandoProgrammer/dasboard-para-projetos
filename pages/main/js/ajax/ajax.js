//Seleciona o ícone das notificações (sino)
var ClearNotifications = document.querySelector('.fa-bell');

//Seleciona onde está a tag ul que contém como atrubto na url o valor de INCLUDE_PATH, ou seja a URL raíz
var ulAttribute = document.getElementById('home');

//Pega o valor da URL atual
var includePath = ulAttribute.getAttribute('href');

//Seleciona o círculo vermelho de alerta de mensagem
var boxAlertBell = document.getElementById('box-alert-bell');

//Ao clicar no ícone das notificações, faz uma requisição ajax a um arquivo PHP para que seja feita uma lógica no banco de dados
ClearNotifications.onclick = function() {


    const xhr = new XMLHttpRequest();

    xhr.open('GET', includePath + 'pages/main/js/ajax/notifications.php');

    xhr.onreadystatechange = () => {

        if (xhr.readyState == 4) {

            //Se tudo ocorrer bem o círculo vermelho desparecerá 
            if(xhr.status == 200){
                boxAlertBell.style.display = 'none';
            }

            //Se não, aparece um erro
            else {
                console.warn('Ocorreu um erro ao inserir as notificações lidas no banco de dados');
            }

        }
    }

    xhr.send(null);

}


//===================================

var submitConfig = document.getElementById('submit-save-config');

submitConfig.onclick = function(){
    
    var siteName = document.querySelector('input[name="site_name"]').value;

    var siteDescription = document.querySelector('textarea[name="site_description"]').value;

    var siteKeywords = document.querySelector('textarea[name="site_keywords"]').value;

    var siteFavicon = document.querySelector('input[name="site_favicon"]').value;    
}
