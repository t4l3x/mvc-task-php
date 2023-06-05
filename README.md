# My PHP Web Application

This web application is built with PHP, it's containerized using Docker, and employs MySQL for the database. The application supports basic CRUD operations for "posts".

## Table of Contents

- [Directory Structure](#directory-structure)
- [Installation](#installation)
- [Running the Application](#running-the-application)

## Directory Structure

The directory structure of the application is as follows:

## Directory Structure

- `config/dependencies.php`: Dependency configuration.
- `docker-compose.yml`: Docker Compose file for local development.
- `Dump20230606.sql`: Database dump for MySQL.
- `public`: Public web root.
    - `index.php`: Index file.
- `routes`: Application routes.
    - `routes.php`: Route definitions.
- `src`: Source files.
    - `Controller`: Controllers.
        - `PostsController.php`: Controller for Posts.
    - `Core`: Core classes.
        - `AppKernel.php`: Application Kernel.
        - `Controller`: Base controller.
            - `BaseController.php`: Base controller class.
        - `Database ORM`: Basic orm.
        - `Helpers`: Helpers.
        - `Notifications`: Notifications
    - `Exceptions`: Custom exception classes.
    - `Model`: Models.
        - `PostModel.php`: Model for Posts.
    - `Services`: Service classes.
        - `NotificationService.php`: Service for Notifications.
        - `PostService.php`: Service for Posts.
    - `View`: Views.
        - `form.twig`: Twig form view.
        - `layout.twig`: Base layout.
## Installation

You need to have Docker and Docker Compose installed in your environment.

1. Clone the project
    ```bash
    git clone 
    ```
2. Move into the directory
    ```bash
    cd repository
    ```
3. Build and run the containers
    ```bash
    docker-compose up -d
    ```

## Running the Application

1. Access the application via `http://localhost/post` in your web browser.


# Packages
psr/http-server-handler (^1.0): This package provides interfaces for HTTP server request and response handling. It follows the PSR-7 standard.

psr/container (^2.0): PSR-11 defines a common interface for dependency injection containers. This package implements the container interface.

ext-pdo: The PDO extension provides a consistent interface for accessing databases in PHP. This extension is used for database operations.

twig/twig (^3.6): Twig is a flexible, fast, and secure template engine for PHP. It allows separation of presentation and logic, providing a clean and readable syntax for templates.

php-di/php-di (^7.0): PHP-DI is a dependency injection container library for PHP. It provides an easy way to manage and inject dependencies into classes.

nikic/fast-route (^1.3): FastRoute is a high-performance routing library for PHP. It is used to define and match routes efficiently, enabling faster request handling.

nyholm/psr7 (^1.8): This package provides PSR-7 implementation for HTTP message interfaces. It allows creating and manipulating HTTP messages.

psr/http-factory (^1.0): This package provides factories for creating PSR-7 HTTP message objects. It simplifies the creation of request, response, and other message instances.

symfony/mailer (^6.3): The Symfony Mailer component provides a unified way to send emails in Symfony applications. It leverages the capabilities of SwiftMailer while providing a simplified API.