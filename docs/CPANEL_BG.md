# cPanel — NEXUS DEV

1. Избери PHP 8.2+ и включи `pdo_mysql`, `mbstring`, `curl`, `openssl`, `fileinfo`, `zip`.
2. Качи проекта извън `public_html`, например `/home/USER/nexus-game-cms`.
3. Насочи Document Root на домейна към `/home/USER/nexus-game-cms/public`.
4. Създай празна MySQL/MariaDB база и потребител с права само върху нея.
5. Отвори `/install` и завърши web installer-а.
6. След успех задай `.env` на права `600` или `640`.

