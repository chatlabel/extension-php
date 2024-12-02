# Exemplo extensão WL

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
 - [WlExtension.openWidget();](#open-widget)
 - [WlExtension.load();](#load)


Ex:

~~~
<script src="https://fileschat.sfo2.cdn.digitaloceanspaces.com/public/libs/wlclient.js"></script>
~~~

--------

## .initialize  <span id="initialize"></span>


- Após importar podemos utilizar a função `window.WlExtension.initialize()` para definir botões e ações que serão configuradas quando a sua extensão for carregada no sistema.

### Botões de ações

  Podemos definir botões no topo da lista de contatos, lista de atendimento ou topo da tela atendimento.

- Lista de contatos, `contacts-list`

![Lista de contatos](assets/prints/list-contacts.png)

- Lista de atendimento, `attendance-list`

![Lista de contatos](assets/prints/attendance-list.png)

- Topo da tela atendimento, `attendance-view`

![Topo da tela atendimento](assets/prints/attendance-view.png)


### Novo menu na navbar

Também podemos definir novos menus, precisamos somente definir a opção `navbar` dentro de `.initialize()`.

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
- `group` - Cria um grupo de botões.
- `item` - Cria um botão, onde acionará o evento de `callback` da propriedade quando for clicado.


Também podemos criar um item num menu já existente, colocando o ID do grupo na propriedade `parentId`. Hoje temos os seguintes grupos de menu e seus IDs, respectivamente:

- Atendimentos: `services`
- Indicadores: `indicators`
- Ajuda: `help`
- Administrativos: `admins`
- Módulos: `modules`
- Financeiro: `financial`


![Menu lateral](assets/prints/navbar.png)


### Eventos 
O sistema emite diversos eventos, e podemos definir callbacks a eles na propriedade `events`. Abaixo, segue a lista de eventos emitidos pelo sistema: 

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
  });
~~~

*Nos botões de tipo `attendance-view`, o callback retorna um objeto no primeiro argumento com as informações do atendimento em foco.*



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
Ao usar a função `.closeModal()`, podemos enviar um objeto com argumentos para recuperar no callback definido na função `.modal({})`.

~~~
 window.WlExtension.closeModal({
    name: 'teste',
    number: '659994837726'
  });
~~~

## Emitir alerta <span id="alert"></span>
Tipos disponíveis de alerta: ``sucess`` / ``error`` / ``warning``

~~~
 window.WlExtension.alert({
    message: 'Alerta de suceso',
    variant: 'success' // success, error, warning
  });
~~~


## Abrir tela de confirmação <span id="confirm-dialog"></span>

~~~
  window.WlExtension.confirmDialog({
    title: 'Dialog de confirmação',
    text: 'Exemplo de texto para tela de confirmação.',
    callback: (confirm) => {
      alert('Resultado: ' + JSON.stringify(confirm));
    }
  });
~~~

## Busca lista de canal disponível para usuário <span id="get-channels"></span>

~~~
  window.WlExtension.getInfoChannels()
    .then((channels) => {
      
    });
~~~

## Busca infomação do usuário logado <span id="get-user"></span>

Função retorna um objeto com `userId` e `systemId`.

~~~
   window.WlExtension.getInfoUser()
    .then((data) => {
      console.log(data.userId);
      console.log(data.systemKey)
    });
~~~

## Abrir página dentro do sistema <span id="open-page"></span>

~~~
  window.WlExtension.openPage({
    url: 'https://br.widgets.investing.com/live-currency-cross-rates?theme=darkTheme'
  });
~~~

## Abrir widget da extensão <span id="open-widget"></span>

A função só trará algum resultado no caso da extensão ter sido carregada por uma extensão de tipo WIDGET.
Fará com que a aba do Widget seja aberta na tela do usuário.

~~~
  window.WlExtension.openWidget();
~~~

## Carrega página no widget da extensão <span id="load"></span>

~~~
  window.WlExtension.load({
    url: 'https://chatlabel.com/extension-demo/acoes.php'
  });
~~~

