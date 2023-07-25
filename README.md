# Electric stations map
Heatmap Microservice

## Installation:
- clone the repository and open a terminal for that location
- install the Docker app
- copy the `.env_laradock` file to the `laradock folder` as `.env`
- go to the `laradock` folder and run `docker-compose up -d nginx mysql phpmyadmin workspace`
- run `docker ps` to check the name of the workspace container and get inside it with `docker exec -it laradock_workspace_1 bash`
- run `composer install`
- run `php artisan migrate:fresh --seed` to init the db
- run `php artisan serve` to start the local server
- install Postman for easily testing the API

## Test the REST API

### 1. Get a token http://localhost/api/login setting the required params from the screenshot

![image](https://github.com/spatariu/electricmap/assets/3978400/c9ebaa36-2768-4ddc-b2db-a64ee6b17c98)

### 2. After the login copy the generated token and set it for all the next requests like this:

![image](https://github.com/spatariu/electricmap/assets/3978400/c66b3b85-4d05-40cc-81db-da8705a7ae03)

![image](https://github.com/spatariu/electricmap/assets/3978400/7547e481-bd02-4e33-9071-c915971c049c)

### 3. These are the available CRUD endpoints:
    ```
    GET /api/companies: Get all companies
    POST /api/companies: Create a new company
    GET /api/companies/{id}: Get a specific company by ID
    PUT /api/companies/{id}: Update a specific company by ID
    DELETE /api/companies/{id}: Delete a specific company by ID

    GET /api/stations: Get all stations
    POST /api/stations: Create a new station
    GET /api/stations/{id}: Get a specific station by ID
    PUT /api/stations/{id}: Update a specific station by ID
    DELETE /api/stations/{id}: Delete a specific station by ID
    GET /api/charging-stations: Get all stations by distance
    ```
### 4. Example call to get all the stations by distance:

http://localhost/api/charging-stations?latitude=46.21&longitude=21.31&radius=200&company_id=1

![image](https://github.com/spatariu/electricmap/assets/3978400/c44c990e-eaf1-4e32-a9a0-d215fb948fa8)

## Automated testing

- run the tests with `php artisan test`


*This is just a demo REST API, if it would be deployed to production the security has to be improved (hiding passwords and so on)!*
