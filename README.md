# Deploy App for Test

You need to follow this steps to run the app.

Is recommended to have installed to run the app Docker and Docker Compose. Composer is optional, but is recommended too.

## Steps

1. Clone or Download from Git

    git@github.com:IsraelDominguez/test-mobusi.git

2. Up all Containers

        docker-compose up -d

3. Update project dependencies with the installed Composer
    
    `dcp` is a bash script to help us with docker interactions
    
    + If you have bash, you can execute composer from webserver container
    
            ./dcp composer install
    
    + From your installed composer
    
            composer install

4. Execute Symfony migrations
    
        ./dcp c doctrine:migrations:migrate

5. Execute SQL scripts in database
    
    ./src/Migrations/advertiser.sql
    
    ./src/Migrations/publisher.sql

        ./dcp c doctrine:database:import src/Migrations/advertiser.sql
        ./dcp c doctrine:database:import src/Migrations/publisher.sql

6. For development you can access via PhpMyAdmin to Mysql Server

    http://localhost:8080
     
    user: sunmedia    
    pass: sunmedia

7. Test App Api, a Postman export with examples is located in: 

    ./Mobusi Test.postman_collection.json

8. The Api routes generated for this test app are:

        ./dcp c debug:router

| Name | Method | Scheme | Host | Path |
| ------ | ---- | --------- | -------| ------- |
| show_ad | GET | ANY | ANY | /ad/{id}
| ad | POST | ANY | ANY | /ad
| publish_ad | PATCH | ANY | ANY | /ad/publish/{id}
| show_advertiser | GET | ANY | ANY | /advertiser/{id}
| show_publisher | GET | ANY | ANY | /publisher/{id}

