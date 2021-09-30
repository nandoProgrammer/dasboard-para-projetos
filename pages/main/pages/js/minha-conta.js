/*NÃO ALTERAR*/

//Seleciona onde está a tag ul que contém como atrubto na url o valor de INCLUDE_PATH
var ulAttribute = document.getElementById('home');

//Seleciona o atributo url e pega o seu valor
var includePath = ulAttribute.getAttribute('href');


//Pega a url atual
var getURL = window.location.href;

//Quando a url for igual a informada, o item com id profile vai ter uma borda inferior de 3px, sólida na cor #727cf5
if((getURL === (includePath + 'minha-conta?tab=profile')) || getURL === (includePath + 'minha-conta')){
  var profile = document.getElementById('profile');

  profile.style.borderBottom = '3px solid #727cf5';
  
}

/*Lógica semelhante para a situação atual*/
else if(getURL === (includePath + 'minha-conta?tab=login')){
  var login = document.getElementById('login');

  login.style.borderBottom = '3px solid #727cf5';
  
}

/*Lógica semelhante para a situação atual*/
else if(getURL === (includePath + 'minha-conta?tab=avatar')){
  var avatar = document.getElementById('avatar');

  avatar.style.borderBottom = '3px solid #727cf5';
  
}

//===================================