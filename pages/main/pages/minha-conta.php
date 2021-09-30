<?php
if (isset($_POST['submit-profile']))
{
    /*NÃO ALTERAR*/

    //Variáveis de POST
    $postName = strip_tags($_POST['name']);
    $postEmail = strip_tags($_POST['email']);
    $postTelephone = strip_tags($_POST['telephone']);
    $postOffice = strip_tags($_POST['office']);
    $postDescription = strip_tags($_POST['description']);

    //Se o valor da variável postOffice for vazio, ele será igual ao valor atual do cargo do usuário, que está na variável $userOffice
    if ($postOffice == '')
    {

        $postOffice = $userOffice;

    }
    
    //Valor do maior cargo
    $masterOffice = Count($arrOffice) - 1;
    
    //Seleciona todos os administradores que possuem o maior cargo 
    $selectUserMasterOffice = MySql::connect()->prepare("SELECT * FROM `tb_admin` WHERE office = ?");
    $selectUserMasterOffice->execute(array(
        $masterOffice
    ));
    
    //Número de usuários que possuem o maior cargo
    $numberOfUserMasterOffice = $selectUserMasterOffice->rowCount();
    
    //userMasterId começa como false, significará que o usário não é o único com maior cargo
    $userMasterId = false;
    
    //Se o número de usários que possuem o maior cargo for igual a 1
    if ($numberOfUserMasterOffice == 1)
    {
        
        //Seleciona todos os administradores que possuem o maior cargo
        $selectUserMasterOfficeId = MySql::connect()->prepare("SELECT * FROM `tb_admin` WHERE office = ?");
        $selectUserMasterOfficeId->execute(array(
            $masterOffice
        ));
        
        //FetchAll de $selectUserMasterOfficeId
        $fetchallSelectUserMasterOfficeId = $selectUserMasterOfficeId -> fetchAll();
        

        foreach ($fetchallSelectUserMasterOfficeId as $key => $value)
        {
            //Id do usuário com maior cargo
            $userMasterId = $value['id'];

        }
        
        //Se o usuário atual for o que tiver o cargo maior, $userMasterId será true
        if ($userMasterId == $userId)
        {
           
            $userMasterId = true;

        }

    }

    //Seleciona os valores do usuário antes do update
    $selectUserInformationsBeforeUpdate = MySql::connect()->prepare("SELECT * FROM `tb_admin` WHERE id = ?");
    $selectUserInformationsBeforeUpdate->execute(array(
        $_SESSION['id']
    ));

    //Fetchall dos valores selecionados em $selectUserInformations
    $fetchAllSelectUserInformationsBeforeUpdate = $selectUserInformationsBeforeUpdate->fetchAll();

    //Pega os valores da linha selecionada em $selectUserInformations
    foreach ($fetchAllSelectUserInformationsBeforeUpdate as $key => $value)
    {

        //Valores
        $userNameBeforeUpdate = $value['name'];
        //$userImg = $value['img'];
        $userEmailBeforeUpdate = $value['email'];
        $userTelephoneBeforeUpdate = $value['telephone'];
        $userOfficeBeforeUpdate = $value['office'];
        $userDescriptionBeforeUpdate = $value['description'];

    }

    if (($postOffice == $userOffice && $numberOfUserMasterOffice == 1) || ($postOffice != $userOffice && $numberOfUserMasterOffice > 1) || ($userOffice != $masterOffice) || (isset($userMasterId) && $userMasterId == false))
    {
        //Atualiza os valores do usuário na tabela 'tb_admin' quando o valor da coluna 'id' for igual ao valor da $_SESSION['id']
        $updateProfileValues = MySql::connect()->prepare("UPDATE `tb_admin` SET name = ?, email = ?, telephone = ?, office = ?, description = ? WHERE id = ?");

        //Se os valores forem atualizados
        if ($updateProfileValues->execute(array(
            $postName,
            $postEmail,
            $postTelephone,
            $postOffice,
            $postDescription,
            $_SESSION['id']
        )))
        {
            //Seleciona todos os valores da tabela 'tb_admin' quando o valor da coluna ID for igual ao valor da $_SESSION['id']
            $selectUserInformations = MySql::connect()->prepare("SELECT * FROM `tb_admin` WHERE id = ?");
            $selectUserInformations->execute(array(
                $_SESSION['id']
            ));

            //Fetchall dos valores selecionados em $selectUserInformations
            $fetchAllSelectUserInformations = $selectUserInformations->fetchAll();

            //Pega os valores da linha selecionada em $selectUserInformations
            foreach ($fetchAllSelectUserInformations as $key => $value)
            {

                //Valores
                $userName = $value['name'];
                $userEmail = $value['email'];
                $userTelephone = $value['telephone'];
                $userOffice = $value['office'];
                $userDescription = $value['description'];

            }

            if ($userNameBeforeUpdate == $postName && $userEmailBeforeUpdate == $postEmail && $userTelephoneBeforeUpdate == $userTelephone && $userOfficeBeforeUpdate == $postOffice && $userDescriptionBeforeUpdate == $postDescription)
            {

                $_SESSION['message'] = General::alert('sucess', 'Dados Inalterados');

            }
            else
            {

                //$_SESSION['message'] irá ter o valor de exibir uma mensagem de êxito
                General::alert('sucess', 'Dados atualizados com sucesso');

            }

            
        }

    }
    //Caso contrário significa que você é o unico administrador, logo não pode mudar de cargo e exibirá uma mensagem de erro
    else
    {
        General::alert('error', 'Você é o único adminstrador, não é possível mudar o cargo');
    }

}

