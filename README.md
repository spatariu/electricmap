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

### 4. These are the available CRUD endpoints:

    ```GET /api/companies: Get all companies
    POST /api/companies: Create a new company
    GET /api/companies/{id}: Get a specific company by ID
    PUT /api/companies/{id}: Update a specific company by ID
    DELETE /api/companies/{id}: Delete a specific company by ID```

    ```GET /api/stations: Get all stations
    POST /api/stations: Create a new station
    GET /api/stations/{id}: Get a specific station by ID
    PUT /api/stations/{id}: Update a specific station by ID
    DELETE /api/stations/{id}: Delete a specific station by ID
    GET /api/charging-stations: Get all stations by distance```

![register](https://user-images.githubusercontent.com/3978400/131661280-4267aff4-107e-4bbe-8e46-da3d15ef1ba4.jpg)

### 5. Get the link hits in a time interval here http://localhost/api/links?link=https://www.emag.ro/&from=2021-08-01&to=2021-08-31

![register](https://user-images.githubusercontent.com/3978400/131661816-58d1013f-48ae-4fd7-b01f-02d0b1e78558.jpg)

### 6. Get the page hits in a time interval here http://localhost/api/pages/2021-08-01/2021-08-31

![register](https://user-images.githubusercontent.com/3978400/131663189-c66d6e76-9729-4c56-99d5-07dce7efed22.jpg)

### 7. Get the customer's journey here http://localhost/api/journey/1

![register](https://user-images.githubusercontent.com/3978400/131662394-e54a3e5d-8952-4d41-a632-713148aae28f.jpg)

### 8. Get the customers with the same journeys here 

![register](https://user-images.githubusercontent.com/3978400/131662591-2d4d3b5d-7619-40bc-a6d2-4773221905c9.jpg)

## Automated testing

- run the tests with `composer test` (only one test was created for demo purposes)

![register](https://user-images.githubusercontent.com/3978400/131665809-e327d36d-18e4-4e16-b518-e1a9b7c202f4.jpg)


*This is just a demo REST API, if it would be deployed to production the security has to be improved (hiding passwords and so on)!*
