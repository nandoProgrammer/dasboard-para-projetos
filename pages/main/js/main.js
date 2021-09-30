/*NÃO ALTERAR*/

//Seleciona onde está a tag ul que contém como atrubto na url o valor de INCLUDE_PATH
var ulAttribute = document.getElementById('home');

//Seleciona o atributo url e pega o seu valor
var includePath = ulAttribute.getAttribute('href');

//Pega a largura atual da tela
var windowWidth = window.innerWidth;

//Pega a url atual
var getURL = window.location.href;

//===================================



//Seleciona o elemento com id content-main
var contentMain = document.getElementById("content-main");

//Seleciona o elemento com id aside-main
var asideMain = document.getElementById('aside-main');

//Seleciona o elemento com id header-main
var headerMain = document.getElementById("header-main");



var closeBox = false;

//Ao clicar em contentMain irá fechar o box do header que estiver aberto
contentMain.onclick = function() {

    closeBox = true;

    closeBoxHeader();

}


//Mesma lógica, porém executada ao clicar em asideMain
asideMain.onclick = function() {

    closeBox = true;

    closeBoxHeader();


}


//Função para fechar todos os box em aberto quando clicar em qualquer lugar da tela que não o prórpio box
var closeBoxHeader = function() {
    
    //Se closeBox for true, irá fechar o box do header que estiver aberto
    if (closeBox) {

        if (infoBox.style.display === 'block') {

            headerInfoI.style.color = "#98a6ad";

            infoBox.style.display = 'none';

        }

        if (toolsBox.style.display === 'block') {

            headerToolsI.style.color = "#98a6ad";

            toolsBox.style.display = 'none';
        }

        /**/
        if (userBox.style.display === 'block') {
            headerUser.style.backgroundColor = "#fff";
            userBox.style.display = 'none';
        }

        if (asideOptions.style.display === 'block') {

            asideOptions.style.display = 'block';
            asideOptions.classList.remove("aside-show");
            asideOptions.classList.add("aside-hide");

            openAsideOptions.style.color = "#98a6ad";

        }

        if (infoSearch.style.display === 'block') {
           infoSearch.style.display = 'none';
           searchBoxI.style.color = '#98a6ad';
        }

    }

}




/*ALTERAR SE NECESSÁRIO*/

//a explanação do primeiro bloco serve para os demais, mudando apenas o nome da variável que faz referência ao valor do id do elemento selecionado e o valor do id


var colorActive = '#fff';

//Compara se o valor de includePath é igual ao da url atual
if (includePath === getURL) {

    //Se for seleciona o elemento com id 'home' 
    var home = document.getElementById('home');

    //coloca o texto do elemento selecionado com cor #fff
    home.style.color = colorActive;

}

/**/
else if ((includePath + 'editar-usuarios') === getURL) {

    var editarUsuarios = document.getElementById('editar-usuarios');

    editarUsuarios.style.color = colorActive;

}

/**/
else if ((includePath + 'editar-paginas') === getURL) {

    var editarPaginas = document.getElementById('editar-paginas');

    editarPaginas.style.color = colorActive;

}

/**/
else if ((includePath + 'estilo-geral') === getURL) {

    var estiloGeral = document.getElementById('estilo-geral');

    estiloGeral.style.color = colorActive;

}

/**/
else if ((includePath + 'editar-css') === getURL) {

    var css = document.getElementById('editar-css');

    css.style.color = colorActive;

}

/**/
else if ((includePath + 'sobre') === getURL) {

    var css = document.getElementById('sobre');

    css.style.color = colorActive;

}

//===================================




/*NÃO ALTERAR*/

//Pega o elemento com o id aside-options
var asideOptions = document.getElementById('aside-options');

//Pega o elemento com a classe fa-cog
var openAsideOptions = document.querySelector('.fa-cog');

//o elemento asideOptions irá iniciar com display:none
asideOptions.style.display = 'none';

