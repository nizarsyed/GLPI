<?php

/*
   ------------------------------------------------------------------------
   Barcode
   Copyright (C) 2009-2016 by the Barcode plugin Development Team.

   https://forge.indepnet.net/projects/barscode
   ------------------------------------------------------------------------

   LICENSE

   This file is part of barcode plugin project.

   Plugin Barcode is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   Plugin Barcode is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with Plugin Barcode. If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------

   @package   Plugin Barcode
   @author    David Durieux
   @co-author
   @copyright Copyright (c) 2009-2016 Barcode plugin Development team
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @link      https://forge.indepnet.net/projects/barscode
   @since     2009

   ------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

/**
 * Class to generate barcodes using PEAR Image_Barcode
 **/
class PluginBarcodeBarcode {
   private $docsPath;

   static $rightname = 'plugin_barcode_barcode';


   /**
     * Constructor
    **/
   function __construct() {
      $this->docsPath = GLPI_PLUGIN_DOC_DIR.'/barcode/';
   }



   function getCodeTypes() {
      $types = ['Code39', 'code128', 'ean13', 'int25', 'postnet', 'upca',
                'QRcode'
               ];
      return $types;
   }



   function showSizeSelect($p_size = null) {
      //TODO : utiliser fonction du coeur

      Dropdown::showFromArray("size",
                              ['4A0'       => __('4A0', 'barcode'),
                               '2A0'       => __('2A0', 'barcode'),
                               'A0'        => __('A0', 'barcode'),
                               'A1'        => __('A1', 'barcode'),
                               'A2'        => __('A2', 'barcode'),
                               'A3'        => __('A3', 'barcode'),
                               'A4'        => __('A4', 'barcode'),
                               'A5'        => __('A5', 'barcode'),
                               'A6'        => __('A6', 'barcode'),
                               'A7'        => __('A7', 'barcode'),
                               'A8'        => __('A8', 'barcode'),
                               'A9'        => __('A9', 'barcode'),
                               'A10'       => __('A10', 'barcode'),
                               'B0'        => __('B0', 'barcode'),
                               'B1'        => __('B1', 'barcode'),
                               'B2'        => __('B2', 'barcode'),
                               'B3'        => __('B3', 'barcode'),
                               'B4'        => __('B4', 'barcode'),
                               'B5'        => __('B5', 'barcode'),
                               'B6'        => __('B6', 'barcode'),
                               'B7'        => __('B7', 'barcode'),
                               'B8'        => __('B8', 'barcode'),
                               'B9'        => __('B9', 'barcode'),
                               'B10'       => __('B10', 'barcode'),
                               'C0'        => __('C0', 'barcode'),
                               'C1'        => __('C1', 'barcode'),
                               'C2'        => __('C2', 'barcode'),
                               'C3'        => __('C3', 'barcode'),
                               'C4'        => __('C4', 'barcode'),
                               'C5'        => __('C5', 'barcode'),
                               'C6'        => __('C6', 'barcode'),
                               'C7'        => __('C7', 'barcode'),
                               'C8'        => __('C8', 'barcode'),
                               'C9'        => __('C9', 'barcode'),
                               'C10'       => __('C10', 'barcode'),
                               'RA0'       => __('RA0', 'barcode'),
                               'RA1'       => __('RA1', 'barcode'),
                               'RA2'       => __('RA2', 'barcode'),
                               'RA3'       => __('RA3', 'barcode'),
                               'RA4'       => __('RA4', 'barcode'),
                               'SRA0'      => __('SRA0', 'barcode'),
                               'SRA1'      => __('SRA1', 'barcode'),
                               'SRA2'      => __('SRA2', 'barcode'),
                               'SRA3'      => __('SRA3', 'barcode'),
                               'SRA4'      => __('SRA4', 'barcode'),
                               'LETTER'    => __('LETTER', 'barcode'),
                               'LEGAL'     => __('LEGAL', 'barcode'),
                               'EXECUTIVE' => __('EXECUTIVE', 'barcode'),
                               'FOLIO'     => __('FOLIO', 'barcode'),
							   'LABEL'     => __('LABEL', 'barcode'),
							   'LABEL2'  => __('LABEL2', 'barcode')],
                              (is_null($p_size)?['width' => '100']:['value' => $p_size, 'width' => '100']));
   }



