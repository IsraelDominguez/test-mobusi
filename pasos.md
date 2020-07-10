1. Clone or Download from Git
git@github.com:IsraelDominguez/test-mobusi.git

2. Run containers
docker-compose up -d

3. Update project dependencies with the installed Composer
    if you have bash
    "./dcp composer install"
    from your composer
    composer install

4. Execute Symfony migrations
    "./dcp c doctrine:migrations:migrate"

5. Execute SQL scripts in database
    ./src/Migrations/advertiser.sql
    ./src/Migrations/publisher.sql

./dcp c doctrine:database:import src/Migrations/advertiser.sql
./dcp c doctrine:database:import src/Migrations/publisher.sql


6. Test App with Postman Api

./dcp c debug:router

 -------------------------- -------- -------- ------ -----------------------------------
  Name                       Method   Scheme   Host   Path
 -------------------------- -------- -------- ------ -----------------------------------
  show_ad                    GET      ANY      ANY    /ad/{id}
  ad                         POST     ANY      ANY    /ad
  publish_ad                 PATCH    ANY      ANY    /ad/publish/{id}
  show_advertisher           GET      ANY      ANY    /advertiser/{id}
  show_publisher             GET      ANY      ANY    /publisher/{id}



