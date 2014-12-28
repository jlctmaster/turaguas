<?php
  
      require_once("../librerias/fpdf/fpdf.php");
      $servicio=$_GET['serv'];
   session_start();
  class clsFpdf extends FPDF {
     var $widths;
      var $aligns;
   //Cabecera de página
    public function Header()
    {
  
      $this->Image("../images/BANNER_TURAGUAS.jpg" , 25 ,15, 250 , 40, "JPG" ,$_SERVER['HTTP_HOST']."/turaguas/vistas/");
  $this->Image("../images/logo2.jpg" ,125,75,45,90, "JPG" ,$_SERVER['HTTP_HOST']."/turaguas/vistas/menu_principal");
   $this->Ln(55);  
   $this->SetFont('Arial','B',12);
   $this->Cell(0,6,'LISTADO DE LOS CONTACTOS DE LOS PROVEEDORES',0,1,"C");
   $this->Ln(8);
    
    
     $this->SetFillColor(0,0,140); 
         $avnzar=18;
         $altura=7;
         $anchura=10;
         $color_fondo=false;
         $this->SetFont('Arial','B',10);
         $this->SetTextColor(0,0,0);
                $this->Cell($avnzar); 
      $this->Cell($anchura*2,$altura,'RIF',1,0,'L',$color_fondo); 
      $this->Cell($anchura*4,$altura,'NOMBRE',1,0,'L',$color_fondo); 
      $this->Cell($anchura*4,$altura,'TELÉFONO',1,0,'L',$color_fondo);
      $this->Cell($anchura*3,$altura,'CARGO',1,0,'L',$color_fondo);
      $this->Cell($anchura*6,$altura,'DIRECCIÓN',1,0,'L',$color_fondo);
      $this->Cell($anchura*2+6,$altura,'ESTATUS',1,1,'L',$color_fondo); 
      
                  $this->Cell($avnzar); 
                  }

    //Pie de página
  public function Footer()
    {
      //Posición: a 2 cm del final
      $this->SetY(-20);
      //Arial italic 8
        $this->SetFont("Arial","I",8);
      //Dirección
      //Número de página
         $this->SetFont('Arial','',13);
           $this->SetFillColor(240,240,240);
            $this->SetTextColor(200, 200, 200);     
          $this->Cell(0,5,"______________________________________________________________________________________________________________",0,1,"C",false);
         $this->SetFont('Arial','',9);
        $this->SetTextColor(0,0,0);     
            $this->Cell(254);
            $this->Cell(25,8,'Página '.$this->PageNo()."/{nb}",0,1,'C',true);
      //Fecha
       
       //setlocale(LC_ALL,"es_VE.UTF8");
       $this->Ln(-7);
        $this->SetFont("Arial","I",6);
          $avanzar=70;
      $this->Cell($avanzar);
      $empresa="Empresa de Propiedad Social Indirecta Comunal \"El Futuro de las Turaguas\"";
      $dir="Dirección: AV. Los Agricultores diagonal a Maquinarias Cadelma al lado del Centro de Acopio de la \"GRAN MISIÓN VIVIENDA VENEZUELA\"";
      $tel="Teléfono: (+58) 0255-6234587";
      $this->Cell(130,4,$empresa,0,1,"C");
      $this->Cell($avanzar);  
      $this->Cell(130,4,$dir,0,1,"C");
      $this->Cell($avanzar);  
      $this->Cell(130,4,$tel,0,1,"C");
    }
    
      function SetWidths($w)
  {
      //Set the array of column widths
      $this->widths=$w;
  }

  function SetAligns($a)
  {
      //Set the array of column alignments
      $this->aligns=$a;
  }
 
  function Row($data)
  {
      //Calculate the height of the row
      $nb=0;
      for($i=0;$i<count($data);$i++)
          $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
      $h=5*$nb;
      //Issue a page break first if needed
      $this->CheckPageBreak($h);
      //Draw the cells of the row
      for($i=0;$i<count($data);$i++)
      {
          $w=$this->widths[$i];
          $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
          //Save the current position
          $x=$this->GetX();
          $y=$this->GetY();
          //Draw the border
          $this->Rect($x,$y,$w,$h);
          
          //Print the text
          if((count($data)-1)==$i && (strtolower($data[count($data)-1])=='desactivado'))        
          $this->SetTextColor(255, 0, 0);
          else 
          $this->SetTextColor(0, 0, 0);
          $this->MultiCell($w,5,$data[$i],0,$a);
          //Put the position to the right of the cell
          $this->SetXY($x+$w,$y);
      }
      //Go to the next line
      $this->Ln($h);
  }

  function CheckPageBreak($h)
  {
      //If the height h would cause an overflow, add a new page immediately
      if($this->GetY()+$h>$this->PageBreakTrigger)
          $this->AddPage($this->CurOrientation);
  }

  function NbLines($w,$txt)
  {
      //Computes the number of lines a MultiCell of width w will take
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
          $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r",'',$txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
          $nb--;
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $nl=1;
      while($i<$nb)
      {
          $c=$s[$i];
          if($c=="\n")
          {
              $i++;
              $sep=-1;
              $j=$i;
              $l=0;
              $nl++;
              continue;
          }
          if($c==' ')
              $sep=$i;
          $l+=$cw[$c];
          if($l>$wmax)
          {
              if($sep==-1)
              {
                  if($i==$j)
                      $i++;
              }
              else
                  $i=$sep+1;
              $sep=-1;
              $j=$i;
              $l=0;
              $nl++;
          }
          else
              $i++;
      }
      return $nl;
  }
}
    //generar el listado 
    setlocale(LC_ALL,"es_VE.UTF8");
   $lobjPdf=new clsFpdf();
   $lobjPdf->AddPage("L");
   $lobjPdf->AliasNbPages();

   $lobjPdf->SetFont("arial","B",8);
   
    $lobjPdf->SetFont('Arial','',12);
   //Table with 20 rows and 5 columns
      $lobjPdf->SetWidths(array(20,40,40,30,60,26));
  require_once("../clases/class_bd.php");
  $pgsql=new Conexion();

