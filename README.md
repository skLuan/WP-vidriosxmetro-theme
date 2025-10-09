# WordPress Docker Setup

This setup provides a WordPress application running on OpenLiteSpeed (simulating LiteSpeed) with the specified configurations.

## Prerequisites

- Docker and Docker Compose installed
- Existing MySQL container named `mysql_general` running in the `develop-net` network with the database `vidriosxmetro_wp988` accessible by user `vidriosxmetro_wp988` with password `password!`

## Configuration

- WordPress version: 6.8.3 with PHP 8.1
- Language: Spanish (es_ES)
- Database: vidriosxmetro_wp988 on mysql_general:3306
- PHP configurations: memory_limit=1G, upload_max_filesize=1G, etc. (see php.ini)
- Environment variables: Configured in .env file for security

## Running the Setup

1. Ensure the MySQL container is running:
   ```bash
   docker ps | grep mysql_general
   ```

2. Start the WordPress container:
   ```bash
   docker-compose up -d
   ```

3. Access WordPress at http://localhost:8080

4. Complete the WordPress installation if needed, or restore from backup.

## Volumes

- `./wp-content` is mounted for theme/plugin persistence
- `./php.ini` is mounted for PHP configuration

## Notes

- If the database needs to be created, ensure the MySQL container has the database and user set up.
- For production, adjust security settings and backups.