//Ao clicar em asideOptions executa o bloco de código a seguir
openAsideOptions.onclick = function() {

    //asideOptions passa a ter display block
    asideOptions.style.display = 'block';

    //É adicionado a asideOptions a classe aside-show
    asideOptions.classList.add("aside-show");

    //É removido da asideOptions a classe aside-hide
    asideOptions.classList.remove("aside-hide");

    openAsideOptions.style.color = "#000";

  
   if (asideOptions.style.display === 'block') {
            var idClick = 0;
            headerMain.onclick = function() {
                idClick++;

                if (idClick % 2 == 0) {
                    asideOptions.classList.add("aside-hide");

                    //É removido da asideOptions a classe aside-hide
                    asideOptions.classList.remove("aside-show");
                    openAsideOptions.style.color = "#98a6ad";
                }

            }
        }

    if (headerUser.style.color = "#000") {

        headerUser.style.color = "#fff";

    }

    if (headerToolsI.style.color = "#000") {

        headerToolsI.style.color = "#98a6ad";

    }

    if (searchBoxI.style.color = '#000') {

        searchBoxI.style.color = '#98a6ad';

    }

    if (headerUser.style.backgroundColor = "#000") {

        headerUser.style.backgroundColor = "#fff";

    }

    //a explanação do primeiro bloco serve para os demais, mudando apenas o nome da variável que faz referência ao valor do id do elemento selecionado e o valor do id

    //Se o Elemento infoBox estiver com  display:block
    if (infoBox.style.display === 'block') {

        //o infobox passa a ter o display:none
        infoBox.style.display = 'none';

    }

    /**/
    if (userBox.style.display === 'block') {
        userBox.style.display = 'none';
    }

    /**/
    if (toolsBox.style.display === 'block') {
        toolsBox.style.display = 'none';
    }

    if (infoSearch.style.display === 'block') {
        infoSearch.style.display = 'none';
    }

}


/**/
var buttonExit = document.getElementById('exit-aside-options');

/**/
buttonExit.onclick = function() {

    asideOptions.style.display = 'block';
    asideOptions.classList.remove("aside-show");
    asideOptions.classList.add("aside-hide");

    openAsideOptions.style.color = "#98a6ad";


    if (headerInfoI.style.color = "#000") {

        headerInfoI.style.color = "#98a6ad";

    }

    if (openAsideOptions.style.color = "#000") {

        openAsideOptions.style.color = "#98a6ad";

    }

    if (searchBoxI.style.color = '#000') {

        searchBoxI.style.color = '#98a6ad';

    }


    if (headerUser.style.backgroundColor = "#000") {

        headerUser.style.backgroundColor = "#fff";

    }

}


/**/
var headerInfo = document.querySelector('#header-info');
var headerInfoI = document.querySelector('#header-info i');
/**/
var infoBox = document.getElementById('info-box');

/**/
infoBox.style.display = 'none';

/**/
headerInfo.onclick = function() {

    closeBox = false;


    if (headerUser.style.backgroundColor = "#000") {

        headerUser.style.backgroundColor = "#fff";

    }

    if (headerToolsI.style.color = "#000") {

        headerToolsI.style.color = "#98a6ad";

    }

    if (openAsideOptions.style.color = "#000") {

        openAsideOptions.style.color = "#98a6ad";

    }

    if (searchBoxI.style.color = '#000') {

        searchBoxI.style.color = '#98a6ad';

    }



    /**/
    if (infoBox.style.display === 'block') {

        headerInfoI.style.color = "#98a6ad";

        infoBox.style.display = 'none';

    }

    /**/
    else {

        headerInfoI.style.color = "#000";

        infoBox.style.display = 'block';

        if (infoBox.style.display === 'block') {
            var idClick = 0;
            headerMain.onclick = function() {
                idClick++;

                if (idClick % 2 == 0) {

                    infoBox.style.display = 'none';
                    headerInfoI.style.color = "#98a6ad";


                }

            }

        }


        /**/
        if (toolsBox.style.display === 'block') {
            toolsBox.style.display = 'none';
        }

        /**/
        if (userBox.style.display === 'block') {
            userBox.style.display = 'none';
        }

        if (infoSearch.style.display === 'block') {
            infoSearch.style.display = 'none';
        }

    }
}


