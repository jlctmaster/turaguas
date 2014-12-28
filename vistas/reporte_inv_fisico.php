<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#parametro" data-toggle="tab" id="tab-parametro">Parámetros</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active in" id="parametro">
      <div class="form_externo">
        <fieldset style="padding: 30px">
          <form action="../pdf/reporte_inv_fisico.php"  method="post" target="_blank" >
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Categoria Desde:</span></td>
                <td><select name="categoria_desde" id="categoria_desde" title="Seleccione la categoria de artículos" required />
          <option value=''>Seleccione la categoria de artículos</option>
          <?php
            require_once("../clases/class_bd.php");
            $mysql=new Conexion();
            $sql = "SELECT DISTINCT cod_categoria,categoria FROM inventario.vw_categoria_materiales ORDER BY cod_categoria ASC";
            $query = $mysql->Ejecutar($sql);
            while ($row = $mysql->Respuesta($query)){
              if($row['cod_categoria']==$cod_categoria){
                echo "<option value='".$row['cod_categoria']."' selected>".$row['categoria']."</option>";
              }else{
                echo "<option value='".$row['cod_categoria']."'>".$row['categoria']."</option>";
                }
                }
              ?>
            </select>
             </td>
              </tr>
              <tr>
                <td><span class="texto_form">Categoria Hasta:</span></td>
                <td><select name="categoria_hasta" id="categoria_hasta" title="Seleccione la categoria de artículos" required />
          <option value=''>Seleccione la categoria de artículos</option>
          <?php
            require_once("../clases/class_bd.php");
            $mysql=new Conexion();
            $sql = "SELECT DISTINCT cod_categoria,categoria FROM inventario.vw_categoria_materiales ORDER BY cod_categoria ASC";
            $query = $mysql->Ejecutar($sql);
            while ($row = $mysql->Respuesta($query)){
              if($row['cod_categoria']==$cod_categoria){
                echo "<option value='".$row['cod_categoria']."' selected>".$row['categoria']."</option>";
              }else{
                echo "<option value='".$row['cod_categoria']."'>".$row['categoria']."</option>";
                }
                }
              ?>
            </select>
             </td>
              </tr>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                  <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <center>
                    <input type="submit" value="Enviar" class="btn btn-default">
                  </center> 
                </td>
              </tr>
            </table>
          </form>
        </fieldset>
      </div>
    </div>
  </div>
</div>