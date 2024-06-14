# Exemplo extensão WL.

Montamos uma pequena biblioteca javascript para facilitar a interação com nosso sistema. Ela fornece um objeto global `window.WlExtension`, para utilizar basta importar a biblioteca no seu arquivo `.html`.


### Lista de métodos da `window.WlExtension`

 - [WlExtension.initialize(options);](#initialize)
 - [WlExtension.modal(options);](#modal)
 - [WlExtension.closeModal();](#close-modal)
 - [WlExtension.alert(options);](#alert)
 - [WlExtension.confirmDialog(options);](#confirm-dialog)
 - [WlExtension.alert(options);](#alert)
 - [WlExtension.getInfoChannels();](#get-channels)
 - [WlExtension.getInfoUser();](#get-user)
 - [WlExtension.openPage();](#open-page)
 - [WlExtension.load();](#load)


Ex:

~~~
<script src="https://fileschat.sfo2.cdn.digitaloceanspaces.com/public/libs/wlclient-0.0.2.js"></script>
~~~

--------

## .initialize  <span id="initialize"></span>


- Após importar podemos utilizar a função `window.WlExtension.initialize()` para definir botões e ações que serão configuradas quando a sua extensão for carregada no sistema.

### Botões de ações

  Podemos definir botões no topo da lista de contatos, lista de atendimento ou topo da tela atendimento.

- Lista de contatos, `contacts-list`

![Lista de contatos](./docs/prints/list-contacts.png)

- Lista de atendimento, `attendance-list`

![Lista de contatos](./docs/prints/attendance-list.png)

- Topo da tela atendimento, `attendance-view`

![Topo da tela atendimento](./docs/prints/attendance-view.png)


### Novo menu na navbar

Tambem podemos definir novos menus, precisamos somente definir a opção `navbar` dentro de `.initialize()`.

~~~
  navbar: [
    {
      id: 'group_extension',
      icon_url: 'http://localhost/docs/shopping.png',
      text: 'Teste',
      type: 'group',
    },
    {
      id: 'ext_1',
      type: 'item',
      icon_url: 'http://localhost/docs/info.png', // icon 16x16
      text: 'Extensao item',
      parentId: 'modules',
      callback: () => {
        window.WlExtension.openPage({
          url: "https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme"
        })
      }
    }
  ]
~~~


Opções de tipo de menu:
- `group` - cria um grupo.
- `item` - Cria um botão, podemos pegar evento `callback` na propriedade quando for clicado.


Também podemos criar um item dentro de um menu já existente, colocando o id do grupo na propriedade `parentId`, hoje temos seguinte grupos de menu.

- Atendimentos  id: `services`
- Indicadores id: `indications`
- Ajuda id: `help`
- Administrativos id: `admins`
- Módulos id: `modules`
- Financeiro id: `financial`


![Menu lateral](./docs/prints/navbar.png)


### Eventos 
O sistema emite vários eventos, e podemos defini-los na propriedade `events`. Abaixo, segue a lista de eventos emitidos pelo sistema: 

* `onOpenAttendance`: Evento é emitido quando se clica no atendimento.
* `onFocusAttendance`: Evento é emitido quando o atendimento recebe foco.
* `onCloseAttendance`: Evento é emitido quando a tela do atendimento é fechada.
* `onOpenHistoricAttendance`: Evento é emitido quando se clica no atendimento no histórico de atendimento.
* `onCloseHistoricAttendance`: Evento é emitido quando a tela do atendimento é fechada na página de histórico de atendimento.
* `onChatPage`: Evento é emitido quando se navega para a tela de atendimentos.
* `onHistoricPage`: Evento é emitido quando se navega para a página de histórico de atendimentos.



Ex: 

~~~
  window.WlExtension.initialize({
    buttons: {
      'contacts-list': [
          {
            icon_url: 'http://localhost/docs/profile.png', // Opcional icone 25x25 
            text: 'Botao Alert',
            callback: () => {
              window.WlExtension.alert({
                message: 'Mensagem de sucesso',
                variant: 'success'
              });
            },
          }
        ],
        'attendance-view': [
          {
            text: 'Ver Perfil',
            callback: (atendimento) => {
              window.WlExtension.modal({
                url: `http://localhost/info-atendimento.php?atendimentoId=${atendimento.atendimentoId}`,
                title: 'Perfil',
                maxWidth: '500px',
                height: '300px'
              });
            },
          }
        ]
    },
    events: {
      'onOpenAttendance': (attendance) => {
        // Evento é emitido quando se clica no atendimento.
        console.log(`onOpenAttendance`,attendance);
      },
      'onFocusAttendance': (attendance) => {
        // Evento é emitido quando o atendimento recebe foco.
        console.log(`onFocusAttendance`,attendance);
      },
      'onCloseAttendance': (attendance) => {
        // Evento é emitido quando a tela do atendimento é fechada.
        console.log(`onCloseAttendance`,attendance);
      },
      'onOpenHistoricAttendance': (attendance) =>{
        // Evento é emitido quando se clica no atendimento no histórico de atendimento.
        console.log(`onOpenHistoricAttendance`,attendance);
      },
      'onCloseHistoricAttendance': (attendance) =>{
        // Evento é emitido quando a tela do atendimento é fechada na página de histórico de atendimento.
        console.log(`onCloseHistoricAttendance`,attendance);
      },
      'onChatPage': () =>{
        // Evento é emitido quando se navega para a tela de atendimentos.
        console.log(`onChatPage`);
      },
      'onHistoricPage': () =>{
        // Evento é emitido quando se navega para a página de histórico de atendimentos.
        console.log(`onHistoricPage`);
      }
    },
    navbar: [
      {
        id: 'group_extension',
        icon_url: 'http://localhost/docs/shopping.png',
        text: 'Teste',
        type: 'group',
      },
      {
        id: 'ext_1',
        type: 'item',
        icon_url: 'http://localhost/docs/info.png', // icon 16x16
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
        icon_url: 'http://localhost/docs/info.png', // icon 16x16
        text: 'Investing',
        parentId: 'group_extension',
        callback: () => {
          window.WlExtension.openPage({
            url: "https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme"
          })
        }
      },
      {
        id: 'ext_3',
        type: 'item',
        icon_url: 'http://localhost/docs/info.png', // icon 16x16
        text: 'Yahoo Finance',
        parentId: 'group_extension',
        callback: () => {
          window.WlExtension.openPage({
            url: "https://finance.yahoo.com/quote/YM%3DF?p=YM%3DF"
          })
        }
      },
    ]
  })
~~~

*Nos botões tipo `attendance-view` o callback retorna um objeto no primeiro argumento com atendimento em foco.*



# Funções adicionais


## Abrir modal <span id="modal"></span>

~~~
  window.WlExtension.modal({
    title: 'Cotações de moeda',
    url: 'https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme', // URL da pagina para abrir iframe.
    maxWidth: '500px', // px ou %
    callback: (args)=>{
      alert('Fechou Modal');
    }
  });
~~~

## Fecha modal <span id="close-modal"></span>
ao usar funcao `.closeModal()` podemos um objeto com argumentos para recuperar no callback definido na função `.modal({})`.

~~~
 window.WlExtension.closeModal({
    name: 'teste',
    number: '659994837726'
  });
~~~

## Emitir alerta <span id="alert"></span>
Tipo diponiveis de alerta: ``sucess`` / ``error`` / ``warning``

~~~
 window.WlExtension.alert({
    message: 'Alert da suceso',
    variant: 'success' // success, error, warning
  });
~~~


## Abrir tela de confirmação <span id="confirm-dialog"></span>

~~~
  window.WlExtension.confirmDialog({
    title: 'Dialog de confirmação',
    text: 'Exemplo de texto para tela de confirmação.',
    callback: (confirm) =>{
      alert('Resultado: ' + JSON.stringify(confirm));
    }
  });
~~~

## Abrir um alerta <span id="alert"></span>

~~~
  window.WlExtension.alert({
    message: 'Alert da suceso',
    variant: 'success' // success, error, warning
  });
~~~



## Busca lista de canal disponível para usuário <span id="get-channels"></span>

~~~
  window.WlExtension.getInfoChannels()
    .then((channels) => {
      
    });
~~~

## Busca infomação do usuário logado. <span id="get-user"></span>

Função retorna um objeto com `userId` e `systemId`.

~~~
   window.WlExtension.getInfoUser()
    .then((data) => {
      console.log(data.userId);
      console.log(data.systemKey)
    })
~~~


## Abrir página dentro do sistema. <span id="open-page"></span>

~~~
  window.WlExtension.openPage({
    url: 'https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme'
  });
~~~

## Carrega página no widget da extensão. <span id="load"></span>

~~~
  window.WlExtension.load({
    url: 'https://chatlabel.com/extension-demo/acoes.php'
  });
~~~

