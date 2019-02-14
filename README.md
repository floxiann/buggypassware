# buggypassware

Для запуска тестов понадобится (если нужно запускать в браузере, например, в chrome):

- Сhromedriver
- Chrome 67.0.3396.99
- Selenium-server-standalone

Запуск Selenium: java -jar selenium-server-standalone-3.141.59.jar

Создать файл в корне проекта .env по аналогии с .example.env

Запуск тестов: codecept run --steps -d
