<?php
class Painel
{


    public static function MessageTitle($messageTitle)
    {
        /*ALTERAR SOMENTE SE FOR NECESSÁRIO*/

        //Esta função exibe um título de acordo com o valor passado no parâmetro $messageTitle
        if ($messageTitle == 1)
        {

            echo 'Novo usuário criado';

        }

        else if ($messageTitle == 2)
        {

            echo 'nova mensagem de';

            //criar tabela onde quando um usuário escrever algo os seus dados e a mensagem ficar lá
            //para que possa pegar a imagem dele e o nome dele
            
        }

        //===================================

    }

    public static function boxMessage($idTypeBox, $messageTitle)
    {
        /*ALTERAR SOMENTE SE FOR NECESSÁRIO*/

        //Esta função exibe um box de acordo com o valor passado no parâmetro $idTypeBox e $messageTitle
        //O valor de $idTypeBox irá setar as dimensões do box, o valor faz referência a uma classe css
        //O valor de $messageTitle irá setar a cor do box, o valor faz referência a uma classe css
        if ($messageTitle == '1')
        {

            $messageType = 'message-type-one';

            //Ícone do font-awesome
            $content = '<i class="fas fa-user-plus center"></i>';

        }

        //Irá mostrar a uma div com os valores setados
        echo '<div class="' . $idTypeBox . ' ' . $messageType . ' circle-message-notification">' . $content . '</div>';

    }

    //===================================

}
?>
