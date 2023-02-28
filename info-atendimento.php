<?php
include './utils.php';

checkDomainAccess();

const API_TOKEN = '*****';

$statusAtendimento = [
  'automatico', 'aguardando', 'manual', 'finalizado', 'pesquisa_satisfacao', 'fora_de_hora'
];

function callAPI($method, $url, $data){
  $curl = curl_init();
  switch ($method){
     case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data)
           curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
     case "PUT":
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if ($data)
           curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
        break;
     default:
        if ($data)
           $url = sprintf("%s?%s", $url, http_build_query($data));
  }
  // OPTIONS:
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
     'access-token:'.API_TOKEN,
     'Content-Type: application/json',
  ));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  // EXECUTE:
  $result = curl_exec($curl);
  $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  if(!$result){die("Connection Failure");}
  curl_close($curl);

  return [ 'result' =>json_decode($result, true) , 'statusCode' => $httpcode];
}

$atendimentoId = isset($_GET['atendimentoId']) ? $_GET['atendimentoId'] : null;

$result = callAPI('GET','https://api.chatlabel.com/core/v2/api/chats/'.$atendimentoId,false);

$atendimento = null;
$error = false;

if($result['statusCode'] != 200){
  $error = true;
}else{
  $atendimento = $result['result'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Infomação do atendimento</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  
  <script src="https://fileschat.sfo2.cdn.digitaloceanspaces.com/public/libs/wlclient.js"></script>
  
  <style>
    body {
      height: 100%;
      width: 100%;
    }

    /* for card */
    .card {
      width: 500px;
      border: none;
      border-radius: 10px;
      background-color: #fff
    }

    .stats {
      background: #f2f5f8 !important;
      color: #000 !important
    }

    .articles {
      font-size: 10px;
      color: #a1aab9
    }

    .number1 {
      font-weight: 500
    }

    .followers {
      font-size: 10px;
      color: #a1aab9
    }

    .number2 {
      text-align: center;
      font-weight: 500
    }

    .rating {
      font-size: 10px;
      color: #a1aab9
    }

    .number3 {
      font-weight: 500
    }

    /* for card end*/
    
  </style>
</head>

<body>
  <!-- for card -->

  <?php if(!$error) { ?>
  <div class="card p-3">
    <div class="d-flex align-items-center">
      <div class="image"> <img
          src="<?php echo $atendimento['linkImage']?>"
          class="rounded" width="155"> </div>
      <div class="ml-3 w-100" style="margin-left: 10px;">
        <h4 class="mb-0 mt-0"><?php echo $atendimento['contact']['name'] ?></h4> <span><?php echo $atendimento['contact']['secondaryName'] ?> </span>
        <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
          <div class="d-flex flex-column"> <span class="articles">Status</span> <span class="number1"><?php echo $statusAtendimento[$atendimento['status']] ?></span> </div>
          <div class="d-flex flex-column"> <span class="followers">Total mensagem</span> <span class="number2"><?php echo count($atendimento['messages']) ?></span>
          </div>
        </div>
        <div class="button mt-2 d-flex flex-row align-items-center"> <button
            class="btn btn-sm btn-outline-primary w-100">Chat</button> <button
            class="btn btn-sm btn-primary w-100 ml-2">Follow</button> </div>
      </div>
    </div>
  </div>

  <?php }else{ ?>
    <div>
      <p style="text-align:center;">Ops. Não foi possível buscar informação!</p>
    </div>  
  <?php } ?>
  <!-- for card end-->
</body>

</html> 