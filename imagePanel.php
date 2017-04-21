#!/usr/bin/env php
<?php
// imagePanel.php for  in /home/piscine/imagePanel
// 
// Made by BENKRIZI El harag
// Login   <benkri_e@etna-alternance.net>
// 
// Started on  Fri Apr  7 10:05:34 2017 BENKRIZI El harag
// Last update Sat Apr  8 11:18:15 2017 BENKRIZI El harag
//


if (isset($argv[3]))
  $nom = $argv[3];
else
  $nom = "images";

if ($argc < 2)
  {
    echo ("No Parametres !\n");
    exit;
  }
if ($argc < 3 && $argv[1] != "--help")
  {
    echo ("Veuillez entrez les commandes => --help\n");
    exit;
  }

if ($argv[1] == "--help")
  {
    echo ("\n------------------------------------------------\n");
    echo ("\nexemple : php imagePanel.php parametres url [nom base]\n\n-g\trecherche les images .gif\n\n-j\trecherche les images .jpg ou .jpeg\n\n-p\trecherche les images .png\n\nLes parametres peuvent être combinés et sont a mettre dans une seule commandes .\n\nexemple:\t -gpj\n");
    echo ("\n------------------------------------------------\n\n");
    exit;
  }

/*try
{
  chargeFichier($argv[2]);
}
catch(Exception $e)
{
  echo ("Url invalide : " . $e->getMessage());
}

function	chargeFichier($files)
{
  
  if ($file = file_get_contents($files) === false)
    throw new Exception("attention\n");
  else
    echo ("salut");
    }*/

if ($file = file_get_contents($argv[2]))
  {
    $i = 1;
    $resP = 0;
    $resG = 0;
    $resJ = 0;
    $params = "";
    if ($argv[1][0] == "-")
      {
	while(isset($argv[1][$i]))
	  {
	    if ($argv[1][$i] == "g" || $argv[1][$i] == "j" || $argv[1][$i] == "l" || $argv[1][$i] == "p")
	      {
		$params .= $argv[1][$i];
	      }
	    else
	      {
		echo "Parametres non fonctionnelle !\n";
		exit();
	      }
	    $i++;
	  }
	$i = 0;
	while (isset($params[$i]))
	  {
	    if ($params[$i] == "g")
	      {
		$resG = preg_match_all('#<img[^>]+src="([^"\t]+\.gif)#i', $file, $mots);
		creerImageGif($mots, $nom);
	      }
	    if ($params[$i] == "j")
	      {
		$resJ = preg_match_all('#<img[^>]+src="([^"\t]+\.jpg|\.jpeg)#i', $file, $mots);
		creerImageJpg($mots, $nom);
	      }
	    /*if ($params[$i] == "l")
	      pref_match_all();
	      if ($params[$i] == "n")
	      preg_match_all();
	      if ($params[$i] == "N")
	      preg_match_all();*/
	    if ($params[$i] == "p")
	      {
		$resP = preg_match_all('#<img[^>]+src="([^"\t]+\.png)#i', $file, $mots);
		creerImagePng($mots, $nom);
	      }
	    /*if ($params[$i] == "s")
	      preg_match_all();*/
	    $i++;
	  }
	echo (($resP += $resJ + $resG)." images trouvées !\n");
      }
  }

function        creerImageGif($lien, $nom)
{
  $i = 0;
  static $image;
  static $white;
  while (isset($lien[1][$i]))
    {
      $res = preg_match("#^http:|https:|/#i", $lien[1][$i], $ext);
      if ($res > 0)
	{
	  if ($ext[0] == "http:" || $ext[0] == "https:")
	    $ext[0] = "";
	  else
	    $ext[0] = "http:";
	}
      $insert = imagecreatefromgif($ext[0].$lien[1][$i]);
      $image = imagecreatetruecolor(imagesx($insert), imagesy($insert));
      $white = imagecolorallocate($image, 255, 255, 255);
      imagefilledrectangle($image, 0, 0, imagesx($insert), imagesy($insert),$white);
      imagecopy($image, $insert, 0, 0, 0, 0, imagesx($insert), imagesy($insert));
      imagegif($image, $nom."_".$i.".gif");
      $i++;
      
    }
  if (isset($image))
    imagedestroy($image);
}

function	creerImagePng($lien, $nom)
{
  $i = 0;
  static $image;
  static $white;
  while (isset($lien[1][$i]))
    {
      $res = preg_match("#^http:|https:|/#i", $lien[1][$i], $ext);
      if ($res > 0)
	{
	  if ($ext[0] == "http:" || $ext[0] == "https:")
	    $ext[0] = "";
	  else
	    $ext[0] = "http:";
	}
      $insert = imagecreatefrompng($ext[0].$lien[1][$i]);
      $image = imagecreatetruecolor(imagesx($insert), imagesy($insert));
      $white = imagecolorallocate($image, 255, 255, 255);
      imagefilledrectangle($image, 0, 0, imagesx($insert), imagesy($insert), $white);
      imagecopy($image, $insert, 0, 0, 0, 0, imagesx($insert), imagesy($insert));
      imagepng($image, $nom."_".$i.".png");
      $i++;
    }
  if (isset($image))
    imagedestroy($image);
}

function        creerImageJpg($lien, $nom)
{
  $i = 0;
  static $image;
  static $white;
  while (isset($lien[1][$i]))
    {
      $res = preg_match("#^http:|https:|/#i", $lien[1][$i], $ext);
      if ($res > 0)
	{
	  if (($ext[0] == "http:") || ($ext[0] == "https:"))
	    $ext[0] = "";
	  else
	    $ext[0] = "http:";
	}
      $insert = imagecreatefromjpeg($ext[0].$lien[1][$i]);
      $image = imagecreatetruecolor(imagesx($insert), imagesy($insert));
      $white = imagecolorallocate($image, 255, 255, 255);
      imagefilledrectangle($image, 0, 0, imagesx($insert), imagesy($insert),$white);
      imagecopy($image, $insert, 0, 0, 0, 0, imagesx($insert), imagesy($insert));
      imagejpeg($image, $nom."_".$i.".jpg");
      $i++;
    }
  if (isset($image))
    imagedestroy($image);
}