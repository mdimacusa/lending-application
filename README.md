<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Lending Application

It is a admin side application for lending business

#Template Color
<p align="center">
    <img src="https://github.com/mdimacusa/lendingapp-laravel-bootstrap-jquery/assets/58607617/1f731d70-8495-475e-a015-d802d1725c50" width="400" alt="Light Dashboard">
    <img src="https://github.com/mdimacusa/lendingapp-laravel-bootstrap-jquery/assets/58607617/98d7b52c-d99b-4794-b6c2-92af1dd77396" width="400" alt="Dark Dashboard">
</p>

## Techstack
Laravel|Jquery|Bootstrap|Mysql

## How to use this application
Step 1. Clone the repository with git clone
Step 2. Create "lendingapp" Database on Mysql
Step 3. To create all tables on database "Run php artisan migrate:fresh --seed"
Step 4. If you want to run send mail on lending app, you have to create your own credential. Check this link -> https://knowledge.workspace.google.com/kb/how-to-create-app-passwords-000009237
Step 5. Just put the app password credential on .env like the format below just change the MAIL_USERNAME and MAIL_PASSWORD:
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=YOUR_EMAIL
    MAIL_PASSWORD=YOUR_APP_PASSWORD
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="no-reply@gmail.com"
    MAIL_FROM_NAME="Angels Mini Lending"
    
#Features

- Dashboard : Show all important data and shows here the list of the borrowers who will due in 5 days
- Borrow : The client can borrow fund from the company
- Deposit Fund : The admin can deposit fund and shows here the Credit fund
- Payment :Can process loan, it shows here the amount borrowed and amount paid of the the client, you can also print the receipt for paid loan
- Client : Can add,update and show the client list ,client transactions
- Administrator : Can add,update and show the administrator list, transactions , deposits
- Company Income : It shows here all of the company profit and you can export excel report
- Overall Loan : It shows here list of all of paid loan and you can export excel report
- Fund history : It shows here Debit and Credit Fund and you can export excel report
- Top borrower : It shows here the list of the borrower in order from highest to lowest amount borrowed and you can export excel report
- Roles and Permission  : Super admin can add,edit,delete roles and permissiom , you can give permission to admin and staff
  
#Note : You can search and filter all the data listed


