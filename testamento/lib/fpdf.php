<?php
/*******************************************************************************
* FPDF                                                                          *
* Version: 1.86                                                                 *
* Date:    2023-05-20                                                            *
* Author:  Olivier PLATHEY                                                       *
* License: Free / Public domain                                                  *
*******************************************************************************/

define('FPDF_VERSION','1.86');

class FPDF {
protected $page, $n, $offsets, $buffer, $pages, $state, $compress, $k, $DefOrientation;
protected $CurOrientation, $StdPageSizes, $DefPageSize, $CurPageSize, $CurRotation;
protected $PageInfo, $wPt, $hPt, $w, $h, $lMargin, $tMargin, $rMargin, $bMargin;
protected $CellMargin, $x, $y, $lasth, $LineWidth, $fontpath, $CoreFonts, $fonts;
protected $FontFiles, $encodings, $cmaps, $FontFamily, $FontStyle, $underline;
protected $CurrentFont, $FontSizePt, $FontSize, $DrawColor, $FillColor, $TextColor;
protected $ColorFlag, $WithAlpha, $ws, $images, $links, $AutoPageBreak;
protected $PageBreakTrigger, $InHeader, $InFooter, $AliasNbPages, $ZoomMode;
protected $LayoutMode, $metadata, $PDFVersion;

function __construct($orientation='P', $unit='mm', $size='A4') {
    $this->_dochecks();
    $this->page = 0;
    $this->n = 2;
    $this->buffer = '';
    $this->pages = [];
    $this->PageInfo = [];
    $this->fonts = [];
    $this->FontFiles = [];
    $this->encodings = [];
    $this->cmaps = [];
    $this->images = [];
    $this->links = [];
    $this->InHeader = false;
    $this->InFooter = false;
    $this->lasth = 0;
    $this->FontFamily = '';
    $this->FontStyle = '';
    $this->FontSizePt = 12;
    $this->underline = false;
    $this->DrawColor = '0 G';
    $this->FillColor = '0 g';
    $this->TextColor = '0 g';
    $this->ColorFlag = false;
    $this->WithAlpha = false;
    $this->ws = 0;
    // Font path
    if(defined('FPDF_FONTPATH'))
        $this->fontpath = FPDF_FONTPATH;
    elseif(is_dir(dirname(__FILE__).'/font'))
        $this->fontpath = dirname(__FILE__).'/font/';
    else
        $this->fontpath = '';
    // Core fonts
    $this->CoreFonts = ['courier','helvetica','arial','times','symbol','zapfdingbats'];
    // Scale factor
    $unit = strtolower($unit);
    if($unit=='pt') $this->k = 1;
    elseif($unit=='mm') $this->k = 72/25.4;
    elseif($unit=='cm') $this->k = 72/2.54;
    elseif($unit=='in') $this->k = 72;
    else $this->Error('Incorrect unit: '.$unit);
    // Page sizes
    $this->StdPageSizes = ['a3'=>[841.89,1190.55],'a4'=>[595.28,841.89],'a5'=>[420.94,595.28],
        'letter'=>[612,792],'legal'=>[612,1008]];
    $size = $this->_getpagesize($size);
    $this->DefPageSize = $size;
    $this->CurPageSize = $size;
    // Page orientation
    $orientation = strtolower($orientation);
    if($orientation=='p' || $orientation=='portrait') {
        $this->DefOrientation = 'P';
        $this->w = $size[0];
        $this->h = $size[1];
    } elseif($orientation=='l' || $orientation=='landscape') {
        $this->DefOrientation = 'L';
        $this->w = $size[1];
        $this->h = $size[0];
    } else $this->Error('Incorrect orientation: '.$orientation);
    $this->CurOrientation = $this->DefOrientation;
    $this->wPt = $this->w*$this->k;
    $this->hPt = $this->h*$this->k;
    // Page rotation
    $this->CurRotation = 0;
    // Page margins (1 cm)
    $margin = 28.35/$this->k;
    $this->SetMargins($margin,$margin);
    // Interior cell margin (1 mm)
    $this->CellMargin = $this->k<=1 ? 1 : 1/$this->k*$this->k;
    // Line width (0.2 mm)
    $this->LineWidth = .567/$this->k;
    // Automatic page break
    $this->SetAutoPageBreak(true,2*$margin);
    // Default display mode
    $this->SetDisplayMode('default');
    // Enable compression
    $this->SetCompression(true);
    // Metadata
    $this->metadata = ['Producer'=>'FPDF '.FPDF_VERSION];
    // Set default PDF version number
    $this->PDFVersion = '1.3';
}

function SetMargins($left, $top, $right=-1) {
    $this->lMargin = $left;
    $this->tMargin = $top;
    if($right==-1) $right = $left;
    $this->rMargin = $right;
}
function SetLeftMargin($margin) { if($this->page>0 && $this->x<$margin) $this->x=$margin; $this->lMargin=$margin; }
function SetTopMargin($margin) { $this->tMargin=$margin; }
function SetRightMargin($margin) { $this->rMargin=$margin; }
function SetAutoPageBreak($auto, $margin=0) { $this->AutoPageBreak=$auto; $this->bMargin=$margin; $this->PageBreakTrigger=$this->h-$margin; }
function SetDisplayMode($zoom, $layout='default') { $this->ZoomMode=$zoom; $this->LayoutMode=$layout; }
function SetCompression($compress) { $this->compress=function_exists('gzcompress')?$compress:false; }
function SetTitle($title, $isUTF8=false) { $this->metadata['Title']=$isUTF8?$title:utf8_encode($title); }
function SetAuthor($author, $isUTF8=false) { $this->metadata['Author']=$isUTF8?$author:utf8_encode($author); }
function SetSubject($subject, $isUTF8=false) { $this->metadata['Subject']=$isUTF8?$subject:utf8_encode($subject); }
function SetKeywords($keywords, $isUTF8=false) { $this->metadata['Keywords']=$isUTF8?$keywords:utf8_encode($keywords); }
function SetCreator($creator, $isUTF8=false) { $this->metadata['Creator']=$isUTF8?$creator:utf8_encode($creator); }
function AliasNbPages($alias='{nb}') { $this->AliasNbPages=$alias; }
function Error($msg) { throw new Exception('FPDF error: '.$msg); }
function Close() {
    if($this->state==3) return;
    if($this->page==0) $this->AddPage();
    $this->InFooter = true;
    $this->Footer();
    $this->InFooter = false;
    $this->_endpage();
    $this->_enddoc();
}
function AddPage($orientation='', $size='', $rotation=0) {
    if($this->state==3) $this->Error('The document is closed');
    $family = $this->FontFamily;
    $style = $this->FontStyle.($this->underline ? 'U' : '');
    $fontsize = $this->FontSizePt;
    $lw = $this->LineWidth;
    $dc = $this->DrawColor;
    $fc = $this->FillColor;
    $tc = $this->TextColor;
    $cf = $this->ColorFlag;
    if($this->page>0) {
        $this->InFooter = true;
        $this->Footer();
        $this->InFooter = false;
        $this->_endpage();
    }
    $this->_beginpage($orientation,$size,$rotation);
    $this->_out('2 J');
    $this->LineWidth = $lw;
    $this->_out(sprintf('%.2F w',$lw*$this->k));
    if($family) $this->SetFont($family,$style,$fontsize);
    $this->DrawColor = $dc;
    if($dc!='0 G') $this->_out($dc);
    $this->FillColor = $fc;
    if($fc!='0 g') $this->_out($fc);
    $this->TextColor = $tc;
    $this->ColorFlag = $cf;
    $this->InHeader = true;
    $this->Header();
    $this->InHeader = false;
    if($this->LineWidth!=$lw) { $this->LineWidth=$lw; $this->_out(sprintf('%.2F w',$lw*$this->k)); }
    if($family) $this->SetFont($family,$style,$fontsize);
    if($this->DrawColor!=$dc) { $this->DrawColor=$dc; $this->_out($dc); }
    if($this->FillColor!=$fc) { $this->FillColor=$fc; $this->_out($fc); }
    $this->TextColor = $tc;
    $this->ColorFlag = $cf;
}
function Header() {}
function Footer() {}
function PageNo() { return $this->page; }
function SetDrawColor($r, $g=-1, $b=-1) {
    if(($r==0 && $g==0 && $b==0) || $g==-1) $this->DrawColor=sprintf('%.3F G',$r/255);
    else $this->DrawColor=sprintf('%.3F %.3F %.3F RG',$r/255,$g/255,$b/255);
    if($this->page>0) $this->_out($this->DrawColor);
}
function SetFillColor($r, $g=-1, $b=-1) {
    if(($r==0 && $g==0 && $b==0) || $g==-1) $this->FillColor=sprintf('%.3F g',$r/255);
    else $this->FillColor=sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
    $this->ColorFlag = ($this->FillColor!=$this->TextColor);
    if($this->page>0) $this->_out($this->FillColor);
}
function SetTextColor($r, $g=-1, $b=-1) {
    if(($r==0 && $g==0 && $b==0) || $g==-1) $this->TextColor=sprintf('%.3F g',$r/255);
    else $this->TextColor=sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
    $this->ColorFlag = ($this->FillColor!=$this->TextColor);
}
function GetStringWidth($s) { $s=(string)$s; $cw=&$this->CurrentFont['cw']; $w=0; $l=strlen($s); for($i=0;$i<$l;$i++) $w+=$cw[ord($s[$i])]; return $w*$this->FontSize/1000; }
function SetLineWidth($width) { $this->LineWidth=$width; if($this->page>0) $this->_out(sprintf('%.2F w',$width*$this->k)); }
function Line($x1, $y1, $x2, $y2) { $this->_out(sprintf('%.2F %.2F m %.2F %.2F l S',$x1*$this->k,($this->h-$y1)*$this->k,$x2*$this->k,($this->h-$y2)*$this->k)); }
function Rect($x, $y, $w, $h, $style='') { if($style=='F') $op='f'; elseif($style=='FD'||$style=='DF') $op='B'; else $op='S'; $this->_out(sprintf('%.2F %.2F %.2F %.2F re %s',$x*$this->k,($this->h-$y)*$this->k,$w*$this->k,-$h*$this->k,$op)); }
function AddFont($family, $style='', $file='', $encoded=false) { /* simplified */ }
function SetFont($family, $style='', $size=0) {
    $family = strtolower($family);
    if($family=='') $family=$this->FontFamily;
    if($family=='arial') $family='helvetica';
    $style = strtoupper($style);
    if(strpos($style,'U')!==false) { $this->underline=true; $style=str_replace('U','',$style); } else $this->underline=false;
    if($style=='IB') $style='BI';
    if($size==0) $size=$this->FontSizePt;
    if($this->FontFamily==$family && $this->FontStyle==$style && $this->FontSizePt==$size) return;
    $fontkey=$family.$style;
    if(!isset($this->fonts[$fontkey])) {
        if(!in_array($family,$this->CoreFonts)) $this->Error('Undefined font: '.$family.' '.$style);
        $name = ['courier'=>'Courier','helvetica'=>'Helvetica','arial'=>'Helvetica','times'=>'Times','symbol'=>'Symbol','zapfdingbats'=>'ZapfDingbats'];
        $n = count($this->fonts)+1;
        $cw = $this->_getcorefontwidths($family);
        $this->fonts[$fontkey] = ['i'=>$n,'type'=>'core','name'=>$name[$family].($style?'-'.$style:''),'up'=>-100,'ut'=>50,'cw'=>$cw];
    }
    $this->FontFamily=$family; $this->FontStyle=$style; $this->FontSizePt=$size;
    $this->FontSize=$size/$this->k;
    $this->CurrentFont=&$this->fonts[$fontkey];
    if($this->page>0) $this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}
function SetFontSize($size) { if($this->FontSizePt==$size) return; $this->FontSizePt=$size; $this->FontSize=$size/$this->k; if($this->page>0) $this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt)); }
function CreateLink() { $n=count($this->links)+1; $this->links[$n]=[0,0]; return $n; }
function SetLink($link, $y=0, $page=-1) { if($y==-1) $y=$this->y; if($page==-1) $page=$this->page; $this->links[$link]=[$page,$y]; }
function AddLink() { return $this->CreateLink(); }
function Write($h, $txt, $link='') { $this->_write($h,$txt,$link); }
function Ln($h='') { if(is_string($h)) $h=$this->lasth; $this->x=$this->lMargin; $this->y+=$h; }
function Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='') { /* simplified placeholder */ }
function GetX() { return $this->x; }
function SetX($x) { $this->x=($x>=0)?$x:$this->w+$x; }
function GetY() { return $this->y; }
function SetY($y, $resetX=true) { if($y>=0) $this->y=$y; else $this->y=$this->h+$y; if($resetX) $this->x=$this->lMargin; }
function SetXY($x, $y) { $this->SetX($x); $this->SetY($y,false); }
function Output($dest='', $name='', $isUTF8=false) {
    $this->Close();
    if(strlen($name)==1 && strlen($dest)!=1) { $tmp=$dest; $dest=$name; $name=$tmp; }
    $dest=strtoupper($dest);
    if($dest=='') { if(php_sapi_name()!='cli') { $dest='I'; } else { $dest='F'; if($name=='') $name='doc.pdf'; } }
    switch($dest) {
        case 'I':
            $this->_checkoutput();
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="'.($name?$name:'doc.pdf').'"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            echo $this->buffer;
            break;
        case 'D':
            $this->_checkoutput();
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.($name?$name:'doc.pdf').'"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            echo $this->buffer;
            break;
        case 'F':
            if(!file_put_contents($name,$this->buffer)) $this->Error('Unable to create output file: '.$name);
            break;
        case 'S':
            return $this->buffer;
        default:
            $this->Error('Incorrect output destination: '.$dest);
    }
    return '';
}

