<?php
    require_once("../librerias/fpdf/fpdf.php");
    $servicio=$_GET['serv'];
    include_once("pdf_".$servicio.'.php');
    session_start();
	class clsFpdf extends FPDF {
	   var $widths;
      var $aligns;
	 //Cabecera de página
		public function Header()
		{
	
       //$this->Image("../images/UDS.jpg" , 10 ,15, 40 , 40, "JPG" ,$_SERVER['HTTP_HOST']."/udesur/vistas/");
      $this->Image("../images/BANNER_TURAGUAS.jpg" , 10 ,5, 270 , 8, "JPG" ,$_SERVER['HTTP_HOST']."/turaguas/vistas/");
	    $this->Ln(25);	
	$this->Cell(0,6,"EL FUTUTO DE LAS TURAGUAS",0,1,"C");
   $this->SetFont('Arial','B',12);	
   $this->Cell(0,6,Titulo_Reporte(),0,1,"C");
   $this->Cell(0,6,"EL FUTUTO DE LAS TURAGUAS",0,1,"C");
   $this->Ln(2);
		}

		//Pie de página
	public function Footer()
		{
			//Posición: a 2 cm del final
			$this->SetY(-20);
			//Arial italic 8
			  $this->SetFont("Arial","I",12);
			//Dirección
			//Número de página
			//$this->Cell(0,5,utf8_decode("Pagina ").$this->PageNo()."/{nb}",0,1,"C");
			   $this->SetFont('Arial','',12);
	         $this->SetFillColor(240,240,240);
            $this->SetTextColor(200, 200, 200);			
		    	$this->Cell(0,5,utf8_decode("______________________________________________________________________________________________________________"),0,1,"C",false);
			   $this->SetFont('Arial','',12);
				$this->SetTextColor(0,0,0);			
            $this->Cell(254);
            $this->Cell(25,8,utf8_decode('Página ').$this->PageNo()."/{nb}",0,1,'C',true);
			//Fecha
       
		   //setlocale(LC_ALL,"es_VE.UTF8");
		   $this->Ln(-7);
			  $this->SetFont("Arial","I",12);
    	    $avanzar=23;
      $this->Cell($avanzar);	
      $uni="EMPRESA DE PROPIEDAD SOCIAL INDIRECTA COMUNAL EL FUTUTO DE LAS TURAGUAS.";
      //$dir="Dirección: Vía Manrique, Av. Universidad, Km. 2 (Villa Deportiva), San Carlos Estado Cojedes,República Bolivariana de Venezuela.";
      //$tel="Teléfono: (+58) 0258-4330349 (Control de Estudio), 4331518 (Rectorado)";
    	$this->Cell(130,10,utf8_decode($uni),0,1,"C");
    	$this->Cell($avanzar);	
    	//$this->Cell(130,4,utf8_decode($dir),0,1,"L");
    	//$this->Cell($avanzar);	
    	//$this->Cell(130,4,utf8_decode($tel),0,1,"L");
		
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
    $i=1;
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
		Generar_Reporte($servicio);
 
  ?>