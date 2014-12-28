<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#parametro" data-toggle="tab" id="tab-parametro">Parámetros</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active in" id="parametro">
      <div class="form_externo">
        <fieldset style="padding: 30px">
          <form action="../pdf/reporte_devolucion_proveedor.php"  method="post" target="_blank" >
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Fecha Desde:</span></td>
                <td><input type="text" name="dfecha_desde" id="dfecha_desde" required/></td>
              </tr>
              <tr>
                <td><span class="texto_form">Fecha Hasta:</span></td>
                <td><input type="text" name="dfecha_hasta" id="dfecha_hasta" required/></td>
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
