MarkdownReader
==============

Requirements
------------
   * PHP 7.2+
   * and the [usual Symfony application requirements][1]. 

Installation
------------

```bash
git clone https://github.com/linnit/markdownreader.git
cd markdownreader
composer install
```

Configure environment variables

```bash
cp .env .env.local
chmod 600 .env.local
```

Edit .env.local and update markdown directory

Clone the repository

```bash
./bin/console app:git-clone
```

Cron
----

Cron is used to keep the markdown repository up-to-date

Replace `<path-to-markdownreader>` with the full location of this repository

```
*/15 * * * *    <path-to-markdownreader>/bin/console app:git-pull
```

Docker
------

In `docker/.env` update `GIT_NOTES_REPOSITORY`, `VIRTUAL_HOST`, and `LETSENCRYPT_HOST`

```bash
cd docker
docker-compose up
```

[1]: https://symfony.com/doc/4.4/setup.html