   function showOrientationSelect($p_orientation = null) {
      //TODO : utiliser fonction du coeur

      Dropdown::showFromArray("orientation",
                              ['Portrait'  => __('Portrait', 'barcode'),
                                    'Landscape' => __('Landscape', 'barcode')],
                              (is_null($p_orientation)?['width' => '100']:['value' => $p_orientation, 'width' => '100']));
   }



   function showForm($p_type, $p_ID) {
      global $CFG_GLPI;
		
		error_log("test");
		error_log($CFG_GLPI);
      $config = $this->getConfigType();
      $ci = new $p_type();
      $ci->getFromDB($p_ID);
	  
      if ($ci->isField('otherserial')) {
         $code = $ci->getField('otherserial');
		 // Log $p_ID and $code to PHP error log
		error_log("p_ID: $p_ID, code: $code");
      } else {
         $code = '';
      }
	  
	  
      echo "<form name='form' method='post'
                  action='".Plugin::getWebDir('barcode')."/front/barcode.form.php'>";
        echo "<div align='center'>";
        echo "<table class='tab_cadre'>";
         echo "<tr><th colspan='4'>".__('Generation', 'barcode')."</th></tr>";
         echo "<tr class='tab_bg_1'>";
            echo "<td>".__('Code', 'barcode')."</td><td>";
            echo "<input type='text' size='20' name='code' value='$code'>";
            echo "</td>";
            echo "<td>".__('Type', 'barcode')."</td><td>";
            $this->showTypeSelect($config['type']);
            echo "</td>";
         echo "<tr class='tab_bg_1'>";
            echo "<td>".__('Page size', 'barcode')."</td><td>";
            $this->showSizeSelect($config['size']);
            echo "</td>";
            echo "<td>".__('Orientation', 'barcode')."</td><td>";
            $this->showOrientationSelect($config['orientation']);
            echo "</td>";
         echo "</tr>";
         echo "<tr class='tab_bg_1'>";
            echo "<td>".__('Number of copies', 'barcode')."</td>";
            echo "<td><input type='text' size='20' name='nb' value='1'></td>";
            echo "<td colspan='2'></td>";
         echo "</tr>";
         echo "<tr><td class='tab_bg_1' colspan='4' align='center'>
                   <input type='submit' value='".__('Create', 'barcode')."'
                          class='submit'></td></tr>";
        echo "</table>";
        echo "</div>";
        Html::closeForm();
   }



   function showFormMassiveAction(MassiveAction $ma) {

      $pbConfig = new PluginBarcodeConfig();

      echo '<center>';
      echo '<strong>';
      echo __('It will generate only elements have defined field:', 'barcode').' ';
		//error_log("barcode.class.php: ma: \n" . print_r($ma, true) , 3, "C:\log\php_error.log");
      if (key($ma->items) == 'Ticket') {
         echo __('Ticket number', 'barcode');
      } else {
         echo __('Inventory number');
      }
      echo '</strong>';
      echo '<table>';
      echo '<tr>';
      echo '<td>';
      $config = $pbConfig->getConfigType();
        echo __('Type', 'barcode')." : </td><td>";
        $pbConfig->showTypeSelect($config['type'], ['QRcode' => 'QRcode']);
      echo '</td>';
      echo '</tr>';
      echo '</table>';
      echo '<br/>';

      PluginBarcodeBarcode::commonShowMassiveAction();
   }