// ── Cell & MultiCell ──────────────────────────────────────────────
function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
    $k=$this->k;
    if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AutoPageBreak) { $x=$this->x; $ws=$this->ws; if($ws>0) { $this->ws=0; $this->_out('0 Tw'); } $this->AddPage($this->CurOrientation,$this->CurPageSize,$this->CurRotation); $this->x=$x; if($ws>0) { $this->ws=$ws; $this->_out(sprintf('%.3F Tw',$ws*$k)); } }
    if($w==0) $w=$this->w-$this->rMargin-$this->x;
    $s='';
    if($fill || $border==1) { if($fill) $op=($border==1)?'B':'f'; else $op='S'; $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op); }
    if(is_string($border)) { $x=$this->x; $y=$this->y; if(strpos($border,'L')!==false) $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k); if(strpos($border,'T')!==false) $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k); if(strpos($border,'R')!==false) $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k); if(strpos($border,'B')!==false) $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k); }
    if($txt!=='') {
        if(!isset($this->CurrentFont)) $this->Error('No font has been set');
        if($align=='R') $dx=$w-$this->CellMargin-$this->GetStringWidth($txt);
        elseif($align=='C') $dx=($w-$this->GetStringWidth($txt))/2;
        else $dx=$this->CellMargin;
        if($this->ColorFlag) $s.='q '.$this->TextColor.' ';
        $s.=sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$this->_escape($txt));
        if($this->underline) $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
        if($this->ColorFlag) $s.=' Q';
        if($link) $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$this->GetStringWidth($txt),$this->FontSize,$link);
    }
    if($s) $this->_out($s);
    $this->lasth=$h;
    if($ln>0) { $this->y+=$h; if($ln==1) $this->x=$this->lMargin; } else $this->x+=$w;
}

