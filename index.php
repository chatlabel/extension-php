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

  <script src="https://fileschat.sfo2.cdn.digitaloceanspaces.com/public/libs/wlclient-0.0.2.js"></script>

  <style>
    html,
    body {
      height: 100%;
      width: 100%;
    }

    .loader {
      width: 100%; 
      height: 100%; 
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #list-channel > {
      text-align: left;
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
      window.WlExtension.initialize({
        buttons: {
          'contacts-list': [
            {
              text: 'Botao Alert',
              callback: (wl) => {
                window.WlExtension.alert({
                  message: 'Mensagem de sucesso',
                  variant: 'success'
                });
              },
            },
            {
              text: 'Botao Confirm',
              callback: (wl) => {
                window.WlExtension.confirmDialog({
                  text: 'Texto...',
                  title: 'Dialog de confirmacao',
                  callback: (confirm) => {
                    console.log(confirm);
                    window.WlExtension
                      .getInfoChannels()
                      .then((data)=> {
                        console.log(data);
                      })
                  }
                })
              },
            },
          ],
          'attendance-view': [
            {
              icon_url: 'https://chatlabel.com/extension-demo/docs/profile.png',
              text: 'Ver Perfil',
              callback: (atendimento) => {
                window.WlExtension.modal({
                  url: `https://chatlabel.com/extension-demo/info-atendimento.php?atendimentoId=${atendimento.atendimentoId}`,
                  title: 'Perfil',
                  maxWidth: '500px',
                  height: '300px'
                });
              },
            }
          ],
          'attendance-list': [
            {
              text: 'Lista de ações',
              callback: () => {
                window.WlExtension.modal({
                  title: 'Lista de ações',
                  url: 'https://chatlabel.com/extension-demo/acoes.php',
                  maxWidth: '500px'
                });
              },
            }
          ]
        },
        events: {
          'onOpenAttendance': (attendance) => {
            // Evento é emitido quando clicado no atendimento
            console.log(`onOpenAttendance`,attendance);
          },
          'onFocusAttendance': (attendance) => {
            // Evento é emitido quando atendimento recebe foco
            console.log(`onFocusAttendance`,attendance);
          },
          'onCloseAttendance': (attendance) => {
            // Evento é emitido quando é fechado a tela do atendimento
            console.log(`onCloseAttendance`,attendance);
          },
          'onOpenHistoricAttendance': (attendance) =>{
            // Evento é emitido quando é clicado no atendimento no histórico de atendimento.
            console.log(`onOpenHistoricAttendance`,attendance);
          },
          'onCloseHistoricAttendance': (attendance) =>{
            // Evento é emitido quando é fechado a tela do atendimento na página histórico de atendimento
            console.log(`onCloseHistoricAttendance`,attendance);
          },
          'onChatPage': () =>{
            // Evento é emitido quando é navegado para tela de atendimentos.
            console.log(`onChatPage`);
          },
          'onHistoricPage': () =>{
            // Evento é emitido quando é navegado para página histórico de atendimentos.
            console.log(`onHistoricPage`);
          }
        },
        navbar: [
          {
            id: 'group_extensao_1',
            icon_url: 'https://chatlabel.com/extension-demo/docs/shopping.png',
            text: 'Teste',
            type: 'group', // group / item
          },
          {
            id: 'ext_1',
            type: 'item',
            icon_url: 'https://chatlabel.com/extension-demo/docs/info.png', // icon 16x16
            text: 'Extensao item',
            parentId: 'modules',
            callback: () => {
              window.WlExtension.openPage({
                url: "https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme"
              })
            }
          },
          {
            id: 'ext_2',
            type: 'item',
            icon_url: 'https://chatlabel.com/extension-demo/docs/info.png', // icon 16x16
            text: 'Investing',
            parentId: 'group_extensao_1',
            callback: () => {
              console.log('Stack overflow')
              window.WlExtension.openPage({
                url: "https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme"
              })
            }
          },
          {
            id: 'ext_3',
            type: 'item',
            icon_url: 'https://chatlabel.com/extension-demo/docs/info.png', // icon 16x16
            text: 'Yahoo Finance',
            parentId: 'group_extensao_1',
            callback: () => {
              window.WlExtension.openPage({
                url: "https://finance.yahoo.com/quote/YM%3DF?p=YM%3DF"
              })
            }
          },
        ]
      })

      $('.loader').hide();

      $('#buscar-dados').click(() => {
        window.WlExtension.getInfoUser()
          .then((data) => {
            $('#list-organization').text(`Usuário ID: ${data.userId} \n Cód Sistema: ${data.systemKey}`)
          });
      });

      $('#buscar-canais').click(() => {
        window.WlExtension.getInfoChannels()
          .then((channels) => {
            channels.forEach((channel) =>{
              $('#list-channel').append(`<li> ${channel.descricao} | ${channel.status} </li>`);
            });
          });
      });

      $('#buscar-acoes').click(()=>{
        window.WlExtension.modal({
          title: 'Lista de ações',
          url: 'https://chatlabel.com/extension-demo/acoes.php',
          maxWidth: '500px'
        });
      });

      $('#recarregar-widget').click(()=>{
        // Recarrega nova pagina no widget da extensão.
        window.WlExtension.load({
          url: 'https://chatlabel.com/extension-demo/acoes.php'
        });
      })
    });
  </script>
</head>

<body>
  <div style="text-align:center">
    <button id="buscar-dados" class="btn btn-primary my-2"> Buscar dados empresa</button>
    <button id="buscar-canais" class="btn btn-primary my-2"> Buscar dados canais </button>
    <button id="buscar-acoes" class="btn btn-primary my-2"> Lista de funções </button>
    <button id="recarregar-widget" class="btn btn-primary my-2"> Recarregar iframe </button>
  <div>

  <hr>
  <p id="list-organization"></p>
  <hr>
  <ul id="list-channel"></ul>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>
</html>