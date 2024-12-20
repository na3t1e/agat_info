## Установка (локально)

### Подготовка к установке

Если вы на Windows, то все эти инструкции нужно делать в [WSL](https://learn.microsoft.com/ru-ru/windows/wsl/install)

1. Передите в директорию docker:\
   ```cd docker```
2. Сгенерируйте SSL сертификат для локального домена:\
   ```openssl req -newkey rsa:2048 -new -nodes -x509 -days 3650 -keyout ./config/ssl/app.key -out ./config/ssl/app.crt```\
   и выберите указанные ниже параметры:

```
Country Name (2 letter code) [AU]:RU
State or Province Name (full name) [Some-State]:
Locality Name (eg, city) []:
Organization Name (eg, company) [Internet Widgits Pty Ltd]:
Organizational Unit Name (eg, section) []:
Common Name (e.g. server FQDN or YOUR name) []:agat-info.loc
Email Address []:
```

3. Скопируйте .env.example в .env \
   ```cp .env.example .env``` \
и укажите id пользователя и его группы (```id -u```-пользователь, ```id -g```-группа),\
укажите название и пароль базы данных\

4. ```docker-compose up -d``` или ```docker compose up -d```

5. в файле [Windows] [hosts](https://help.reg.ru/support/dns-servery-i-nastroyka-zony/rabota-s-dns-serverami/fayl-hosts-dlya-windows-10#0) [MacOS и Linux] [hosts](https://help.reg.ru/support/dns-servery-i-nastroyka-zony/rabota-s-dns-serverami/fayl-hosts-na-linux#:~:text=%D0%92%20Linux%20%D1%84%D0%B0%D0%B9%D0%BB%20hosts%20%D0%BD%D0%B0%D1%85%D0%BE%D0%B4%D0%B8%D1%82%D1%81%D1%8F%20%D0%B2%20%D0%BF%D0%B0%D0%BF%D0%BA%D0%B5%20%2Fetc%2Fhosts.) прописать:\
127.0.0.1 agat-info.loc.loc

### Основная установка

1. Скопируйте ```.env.example``` в ```.env``` (в корне проекта) и проставьте конфигурационные переменные
Зайти в docker-контейнер agat-info.loc-app и выполнить:

2. ```composer install```
3. ```php bin/console d:m:m```
