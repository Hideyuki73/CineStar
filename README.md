# CineStar
## Descrição
O CineStar é um site criado para que os usuários possam avaliar filmes, expressando suas opiniões pessoais. Ele oferece um espaço onde qualquer pessoa pode registrar filmes, atribuir notas e escrever descrições do que achou dos filmes. O foco está na simplicidade e usabilidade, tornando o sistema acessível para todos os tipos de usuários.

## Usado por
Principais usuários são os que assistem diversos filmes, de crianças a idosos.

## Diagrama
https://drive.google.com/file/d/1qf0WfyXkwxMwQ7O50s0TFNYGAFkt_eau/view?usp=drive_link

## Funcionalidades
### Cadastro e Login de Usuários
Permite que novos usuários criem contas para acessar o sistema.
Autenticação para garantir segurança no acesso às funcionalidades.
Gestão de Filmes

### Adicionar filmes com informações como nome, descrição e nota.
Editar informações de filmes já cadastrados.
Excluir filmes da coleção pessoal.

## Vinculação ao Usuário
Cada filme está vinculado ao usuário que o cadastrou, garantindo uma experiência personalizada.

## Tecnologias
O CineStar foi desenvolvido utilizando as seguintes tecnologias:

PHP: Backend para implementação da lógica de negócios.
PHPUnit: Framework de testes para garantir qualidade no código.
PostgreSQL: Banco de dados para armazenamento das informações.
Composer: Gerenciador de dependências PHP.
HTML/CSS/JavaScript: Desenvolvimento do frontend para interação do usuário.

## Rotas
### Backend
Usuários:
http://localhost:8080/src/api/users
(Endpoints para registro, login e gerenciamento de usuários)

Filmes:
http://localhost:8080/src/api/movies
(Endpoints para criação, edição e exclusão de filmes)

### Frontend
Telas:
http://localhost:8080/src/view/

## Configuração e Execução
Pré-requisitos
PHP (7.4 ou superior).
PostgreSQL.
Composer instalado globalmente.

## Dados necessários para o banco
$host = 'localhost';
$db = 'api';
$user = 'postgres';
$pass = 'unigran';