   static function commonShowMassiveAction() {

      $pbBarcode = new PluginBarcodeBarcode();
      $pbConfig  = new PluginBarcodeConfig();
      $config    = $pbConfig->getConfigType();

      echo '<table>';
      echo '<tr>';
      echo '<td>';
      echo "<br/>".__('Page size', 'barcode')." : </td><td>";
         $pbBarcode->showSizeSelect($config['size']);
      echo '</td>';
      echo '<td>';
      echo __('Not use first xx barcodes', 'barcode')." : </td><td>";
      Dropdown::showNumber("eliminate", ['width'=>'100']);
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo "<br/>".__('Orientation', 'barcode')." : </td><td>";
         $pbBarcode->showOrientationSelect($config['orientation']);
      echo '</td>';
      echo '<td>';
      echo __('Display border', 'barcode')." : </td><td>";
      Dropdown::showYesNo("border", 1, -1, ['width' => '100']);
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>&nbsp;</td>';
      echo '<td>&nbsp;</td>';
      echo '<td>';
      echo __('Display labels', 'barcode')." : </td><td>";
      Dropdown::showYesNo("displaylabels", 0, -1, ['width' => '100']);
      echo '</td>';
      echo '</tr>';
      echo '</table>';
      echo '</center>';

      echo "<br/><input type='submit' value='".__('Create', 'barcode')."' class='submit'>";
      echo "<br/>";
      echo Html::submit(__('Create', 'barcode'), ['value' => 'create']);
   }



