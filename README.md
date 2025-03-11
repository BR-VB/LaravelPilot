# ProjectNavigator

## General Info

Project name: "ProjectNavigator"

Project version: 1.0

Project Status: Phase of development

Launch: 03.2025 (on a local server)

[Project Documentation](https://github.com/BR-VB/ProjectNavigator/blob/main/documentation/ProjectNavigator%20-%20Blog%20Post.md)

License name: MIT

Author names: Brigitta Röck

## Project Description

**Document. Share. Succeed.**  
*ProjectNavigator helps you document your projects comprehensively, ensuring they are traceable for future reference and easily understandable for others.*

With ProjectNavigator, you can systematically record your own projects to make them traceable later or share them with others as an introduction to new topics. ProjectNavigator doesn’t just provide step-by-step instructions; it also offers background knowledge, tips, and tricks that are essential for creating comprehensive documentation. The goal is to help you preserve your project knowledge and support others in understanding and continuing your work.

## Features  

- **Step-by-Step Documentation**: Record every detail of your projects, from setup to completion.  
- **Knowledge Sharing**: Create structured guides to onboard others into your projects effortlessly.  
- **Reusable Tips & Tricks**: Include practical advice and proven solutions to common challenges.  
- **Enhanced Collaboration**: A perfect tool for teams to standardize documentation and streamline knowledge sharing.

## Why Use ProjectNavigator?  

Many developers and teams struggle to remember the steps or context behind completed projects. With ProjectNavigator, you can:  

- **Save Time**: Avoid reinventing the wheel by documenting your workflows.  
- **Improve Clarity**: Make your projects understandable, even months or years later.  
- **Onboard Faster**: Share your knowledge to help others quickly dive into new topics.

## Getting Started  

### Prerequisites - Mac

To use **ProjectNavigator**, ensure you have the following software installed, configured and updated to actual versions:  

- Homebrew
- Git
- PHP, Composer
- Node
- XAMPP (up and running)
- An IDE (e.g., Visual Code Studio or PhpStorm)

### Installation  

1. Clone the repository:

   ```bash
   git clone https://github.com/BR-VB/ProjectNavigator.git
   cd ProjectNavigator
   ```

2. Open ProjectNavigator with an IDE

3. Create and adapt .env

   ```bash
   cp .env.example .env
   ```

   Adapt following entries:

   - **APP_NAME**: ProjectNavigator
   - **DEBUGBAR_ENABLED**: true (or false if you do not want to use Debugbar)
   - **LOG_STACK**: daily
   - **DB_DATABASE**=projectnavigator (adapt DB name to your needs or leave it unchanged)

4. Create and adapt .env.testing

   ```bash
   cp .env .env.testing
   ```

   - **APP_ENV**=testing
   - **DB_DATABASE**=projectnavigator_test

   Add .env.testing to .gitignore file.

5. Install Project-Dependencies

   ```bash
   npm install
   composer install

   cd frontend
   npm install

   cd ..
   ```

6. Create an APP key (if not already done: see .env file **APP_KEY**)

   ```bash
   php artisan key:generate
   php artisan key:generate --env=testing
   ```

7. Execute Database Migrations  

   ```bash
   php artisan migrate
   php artisan migrate --env=testing
   ```

8. Import DB Content from folder db_export with phpMyAdmin

   ```bash
    import newest export-file (e.g., 2025_03_11__17_29__projectnavigator.sql)
   ```

9. Start Backend & Frontend servers

   ```bash
    npm run dev (Vite for Laravel backend)
    php artisan serve (Laravel backend)

    cd frontend
    npm run dev (Vite & React frontend)
   ```

## Usage  

Laravel - Backend: [http://localhost:8000](http://localhost:8000).

Follow the instructions on the Welcome page!

Vite & React - Frontend: [http://localhost:3000](http://localhost:3000).

## Laravel Links

- [Laravel on Github](https://github.com/orgs/laravel/repositories)
- [Laravel Documentation](https://laravel.com/docs/11.x)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts](https://laracasts.com)

## License

ProjectNavigator is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Copyright (c) 2025 ProjectNavigator

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
