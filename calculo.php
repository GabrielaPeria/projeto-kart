<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//config. para milegundos//

require_once "function.php";

?>

<!doctype html>
<html lang="pt-br">
  <head>

  <?php header("Content-type: text/html; charset=utf-8"); ?>

    <meta name="viewport"content="width=device=width,initial-scale=1.0">    
    <title>Cadastro de Piloto</title>
    <link rel="stylesheet" type="txt/css" href="tabela.css">
    <style>
      
      body {
        font-family: Arial, Helvetica, sans-serif;     
        border: 1px solid black;
        text-align: center;     
        color: red;
      }
      table{
        width: 100%;
        height: 100px;
        border-collapse: collapse;
        border: 0.9px solid black;
        font-weight: 80;
        color: black;
      }
      td,th {
        border: 1px solid black;
        padding: 2px;
        text-align: center;
        vertical-align: middle;
               
      }
      thead{
        background-color: burlywood;
        color: white;
      }
      *{
        margin: 0;
            padding: 0; 
        }
        .botao{

            font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            top: 50%;
            left: 80%;
            border-radius: 50px;
            padding: 15px;
            color: red;
            font-size: 15px;
            cursor: pointer;
    
        }
      
      </style>
   </head> 
   
</table>
  
<?php

    $dados = [[38,"F.MASSA",          1,  "0:01:02.852",  44.275, "23:49:08.277"],
             [33,"R.BARRICHELLO",    1,  "0:01:04.352",  43.243, "23:49:10.858"],
             [2,"K.RAIKKONEN",       1,  "0:01:04.108",  43.408, "23:49:11.075"],
             [23,"M.WEBBER",         1,  "0:01:04.414",  43.202, "23:49:12.667"],
             [15,"F.ALONSO",         1,  "0:01:18.456",  35.470, "23:49:30.976"],
             [11,"S.VETTEL",         1,  "0:03:31.315",  13.169, "23:52:01.796"],
             [38,"F.MASSA",          2,  "0:01:03.170",  44.053, "23:50:11.447"],
             [33,"R.BARRICHELLO",    2,  "0:01:04.002",  43.480, "23:50:14.860"],
             [2,"K.RAIKKONEN",       2,  "0:01:03.982",  43.493, "23:50:15.057"],
             [23,"M.WEBBER",         2,  "0:01:04.805",  42.941, "23:50:17.472"],
             [15,"F.ALONSO",         2,  "0:01:07.011",  41.528, "23:50:37.987"],
             [11,"S.VETTEL",         2,  "0:01:37.864",  28.435, "23:53:39.660"],
             [38,"F.MASSA",          3,  "0:01:02.769",  44.334, "23:51:14.216"],
             [33,"R.BARRICHELLO",    3,  "0:01:03.716",  43.675, "23:51:18.576"],
             [2,"K.RAIKKONEN",       3,  "0:01:03.987",  43.490, "23:51:19.044"],
             [23,"M.WEBBER",         3,  "0:01:04.287",  43.287, "23:51:21.759"],
             [15,"F.ALONSO",         3,  "0:01:08.704",  40.504, "23:51:46.691"],
             [11,"S.VETTEL",         3,  "0:01:18.097",  35.633, "23:54:57.757"],
             [38,"F.MASSA",          4,  "0:01:02.787",  44.321, "23:52:17.003"],
             [33,"R.BARRICHELLO",    4,  "0:01:04.010",  43.474, "23:52:22.586"],
             [2,"K.RAIKKONEN",       4,  "0:01:03.076",  44.118, "23:52:22.120"],
             [23,"M.WEBBER",         4,  "0:01:04.216",  43.335, "23:52:25.975"],
             [15,"F.ALONSO",         4,  "0:01:20.050",  34.763, "23:53:06.741"]]; 

   $acao =  isset($_REQUEST['acao'])  ?(int)$_REQUEST['acao'] :0;

   if($acao == 1){
    $result = [];
   
    foreach($dados as $d){
    
      $idPiloto       = is_null($d[0])    ?   0   :   $d[0];
      $numeroDaVolta  = is_null($d[2])    ?   0   :   $d[2];
      $tempoDaVolta   = is_null($d[3])    ?   0   :   timeToMilliseconds($d[3]);
      $velMedia       = is_null($d[4])    ?   0   :   $d[4];
      $nome           = is_null($d[1])    ?   ""   :  $d[1];

      if(in_array($idPiloto,array_keys($result))){

        if($tempoDaVolta>0){
          $tempoDaVolta=$result[$idPiloto]["tempoDeProva"];
          $result[$idPiloto]["tempoDeProva"]=($tempoAtual+$tempoDaVolta);
        }

        if($velMedia>0){
        $result[$idPiloto]["sumVelMedia"]=$result[$idPiloto]["sumVelMedia"]+$velMedia;
        }

        if($numeroDaVolta>0){
        $result[$idPiloto]["numVoltas"]=$numeroDaVolta;
        }

        if($result[$idPiloto]["voltaMaisRapida"]>0 && $result[$idPiloto]["voltaMaisRapida"]>$tempoDaVolta){
          $result[$idPiloto]["voltaMaisRapida"]=$tempoDaVolta;
        }

        else{
            if ($idPiloto > 0 && $numeroDaVolta > 0 && $tempoDaVolta > 0 && $velMedia > 0 && $nome != ""){
              $result[$idPiloto]=[
                "nome" => $nome,"tempoDeProva"=>$tempoDaVolta,"sumVelMedia"=>$velMedia,"voltaMaisRapida"=>$tempoDaVolta,"numVoltas"=> $numeroDaVolta];
             }
          }
     }
    }
      $vetor = array_keys($result);
      $ranking = array_column($result, 'tempoDeProva');
      array_multisort($ranking, SORT_ASC,$result,$vetor);
      $result = array_combine($vetor, $result);
  }
