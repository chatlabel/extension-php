<?php
include './utils.php';

checkDomainAccess();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Primeira Extensão</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  
  <script src="https://fileschat.sfo2.cdn.digitaloceanspaces.com/public/libs/wlclient.js"></script>
  <style>
    body{
      height: 100%;
      width: 100%;
    }

    .list-buttons{
      text-align: center;
      display: flex;
      flex-direction: column;
      margin: 26px;
    }

    .btn-primary{
      background-color: #192d3e;
      border-color: #192d3e;
    }

    .btn-primary:hover{
      background-color: #192d3e;
      border-color: #192d3e;
    }
  </style>

  <script>
    $(document).ready(() => {
      $('#acao-modal').click(()=>{
        window.WlExtension.modal({
          title: 'Cotações de moeda',
          url: 'https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme', // URL da pagina para abrir iframe.
          maxWidth: '500px', // px ou %
          callback: (args)=>{
            alert('Fechou Modal');
          }
        });
      });

      $('#acao-alert').click(()=>{
        window.WlExtension.alert({
          message: 'Alert da suceso',
	        variant: 'success' // success, error, warning
        });
      });

      $('#acao-confirm').click(()=>{
        window.WlExtension.confirmDialog({
          title: 'Dialog de confirmação',
	        text: 'Exemplo de texto para tela de confirmação.',
          callback: (confirm) =>{
              alert('Resultado: ' + JSON.stringify(confirm));
          }
        });
      });

      $('#acao-fechar-modal').click(()=>{
        window.WlExtension.closeModal({
          name: 'teste',
          number: '659994837726'
        });
      });
    });
  </script>
</head>
<body>
  <p style="text-align:center">Exemplo de ações:</p>
  <div class="list-buttons">
    <button id="acao-modal" class="btn btn-primary my-2"> Abrir modal com iframe </button>
    <button id="acao-alert" class="btn btn-primary my-2"> Abrir um alerta </button>
    <button id="acao-confirm" class="btn btn-primary my-2"> Abrir um dialog de confirmação </button>
    <button id="acao-fechar-modal" class="btn btn-primary my-2"> Fechar modal</button>
  <div>
</body>
</html>