if (isset($_POST['submit-login-user']))
{

    /*NÃO ALTERAR*/

    //Variáveis de POST
    

    $postCurrentUser = $_POST['current-user'];
    $postNewUser = $_POST['new-user'];

    //Se os valores passados nos campos de Usuário Atual e Novo Usuário forem vazios, exibe uma mensagem de erro
    if ($postCurrentUser == '' && $postNewUser == '')
    {

        General::alert('error', 'Preencha os campos');

    }

    //Se o valor passado no campo de Usuário Atual for vazio e o valor passado no campo de Novo Usuário for vazio, exibe uma mensagem de erro
    else if ($postCurrentUser != '' && $postNewUser == '')
    {
        //A variável $currentUser será true, ela serve para que ao enviar o fomulário e ocorrer algum erro o valor enviado no campo não seja limpo
        $currentUser = true;
        General::alert('error', 'Preencha o campo Novo Usuário');

    }

    //Segue a mesma lógica, porém para quando a variável $postCurrentUser for vazia e $postNewUser não
    else if ($postCurrentUser == '' && $postNewUser != '')
    {
        $newUser = true;
        General::alert('error', 'Preencha o campo Usuário Atual');

    }

    //Se nenhuma das verificações forem válidas, então será executado o bloco de código
    else
    {
        //Seleciona todas as linhas da tabela 'tb_admin' em que o valor da coluna id é igual ao valor da variável $userId
        $selectUserValues = MySql::connect()->prepare("SELECT * FROM `tb_admin` WHERE id = ?");
        if ($selectUserValues->execute(array(
            $userId
        )))
        {
            //FetchAll para pegar os valores selecionados em $selectUserValues;
            $fetchAllUserValues = $selectUserValues->fetchAll();

            foreach ($fetchAllUserValues as $key => $value)
            {
                //valor do usuário atual no banco de dados
                $currentUserValue = $value['user'];

            }

        }

        //Valor passado no campo Usuário Atual encriptado em md5
        $postUserCript = md5($postCurrentUser);

        //Se for igual
        if ($currentUserValue == $postUserCript)
        {
            //Valor passado no campo Novo Usuário encriptado em md5
            $postNewUserCript = md5($postNewUser);

            //Se o valor do Novo Usuário encriptado for diferente do Usuário atual no banco de dados
            if ($postNewUserCript != $currentUserValue)
            {
                //Atualiza os valores user da tabela 'tb_admin' para o valor de $postNewUserCript quando o valor da coluna id for igual ao valor de $userId
                $updateProfileValues = MySql::connect()->prepare("UPDATE `tb_admin` SET user = ? WHERE id = ?");

                //Ao executar e retornar true
                if ($updateProfileValues->execute(array(
                    $postNewUserCript,
                    $userId
                )))
                {
                    //A $_SESSION['message'] terá valor de uma menagem de erro
                    $_SESSION['message'] = General::alert('sucess', 'Usuário atualizado com sucesso');

                }

            }

            //Caso contrário siginifica $postNewUserCript é igual a $currentUserValue e exibe um amensagem de erro
            else
            {

                General::alert('error', 'O novo usuário deve ser diferente do atual');

            }

        }

        //Se o valor do usuário atual no banco de dados for diferente do valor passado no Usuário Atual
        else if ($currentUserValue != $postUserCript)
        {

            //Se o valor do campo Novo Usuário for vazio
            if ($_POST['new-user'] != '')
            {

                $currentUser = true;
                $newUser = true;

            }

            //E exibe uma mensagem de erro
            General::alert('error', 'Usuário atual errado');

        }

    }

}

