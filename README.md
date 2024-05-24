## Boonbac - KPIE Assessment Project (Completed)

This project represents a complete submission for the KPIE assessment, demonstrating proficiency in both frontend and backend development. It leverages the Laravel framework to construct a web application boasting a comprehensive user interface and robust backend logic.

### Features

* **User Authentication:** Streamlined Login, Registration, and Forgot Password functionalities.
* **Secure Backend:** Implements industry-standard security practices to safeguard against vulnerabilities.
* **Intuitive User Interface:** Fully functional user interfaces for Login, Register, Forgot Password, and Home pages meticulously replicate the visual styles of the provided links, achieving a high degree of fidelity.

### Technologies Used

* PHP ^8.1
* Laravel ^11.0
* Doctrine/DBAL ^3.6.2 (Database abstraction layer)
* GuzzleHTTP/Guzzle ^7.5.1 (HTTP client)
* Laravel Sanctum ^4.0 (API authentication)
* Laravel Socialite ^5.6.1 (Social login functionality)
* Laravel Tinker ^2.8.1 (REPL for interactive PHP)
* Laravel UI ^4.2.1 (Blade UI components)


### Installation

1. Clone the repository:

```bash
git clone https://github.com/omartins365/boonbac.git
```

2. Navigate to the project directory:

```bash
cd boonbac
```

3. Install dependencies:

```bash
composer install
```

4. Generate an application key:

```bash
php artisan key:generate
```

5. Create a `.env` file by copying the `.env.example` file:

   This file stores environment variables like database credentials.

```bash
cp .env.example .env
```

   **Make sure to update the `.env` file with your own credentials.**

6. Migrate the database (if applicable):

```bash
php artisan migrate
```

7. Start the development server:

```bash
php artisan storage:link
```

8. Start the development server:

```bash
php artisan serve
```

This will launch the application on `http://localhost:8000` by default.


### Code Structure

The project adheres to a PSR-4 autoloading structure. The core application code resides in the `app` directory.

* `app/Base` - Contains foundational elements like enums and helper functions.
* `app/Http` - Houses controllers for handling HTTP requests.
* `config` - Stores configuration files for the application.
* `database` - Contains database migrations and seeders.
* `resources` - Holds views, assets, and other resources.
* `routes` - Defines application routes.
* `tests` - Includes unit and feature tests for the application.

### Contributing

Currently, this project serves assessment purposes only.

**Note:**

* The user interface, while fully functional, might exhibit slight discrepancies compared to the reference links due to the time constraint. 
* The social sign in options will not work if the relevant credentials are not included in the env file 
