Shopinv progress:
- Scope of project
+ CRUD Product
+ Single Page product
- Requirement environment:
+ composer
+ php8.1
+ mysql/mariadb
Setup step:
1. run install laravel latest: composer create-project laravel/laravel shopinv
2. Config .env file to empty database name: shopinv (mariadb)
3. php artisan serve
https://prnt.sc/SdZ9SL6uDHgH
4. git init
+ git init shopinv
+  git add *
+ git commit -m "init"
+ git remote add origin https://github.com/toan10921/shopinv.git
+ git push origin master
5. design quick db
According Requirement
I will create following tables in database/migration:
brand (id, name)
images (id, image_path)
product (id , name, price, brand_id, desc) -> foreign key to brand_id
product_image (id, product_id ,image_id) => foreign key to product_id, image_id

+ php artisan make:migration create_table_brands
+ php artisan make:migration create_table_products
+ php artisan make:migration create_table_images
+ php artisan make:migration create_table_product_images

6. migrate:
+ php artisan migrate
Showing results after migrate:
https://prnt.sc/g_kdO5xPPYzn


6. Init boostrap framework for quick dev & create authorization for backend. I can do it manually, but for quick init i use Bootstrap auth dependency of laravel, vite.js serve boostrap

+ composer require laravel/ui
+ php artisan ui bootstrap --auth
+ npm install # isntall module npm
+ npm run dev # service vitejs

Results:

https://prnt.sc/fPgQbp-hh09z


After that, HomeController created automatically, file changes result:
https://prnt.sc/r3v2jUmjRZTT

Login route:
https://prnt.sc/r_D2pWKmSUaZ

Create model for all tables


Insert sample db:

make all Seeders
run Seeders

Start coding