if (isset($_POST['submit-login-password']))
{
    /*NÃO ALTERAR*/

    //Variáveis de POST
    $postCurrentPassword = $_POST['current-password'];
    $postNewPassword = $_POST['new-password'];

    //Se o valor do campo Senha Atual e o valor do campo Nova Senha forem vazios, exibe uma mensagem de erro
    if ($postCurrentPassword == '' && $postNewPassword == '')
    {

        General::alert('error', 'Preencha os campos');

    }

    //Se o valor do campo Senha Atual for diferente de vazio e o valor da Nova Senha for vazio, exibe uma mensagem de erro
    else if ($postCurrentPassword != '' && $postNewPassword == '')
    {
        //A variável $currentPassword será true, ela serve para que ao enviar o fomulário e ocorrer algum erro o valor enviado no campo não seja limpo
        $currentPassword = true;
        General::alert('error', 'Preencha o campo Nova Senha');

    }

    //Segue a mesma lógica, porém para quando a variável $postCurrentPassword for vazia e $postNewPassword não
    else if ($postCurrentPassword == '' && $postNewPassword != '')
    {
        $newPassword = true;
        General::alert('error', 'Preencha o campo Senha Atual');

    }

    //Se nenhuma das verificações forem verdadeiras executa o bloco de código a seguir
    else
    {
        //Seleciona todos os valores do usuário atual no banco de dados
        $selectPasswordValues = MySql::connect()->prepare("SELECT * FROM `tb_admin` WHERE id = ?");
        if ($selectPasswordValues->execute(array(
            $userId
        )))
        {
            //Fetchall da seleção de todos os dados do usuário atual
            $fetchAllPasswordValues = $selectPasswordValues->fetchAll();

            foreach ($fetchAllPasswordValues as $key => $value)
            {
                //Valor atual da senha
                $currentPasswordValue = $value['password'];

            }

        }

        //Valor passado no campo Senha Atual encriptado
        $postPasswordCript = md5($postCurrentPassword);

        //Se o valor da senha atual for igual ao valor passado no campo Senha Atual
        if ($currentPasswordValue == $postPasswordCript)
        {
            //Valor passado no campo Nova Senha encriptado
            $postNewPasswordCript = md5($postNewPassword);

            //Se o valor passado no campo Nova Senha for diferente da senha atual no banco de dados
            if ($postNewPasswordCript != $currentPasswordValue)
            {
                //Atualiza a senha do usuário atual no banco de dados
                $updatePasswordValues = MySql::connect()->prepare("UPDATE `tb_admin` SET password = ? WHERE id = ?");
                if ($updateProfileValues->execute(array(
                    $postNewPasswordCript,
                    $userId
                )))
                {
                    //$_SESSION['message'] terá valor de um alerta de êxito
                    $_SESSION['message'] = General::alert('sucess', 'Senha atualizada com sucesso');

                }

            }

            //Caso contrário Nova senha será igual a atual, logo, exibirá uma mensagem de erro
            else
            {

                General::alert('error', 'A nova  deve ser diferente do atual');

            }

        }

        //Se a senha atual no banco de dados for diferente do valor passado no campo Senha Atual 
        else if ($currentPasswordValue != $postPasswordCript)
        {
            //As variáveis para que os valores não desapareça nos campos serão true se o campo Nova Senha for diferente de vazio
            if ($_POST['new-password'] != '')
            {
                $currentPassword = true;
                $newPassword = true;
            }
            
            //Exibe uma mensagem de erro
            General::alert('error', 'Senha atual errada');

        }

    }

}