function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false) {
    if(!isset($this->CurrentFont)) $this->Error('No font has been set');
    $cw=&$this->CurrentFont['cw'];
    if($w==0) $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->CellMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',(string)$txt);
    $nb=strlen($s);
    if($nb>0 && $s[$nb-1]=="\n") $nb--;
    $b=0;
    if($border) { if($border==1) { $border='LTRB'; $b='LRT'; $b2='LR'; } else { $b2=''; if(strpos($border,'L')!==false) $b2.='L'; if(strpos($border,'R')!==false) $b2.='R'; $b=((strpos($border,'T')!==false)?$b2.'T':$b2); } }
    $sep=-1; $i=0; $j=0; $l=0; $ns=0; $nl=1;
    while($i<$nb) {
        $c=$s[$i];
        if($c=="\n") { if($this->ws>0) { $this->ws=0; $this->_out('0 Tw'); } $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill); $i++; $sep=-1; $j=$i; $l=0; $ns=0; $nl++; if($border && $nl==2) $b=$b2; continue; }
        if($c==' ') { $sep=$i; $ls=$l; $ns++; }
        $l+=$cw[ord($c)];
        if($l>$wmax) {
            if($sep==-1) { if($i==$j) $i++; if($this->ws>0) { $this->ws=0; $this->_out('0 Tw'); } $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill); } else { if($align=='J') { $this->ws=(($ns>1)?($wmax-$ls+$cw[ord(' ')])/($ns-1)/1000*$this->FontSize:0); $this->_out(sprintf('%.3F Tw',$this->ws*$this->k)); } $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill); $i=$sep+1; } $sep=-1; $j=$i; $l=0; $ns=0; $nl++; if($border && $nl==2) $b=$b2;
        } else $i++;
    }
    if($this->ws>0) { $this->ws=0; $this->_out('0 Tw'); }
    if($border && strpos($border,'B')!==false) $b.='B';
    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    $this->x=$this->lMargin;
}

