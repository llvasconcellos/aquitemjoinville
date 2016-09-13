<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/
  //Start the session
  @session_start();



  //Create a CAPTCHA
  $captcha = new captcha();

  //Store the String in a session
  $_SESSION['CAPTCHA'] = $captcha->getCaptcha();


   class captcha{

    var $Length;
    var $CaptchaString;
    var $fontpath;
    var $fonts;

    function captcha ($length = 4){

    if(!function_exists('imagecreate')) header('Location:uploads/nogd.gif');//die('GD Library not found!');

      header('Content-type: image/png');
      $this->Length   = $length;

      //$this->fontpath = dirname($_SERVER['SCRIPT_FILENAME']) . '/fonts/';
      $this->fontpath = 'fonts/';
      $this->fonts    = $this->getFonts();
      $errormgr       = new error;

      if ($this->fonts == FALSE)
      {

          //$errormgr = new error;
          $errormgr->addError('No fonts available!');
          $errormgr->displayError();
          die();

      }

      if (function_exists('imagettftext') == FALSE)
      {

        $errormgr->addError('');
        $errormgr->displayError();
        die();

      }

      $this->stringGenerate();

      $this->makeCaptcha();

    } //captcha

    function getFonts (){
      $fonts = array();
      if ($handle = @opendir($this->fontpath)){
        while (($file = readdir($handle)) !== FALSE){
          $extension = strtolower(substr($file, strlen($file) - 3, 3));
          if ($extension == 'ttf'){
            $fonts[] = $file;
          }
        }
        closedir($handle);
      }else{
          return FALSE;
      }

      if (count($fonts) == 0){
          return FALSE;
      }else{
          return $fonts;
      }
    }
    function getRandomFont (){
      return $this->fontpath . $this->fonts[mt_rand(0, count($this->fonts) - 1)];
    }
    function stringGenerate(){
      $uppercase  = range('A', 'Z');

      $CharPool   = range('A', 'Z');
      $PoolLength = count($CharPool) - 1;

      for ($i = 0; $i < $this->Length; $i++){
        $this->CaptchaString .= $CharPool[mt_rand(0, $PoolLength)];
      }
    } //stringGenerate

    function makeCaptcha (){
      $imagelength = $this->Length * 15 + 16;
      $imageheight = 40;
		$image       = imagecreate($imagelength, $imageheight);


      $bgcolor     = imagecolorallocate($image, 255, 255, 255);

      $stringcolor = imagecolorallocate($image, 0, 0, 0);

      $filter      = new filters;

      $filter->signs($image, $this->getRandomFont(),1);

      for ($i = 0; $i < strlen($this->CaptchaString); $i++){
        imagettftext($image,15, mt_rand(-15, 15), $i * 15 + 10,
                     mt_rand(20, 30),
                     $stringcolor,
                     $this->getRandomFont(),
                     $this->CaptchaString{$i});
      }

      $filter->noise($image, 2);
      //$filter->blur($image, 0);

      imagepng($image);

      imagedestroy($image);

    } //MakeCaptcha

    function getCaptcha ()
    {

      return $this->CaptchaString;

    } //getCaptcha

  } //class: captcha



  class error
  {

      var $errors;

      function error ()
      {

        $this->errors = array();

      } //error

      function addError ($errormsg)
      {

        $this->errors[] = $errormsg;

      } //addError

      function displayError ()
      {

      $iheight     = count($this->errors) * 20 + 10;
      $iheight     = ($iheight < 130) ? 130 : $iheight;

      $image       = imagecreate(600, $iheight);

      $errorsign   = imagecreatefromjpeg('./gfx/errorsign.jpg');
      imagecopy($image, $errorsign, 1, 1, 1, 1, 180, 120);

      $bgcolor     = imagecolorallocate($image, 255, 255, 255);

      $stringcolor = imagecolorallocate($image, 0, 0, 0);

      for ($i = 0; $i < count($this->errors); $i++)
      {

        $imx = ($i == 0) ? $i * 20 + 5 : $i * 20;


        $msg = 'Error[' . $i . ']: ' . $this->errors[$i];

        imagestring($image, 5, 190, $imx, $msg, $stringcolor);

        }

      imagepng($image);

      imagedestroy($image);

      } //displayError

      function isError ()
      {

        if (count($this->errors) == 0)
        {

            return FALSE;

        }
        else
        {

            return TRUE;

        }

      } //isError

  } //class: error



  class filters
  {

    function noise (&$image, $runs = 30){

      $w = imagesx($image);
      $h = imagesy($image);

      for ($n = 0; $n < $runs; $n++)
      {

        for ($i = 1; $i <= $h; $i++)
        {

          $randcolor = imagecolorallocate($image,
                                          mt_rand(0, 255),
                                          mt_rand(0, 255),
                                          mt_rand(0, 255));

          imagesetpixel($image,
                        mt_rand(1, $w),
                        mt_rand(1, $h),
                        $randcolor);

        }

      }

    } //noise

    function signs (&$image, $font, $cells = 3){

      $w = imagesx($image);
      $h = imagesy($image);

         for ($i = 0; $i < $cells; $i++)
         {

             $centerX     = mt_rand(5, $w);
             $centerY     = mt_rand(1, $h);
             $amount      = mt_rand(5, 10);
        $stringcolor = imagecolorallocate($image, 150, 150, 150);

             for ($n = 0; $n < $amount; $n++)
             {

          $signs = range('A', 'Z');
          $sign  = $signs[mt_rand(0, count($signs) - 1)];

               imagettftext($image, 15,
                            mt_rand(-15, 15),
                            $n * 15,//mt_rand(0, 15),
                            30 + mt_rand(-5, 5),
                            $stringcolor, $font, $sign);

             }

         }

    } //signs


  } //class: filters

?>