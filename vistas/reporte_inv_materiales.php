<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#parametro" data-toggle="tab" id="tab-parametro">Parámetros</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active in" id="parametro">
      <div class="form_externo">
        <fieldset style="padding: 30px">
          <form action="../pdf/reporte_inv_materiales.php"  method="post" target="_blank" >
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Tipo Desde:</span></td>
                <td><select name="tipo_desde" id="tipo_desde" title="Seleccione el tipo de inventario" required />
          <option value=''>Seleccione el Tipo de Inventario</option>
          <?php
            require_once("../clases/class_bd.php");
            $mysql=new Conexion();
            $sql = "SELECT nid_combovalor,cdescripcion FROM general.tcombo_valor WHERE ctabla='tdetalle_movimiento_inventario' ORDER BY nid_combovalor";
            $query = $mysql->Ejecutar($sql);
            while ($row = $mysql->Respuesta($query)){
              if($row['nid_combovalor']==$nid_combovalor){
                echo "<option value='".$row['nid_combovalor']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_combovalor']."'>".$row['cdescripcion']."</option>";
                }
                }
              ?>
            </select>
             </td>
              </tr>
              <tr>
                <td><span class="texto_form">Tipo Hasta:</span></td>
                <td><select name="tipo_hasta" id="tipo_hasta" title="Seleccione el tipo de inventario" required />
          <option value=''>Seleccione el Tipo de Inventario</option>
          <?php
            require_once("../clases/class_bd.php");
            $mysql=new Conexion();
            $sql = "SELECT nid_combovalor,cdescripcion FROM general.tcombo_valor WHERE ctabla='tdetalle_movimiento_inventario' ORDER BY nid_combovalor";
            $query = $mysql->Ejecutar($sql);
            while ($row = $mysql->Respuesta($query)){
              if($row['nid_combovalor']==$nid_combovalor){
                echo "<option value='".$row['nid_combovalor']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_combovalor']."'>".$row['cdescripcion']."</option>";
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