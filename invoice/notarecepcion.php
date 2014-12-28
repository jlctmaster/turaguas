<?php
	require('fpdf.php');
	require_once("../clases/class_bd.php");
	class clsFpdf extends FPDF {
    var $widths;
    var $aligns;
   	//Cabecera de página
    public function Header(){
    	$this->Image("logo2.jpg" ,85,75,45,90, "JPG");
    	$pgsql=new Conexion();
    	$sql="SELECT DISTINCT TO_CHAR(r.dfecha_recepcion,'DD/MM/YYYY') fecha,r.nnro_recepcion 
		FROM facturacion.vw_recepcion r 
		WHERE r.nnro_recepcion = '".$_GET['nnro_recepcion']."'";
		$data=$pgsql->Ejecutar($sql);
		$fila=array();
		while ($row=$pgsql->Respuesta($data)){
			$fila['fecha'][]=$row['fecha'];
			$fila['nnro_recepcion'][]=$row['nnro_recepcion'];
		}
		$r1  = $this->w - 81;
		$r2  = $r1 + 60;
		$y1  = 19;
		$y2  = $y1 -9;
		$this->SetFont('Arial','BU',12);
		$this->Cell(0,6,'NOTA DE RECEPCIÓN',0,1,"C");
		$this->Ln(2);
		$this->SetFillColor(0,0,140); 
		$avnzar=18;
		$altura=4;
		$anchura=10;
		$color_fondo=false;
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($avnzar); 
		$this->Cell($anchura*2,$altura,"EMPRESA DE PROPIEDAD SOCIAL INDIRECTA",0,1,'L',$color_fondo);
		$this->Cell($avnzar); 
		$this->Cell($anchura*2,$altura,"COMUNAL \"EL FUTURO DE LAS TURAGUAS\"",0,1,'L',$color_fondo);
		$this->SetFont('Arial','',8); 
		$this->Cell($avnzar); 
		$this->Cell($anchura*2,$altura,'RIF.: J-40208964-3',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Av. Los Agricultores sector los pioneros, frente a',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Maquinarias Cadelma al lado del Centro de Acopio.',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Araure, Estado Portuguesa',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Telf.: 0255-6234587',0,1,'L',$color_fondo);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 1.5, 'D');
		$this->SetXY( $r1 + ($r2-$r1)/2 - 26, $y1+3 );
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,'Fecha: ',0,1,'L',$color_fondo);
		$this->SetXY( $r1 + ($r2-$r1)/2, $y1+3 );
		$this->SetFont('Arial','',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,$fila['fecha'][0],0,1,'R',$color_fondo);
		$this->RoundedRect($r1, $y1+13, ($r2 - $r1), $y2, 1.5, 'D');
		$this->SetXY( $r1 + ($r2-$r1)/2 - 26, $y1+16 );
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,'Nota N°: ',0,1,'L',$color_fondo);
		$this->SetXY( $r1 + ($r2-$r1)/2, $y1+16 );
		$this->SetFont('Arial','',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,$fila['nnro_recepcion'][0],0,1,'L',$color_fondo);
	}

	//Pie de página
	public function Footer(){
		$this->SetFont( "Arial", "B", 10);
		$this->SetXY(28,-60);
		$this->Cell(1);
		$this->SetFillColor(140,140,140);
		$this->SetWidths(array(40,40,40,40));
		$this->Row(array('Elaborado por:','Entregado por:','Placa del Vehículo:','Recibido por:'),true);
		$this->Cell(19);
		$this->SetFont("Arial","",10);
		$this->Row(array(''.ucwords(strtolower($_GET['nameuser'])).'','','',''),false);
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
		$this->Cell(170);
		$this->Cell(25,8,'Página '.$this->PageNo()."/{nb}",0,1,'C',true);
	}
    
	function SetWidths($w){
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a){
		//Set the array of column alignments
		$this->aligns=$a;
	}
 
	
	function Row($data,$color){
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++){
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
			$this->MultiCell($w,5,$data[$i],0,$a,$color);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h){
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt){
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
		while($i<$nb){
			$c=$s[$i];
			if($c=="\n"){
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
			if($l>$wmax){
				if($sep==-1){
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

	public function RoundedRect($x, $y, $w, $h, $r, $style = '')
	{
		$k = $this->k;
		$hp = $this->h;
		if($style=='F')
			$op='f';
		elseif($style=='FD' || $style=='DF')
			$op='B';
		else
			$op='S';
		$MyArc = 4/3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
		$xc = $x+$w-$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

		$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
		$xc = $x+$w-$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
		$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x+$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
		$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
		$xc = $x+$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
		$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	public function _Arc($x1, $y1, $x2, $y2, $x3, $y3){
		$h = $this->h;
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
		$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}
}

	//generar el listado 
	setlocale(LC_ALL,"es_VE.UTF8");
	$lobjPdf=new clsFpdf();
	$lobjPdf->AddPage("P");
	$lobjPdf->AliasNbPages();
	$lobjPdf->Ln(15);
	//Table with 20 rows and 5 columns
	$lobjPdf->SetWidths(array(10,30,68,23,30));
	require_once("../clases/class_bd.php");
	$pgsql=new Conexion();
	$sql="SELECT DISTINCT TO_CHAR(r.dfecha_documento,'DD/MM/YYYY') fechasolicitud,r.nnro_solicitud,r.nnro_factura, 
	r.nlinea,r.cid_articulo,a.cdescripcion articulo,r.ncantidad_articulo, um.csimbolo,
	substr(r.crif_persona,1,1)||'-'||substr(r.crif_persona,2,8)||'-'||substr(r.crif_persona,9,1) crif_persona,
	p.cnombre,p.cdireccion,substr(p.ctelefhab,1,4)||'-'||substr(p.ctelefhab,5,7) ctelefhab
	FROM facturacion.vw_recepcion r 
	INNER JOIN inventario.tarticulo a ON r.cid_articulo = a.cid_articulo 
    INNER JOIN inventario.tpresentacion pr ON a.nid_presentacion = pr.nid_presentacion 
    INNER JOIN inventario.tunidad_medida um ON pr.nid_unidadmedida = um.nid_unidadmedida 
	INNER JOIN general.tpersona p ON r.crif_persona = p.crif_persona 
	WHERE r.nnro_recepcion = '".$_GET['nnro_recepcion']."' 
	ORDER BY nlinea ASC";
	$i=-1;
	$data=$pgsql->Ejecutar($sql);
	if($pgsql->Total_Filas($data)!=0){
		$filas=array();
		while($rows=$pgsql->Respuesta($data)){
			$filas['fechasolicitud'][]=$rows['fechasolicitud'];
			$filas['nnro_solicitud'][]=$rows['nnro_solicitud'];
			$filas['nnro_factura'][]=$rows['nnro_factura'];
			$filas['nlinea'][]=$rows['nlinea'];
			$filas['cid_articulo'][]=$rows['cid_articulo'];
			$filas['articulo'][]=$rows['articulo'];
			$filas['ncantidad_articulo'][]=$rows['ncantidad_articulo'];
			$filas['csimbolo'][]=$rows['csimbolo'];
			$filas['almacen'][]=$rows['almacen'];
			$filas['crif_persona'][]=$rows['crif_persona'];
			$filas['cnombre'][]=$rows['cnombre'];
			$filas['cdireccion'][]=$rows['cdireccion'];
			$filas['ctelefhab'][]=$rows['ctelefhab'];
		}
		$lobjPdf->SetFillColor(0,0,140); 
		$avnzar=18;
		$altura=4;
		$anchura=10;
		$color_fondo=false;
		$lobjPdf->Cell($avnzar*1.95);
		$lobjPdf->SetFont('Arial','B',10);
		$lobjPdf->SetTextColor(0,0,0);
		$lobjPdf->Cell($anchura*2,$altura,'Razón Social: ',0,0,'R',$color_fondo);
		$lobjPdf->SetFont('Arial','',9);
		$lobjPdf->SetTextColor(0,0,0); 
		$lobjPdf->Cell($anchura*2,$altura,$filas['cnombre'][0],0,1,'L',$color_fondo);
		$lobjPdf->Cell($avnzar*1.61);
		$lobjPdf->SetFont('Arial','B',10);
		$lobjPdf->SetTextColor(0,0,0);
		$lobjPdf->Cell($anchura*2,$altura,'RIF: ',0,0,'L',$color_fondo);
		$lobjPdf->SetFont('Arial','',9);
		$lobjPdf->SetTextColor(0,0,0); 
		$lobjPdf->Cell($avnzar-11);
		$lobjPdf->Cell($anchura*2,$altura,$filas['crif_persona'][0],0,0,'L',$color_fondo);
		$lobjPdf->Cell($avnzar+15);
		$lobjPdf->SetFont('Arial','B',10);
		$lobjPdf->SetTextColor(0,0,0);
		$lobjPdf->Cell($anchura*2,$altura,'Telf: ',0,0,'L',$color_fondo);
		$lobjPdf->SetFont('Arial','',9);
		$lobjPdf->SetTextColor(0,0,0); 
		$lobjPdf->Cell($avnzar-25);
		$lobjPdf->Cell($anchura*1,$altura,$filas['ctelefhab'][0],0,1,'L',$color_fondo);
		$lobjPdf->Cell($avnzar*1.61);
		$lobjPdf->SetFont('Arial','B',10);
		$lobjPdf->SetTextColor(0,0,0);
		$lobjPdf->Cell($anchura*2,$altura,'Dirección: ',0,0,'L',$color_fondo);
		$lobjPdf->SetFont('Arial','',9);
		$lobjPdf->SetTextColor(0,0,0); 
		$lobjPdf->Cell($avnzar-11);
		$lobjPdf->Cell($anchura*10,$altura,$filas['cdireccion'][0],0,1,'L',$color_fondo);
		$lobjPdf->Cell($avnzar*1.61);
		$lobjPdf->SetFont('Arial','B',10);
		$lobjPdf->SetTextColor(0,0,0);
		$lobjPdf->Cell($anchura*2,$altura,'N° Solicitud Asociada: ',0,0,'L',$color_fondo);
		$lobjPdf->SetFont('Arial','',9);
		$lobjPdf->SetTextColor(0,0,0); 
		$lobjPdf->Cell($avnzar+3);
		$lobjPdf->Cell($anchura*2,$altura,$filas['nnro_solicitud'][0],0,0,'L',$color_fondo);
		$lobjPdf->Cell($avnzar*1);
		$lobjPdf->SetFont('Arial','B',10);
		$lobjPdf->SetTextColor(0,0,0);
		$lobjPdf->Cell($anchura*2,$altura,'Fecha de Solicitud Asociada: ',0,0,'L',$color_fondo);
		$lobjPdf->SetFont('Arial','',9);
		$lobjPdf->SetTextColor(0,0,0); 
		$lobjPdf->Cell($avnzar+15);
		$lobjPdf->Cell($anchura*2,$altura,$filas['fechasolicitud'][0],0,1,'L',$color_fondo);
		$lobjPdf->Cell($avnzar*1.61);
		$lobjPdf->SetFont('Arial','B',10);
		$lobjPdf->SetTextColor(0,0,0);
		$lobjPdf->Cell($anchura*2,$altura,'N° Factura Asociada: ',0,0,'L',$color_fondo);
		$lobjPdf->SetFont('Arial','',9);
		$lobjPdf->SetTextColor(0,0,0); 
		$lobjPdf->Cell($avnzar+3);
		$lobjPdf->Cell($anchura*2,$altura,$filas['nnro_factura'][0],0,0,'L',$color_fondo);
		$lobjPdf->Ln(20);
		$lobjPdf->Cell($avnzar);
		$lobjPdf->SetFont("arial","B",10);
		$lobjPdf->Row(array('N°','Cod. Artículo','Descripción','Cantidad','UM'),false);
		$lobjPdf->SetFont("arial","",10);
		$lobjPdf->Cell($avnzar);
		for($i=0;$i<count($filas['nnro_solicitud']);$i++){
			$lobjPdf->Row(array(
			$filas['nlinea'][$i],
			$filas['cid_articulo'][$i],
			$filas['articulo'][$i],
			$filas['ncantidad_articulo'][$i],
			$filas['csimbolo'][$i]),false);
			$lobjPdf->Cell($avnzar);         
		}
		$lobjPdf->Output('documento',"I");
	}else{
		echo "ERROR AL GENERAR ESTE REPORTE!";          
	}
?>