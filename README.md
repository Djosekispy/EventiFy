
# EventiFy

**EventiFy** é uma aplicação moderna de gerenciamento de eventos projetada para simplificar a criação, participação, e gerenciamento de eventos, oferecendo uma experiência de usuário fluída tanto para organizadores quanto para participantes. O sistema é completo e abrange desde o CRUD de eventos até notificações, permissões avançadas, e funcionalidades interativas como convites, lembretes, e compartilhamento de eventos.

## Funcionalidades

### 1. **CRUD de Eventos**
- **Criar, Editar, Visualizar e Excluir** eventos de forma fácil e eficiente.
- Cada evento contém informações como título, descrição, data, local e status.
- Suporte para eventos públicos e privados, com controle de visibilidade.

### 2. **Notificação para Participantes**
- O sistema envia notificações automáticas para os participantes sempre que há alterações importantes em um evento, como atualização de horário ou local.
- Notificações por **e-mail** sobre eventos futuros e lembretes de sessões.

### 3. **Notificação para Criador**
- O criador de um evento recebe **notificações** quando alterações significativas são feitas no evento (por exemplo, quando um participante é adicionado ou quando o evento é alterado).
- A comunicação entre o organizador e os participantes é eficiente e garantida.

### 4. **Definir Permissões de Atualização no Evento**
- Apenas o **criador** do evento tem permissão para realizar atualizações no evento (edição de título, data, local, etc.).
- Implementação de **controle de acesso** para garantir que somente o criador tenha privilégios administrativos sobre o evento.

### 5. **Participar de um Evento**
- Usuários podem se **inscrever** facilmente em eventos e visualizar as sessões disponíveis.
- Interface intuitiva para gestão de inscrições, permitindo aos participantes se manterem atualizados sobre os eventos em que estão envolvidos.

### 6. **Convidar Pessoas**
- Os organizadores podem **convidar** pessoas para participar de eventos, seja por e-mail ou através de links diretos.
- Sistema de convites com confirmação de participação e acompanhamento do status dos convidados.

### 7. **Enviar Lembretes**
- **Lembretes automáticos** são enviados antes de eventos e sessões para garantir que os participantes estejam sempre informados e preparados.
- Funcionalidade de **envio de e-mails** com detalhes sobre horários, sessões e atualizações.

### 8. **Partilhar Evento**
- Os usuários podem **compartilhar eventos** nas redes sociais ou por link direto, aumentando a visibilidade e o alcance dos eventos.
- Funcionalidade integrada para compartilhamento via **Facebook, Twitter, WhatsApp** e outras plataformas.

### 9. **Ver Galeria de Fotos**
- Cada evento possui uma **galeria de fotos**, onde os participantes podem visualizar imagens relacionadas ao evento.
- Os organizadores podem adicionar fotos da **prévia do evento** ou de **eventos passados**.

### 10. **Funcionalidade Extra (Ainda não foram adicionadas)**
- **Controle de sessões** dentro de eventos para que os participantes possam visualizar e se inscrever em sessões específicas.
- **Feedback** pós-evento para avaliação da experiência do participante.
- **Integração com calendários**, permitindo adicionar o evento ao Google Calendar ou outros calendários online.
- **Pesquisa e filtro** avançado de eventos, com base em data, tipo, e local.

---

## Tecnologias Utilizadas

- **Backend:** Laravel (PHP)
- **Frontend:** Vue.js (ou outro framework de sua preferência)
- **Banco de Dados:** MySQL 
- **Notificações:** E-mail via SMTP
- **Autenticação:** Laravel Auth (com suporte para login social, se desejado)

## Instalação

### 1. Clone o Repositório

```bash
git clone https://github.com/Djosekispy/Eventify.git
cd Eventify
```

### 2. Instale as Dependências

```bash
composer install
npm install
```

### 3. Configuração do Ambiente

- Crie um arquivo `.env` a partir do arquivo `.env.example`:

```bash
cp .env.example .env
```

- Configure seu banco de dados, e-mail e outras variáveis de ambiente no arquivo `.env`.

### 4. Execute as Migrations

```bash
php artisan migrate
```

### 5. Inicie o Servidor

```bash
php artisan serve
npm run dev
```

Agora a aplicação estará rodando localmente no endereço `http://localhost:8000`.

## Contribuição

Contribuições são bem-vindas! Se você deseja contribuir para o projeto, siga os seguintes passos:

1. Faça um fork do repositório.
2. Crie uma nova branch para sua feature (`git checkout -b feature/nova-feature`).
3. Faça commit das suas mudanças (`git commit -am 'Adicionando nova feature'`).
4. Envie para o repositório remoto (`git push origin feature/nova-feature`).
5. Abra um pull request.

## Licença

Este projeto está licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT).


## Imagens de Tela (opcional)