/**/
var headerToolsI = document.querySelector('#header-tools i');

/**/
var toolsBox = document.getElementById('tools-box');

/**/
toolsBox.style.display = 'none';

/**/
headerToolsI.onclick = function() {


    if (headerUser.style.backgroundColor = "#000") {

        headerUser.style.backgroundColor = "#fff";

    }

    if (headerInfoI.style.color = "#000") {

        headerInfoI.style.color = "#98a6ad";

    }

    if (openAsideOptions.style.color = "#000") {

        openAsideOptions.style.color = "#98a6ad";

    }

    if (searchBoxI.style.color = '#000') {

        searchBoxI.style.color = '#98a6ad';

    }


    /**/
    if (toolsBox.style.display === 'block') {
        headerToolsI.style.color = "#98a6ad";
        toolsBox.style.display = 'none';
    }

    /**/
    else {
        headerToolsI.style.color = "#000";
        toolsBox.style.display = 'block';
        /**/
         if (toolsBox.style.display === 'block') {
            idClick = 0;
            headerMain.onclick = function() {
                idClick++;

                if (idClick % 2 == 0) {

                    toolsBox.style.display = 'none';
                    headerToolsI.style.color = "#98a6ad";

                }

            }

        }
        if (infoBox.style.display === 'block') {
            infoBox.style.display = 'none';
        }

        /**/
        if (userBox.style.display === 'block') {
            userBox.style.display = 'none';
        }

        if (infoSearch.style.display === 'block') {
            infoSearch.style.display = 'none';
        }
    }
}

/**/
var headerUser = document.querySelector('#header-user #box-user');

/**/
var userBox = document.getElementById('user-box');

/**/
userBox.style.display = 'none';

/**/
headerUser.onclick = function() {

    if (headerToolsI.style.color = "#000") {

        headerToolsI.style.color = "#98a6ad";

    }

    if (headerInfoI.style.color = "#000") {

        headerInfoI.style.color = "#98a6ad";

    }

    if (openAsideOptions.style.color = "#000") {

        openAsideOptions.style.color = "#98a6ad";

    }

    if (searchBoxI.style.color = '#000') {

        searchBoxI.style.color = '#98a6ad';

    }

    /**/
    if (userBox.style.display === 'block') {
        headerUser.style.backgroundColor = "#fff";
        userBox.style.display = 'none';
    }

    /**/
    else {
        headerUser.style.backgroundColor = "#000";
        userBox.style.display = 'block';

        if (userBox.style.display === 'block') {
            idClick = 0;
            headerMain.onclick = function() {
                idClick++;

                if (idClick % 2 == 0) {

                    userBox.style.display = 'none';
                    headerUser.style.backgroundColor = "#fff";


                }
        }

        }
        /**/
        if (infoBox.style.display === 'block') {
            infoBox.style.display = 'none';
        }

        /**/
        if (toolsBox.style.display === 'block') {
            toolsBox.style.display = 'none';
        }

        if (infoSearch.style.display === 'block') {
            infoSearch.style.display = 'none';
        }
    }
}

var searchBox = document.getElementById('header-search');

var searchBoxI = document.querySelector('#header-search i');

var infoSearch = document.getElementById('info-search');

infoSearch.style.display = 'none';

