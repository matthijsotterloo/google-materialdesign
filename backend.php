<?php
  header("Access-Control-Allow-Origin: *");
  if($_REQUEST["q"]) {
    $query = file_get_contents("https://www.google.be/search?q=".urlencode($_REQUEST["q"]));
    $query = explode('<ol>', $query);
    $query = explode('<div id="foot"', $query[1]);
    $query = explode('<div id="tads"', $query[0]);

    $query = explode('<li class="g">', $query[0]);

    foreach ($query as $key => $value) {
      if($key == 0) continue;
      $site = explode("<cite>",$query[$key]);
      $site = explode("</cite>",$site[1]);
      $site = str_replace("<b>", "", $site[0]);
      $site = str_replace("</b>", "", $site);
      $site = str_replace("https://", "", $site);

      $lien = explode('<a href="/url?q=',$query[$key]);
      $lien = explode('</a>',$lien[1]);
      $lien = explode('">',$lien[0]);
      $lienTitre = str_replace("<b>", "", $lien[1]);
      $lienTitre = str_replace("</b>", "", $lienTitre);

      if(strlen($lienTitre) > 50) continue;

      $lien = str_replace("<b>", "", $lien[0]);
      $lien = str_replace("</b>", "", $lien);
      

      $description = explode('<span class="st">',$query[$key]);
      $description = explode('</span>',$description[1]);
      $description = str_replace("<b>", "", $description[0]);
      $description = str_replace("</b>", "", $description);

      $info["site"] = $site;
      $info["lien"] = $lien;
      $info["lienTitre"] = $lienTitre;
      $info["description"] = $description;

      $resultats[] = $info;
    }
    print json_encode($resultats);
  } else {
    print "[{}]";
  }
?>