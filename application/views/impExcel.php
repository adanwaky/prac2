<div class="container">
    <div class="row" >
        <div class="col-sm-4">
            <div class="signup-form" >
                <form method="post" action="<?=  base_url().'index.php/ImportarExcel/ProcesaArchivo'?>" enctype="multipart/form-data">
                <input type="file" name="archivo" /><br />
                <input type="submit" value="Enviar" />
            </form>      
            </div>
        </div>
    </div>
</div>
