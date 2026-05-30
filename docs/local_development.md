Local development
=================

### Preconditions

To get started, ensure [docker](https://docs.docker.com/engine/install/)
and [docker-compose](https://docs.docker.com/compose/install/) are installed.
It is expected that you are familiar with them.

### Start up project

1. Start the docker container:
    ```shell
   docker compose up -d
   ```
2. Install packages required by composer:
   ```shell
   docker compose exec php-cli composer install
   ```
3. Install dev-tools by PHIVE:
   ```shell
   docker compose exec php-cli composer phive-install
   ```
4. Connect to the container for the calling of [dev-tools](used_code_quality_tools.md)
   defined in [composer.json](../composer.json)
   ```shell
   docker compose exec php-cli bash
   ```

### Dev Notes

When running composer scripts from the host instead of inside the container, prefix them with
`docker compose exec php-cli ` (for example, `docker compose exec php-cli composer test-all`).
