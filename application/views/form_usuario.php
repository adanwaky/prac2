
    <section id="form"><!--form-->
        <div class="container">
            <div class="row" >
                <div class="col-sm-4">
                    <div class="signup-form" ><!--sign up form-->
                        <h2>Datos Usuario</h2>
                        <form action="#">
                            <input type="text" placeholder="Usuario"/>
                            <input type="email" placeholder="E-mail"/>
                            <input type="password" placeholder="Contraseña"/>
                            <input type="text" placeholder="DNI"/>
                            <input type="text" placeholder="Nombre"/>
                            <input type="text" placeholder="Apellidos"/>
                            <input type="text" placeholder="Dirección"/>
                            <input type="text" placeholder="Código Postal"/>                                                        
                            <?php echo form_dropdown('provincias_id', $provincias) ?>    
                            <br><br>
                            <button type="submit" class="btn btn-default">Guardar</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section>

