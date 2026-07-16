# CyberPanel / OpenLiteSpeed — NEXUS DEV

## Препоръчителна структура

Качи приложението в:

```text
/home/community.cs2monitor.eu/nexus-game-cms
```

Document Root трябва да бъде:

```text
/home/community.cs2monitor.eu/nexus-game-cms/public
```

В CyberPanel отвори `Websites → List Websites → Manage → vHost Conf` и промени `docRoot`. След запазване рестартирай LiteSpeed веднъж.

Папките `storage` и `bootstrap/cache` трябва да могат да се записват от PHP процеса. Не използвай права `777`.

След това отвори:

```text
https://community.cs2monitor.eu/install
```

Инсталаторът създава `.env`, мигрира базата и създава owner профила. След успешна инсталация marker файлът `storage/app/nexus-installed` блокира повторното стартиране на installer-а.