// ── Internal helpers ──────────────────────────────────────────────
protected function _write($h, $txt, $link='') {
    $cw=&$this->CurrentFont['cw'];
    $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->CellMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    $sep=-1; $i=0; $j=0; $l=0; $nl=1;
    while($i<$nb) {
        $c=$s[$i];
        if($c=="\n") { $this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',false,$link); $i++; $sep=-1; $j=$i; $l=0; if($nl==1) { $this->x=$this->lMargin; $w=$this->w-$this->rMargin-$this->x; $wmax=($w-2*$this->CellMargin)*1000/$this->FontSize; } $nl++; continue; }
        if($c==' ') $sep=$i;
        $l+=$cw[ord($c)];
        if($l>$wmax) { if($sep==-1) { if($this->x>$this->lMargin) { $this->x=$this->lMargin; $this->y+=$h; $w=$this->w-$this->rMargin-$this->x; $wmax=($w-2*$this->CellMargin)*1000/$this->FontSize; $i++; $nl++; continue; } if($i==$j) $i++; $this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',false,$link); } else { $this->Cell($w,$h,substr($s,$j,$sep-$j),0,2,'',false,$link); $i=$sep+1; } $sep=-1; $j=$i; $l=0; if($nl==1) { $this->x=$this->lMargin; $w=$this->w-$this->rMargin-$this->x; $wmax=($w-2*$this->CellMargin)*1000/$this->FontSize; } $nl++; } else $i++;
    }
    if($i!=$j) $this->Cell($l/1000*$this->FontSize,$h,substr($s,$j),0,0,'',false,$link);
}

protected function _dochecks() { if(PHP_INT_SIZE<8) $this->Error('64-bit PHP required'); }
protected function _checkoutput() { if(PHP_SAPI!='cli') { if(headers_sent($file,$line)) $this->Error("Some data has already been output to browser, can't send PDF file (output started at $file:$line)"); if(ob_get_length()) { if(preg_match('/^(\xEF\xBB\xBF)?\s*$/',ob_get_contents())) ob_clean(); else $this->Error("Some data has already been output to browser, can't send PDF file"); } } }
protected function _getpagesize($size) { if(is_string($size)) { $size=strtolower($size); if(!isset($this->StdPageSizes[$size])) $this->Error('Unknown page size: '.$size); $a=$this->StdPageSizes[$size]; return [$a[0]/$this->k,$a[1]/$this->k]; } else { if($size[0]>$size[1]) return [$size[1],$size[0]]; else return $size; } }
protected function _beginpage($orientation, $size, $rotation) {
    $this->page++;
    $this->pages[$this->page]='';
    $this->PageInfo[$this->page]=[];
    $this->state=2;
    $this->x=$this->lMargin;
    $this->y=$this->tMargin;
    $this->FontFamily='';
    if($orientation=='') $orientation=$this->DefOrientation; else $orientation=strtoupper($orientation[0]);
    if($size=='') $size=$this->DefPageSize; else $size=$this->_getpagesize($size);
    if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1]) {
        if($orientation=='P') { $this->w=$size[0]; $this->h=$size[1]; } else { $this->w=$size[1]; $this->h=$size[0]; }
        $this->wPt=$this->w*$this->k; $this->hPt=$this->h*$this->k;
        $this->PageBreakTrigger=$this->h-$this->bMargin;
        $this->CurOrientation=$orientation; $this->CurPageSize=$size;
    }
    if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1])
        $this->PageInfo[$this->page]['size']=[$this->wPt,$this->hPt];
    if($rotation!=0) { if($rotation%90!=0) $this->Error('Incorrect rotation value: '.$rotation); $this->CurRotation=$rotation; $this->PageInfo[$this->page]['rotation']=$rotation; }
}
protected function _endpage() { $this->state=1; }
protected function _escape($s) { $s=str_replace('\\','\\\\',$s); $s=str_replace(')','\\)',$s); $s=str_replace('(','\\(',$s); $s=str_replace("\r",'\\r',$s); return $s; }
protected function _textstring($s) { if(!$this->_isascii($s)) $s=$this->_UTF8toUTF16($s); return '('.$this->_escape($s).')'; }
protected function _isascii($s) { $nb=strlen($s); for($i=0;$i<$nb;$i++) { if(ord($s[$i])>127) return false; } return true; }
protected function _UTF8toUTF16($s) { $res="\xFE\xFF"; $nb=strlen($s); $i=0; while($i<$nb) { $c1=ord($s[$i++]); if($c1>=224) { $c2=ord($s[$i++]); $c3=ord($s[$i++]); $res.=chr((($c1&0x0F)<<4)+(($c2&0x3C)>>2)).chr((($c2&0x03)<<6)+($c3&0x3F)); } elseif($c1>=192) { $c2=ord($s[$i++]); $res.=chr(($c1&0x1F)>>2).chr((($c1&0x03)<<6)+($c2&0x3F)); } else $res.="\x00".chr($c1); } return $res; }
protected function _dounderline($x, $y, $txt) { $up=$this->CurrentFont['up']; $ut=$this->CurrentFont['ut']; $w=$this->GetStringWidth($txt)+$this->ws*substr_count($txt,' '); return sprintf('%.2F %.2F %.2F %.2F re f',$x*$this->k,($this->h-($y-$up/1000*$this->FontSize))*$this->k,$w*$this->k,-$ut/1000*$this->FontSizePt); }
protected function _out($s) { if($this->state==2) $this->pages[$this->page].=$s."\n"; elseif($this->state==1) $this->_put($s); elseif($this->state==0) $this->Error('No page has been added yet'); elseif($this->state==3) $this->Error('The document is closed'); }
protected function _put($s) { $this->buffer.=$s."\n"; }
protected function _newobj($n=null) { if($n===null) $n=++$this->n; $this->offsets[$n]=strlen($this->buffer); $this->_put($n.' 0 obj'); }
protected function _putstream($data) { $this->_put('stream'); $this->_put($data); $this->_put('endstream'); }
protected function _putstreamobj($data) { if($this->compress) $data=gzcompress($data); $this->_newobj(); $this->_put('<<'); if($this->compress) $this->_put('/Filter /FlateDecode'); $this->_put('/Length '.strlen($data)); $this->_put('>>'); $this->_putstream($data); $this->_put('endobj'); }
protected function _putlinks($n) {}
protected function _putpage($n) {
    $this->_newobj();
    $this->_put('<</Type /Page');
    $this->_put('/Parent 1 0 R');
    if(isset($this->PageInfo[$n]['size'])) $this->_put(sprintf('/MediaBox [0 0 %.2F %.2F]',$this->PageInfo[$n]['size'][0],$this->PageInfo[$n]['size'][1]));
    if(isset($this->PageInfo[$n]['rotation'])) $this->_put('/Rotate '.$this->PageInfo[$n]['rotation']);
    $this->_put('/Resources 2 0 R');
    $this->_putlinks($n);
    $this->_put('/Contents '.($this->n+1).' 0 R>>');
    $this->_put('endobj');
    if(!empty($this->AliasNbPages)) $this->pages[$n]=str_replace($this->AliasNbPages,$this->page,$this->pages[$n]);
    $this->_putstreamobj($this->pages[$n]);
}
protected function _putpages() {
    $nb=$this->page;
    $refs='';
    for($n=1;$n<=$nb;$n++) { $this->PageInfo[$n]['n']=$this->n+1+2*($n-1); $refs.=$this->PageInfo[$n]['n'].' 0 R '; }
    $this->_newobj(1);
    $this->_put('<</Type /Pages');
    $this->_put('/Kids ['.$refs.']');
    $this->_put('/Count '.$nb);
    if($this->DefOrientation=='P') { $w=$this->DefPageSize[0]; $h=$this->DefPageSize[1]; } else { $w=$this->DefPageSize[1]; $h=$this->DefPageSize[0]; }
    $this->_put(sprintf('/MediaBox [0 0 %.2F %.2F]',$w*$this->k,$h*$this->k));
    $this->_put('>>');
    $this->_put('endobj');
    for($n=1;$n<=$nb;$n++) $this->_putpage($n);
}
protected function _putfonts() {
    foreach($this->fonts as $k=>$font) {
        $this->_newobj();
        $this->fonts[$k]['n']=$this->n;
        $this->_put('<</Type /Font');
        if($font['type']=='core') {
            $this->_put('/Subtype /Type1');
            $this->_put('/BaseFont /'.$font['name']);
            if($font['name']!='Symbol' && $font['name']!='ZapfDingbats') $this->_put('/Encoding /WinAnsiEncoding');
        }
        $this->_put('>>');
        $this->_put('endobj');
    }
}
protected function _putimages() {}
protected function _putxobjectdict() {}
protected function _putresourcedict() {
    $this->_put('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
    $this->_put('/Font <<');
    foreach($this->fonts as $font) $this->_put('/F'.$font['i'].' '.$font['n'].' 0 R');
    $this->_put('>>');
    $this->_put('/XObject <<');
    $this->_putxobjectdict();
    $this->_put('>>');
}
protected function _putresources() {
    $this->_putfonts();
    $this->_putimages();
    $this->_newobj(2);
    $this->_put('<<');
    $this->_putresourcedict();
    $this->_put('>>');
    $this->_put('endobj');
}
protected function _putinfo() {
    $this->metadata['Producer']='FPDF '.FPDF_VERSION;
    $this->metadata['CreationDate']='D:'.@date('YmdHis');
    foreach($this->metadata as $key=>$value)
        $this->_put('/'.$key.' '.$this->_textstring($value));
}
protected function _putcatalog() { $n=$this->PageInfo[1]['n']; $this->_put('/Type /Catalog'); $this->_put('/Pages 1 0 R'); if($this->ZoomMode=='fullpage') $this->_put('/OpenAction ['.$n.' 0 R /Fit]'); elseif($this->ZoomMode=='fullwidth') $this->_put('/OpenAction ['.$n.' 0 R /FitH null]'); elseif($this->ZoomMode=='real') $this->_put('/OpenAction ['.$n.' 0 R /XYZ null null 1]'); elseif(!is_string($this->ZoomMode)) $this->_put('/OpenAction ['.$n.' 0 R /XYZ null null '.sprintf('%.2F',$this->ZoomMode/100).']'); if($this->LayoutMode=='single') $this->_put('/PageLayout /SinglePage'); elseif($this->LayoutMode=='continuous') $this->_put('/PageLayout /OneColumn'); elseif($this->LayoutMode=='two') $this->_put('/PageLayout /TwoColumnLeft'); }
protected function _putheader() { $this->_put('%PDF-'.$this->PDFVersion); }
protected function _puttrailer() { $this->_put('/Size '.($this->n+1)); $this->_put('/Root '.$this->n.' 0 R'); $this->_put('/Info '.($this->n-1).' 0 R'); }
protected function _enddoc() {
    $this->state=3;
    $this->_putheader();
    $this->_putpages();
    $this->_putresources();
    $this->_newobj();
    $this->_put('<<');
    $this->_putinfo();
    $this->_put('>>');
    $this->_put('endobj');
    $this->_newobj();
    $this->_put('<<');
    $this->_putcatalog();
    $this->_put('>>');
    $this->_put('endobj');
    $offset=strlen($this->buffer);
    $this->_put('xref');
    $this->_put('0 '.($this->n+1));
    $this->_put('0000000000 65535 f ');
    for($i=1;$i<=$this->n;$i++) $this->_put(sprintf('%010d 00000 n ',$this->offsets[$i]));
    $this->_put('trailer');
    $this->_put('<<');
    $this->_puttrailer();
    $this->_put('>>');
    $this->_put('startxref');
    $this->_put($offset);
    $this->_put('%%EOF');
}

// ── Core font widths (Arial/Helvetica) ──────────────────────────
protected function _getcorefontwidths($family) {
    // Widths for WinAnsi encoding — Helvetica/Arial approximation
    $w = array_fill(0, 256, 278);
    // Common chars
    $map = [32=>278,33=>278,34=>355,35=>556,36=>556,37=>889,38=>667,39=>191,40=>333,41=>333,42=>389,43=>584,44=>278,45=>333,46=>278,47=>278,48=>556,49=>556,50=>556,51=>556,52=>556,53=>556,54=>556,55=>556,56=>556,57=>556,58=>278,59=>278,60=>584,61=>584,62=>584,63=>556,64=>1015,65=>667,66=>667,67=>722,68=>722,69=>667,70=>611,71=>778,72=>722,73=>278,74=>500,75=>667,76=>556,77=>833,78=>722,79=>778,80=>667,81=>778,82=>722,83=>667,84=>611,85=>722,86=>667,87=>944,88=>667,89=>667,90=>611,91=>278,92=>278,93=>278,94=>469,95=>556,96=>333,97=>556,98=>556,99=>500,100=>556,101=>556,102=>278,103=>556,104=>556,105=>222,106=>222,107=>500,108=>222,109=>833,110=>556,111=>556,112=>556,113=>556,114=>333,115=>500,116=>278,117=>556,118=>500,119=>722,120=>500,121=>500,122=>500];
    foreach($map as $k=>$v) $w[$k]=$v;
    if($family=='times') { $w[32]=250; $w[65]=722; $w[97]=444; } // rough Times adjustment
    return $w;
}

} // end class FPDF
