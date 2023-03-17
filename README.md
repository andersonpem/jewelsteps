# JewelSteps

Step into Elegance: Where Shoes and Jewelry Unite

The API for jewels and shoes



## This API is Docker-fluent

This project comes with all batteries included. The docker-compose.yml file gives you a fully-fledged functional Apache web server with PHP in it. Ready to rock.



I don't wanna brag, but the docker image used here was built by the creator of this API :) it works even on ARM processors (M1 Macbook, anyone?)



## Business logic

The API accepts products of two types

- Non-variable prices: products which, no matter what's its size, all units of this product will always have the same price. When a new size is introduced, if the price is different, all older ones should be updated too. There's an event listener for this.

- Variable price: in this situation every unit of an item is independent of the others. Prices should not be updated when a new item is created.



It would be nice to have things like SKUs for this kind of control, but it is beyond what the task asks.



Other basic business logic rules

- The categories are: Shoes (non-variable), and Jewelry (variable)

- The price must be created only if the product has no price in the database. Thus, if I try to input an existing item to the database, it will update the existing price.



---

# How to use

* Clone this repository

* Go to the repository's folder in a terminal

* Run the command **docker compose up** or **docker-compose up** (depending on your system's configuration)

* The api is ready to roll on your local machine at port 8080



### The main endpoint

As it is good practice to version APIs, the main endpoint is:

localhost:8080/api/v1/...



### Testing the endpoints

Get yourself postman and go to this URL



[API Example on Postman](https://bit.ly/test-api-example)

Use the **Get Categories** to be aware of the existing category IDs



Use the Create a new shoe request to insert or edit a shoe. Feel free to tinker with name, size and price to explore the  interactions.



You're on a roll. Use the create new jewel endpoint to test jewels. Feel free to tinker with this one too.



### Checking the database

If you'd like to inspect the database while you run the API, you can use a database tool like DBeaver or TablePlus and connect to the file existing in **src/var/data.db**

This project runs on SQLite for convenience.



### XDebug?

Yes, this image supports XDebug. Took me some time to get it right back when I first built the images. If you wish to enable it, do the following:



- Go to the root's .env file (the Docker environment variable file) and change the value of **PHP_EXTENSION_XDEBUG** from 0 to 1.

- This will expose the port 10000 for debugging.

- Configure your favorite IDE for remote debugging on this port.

- Map the files from remote to local in the following fashion:
  
  - src -> /var/www/html

- Feel free to breakpoint through the code.



### Considerations

The choice of PHP v8 allowed to use new amenities like the constructor's property promotion feature.

For convenience, .env files are commited in the project. In a production environent env vars (other the Symfony's main .env) **SHOULD NOT BE COMMITED**. Only an example .env should be commited for the developer to set up his machine.

The database choice is purely for convenience. But this container has plugins for postgres and MySQL too.



## License

This code is MIT licensed and the owner of the intellectual property is Anderson S. de Souza (AKA @andersonpem). You have the rights to modify and distribute as you wish. No liability to the author.
