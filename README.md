# JewelSteps

The API for jewels and shoes



## This API is Docker-fluent

This project comes with all batteries included. The docker-compose.yml file gives you a fully-fledged functional Apache web server with PHP in it. Ready to rock.



## Business logic

The API accepts products of two types

- Non-variable prices: products which, no matter what's its size, all units of this product will always have the same price. When a new size is introduced, if the price is different, all older ones should be updated too. There's an event listener for this.

- Variable price: in this situation every unit of an item is independent of the others. Prices should not be updated when a new item is created.

- The categories are: Shoes (non-variable), and Jewelry (variable)

- The price must be created only if the product has no price in the database. Thus, if I try to input an existing item to the database, it will fail.

---

# How to use

* Clone this repository

* Go to the repository's folder in a terminal

* Run the command **docker compose up** or** docker-compose up** (depending on your system's configuration)

* The api is ready to roll on your local machine at port 8080





## License

This code is MIT licensed and the owner of the intellectual property is Anderson S. de Souza (AKA @andersonpem). You have the rights to modify and distribute as you wish. No liability to the author.