?>
  
      <body>
<table class="table"> 
<br>
  <h2>Problema corrida de kart</h2>  
  
     <thead>
      <th>Código</th>
      <th>Piloto</th>
      <th>Nº da volta</th>
      <th>Tempo de volta</th>
      <th>Velocidade média da volta</th>
      <th>Horário</th>
      </td>
      </thead>
<tbody>

   <?php
   foreach($dados as $volta ){
      echo "<tr> ";

      // exibe os dados//

      foreach($volta as $voltas){
        echo "<td>$voltas</td>";
      }
      echo "<tr>";
   }
   ?>
   </tbody>
</table>

<br/>
<!-- botão -->
<form action="calculo.php" method="POST" role="form">
<input type="hidden" name="acao" id="acao" value="1">
<button type="submit" class="botao">Resuldado da Corrida</button>

</form>
<?php

if($acao == 1){

?>

<table class="table"> 

       <thead>
            <th>Posição de chegada</th>
            <th>Código</th>
            <th>nome</th>
            <th>Tempo de prova</th>
            <th>Velocidade média</th>
            <th>Volta mais rápida</th>
            </td>
    </thead>
    <tbody>
<?php
$i = 0;
$voltaMaisRapidadaCorrida=9999999999999;
$pilotoDaVoltaMaisRapida = "";
$pilotosQueNaoTerminaram = "";

    foreach($result as $vetor => $r){
  if($r['voltaMaisRapida'] < $voltaMaisRapidadaCorrida){
    $voltaMaisRapidadaCorrida = $r['voltaMaisRapida'];
    $pilotoDaVoltaMaisRapida = $r['nome'];
  }

  if($r["numVoltas"] < 4) {
    $pilotosQueNaoTerminaram .= $r['nome'] . "(cod: " . $vetor . ");";

} else {
 
    $i++;
    echo "<tr>";
    echo "<td>$i</td>";
    echo "<td>$vetor</td>";
    echo "<td>" . $r['nome'] . "</td>";
    echo "<td>" . formatMilliseconds($r['tempoDeProva']) . "</td>";
    echo "<td>" . ($r["sumVelMedia"] / $r["numVoltas"]) . "</td>";
    echo "<td>" . formatMilliseconds($r['voltaMaisRapida']) . "</td>";
    echo "</tr>";
}
    }
}

?>
    </tbody>
</table>
<?php
if($acao == 1) {
    echo "A volta mais rápida da corrida foi de " . formatMilliseconds($voltaMaisRapidadaCorrida) . " executada pelo piloto $pilotoDaVoltaMaisRapida <br>"; 
    echo "Não terminou a prova: $pilotosQueNaoTerminaram";
}
?>
      </body>
</html

?>


