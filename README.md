Set environment
- Create database: contextus
- Import dump database from the root project: dump.sql
- Edit database vars (hostname, username, password) from /app project: config.php
- In terminal, from project root directory, run: composer install
- Run the application: http://localhost/contextus/app/

Run tests
- In terminal, from project root directory, run: ./vendor/bin/phpunit app/Tests 
