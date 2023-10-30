#### In order to run the application, follow the steps below:
1. Create .env file from env.example
2. Install the dependencies:
    ```bash
    composer install
    ```
3. Create a SQLite database:

    ```bash
    touch database/database.sqlite
    ```
4. Run the database migrations:

    ```bash
    php artisan migrate
    ```

5. Serve the application:

    ```bash
    php artisan serve
    ```

In order to authorize API requests, I used `JWT`.

The format of the header is still the same as mention in task:

```bash
Authorization: Bearer <your_token>
```

#### In order to run the API requests please use INSOMNIA.json with insomnia client https://insomnia.rest/download. Everything is set up there.

Steps to play the game

1. Register User
2. Login as a first User
3. Create a game
4. Register second User
5. Login as a second User
6. Enter the game as Second user
7. Login as a first user
8. Create user Move as so on...

Few game rules:
1. There is only 3 type of ships : carrier(5 cells), battleship(4 cells), submarine(3 cells). App is fully extendable so more types of ship can be added.
2. First move is always assign to owner
3. When user hit last cell. He is a winner, and we assign date of win and winner user in `games` table.


If you have any issues with running application please contact me. I will help :)