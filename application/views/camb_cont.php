
        <div class="container">
            <?php if(isset($mensaje)){
            echo $mensaje;}?>
            <div class="row" >
                <div class="col-sm-4">
                    <div class="signup-form" >
                        <form method="post">
                            Nombre usuario: <input type="text" name="user"><br>
                            DNI: <input type="text" name="dni"placeholder="12345678X"><br>
                            Nueva contraseña: <input type="password" name="pass"><br>
                            <input type="submit" 
                                   style="background-color:#FF8A02;color:white;"  
                                   value='Cambiar contraseña'> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
