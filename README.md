## E-Procurement


##### Requirements:
- PHP 8.2.4
- NodeJS 18.16.1
- composer 2.7.2
- mysql 8.2.4

##### Run:
- npm install
- composer install
- php artisan key:generate
- php artisan storage:link
- php artisan migrate
- php artisan passport:keys
- php artisan passport:install
- php artisan passport:client
-  Which API are repeated?  there are total 4 logins
- php artisan db:seed (To modify or verify the values of **Admin** or **Organization**, please refer to the files `database\seeders\OrganizationSeeder.php` or `database\seeders\AdminSeeder.php`.)
- npm run build


##### In `.env` file set the following:
- Set Basic Auth Username and password
- Set API Service CLIENT ID & SECRET
- Set Business Central URLs and Auth Details
- Set Database config
- Set Mailing config
- Set APP config
- Import Countries and States in DB

##### User Pages:
- Admin: http://localhost:8000/admin
- RFQ USER: http://localhost:8000/rfq
- Vendor(V1): http://localhost:8000/register/{ID}
- Vendor(V2): http://localhost:8000/sign-in