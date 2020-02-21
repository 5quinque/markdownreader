MarkdownReader
==============

Requirements
------------
   * PHP 7.1+
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

Cron
----

Cron is used to keep the markdown repository up-to-date

Replace `<path-to-markdownreader>` with the full location of this repository

```
*/15 * * * *    <path-to-markdownreader>/bin/console app:git-pull
```

[1]: https://symfony.com/doc/4.4/setup.html