   function printPDF($p_params) {
	   
	   //error_log("barcode.class.php: p_params: \n" . print_r($p_params, true) , 3, "C:\log\php_error.log");

      $pbConfig = new PluginBarcodeConfig();

      // create barcodes
      $ext         = 'png';
      $type        = $p_params['type'];
      $size        = $p_params['size'];  
      $orientation = $p_params['orientation'];
      $codes       = [];
	  $names	   = $p_params['names'];
	  $uins	   	   = $p_params['uin'];
		
		//error_log("Creating barcode start:" . $codes, E_USER_NOTICE);
		
      $displayDataCollection = $p_params['displayData'] ?? [];

      if ($type == 'QRcode') {
         $codes = $p_params['codes'];
      } else {
         if (isset($p_params['code'])) {
			 
			 
            if (isset($p_params['nb']) AND $p_params['nb']>1) {
               $this->create($p_params['code'], $type, $ext);
               for ($i=1; $i<=$p_params['nb']; $i++) {
                  $codes[] = $p_params['code'];
               }
			   
            } else {
               if (!$this->create($p_params['code'], $type, $ext)) {
                  Session::addMessageAfterRedirect(__('The generation of some barcodes produced errors.', 'barcode'));
               }
               $codes[] = $p_params['code'];
			   
			   
            }
         } else if (isset($p_params['codes'])) {
            $codes = $p_params['codes'];
			
			//error_log("\n \n barcode.class.php: codes:\n" . print_r($codes, true) , 3, "C:\log\php_error.log");
			
            foreach ($codes as $code) {
               if ($code != '') {
                  $this->create($code, $type, $ext);
               }
            }
         } else {
            // TODO : erreur ?
            //         print_r($p_params);
            return 0;
         }
      }

      // create pdf
      // x is horizontal axis and y is vertical
      // x=0 and y=0 in bottom left hand corner
      $config = $pbConfig->getConfigType($type);

      $pdf= new Cezpdf($size, $orientation);
      $pdf->tempPath = GLPI_TMP_DIR;
      $pdf->selectFont(Plugin::getPhpDir('barcode')."/lib/ezpdf/fonts/Helvetica.afm");
      $pdf->ezSetMargins($config['marginTop'], $config['marginBottom'], $config['marginLeft'], $config['marginRight']);
      //$pdf->ezStartPageNumbers($pdf->ez['pageWidth']-30, 10, 10, 'left', '{PAGENUM} / {TOTALPAGENUM}').
      $width   = $config['maxCodeWidth'];
      $height  = $config['maxCodeHeight'];
      $marginH = $config['marginHorizontal'];
      $marginV = $config['marginVertical'];
      $txtSize    = $config['txtSize'];
      $txtSpacing = $config['txtSpacing'];

      $heightimage = $height;

      if (file_exists(GLPI_PLUGIN_DOC_DIR.'/barcode/logo.png')) {
         // Add logo to barcode
         $heightLogomax = 15;
         $imgSize       = getimagesize(GLPI_PLUGIN_DOC_DIR.'/barcode/logo.png');
         $logoWidth     = $imgSize[0];
         $logoHeight    = $imgSize[1];
         if ($logoHeight > $heightLogomax) {
            $ratio      = (100 * $heightLogomax ) / $logoHeight;
            $logoHeight = $heightLogomax;
            $logoWidth  = $logoWidth * ($ratio / 100);
         }
         if ($logoWidth > $width) {
            $ratio      = (100 * $width ) / $logoWidth;
            $logoWidth  = $width;
            $logoHeight = $logoHeight * ($ratio / 100);
         }
         $heightyposText = $height - $logoHeight;
         $heightimage    = $heightyposText;
      }

      $first=true;
      for ($ia = 0; $ia < count($codes); $ia++) {
         $code = $codes[$ia];
		 
		 $name = $names[$ia];
		 //error_log("barcode.class.php: name: \n" . print_r($name, true) , 3, "C:\log\php_error.log");
		 
		 $uin = $uins[$ia];
		 
         $displayData = $displayDataCollection[$ia] ?? [];
         if ($first) {
            $x = $pdf->ez['leftMargin'];
            $y = $pdf->ez['pageHeight'] - $pdf->ez['topMargin'] - $height;
            $first = false;
         } else {
            if ($x + $width + $marginH > $pdf->ez['pageWidth']) { // new line
               $x = $pdf->ez['leftMargin'];
               if ($y - $height - $marginV < $pdf->ez['bottomMargin']) { // new page
                  $pdf->ezNewPage();
                  $y = $pdf->ez['pageHeight'] - $pdf->ez['topMargin'] - $height;
               } else {
                  $y -= $height + $marginV;
               }
            }
         }
         if ($code != '') {
            if ($type == 'QRcode') {
               $imgFile = $code;
            } else {
               $imgFile = $this->docsPath.$code.'_'.$type.'.'.$ext;
			   //error_log("imagefile: " . $imgFile);
            }
            if (file_exists($imgFile)) {
               $imgSize   = getimagesize($imgFile);
               $imgWidth  = $imgSize[0];
               $imgHeight = $imgSize[1];
               if ($imgWidth > $width) {
                  $ratio     = (100 * $width ) / $imgWidth;
                  $imgWidth  = $width;
                  $imgHeight = $imgHeight * ($ratio / 100) * 0.8;
               }
               if ($imgHeight > $heightimage) {
                  $ratio     = (100 * $heightimage ) / $imgHeight;
                  $imgHeight = $heightimage;
                  $imgWidth  = $imgWidth * ($ratio / 100) * 0.8;
               }

               $image = imagecreatefrompng($imgFile);
               if ($imgWidth < $width) {
                  $pdf->addImage($image,
                                 $x + (($width - $imgWidth) / 2),
                                 $y-1,
                                 $imgWidth,
                                 $imgHeight-2);
               } else {
                  $pdf->addImage($image,
                                 $x,
                                 $y-1,
                                 $imgWidth,
                                 $imgHeight-2);
               }

               if (file_exists(GLPI_PLUGIN_DOC_DIR.'/barcode/logo.png')) {
                  $logoimg = imagecreatefrompng(GLPI_PLUGIN_DOC_DIR.'/barcode/logo.png');
                  $pdf->addImage($logoimg,
                                 $x +1,//+ (($width - $logoWidth) / 2),
                                 $y + $heightyposText-1,
                                 $logoWidth,
                                 $logoHeight);
               }
			   
			   $txtHeight = 0;

				// Hardcoded text + name from DB
				$Textline1 = "Name: " . $name;
				$Textline2 = "UIN: " . $uin;
				
				$pdf->addTextWrap(
					$x+ $logoWidth+2,
					$y + $height - $txtSize +1,
					$txtSize,
					$Textline1,
					$width - $logoWidth-3,
					'right'
				);
				

				$pdf->addTextWrap(
					$x+ $logoWidth+2,
					$y + $height - ($txtSize *2) +1,
					//$y - ($txtSpacing + $txtHeight),
					$txtSize,
					//$p_params['names'],
					$Textline2,
					$width - $logoWidth-3,
					'right'
				);
				
				
							   
               // $txtHeight = 0;
               // for ($i = 0; $i < count($displayData); $i++) {
                   // $pdf->addTextWrap(
                       // $x,
                       // $y - ($txtSpacing + $txtHeight),
                       // $txtSize,
                       // $displayData[$i],
					   // //error_log("text written: " . $displayData[$i]),
                       // $width,
                       // 'center');
                   // $txtHeight += $txtSpacing/2 + $txtSize;
               // }
               if ($p_params['border']) {
                  $pdf->Rectangle($x, $y - ($txtHeight + $txtSpacing*2),
                       $width, $height + ($txtHeight + $txtSpacing*2));
               }
            }
         }
         $x += $width + $marginH;
         $y -= 0;
      }
	  

      $file    = $pdf->ezOutput();
      $pdfFile = $_SESSION['glpiID'].'_'.$type.'.pdf';
	  $filePath = $this->docsPath.$pdfFile;  // Full path to the PDF file
	  file_put_contents($filePath, $file);
	  // Log the file path
	  // error_log("Barcode PDF saved at: " . $filePath);
      return '/files/_plugins/barcode/'.$pdfFile;
   }