if (isset($_POST['submit-avatar']))
{

    /*NÃO ALTERAR*/

    //Variáveis de POST
    $avatarImage = $_FILES['avatar'];

    //Se o campo Imagem for vazio, exibe uma mensagem de erro
    if ($avatarImage['name'] == '')
    {

        General::alert('error', 'Escolha uma imagem');

    }

    //Caso contrário executa o bloco de código a seguir
    else
    {

        if (General::fileValidate($avatarImage))
        {

            //Upload da imagem é armazenada em uma variável
            $imageUpload = General::uploadFile($avatarImage);

            //Se o upload for true
            if ($imageUpload)
            {

                //Quando o existir uma imagem do usuário anterior
                if ($userImg != '')
                {

                    //Imagem anterior será deletada
                    General::deleteFile($userImg);

                    //Imagem de usuário terá o valor da imagem que foi feito o upload
                    $userImg = $imageUpload;

                }
                

                //Atualiza a imagem no banco de dados
                $updateProfileImage = MySql::connect()->prepare("UPDATE `tb_admin` SET img = ? WHERE id = ?");
                if ($updateProfileImage->execute(array(
                    $imageUpload,
                    $userId
                )))
                {
                    //Mensagem de êxito que será por meio de uma $_SESSION
                    $_SESSION['message-upload-avatar'] = true;
                    
                    //Se existir a $_SESSION['message-remove-avatar'] ela será false
                    if (isset($_SESSION['message-upload-avatar']))
                    {

                         $_SESSION['message-remove-avatar'] = false; 

                    }
                    
                    //Reload na página
                    General::redirect('minha-conta?tab=avatar');

                }

            }

        }

        //Se a imagem não for válida, será exibida uma mensagem de erro
        else
        {   

            $_SESSION['message-remove-avatar'] = false;
            $_SESSION['message-upload-avatar'] = false;
            General::alert('error', 'Escolha uma imagem válida');

        }

    }

}

//Se existir o valor de image na URL e for igual a delete executa o bloco de código
if (isset($_GET['image']) && $_GET['image'] == 'delete')
{

    //Atualiza na tabela 'tb_admin' o valor da coluna img para vazio quando o valor da coluna id for igual ao valor da variável $userId
    $updateProfileImage = MySql::connect()->prepare("UPDATE `tb_admin` SET img = '' WHERE id = ?");

    //Ao executar a querie
    if ($updateProfileImage->execute(array(
        $userId
    )))
    {

        //Exibe uma mensagem de êxito
        $_SESSION['message-remove-avatar'] = true;
        
        //Se existir a $_SESSION['message-upload-avatar'] ela será false
        if (isset($_SESSION['message-remove-avatar']))
        {

            $_SESSION['message-upload-avatar'] = false; 

        }

        //Deleta a imagem atual
        General::deleteFile($userImg);

        //Atualiza a página
        General::redirect('minha-conta?tab=avatar');

    }

}

