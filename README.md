## Backend Assignment

## Task
You were given a sample [Laravel][laravel] project which implements sort of a personal wishlist
where user can add their wanted products with some basic information (price, link etc.) and
view the list.

#### Refactoring
The `ItemController` is messy. Please use your best judgement to improve the code. Your task
is to identify the imperfect areas and improve them whilst keeping the backwards compatibility.

#### New feature
Please modify the project to add statistics for the wishlist items. Statistics should include:

- total items count
- average price of an item
- the website with the highest total price of its items
- total price of items added this month

The statistics should be exposed using an API endpoint. **Moreover**, user should be able to
display the statistics using a CLI command.

Please also include a way for the command to display a single information from the statistics,
for example just the average price. You can add a command parameter/option to specify which
statistic should be displayed.

## Open questions
Please write your answers to following questions.

> **Please briefly explain your implementation of the new feature**  
>  created new routes and controller for get statistics using api endpoint.
>   created a command for get statistics  using CLI commands
>   php artisan show:statistic (statistic parameter)
>   allowed parameters
>       count_items     -> get total items count                -> php artisan show:statistic count_items
>       average_price   -> average price of all items           -> php artisan show:statistic average_price 
>                Note : for get average price for specific item we must have a multiple price for the item that mean that
>               we must have another table for item prics (one to many relation ship) and we don't have that here
>       sum_price_month -> total price of items added this month -> php artisan show:statistic sum_price_month

>          
> _..._

> **For the refactoring, would you change something else if you had more time?**  
>  i think no but we can use token for allow only authorized users for access the endpoints
> _..._

## Running the project
This project requires a database to run. For the server part, you can use `php artisan serve`
or whatever you're most comfortable with.

You can use the attached DB seeder to get data to work with.

#### Running tests
The attached test suite can be run using `php artisan test` command.

[laravel]: https://laravel.com/docs/8.x
