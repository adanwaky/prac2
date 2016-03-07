<section id="form"><!--form-->
    <div class="container">
        <?php  if (isset($mensaje)){
        echo "<p style='color:red; font-weight: bold;'>".$mensaje.'</p>';}
        ?>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Accede a tu cuenta</h2>
                    <form method="post">
                        <input type="text" name="user" placeholder="Usuario" />
                        <input type="password" name="pass" placeholder="Contraseña" />
                     
                        <!--span>
                                <input type="checkbox" class="checkbox"> 
                                Guardar contraseña
                        </span-->
                        <input type="submit" name="login" 
                               style="background-color:#FF8A02;color:white;"  
                               value='Entrar'> 
                    </form>
                     <?php echo anchor("Login/ResetPass", "¿Ha olvidado su contraseña?") ?>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Ó</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Nuevo Usuario, Inscríbete!</h2>
                    <form method="post">
                        <input type="text" name="us" value="<?=set_value('us')?>" placeholder="Usuario"/>
                        <input type="email" name="mail" value="<?=set_value('mail')?>" placeholder="E-mail"/>
                        <input type="password" name="ps" value="<?=set_value('ps')?>"placeholder="Contraseña"/>    
                        <input type="text" name="DNI" value="<?=set_value('DNI')?>"placeholder="DNI"/>
                            <input type="text" name="nombre" value="<?=set_value('nombre')?>"placeholder="Nombre"/>
                            <input type="text" name="apellidos" value="<?=set_value('apellidos')?>"placeholder="Apellidos"/>
                            <input type="text" name="dir" value="<?=set_value('dir')?>"placeholder="Dirección"/>
                            <input type="text" name="cp" value="<?=set_value('cp')?>"maxlength="5"placeholder="Código Postal"/>                                                        
                            <?php echo form_dropdown('provincias_id', $provincias, set_value('provincias_id')) ?>    
                            <br><br>
                       <input type="submit" name="insc" 
                               style="background-color:#FF8A02;color:white;"  
                               value='Inscribirse'> 
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->