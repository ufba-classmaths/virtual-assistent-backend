# Virtual IC Assistent
- Thats is the backend implementation of IC virtual assistent to help students and professors to get some information about Computation Institute of UFBA (ICUFBA)

## First steps after clone repository 
- To run laravel you need install a PHP version > 7.3, the composer and a database. We are using MYSQL and to make it easy, we are using xampp which provides php and the MYSQL. 
### Requiriments softwares
1. Install xampp
2. Install composer 

### Start project
- To install base packages you need run the command:
> composer install

### Test if all right
- To test laravel is running well, run the code:
> php artisan serve
- It will return a link of server where service is runing. Access that link and check if a laravel base page is shown. That is it! 


### Config database in Heroku
- After define its migrations, to run in Heroku you'll need config a database. We are using Postgre (Heroku Postgre), provided by 
Herokus for free. This database service has some limitations like:
-- maximum of 10,000 rows
-- 20 connections
-- maximum 10 MB of data

- To config that in Heroku you can follow that tutorial:
> (https://www.youtube.com/watch?v=639Pe0PpVLQ)
## Heroku's server link
- It is the URL used do take requests to Virtual Assistent API: (https://virtual-assistent-backend.herokuapp.com/)

## Requiriments of system
- The requiriments of project is avalilable in: (https://drive.google.com/drive/folders/1wQ_EoAkUwsMh9vt8VNHWr2dJ2YOKP9y1?usp=sharing)

## Arcteture model 
- The arquiteture model is avalilable in: (https://drive.google.com/drive/folders/1Am2HyrRsltKiXkUHeORgqAcMWP3VGUN0?usp=sharing)

## Documentation of API
That link show the API documentation
> https://silvaengcomp.github.io/virtual-assistent-backend/