$sql="SELECT pc.crif_persona,pc.cnombre,d.cdireccion,pc.ccargo,pc.ctelefono,
      CASE WHEN p.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END estatus
      FROM general.tpersona p 
      INNER JOIN general.tdireccion_despacho d ON d.crif_persona = p.crif_persona 
      INNER JOIN general.tpersona_contacto pc on pc.nid_direcciondespacho=d.nid_direcciondespacho 
      INNER JOIN general.tcombo_valor v on p.ntipo_persona=v.nid_combovalor WHERE lower(v.cdescripcion) LIKE '%proveedor%'  
      ORDER BY pc.crif_persona DESC";
   $i=-1;
  $data=$pgsql->Ejecutar($sql);
    if($pgsql->Total_Filas($data)!=0){
         $lobjPdf->SetFillColor(0,0,140); 
         $avnzar=18;
         $altura=7;
         $anchura=10;
         $color_fondo=false;
         $lobjPdf->SetFont('Arial','B',10);
         $lobjPdf->SetTextColor(0,0,0);
         $lobjPdf->SetFont('Arial','',8);
         $lobjPdf->SetTextColor(0,0,0); 
         $xxxx=0;
         while($tperfil=$pgsql->Respuesta($data)){
         $lobjPdf->Row(array(
         ucwords($tperfil['crif_persona']),
         ucwords($tperfil['cnombre']),
         ucwords($tperfil['ctelefono']),
         ucwords($tperfil['ccargo']),
         ucwords($tperfil['cdireccion']),
         ucwords($tperfil['estatus'])));
          $lobjPdf->Cell($avnzar);         
         }
         
         $lobjPdf->Output('documento',"I");
         }else{
            echo "ERROR AL GENERAR ESTE REPORTE!";          
          }
?>