	/* function create($p_code, $p_type, $p_ext, $compression = 3) {
    //TODO : filter on the type
    if (!file_exists($this->docsPath.$p_code.'_'.$p_type.'.'.$p_ext)) {
        ob_start();
        $barcode = new Image_Barcode();
        // Set compression level here (default is 6)
        $resImg  = @imagepng(
            @$barcode->draw($p_code, $p_type, $p_ext, false),
            $this->docsPath.$p_code.'_'.$p_type.'.'.$p_ext,
            $compression
        );
        $img     = ob_get_clean();
        file_put_contents($this->docsPath.$p_code.'_'.$p_type.'.'.$p_ext, $img);
        if (!$resImg) {
            return false;
        }
    }
    return true;
} */

	function create($p_code, $p_type, $p_ext) {
	   //TODO : filter on the type
	   if (!file_exists($this->docsPath.$p_code.'_'.$p_type.'.'.$p_ext)) {
		  ob_start();
		  $barcode = new Image_Barcode();
		  // Generate the image
		  $img = $barcode->draw($p_code, $p_type, $p_ext, false);
		  // Save the image to a file and capture the result
		  $resImg = imagepng($img, $this->docsPath.$p_code.'_'.$p_type.'.'.$p_ext,0);
		  // Clean up output buffer
		  ob_end_clean();
		  // Check if imagepng() was successful
		  if (!$resImg) {
			 return false;
		  }
	   }
	   return true;
	}



	
	
	
/* 
   function create($p_code, $p_type, $p_ext) {
      // TODO : filtre sur le type
      if (!file_exists($this->docsPath.$p_code.'_'.$p_type.'.'.$p_ext)) {
         ob_start();
         $barcode = new Image_Barcode();
         $resImg  = @imagepng(
            @$barcode->draw($p_code, $p_type, $p_ext, false)
         );
         $img     = ob_get_clean();
         file_put_contents($this->docsPath.$p_code.'_'.$p_type.'.'.$p_ext, $img);
         if (!$resImg) {
            return false;
         }
      }
      return true;
   }
 */


   function getSpecificMassiveActions($checkitem = null) {
      return [];
   }



   /**
    * @since version 0.85
    *
    * @see CommonDBTM::showMassiveActionsSubForm()
   **/
   static function showMassiveActionsSubForm(MassiveAction $ma) {
      switch ($ma->getAction()) {
         case 'Generate':
            $barcode = new self();
            $barcode->showFormMassiveAction($ma);
            return true;

      }
      return false;
   }

	

