
<section id="form"><!--form-->
    <div class="container">
        <?php if(isset($mensaje)) echo $mensaje;?>
        <div class="row" >
            <div class="col-sm-4">
                <div class="signup-form" ><!--sign up form-->
                    <h2>Datos Usuario</h2>
                    <form method="post">
                        <label>Nombre de usuario: </label> 
                        <input type="text" name="us" value="<?= $user[0]['user'] ?>"/>
                        <input type="submit" name="cons" 
                               style="background-color:#FF8A02;color:white;"  
                               value='¿Cambiar contraseña?'> 
                        <label>Correo electrónico: </label>
                        <input type="email" name="mail" value="<?= $user[0]['mail'] ?>"/>
                         
                        <label>DNI: </label>
                        <input type="text" name="DNI" value="<?= $user[0]['dni'] ?>"/>
                        <label>Nombre: </label>
                        <input type="text" name="nombre" value="<?= $user[0]['nombreUs'] ?>"/>
                        <label>Apellidos: </label>
                        <input type="text" name="apellidos" value="<?= $user[0]['apellidos'] ?>"/>
                        <label>Dirección: </label>
                        <input type="text" name="dir" value="<?= $user[0]['direccion'] ?>"/>
                        <label>Código Postal: </label>
                        <input type="text" name="cp" value="<?= $user[0]['cp'] ?>"/>     
                        <label>Provincia: </label>
                        <?php echo form_dropdown('provincias_id', $provincias, $user[0]['provincias_id']) ?>    
                        <br><br>
                        <input type="submit" name="act" 
                               style="background-color:#FF8A02;color:white;"  
                               value='Guardar Datos'> 
                        <input type="submit" name="baja" 
                               style="background-color:#FF8A02;color:white;"  
                               value='Darme de baja'> 
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section>

