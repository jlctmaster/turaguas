<?php
  
      require_once("../librerias/fpdf/fpdf.php");
   session_start();

   //Captura de Parámetros
   if(isset($_POST['dfecha_desde']))
    $dfecha_desde=$_POST['dfecha_desde'];

   if(isset($_POST['dfecha_hasta']))
    $dfecha_hasta=$_POST['dfecha_hasta'];

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
       $this->Cell(0,6,'CANTIDAD DE NOTAS DE RECEPCIONES POR PROVEEDOR',0,1,"C");
       $this->SetFont('Arial','',10);  
            $this->Cell(130);   
       $this->SetFont('Arial','B',10);
            $this->Cell(100,10,"FECHA DE EMISIÓN: ",0,0,'R',false);
       $this->SetFont('Arial','',10);  
            $this->Cell(32,10,date("d/m/y H:i:s"),0,1,'R',false);  
            $this->SetFont('Arial','',10);
       $this->Ln(8);
     
    
     $this->SetFillColor(0,0,140); 
         $avnzar=15;
         $altura=7;
         $anchura=10;
         $color_fondo=false;
         $this->SetFont('Arial','B',10);
         $this->SetTextColor(0,0,0);
                $this->Cell($avnzar);
      $this->Cell($anchura*4,$altura,'NÚMERO DE ÓRDEN',1,0,'L',$color_fondo); 
      $this->Cell($anchura*4,$altura,'RIF. PROVEEDOR',1,0,'L',$color_fondo); 
      $this->Cell($anchura*5,$altura,'NOMBRE PROVEEDOR',1,0,'L',$color_fondo); 
      $this->Cell($anchura*5,$altura,'DIRECCIÓN PROVEEDOR',1,0,'L',$color_fondo); 
      $this->Cell($anchura*3.5,$altura,'FECHA SOLICITUD',1,0,'L',$color_fondo); 
      $this->Cell($anchura*4,$altura,'FECHA RECEPCIÓN',1,1,'L',$color_fondo); 

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
      $rif="RIF. J-40133785-6";
      $this->Cell(130,4,$empresa,0,1,"C");
      $this->Cell($avanzar);  
      $this->Cell(130,4,$dir,0,1,"C");
      $this->Cell($avanzar);  
      $this->Cell(130,4,$rif,0,1,"C");
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
      $lobjPdf->SetWidths(array(40,40,50,50,35,40));
  require_once("../clases/class_bd.php");
  $pgsql=new Conexion();
    $sql="SELECT DISTINCT d.nnro_recepcion, prov.crif_persona, prov.cnombre, prov.cdireccion, 
    to_char(d.dfecha_documento,'DD/MM/YYYY') fechasolicitud,to_char(d.dfecha_recepcion,'DD/MM/YYYY') fecharecepcion
    From general.tpersona prov 
    Inner Join facturacion.vw_recepcion d On prov.crif_persona = d.crif_persona 
    WHERE d.dfecha_recepcion between '$dfecha_desde' and '$dfecha_hasta'";
$i=-1;
  $data=$pgsql->Ejecutar($sql);
    if($pgsql->Total_Filas($data)!=0){
         $lobjPdf->SetFillColor(0,0,140); 
         $avnzar=15;
         $altura=7;
         $anchura=10;
         $color_fondo=false;
         $lobjPdf->SetFont('Arial','B',10);
         //$lobjPdf->Row(array("N°","Codigo","Perfil","Estatus"));
         $lobjPdf->SetTextColor(0,0,0);
         $lobjPdf->SetFont('Arial','',8);
         $lobjPdf->SetTextColor(0,0,0); 
         $cant=0;
         while($tperfil=$pgsql->Respuesta($data)){
          $cant++;
         $lobjPdf->Row(array(
         ucwords($tperfil['nnro_recepcion']),
         ucwords($tperfil['crif_persona']),
         ucwords($tperfil['cnombre']),
         ucwords($tperfil['cdireccion']),
         ucwords($tperfil['fechasolicitud']),
         ucwords($tperfil['fecharecepcion'])));
          
          $lobjPdf->Cell($avnzar);         
         }
        $lobjPdf->SetWidths(array(35,40));
        $lobjPdf->Cell($avnzar*12);
        $lobjPdf->SetFont("arial","B",10);
        $lobjPdf->Row(array('TOTAL:',$cant));
         
         $lobjPdf->Output('documento',"I");
         }else{
            echo "ERROR AL GENERAR ESTE REPORTE!";          
          }
?>
