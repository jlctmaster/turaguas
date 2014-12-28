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
    	$sql="SELECT DISTINCT TO_CHAR(sc.dfecha_documento,'DD/MM/YYYY') fecha,sc.nnro_solicitud 
		FROM facturacion.vw_solicitudcompra sc 
		WHERE sc.nnro_solicitud = '".$_GET['nnro_solicitud']."'";
		$data=$pgsql->Ejecutar($sql);
		$fila=array();
		while ($row=$pgsql->Respuesta($data)){
			$fila['fecha'][]=$row['fecha'];
			$fila['nnro_solicitud'][]=$row['nnro_solicitud'];
		}
		$r1  = $this->w - 81;
		$r2  = $r1 + 60;
		$y1  = 19;
		$y2  = $y1 -9;
		$this->SetFont('Arial','BU',12);
		$this->Cell(0,6,'SOLICITUD DE COMPRA',0,1,"C");
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
		$this->Cell($anchura*2,$altura,'Solicitud N°: ',0,1,'L',$color_fondo);
		$this->SetXY( $r1 + ($r2-$r1)/2, $y1+16 );
		$this->SetFont('Arial','',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,$fila['nnro_solicitud'][0],0,1,'L',$color_fondo);
		$this->Ln(15);
		$this->Cell($avnzar);
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,'Tipo de Artículo: ',0,0,'L',$color_fondo);
		$this->Cell($avnzar-8);
		$this->SetFont('Arial','',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,'Materia Prima',0,1,'L',$color_fondo);
	}

	//Pie de página
	public function Footer(){
		$this->SetFont( "Arial", "B", 10);
		$this->SetXY(28,-60);
		$this->Cell(1);
		$this->SetFillColor(140,140,140);
		$this->SetWidths(array(40,40,40,40));
		$this->Row(array('Elaborado por:','Revisado por:','Recibido por:','Aprobado por:'),true);
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
	$lobjPdf->Ln(20);
	require_once("../clases/class_bd.php");
	$pgsql=new Conexion();
	$sql="SELECT DISTINCT TO_CHAR(sc.dfecha_documento,'DD/MM/YYYY') fecha,sc.nnro_solicitud,sc.nlinea,sc.cid_articulo,a.cdescripcion articulo, 
	sc.ncantidad_articulo,CASE WHEN i.existencia IS NULL THEN 0 ELSE i.existencia END pdp,um.csimbolo 
	FROM facturacion.vw_solicitudcompra sc 
	INNER JOIN inventario.tarticulo a ON sc.cid_articulo = a.cid_articulo 
    INNER JOIN inventario.tpresentacion p ON a.nid_presentacion = p.nid_presentacion 
    INNER JOIN inventario.tunidad_medida um ON p.nid_unidadmedida = um.nid_unidadmedida 
	LEFT JOIN inventario.vw_inventario_productos i ON sc.cid_articulo = i.cid_articulo AND i.nid_estatus_inventario = (SELECT nid_combovalor FROM 
    general.tcombo_valor WHERE LOWER(cdescripcion) LIKE '%materia prima%')
	WHERE sc.nnro_solicitud = '".$_GET['nnro_solicitud']."' 
	ORDER BY nlinea ASC";
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
		$lobjPdf->Cell($avnzar);
		$lobjPdf->SetFont("arial","B",10);
		//Table with 20 rows and 5 columns
		$lobjPdf->SetWidths(array(10,30,60,20,10,20,10));
		$lobjPdf->Row(array('N°','Cod. Artículo','Descripción','Cantidad','UM','Punto de Pedido','UM'),false);
		$lobjPdf->SetFont("arial","",10);
		$lobjPdf->Cell($avnzar);
		while($rows=$pgsql->Respuesta($data)){
			$lobjPdf->Row(array(
			$rows['nlinea'],
			$rows['cid_articulo'],
			$rows['articulo'],
			$rows['ncantidad_articulo'],
			$rows['csimbolo'],
			$rows['pdp'],
			$rows['csimbolo']),false);
			$lobjPdf->Cell($avnzar);         
		}
		$lobjPdf->Output('documento',"I");
	}else{
		echo "ERROR AL GENERAR ESTE REPORTE!";          
	}
?>