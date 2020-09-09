### Importing Excel Data

#### project setup

- git clone 
- `composer install`
- `cp .env.example .env`
- change MAIL_TO in .env file to the email you want receive emails on
- create db lara_excel_importer
- php artisan migrate
- to start local queue worker `php artisan queue:work`
- run the project then navigate to homepage and test the importer