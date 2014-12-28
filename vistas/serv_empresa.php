<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#empresa" data-toggle="tab" id="tab-empresa">Datos de la Empresa</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_empresa.js"> </script>
    <div class="tab-pane active in" id="empresa">
      <div class="form_externo" >
        <?php
          require_once('../clases/class_bd.php');
          $conexion = new Conexion();
          $sql = "SELECT * FROM seguridad.tsistema";
          $query = $conexion->Ejecutar($sql);
          while($row=$conexion->Respuesta($query)){
            $crif_empresa=$row['crif_empresa'];
            $cnombre_empresa=$row['cnombre_empresa'];
            $ctlf_empresa=$row['ctlf_empresa'];
            $cemail_empresa=$row['cemail_empresa'];
            $cclave_email_empresa=$row['cclave_email_empresa'];
            $cdireccion_empresa=$row['cdireccion_empresa'];
            $nid_localidad=$row['nid_localidad'];
            $cmision=$row['cmision'];
            $cvision=$row['cvision'];
            $cobjetivo=$row['cobjetivo'];
            $chistoria=$row['chistoria'];
          }
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_empresa.php" method="post" id="form1">
            <table border="0" style="width: 100%"> 
              <tr>
                <td><span class="texto_form">RIF Empresa</span></td>
                <td><input onKeyPress="return isRif(event)" onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese el rif de la empresa" name="crif_empresa" id="crif_empresa" type="text" size="10" value="<?= $crif_empresa;?>" required /> </td>
              </tr>
              <tr>
                <td><span class="texto_form">Nombre</span></td>
                <td><textarea title="Ingrese el nombre de la empresa" name="cnombre_empresa" id="cnombre_empresa" rows="2" cols="30" required /><?= $cnombre_empresa;?></textarea></td>
                <td><span class="texto_form">Tlf. de Habitación</span></td>
                <td><input maxlength=11 title="Ingrese el n&uacute;mero de habitaci&oacute;n de la empresa" onKeyPress="return isNumberKey(event)" name="ctlf_empresa" id="ctlf_empresa" type="text" size="50" value="<?= $ctlf_empresa;?>" required /></td>
              </tr>
              <tr>
                <td><span class="texto_form">Email</span></td>
                <td><input title="Ingrese el email de la empresa" name="cemail_empresa" id="cemail_empresa" type="text" size="50" value="<?= $cemail_empresa;?>"/> </td>
                <td><span class="texto_form">Contraseña</span></td>
                <td><input title="Ingrese la contraseña del email de la empresa" name="cclave_email_empresa" id="cclave_email_empresa" type="password" size="50" value="<?= $cclave_email_empresa;?>"/> </td>
              </tr>
              <tr>
                <td><span class="texto_form">Parroquia</span></td>
                <td>
                  <select id="nid_localidad" name="nid_localidad" title="Seleccione una parroquia" required />
                    <option value="0">Seleccione la parroquia</option>
                    <?php
                      require_once('../clases/class_bd.php');
                      $pgsql=new Conexion();
                      $sql="SELECT nid_localidad,cdescripcion FROM general.tlocalidad WHERE ctabla='tparroquia'";
                      $query=$pgsql->Ejecutar($sql);
                      while ($row=$pgsql->Respuesta($query)){
                        if($row['nid_localidad']==$nid_localidad){
                          echo "<option value='".$row['nid_localidad']."' selected >".$row['cdescripcion']."</option>";
                        }else{
                          echo "<option value='".$row['nid_localidad']."'>".$row['cdescripcion']."</option>";
                        }
                      }
                    ?>
                  </select>
                </td>
                <td><span class="texto_form">Dirección</span></td>
                <td><textarea title="Ingrese la dirección de la empresa" name="cdireccion_empresa" id="cdireccion_empresa" rows="5" cols="50" required /><?= $cdireccion_empresa;?></textarea></td>
              </tr>
              <tr>
                <td><span class="texto_form">Misión</span></td>
                <td><textarea title="Ingrese la misión de la empresa" name="cmision" id="cmision" rows="8" cols="50" required /><?= $cmision;?></textarea></td>
                <td><span class="texto_form">Visión</span></td>
                <td><textarea title="Ingrese la visión de la empresa" name="cvision" id="cvision" rows="8" cols="50" required /><?= $cvision;?></textarea></td>
              </tr>
              <tr>
                <td><span class="texto_form">Objetivos</span></td>
                <td><textarea title="Ingrese los objetivos de la empresa" name="cobjetivo" id="cobjetivo" rows="8" cols="50" required /><?= $cobjetivo;?></textarea></td>
                <td><span class="texto_form">História</span></td>
                <td><textarea title="Ingrese la reseña histórica de la empresa" name="chistoria" id="chistoria" rows="8" cols="50" required /><?= $chistoria;?></textarea></td>
              </tr>
            </table>
            <table align="center">
              <tr>
                <td>
                  <center>
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                    <?php
                      imprimir_boton('disabled','',null,'empresa',"empresa");
                    ?>
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