<section id="form"><!--form-->
    <div class="container">
        <?php  echo @$mensaje;
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
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Ó</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Nuevo Usuario, Inscríbete!</h2>
                    <form method="post">
                        <input type="text" name="us" placeholder="Usuario"/>
                        <input type="email" name="mail" placeholder="E-mail"/>
                        <input type="password" name="ps" placeholder="Contraseña"/>    
                        <input type="text" name="DNI" placeholder="DNI"/>
                            <input type="text" name="nombre" placeholder="Nombre"/>
                            <input type="text" name="apellidos" placeholder="Apellidos"/>
                            <input type="text" name="dir" placeholder="Dirección"/>
                            <input type="text" name="cp" placeholder="Código Postal"/>                                                        
                            <?php echo form_dropdown('provincias_id', $provincias) ?>    
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