searchBox.onclick = function() {


    if (headerToolsI.style.color = "#000") {

        headerToolsI.style.color = "#98a6ad";

    }

    if (headerInfoI.style.color = "#000") {

        headerInfoI.style.color = "#98a6ad";

    }

    if (openAsideOptions.style.color = "#000") {

        openAsideOptions.style.color = "#98a6ad";

    }

    if (headerUser.style.backgroundColor = "#000") {

        headerUser.style.backgroundColor = "#fff";

    }


    if (infoSearch.style.display === 'none') {
        searchBoxI.style.color = '#000';
        infoSearch.style.display = 'block';

    } 

    else {
        searchBoxI.style.color = '#98a6ad';
        infoSearch.style.display = 'none';


         if (infoSearch.style.display === 'block') {
            idClick = 0;
            headerMain.onclick = function() {
                idClick++;

                if (idClick % 2 == 0) {

                    infoSearch.style.display = 'none';
                    searchBoxI.style.color = "#98a6ad";


                }
            }

            }

        
    }

    if (infoBox.style.display === 'block') {

        infoBox.style.display = 'none';

    }

    if (toolsBox.style.display === 'block') {

        toolsBox.style.display = 'none';

    }

    if (userBox.style.display === 'block') {

        userBox.style.display = 'none';

    }
}
//===================================


/*NÃO ALTERAR*/

//Seleciona o elemento com id menu-icon
var menuButton = document.getElementById('menu-icon');
var menuButtonBars = document.querySelector('#bars');
var menuButtonTimes = document.querySelector('#times');


//Se o tamanho da tela for menor ou igual a 992px
if (windowWidth <= 992) {

    //asideMain começa com display:none
    asideMain.style.display = 'none';
    asideMain.classList.add("aside-main-hide");
    var asideMainStatus = 'hide';

}

//Se o tamanho da tela for maior que 992px
else {

    //asideMain começa com display:block
    asideMain.style.display = 'block';
}

menuButtonTimes.style.display = 'none';
//Ao clicar no elemento menuButton
menuButton.onclick = function() {
    asideMain.style.display = 'block';


    //Se asideMain estiver com display:none
    if (asideMainStatus === 'hide') {


        asideMainStatus = 'show';
        menuButtonTimes.style.display = 'block';
        menuButtonBars.style.display = 'none';

        menuButtonBars.classList.add("menu-aside-main-hide");
        menuButtonTimes.classList.add("menu-aside-main-show");

        menuButtonBars.classList.remove("menu-aside-main-show");
        menuButtonTimes.classList.remove("menu-aside-main-hide");

        menuButtonBars.style.display = 'none';

        asideMain.classList.remove("aside-main-hide");
        asideMain.classList.add("aside-main-show");



        if (headerToolsI.style.color = "#000") {

            headerToolsI.style.color = "#98a6ad";

        }

        if (headerInfoI.style.color = "#000") {

            headerInfoI.style.color = "#98a6ad";

        }

        if (openAsideOptions.style.color = "#000") {

            openAsideOptions.style.color = "#98a6ad";

        }

        if (searchBoxI.style.color = '#000') {

            searchBoxI.style.color = '#98a6ad';

        }


        if (headerUser.style.backgroundColor = "#000") {

            headerUser.style.backgroundColor = "#fff";

        }


        if (infoBox.style.display === 'block') {

            infoBox.style.display = 'none';

        } else if (toolsBox.style.display === 'block') {

            toolsBox.style.display = 'none';

        } else if (userBox.style.display === 'block') {

            userBox.style.display = 'none';

        } else if (infoSearch.style.display === 'block') {

            infoSearch.style.display = 'none';

        }

    }

    //Se asideMain estiver com display:block
    else if (asideMainStatus === 'show') {
        menuButtonTimes.style.display = 'none';
        menuButtonBars.style.display = 'block';

        menuButtonBars.classList.remove("menu-aside-main-hide");
        menuButtonTimes.classList.remove("menu-aside-main-show");

        menuButtonBars.classList.add("menu-aside-main-show");
        menuButtonTimes.classList.add("menu-aside-main-hide");
        //Ele passa a ter display:none
        asideMainStatus = 'hide';


        asideMain.classList.add("aside-main-hide");
        asideMain.classList.remove("aside-main-show");

    }

}
//===================================