   static function processMassiveActionsForOneItemtype(MassiveAction $ma, CommonDBTM $item, array $ids) {
      global $CFG_GLPI;
		// Import the class representing the other table
	require_once('plugin_fields_plugingenericobjectconfigitemlifourimports.php');
		
		//error_log("\n \n barcode.class.php: item:\n" . print_r($item, true) , 3, "C:\log\php_error.log");

		

      switch ($ma->getAction()) {

         case 'Generate' :
            $pbQRcode = new PluginBarcodeQRcode();
            $rand     = mt_rand();
            $number   = 0;
            $codes    = [];
			$names	  = [];
			$UIN	  = [];
            if ($ma->POST['eliminate'] > 0) {
               for ($nb=0; $nb < $ma->POST['eliminate']; $nb++) {
                  $codes[] = '';
               }
            }
			
			// Instantiate an object of the OtherTable class
			$otherTable = new plugin_fields_plugingenericobjectconfigitemlifourimports();
			error_log("\n barcode.class.php: tableName:\n" . print_r($otherTable->getTable(), true) , 3, "C:\log\php_error.log");
			error_log("\n barcode.class.php: otherTable:\n" . print_r($otherTable, true) , 3, "C:\log\php_error.log");
			
			
            foreach ($ids as $key) {
               $item->getFromDB($key);
			   $otherTable->getFromDB($key);
			   //error_log("\n barcode.class.php: item:\n" . print_r($item, true) , 3, "C:\log\php_error.log");
			   error_log("\n barcode.class.php: key:\n" . print_r($key, true) , 3, "C:\log\php_error.log");
               if (key($ma->items) == 'CommonITILObject') {
                  $codes[] = $item->getField('id');
               } else if ($item->isField('otherserial')) {
                  $codes[] = $item->getField('serial');
				  $names[] = $item->getField('name');
				  error_log("\n barcode.class.php: uin1:\n" . print_r($UIN, true) , 3, "C:\log\php_error.log");
				  
				  // Code to use for Custom v3.0 PKMF list
				  //$UIN[] = $otherTable->getField('uinfield');
				  // Code to use for GLPi G2G standard list
				  $UIN[] = $item->getField('otherserial');
				  
				  error_log("\n barcode.class.php: uin2:\n" . print_r($UIN, true) , 3, "C:\log\php_error.log");
               }
            }
            if (count($codes) > 0) {
               $params['codes']       = $codes;
               $params['type']        = $ma->POST['type'];
               $params['size']        = $ma->POST['size'];
               $params['border']      = $ma->POST['border'];
               $params['orientation'] = $ma->POST['orientation'];
               $params['displaylabels'] = $ma->POST['displaylabels'];
			   $params['names']			= $names;
			   $params['uin']			= $UIN;

               $barcode  = new PluginBarcodeBarcode();
               $file     = $barcode->printPDF($params);
               $filePath = explode('/', $file);
               $filename = $filePath[count($filePath)-1];

               $msg = "<a href='".Plugin::getWebDir('barcode').'/front/send.php?file='.urlencode($filename)
                  ."'>".__('Generated file', 'barcode')."</a>";

               Session::addMessageAfterRedirect($msg);
               $pbQRcode->cleanQRcodefiles($rand, $number);
            }
            $ma->itemDone($item->getType(), 0, MassiveAction::ACTION_OK);
            return;

      }
      return;
   }

	function fillArrayFromDatabase($idKeys) {
		// Database table name
		$tableName = 'glpi_plugin_fields_plugingenericobjectconfigitemlifourimports';
		// Field name to fetch
		$fieldName = 'uinfield';

		error_log("\n barcode.class.php: fieldName:\n" . print_r($fieldName, true) , 3, "C:\log\php_error.log");
		// Include CommonDBTM class
		require_once 'CommonDBTM.php';

		// Initialize array to store data
		$dataArray = [];

		// Loop through idKeys to fetch data from database
		foreach ($idKeys as $id) {
			// Define request criteria
			$request = [
				'FROM' => $tableName,
				'WHERE' => [
					'id' => $id
				],
				'LIMIT' => 1
			];

			// Instantiate CommonDBTM object
			$dbObject = new CommonDBTM();
			// Retrieve data from database for the given ID and table
			$dbObject->getFromDBByRequest($request);
			// Get the value of the specified field for the current object
			$fieldValue = $dbObject->getField($fieldName);
			// Add field value to the array
			$dataArray[$id] = $fieldValue;
		}

		// Return the array filled with data
		return $dataArray;
	}




}
