# 💸 PayMe - API

### Olá Dev 😉

<hr>

> <strong>Nota:</strong> Esta API foi desenvolvida utilizando o [Lumen Framework](https://lumen.laravel.com)

## Vamos lá? 👌

Primero, certifique-se que seu ambiente está pronto para rodar o projeto. Para isto, atente-se do que será necessário e suas versões:

* PHP 7.4
* Composer 2.1.9
* MySQL Server 8.0.26


Agora, faça um ``fork`` do projeto no seu github e clone-o onde preferir.

### Preparando o ambiente de desenvolvimento

> Caso esteja no Windows 10 ou 11 recomendo utilizar o WSL 2 caso queira usar o Docker, visto que o mesmo possui um desempenho melhor em sistemas Linux.

Se desejar, pode utilizar o [Laradock](https://github.com/laradock/laradock), será necessário configurar os seguintes serviços do laradock:

* Nginx
* PhpMyAdmin
* MySQL
* PHP Worker

Configure um site no Nginx utilizando o exemplo do Laravel, veja o exemplo:

```
#server {
#    listen 80;
#    server_name laravel.com.co;
#    return 301 https://laravel.com.co$request_uri;
#}

server {

    listen 80;
    listen [::]:80;

    # For https
    # listen 443 ssl;
    # listen [::]:443 ssl ipv6only=on;
    # ssl_certificate /etc/nginx/ssl/default.crt;
    # ssl_certificate_key /etc/nginx/ssl/default.key;

    server_name payme.localhost;
    root /var/www/payme/public;
    index index.php index.html index.htm;

    location / {
         try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_pass php-upstream;
        fastcgi_index index.php;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        #fixes timeouts
        fastcgi_read_timeout 600;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    location /.well-known/acme-challenge/ {
        root /var/www/letsencrypt/;
        log_not_found off;
    }

    error_log /var/log/nginx/laravel_error.log;
    access_log /var/log/nginx/laravel_access.log;
}
```

Configure o ``server_name`` e o declare no arquivo ``hosts`` em ``C:\Windows\System32\drivers\etc`` para que o domínio local funcione. O arquivo ``hosts`` deve estar com uma linha dessa forma: 
```
127.0.0.1 payme.localhost
```
Sendo que, primeiro, vem o endereço IP (no caso o localhost), seguido do domínio separados por um TAB.

Estando com todos os serviços ``docker`` configurados, basta executar o comando abaixo para criar os containers e subir tudo:

```
sudo docker-compose up -d nginx phpmyadmin mysql php-worker
```

## Com o ambiente criado, está na hora de colocar ``on-line`` a API 🌎

Caso esteja utilizano o ``docker``, seja com o ``laradock`` ou uma imagem pessoal, necessitará acessar o terminal ``bash`` do seu ``workspace`` com o comando:

```
sudo docker exec -it container_workspace_name /bin/bash
```

Para saber o ``container_workspace_name`` rode o comando:

```
sudo docker ps
```

No caso do laradock, pode ser um dos abaixo:

* ``laradock_workspace_1``
* ``laradock-workspace-1``

Este terminal ``docker`` deve conseguir acessar os arquivos do projeto e executar os comandos ``php``, ``php artisan`` e ``composer`` para que você possa prosseguir com os próximos passos.

Rode o comando ``composer install`` na pasta do projeto ``~/payme`` para instalar as dependências.

Configure o arquivo ``.env`` de modo que fique semelhante a este:

```env
APP_NAME=PayMe
APP_ENV=local
APP_KEY=api_secret_key
APP_DEBUG=true
APP_URL=http://payme.localhost
APP_TIMEZONE=America/Sao_Paulo

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=payme
DB_USERNAME=payme
DB_PASSWORD=database_password

CACHE_DRIVER=file
QUEUE_CONNECTION=database

URL_API_TRANSFER_VERIFY=
URL_API_SEND_NOTIFY=

```

Configure os seguintes ``URL_API_TRANSFER_VERIFY`` e ``URL_API_SEND_NOTIFY`` com ``URLs`` para serviços ``mock`` a fim de simular a verificação de transferência e o envio de notificações respectivamente.

Deixe o ``QUEUE_CONNECTION`` como ``DATABASE`` para que as filas sejam criadas. E rode o comando ``php artisan queue:work`` em um novo terminal aberto na pasta do projeto para executar os processos em fila.

Crie um novo banco e dados e configure no ``.env``. 

Atente-se para o checklist do ``.env``:

* APP_NAME: Set and verified ✅
* APP_ENV: local ✅
* API_KEY: Configured ✅
* DB_CONNECTION: Configured ✅
* DB_HOST: Configured ✅
* DB_PORT: Configured ✅
* DB_DATABASE: Configured ✅
* DB_USERNAME: Configured ✅
* DB_PASSWORD: Configured ✅
* QUEUE_CONNECTION: Configured ✅
* URL_API_TRANSFER_VERIFY: Setted ✅
* URL_API_SEND_NOTIFY: Setted ✅

###  Tudo ok? 👌

Execute o comando ``php artisan jwt:secret`` para criar a chave secreta o ``JWT Auth`` e o ``php artisan migrate --seed`` para rodar as migrações do banco de dados.

Caso esteja com o ``docker`` basta acessar o domínio que você configurou no ``Nginx``. 

Se não, rode o comando ``php -S localhost:8000 -t public`` na pasta do projeto para iniciar o servidor.

Se desejar, execute ``vendor/bin/phpunit`` para rodar os testes automatizados da aplicação e certificar-se de que está tudo certo com a ``API``. 

## Muito bem! O processo foi concluido 🎉

Para saber quais os ``endpoints`` disponíveis na ``API``, veja a documentação no [POSTMAN](https://documenter.getpostman.com/view/9336516/UVXqECdw)

Outras documentações

[Lumen Framework](https://lumen.laravel.com/docs/) <br>
[Laravel Framework](https://laravel.com/docs)

Desenvolvido por [Douglas Menezes](https://douglasmenezes.dev.br) <br>
<small>@MIT License</small>