?>


<section>
   <div class="container-items-pages-main">
    <?php 

    //Se todas as verificações forem corretas, exibe uma mensagem de êxito
    if(isset($_SESSION['message-remove-avatar']) && $_SESSION['message-remove-avatar'] == true && $_GET['tab'] == 'avatar'){ 


      General::alert('sucess', 'Imagem removida com sucesso');

      
      
    }
    
    //Se todas as verificações forem corretas, exibe uma mensagem de êxito
    if(isset($_SESSION['message-upload-avatar']) && $_SESSION['message-upload-avatar'] == true && $_GET['tab'] == 'avatar'){


      General::alert('sucess', 'Imagem Atualizada com sucesso');

     

    }
    
    //Quando trocar de página irá destruir as $_SESSION
    else if(isset($_GET['tab']) && $_GET['tab'] != 'avatar'){

        unset($_SESSION['message-remove-avatar']);
        unset($_SESSION['message-upload-avatar']);
    }


    
    ?>
      <div class="w100">
         <h1>Minha Conta</h1>
         <div class="bar-dotted"></div>
      </div>
      <!--w100-->
      <div class="nav-items-main">
         <nav>
            <ul class="display-flex-row">
               <li id="profile"><a href="<?php echo INCLUDE_PATH; ?>minha-conta?tab=profile"><i class="fas fa-user-alt"></i> Perfil</a></li>
               <li id="login"><a href="<?php echo INCLUDE_PATH; ?>minha-conta?tab=login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
               <li id="avatar"><a href="<?php echo INCLUDE_PATH; ?>minha-conta?tab=avatar"><i class="fas fa-user-astronaut"></i> Avatar</a></li>
            </ul>
         </nav>
      </div>
      <!--nav-items-main-->
       <div class="space-1 mobile"></div>
      <?php 
      $tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';
      if($tab == 'profile'){ ?>
      <form method="post" id="form-profile">
         <div class="w100 display-flex-row display-flex-column-mobile">
            <div class="w50 display-flex-column">
               <label>Seu Nome:</label>
               <input class="input-style-2" type="text" name="name" value="<?php echo $userName; ?>">
            </div>
            <!--w50-->
            <div class="w50 display-flex-column">
               <label>Email:</label>
               <input class="input-style-2" type="text" name="email" value="<?php echo $userEmail; ?>">
            </div>
            <!--w50-->
         </div>
         <!--w100-->
         <div class="w100 display-flex-row display-flex-column-mobile">
            <div class="w50 display-flex-column">
               <label>Telefone:</label>
               <input class="input-style-2" type="text" name="telephone" maxlength="16" value="<?php echo $userTelephone; ?>">
            </div>
            <!--w50-->
            <div class="w50 display-flex-column">
               <label>Cargo:</label>
               <select class="input-style-2" type="text" name="office">
                 <option value="<?php echo $userOffice; ?>"><?php echo $arrOffice[$userOffice] ?></option>
                 <?php 

                       for ($i=0; $i < Count($arrOffice); $i++) { 

                        if($arrOffice[$i] != $arrOffice[$userOffice]){
                 ?>
                      <option value="<?php echo $i; ?>"><?php echo $arrOffice[$i]; ?></option>
                 <?php }} ?>
                 
               </select>
            </div>
            <!--w50-->
         </div>
         <!--w100-->
         <div class="w100">
            <div class="w100 display-flex-column">
               <label>Descrição:</label>
               <textarea style="margin-right:1%" class="input-style-2" class="w50" name="description"><?php echo $userDescription; ?></textarea>
            </div>
            <!--w100-->
         </div>
         <!--w100-->
         
         <div class="w100">
            <input class="submit-save button-style-1" type="submit" name="submit-profile" value="Salvar">
         </div>
         <!--w100-->
      </form>
      <?php }else if($tab == 'login'){ ?>
      	<form method="post" id="form-login">
             <div class="w100">
                <h3><i class="fas fa-user"></i> Redefina Seu Usuário</h3>
             </div>
             <!--w100-->
            <div class="w100 display-flex-column">
                <label>Usuário Atual:</label>
                <input class=" w50 input-style-2" type="text" name="current-user" <?php if(isset($currentUser) && $currentUser == true){ echo 'value='.$_POST['current-user'].''; } ?>>
             </div>
             <!--w100-->
             <div class="w100 display-flex-column">
                <label>Novo Usuário:</label>
                <input class=" w50 input-style-2" type="text" name="new-user" <?php if(isset($newUser) && $newUser == true){ echo 'value='.$_POST['new-user'].''; } ?>>
             </div>
             <!--w100-->
         <div class="w100">
            <input class="submit-save button-style-1" type="submit" name="submit-login-user" value="Salvar">
         </div>
         <!--w100-->
         </form>
         <div class="space-1"></div>
         <form method="post" id="form-login">
             <div class="w100">
                <h3><i class="fas fa-key"></i> Redefina Sua Senha</h3>
             </div>
             <!--w100-->
            <div class="w100 display-flex-column">
                <label>Senha Atual:</label>
                <input class="w50 input-style-2" type="text" name="current-password" <?php if(isset($currentPassword) && $currentPassword == true){ echo 'value='.$_POST['current-password'].''; } ?>>
             </div>
             <!--w100-->
             <div class="w100 display-flex-column">
                <label>Nova Senha:</label>
                <input class="w50 input-style-2" type="text" name="new-password" <?php if(isset($newPassword) && $newPassword == true){ echo 'value='.$_POST['new-password'].''; } ?>>
             </div>
             <!--w100-->
         <div class="w100">
            <input class="submit-save button-style-1" type="submit" name="submit-login-password" value="Salvar">
         </div>
         <!--w100-->
         </form>
      <?php }else if($tab == 'avatar'){ ?>
         <form method="post" id="form-avatar" enctype="multipart/form-data">
           <div class="w100">
                <h3>Defina Sua Foto de Avatar</h3>
             </div>
             <!--w100-->
         <div class="w100 display-flex-column">

            <div class="w50 display-flex-row display-flex-column-mobile">
            
             
              
               <div id="box-user-avatar" div class="w50">
                  <div <?php if($userImg != ''){ echo 'style="background-image:url('.INCLUDE_PATH.'uploads/'.$userImg.');background-size:cover"'; } ?> id="box-user-avatar-minor" class="center">
                    <?php if($userImg == ''){ ?>
                     <i class="fas fa-user center"></i>
                    <?php } ?>

                  </div>
                  <?php if($userImg != '') {?>
                   <a id="delete-image" href="<?php echo INCLUDE_PATH; ?>minha-conta?tab=avatar&image=delete">
                     <i class="fas fa-times center"></i>
                   </a>
                  <?php } ?>
               </div>
               <!--box-user-avatar-->
               
               <div class="w50 align-flex-center-vertical">
               <span class="display-flex-column">
                  <p>PNG, JPG e JPEG</p>
                  <p>Tamanho: 300kb</p>
                  <p>Dimensões: 135px x 135px</p>
               </span>
             </div>
            </div>
            <!--w20-->
            
            
            <div class="w100">
                  <div align="center" class="box-input-style-2-file">
                     <input class="input-style-2" type="file" name="avatar">
                  </div>
                  <!--box-input-file-->
            </div>
            <!--w100-->
         </div>
         <!--w100-->
          <div class="w100">
               <input class="submit-save button-style-1" type="submit" name="submit-avatar" value="Salvar">
          </div>  
          <!--w100-->
         </form>
      <?php }else if($tab != 'profile' || $tab == 'login' || $tab == 'avatar'){
           General::redirect('');
      } ?>
   </div>
   <!--container-items-pages-main-->
</section>