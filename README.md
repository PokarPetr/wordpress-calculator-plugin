   # Calculator Plugin

   ##Installation

   1. Clone the repository:
      ```bash
      git clone https://github.com/PokarPetr/wordpress-calculator-plugin.git
   
   2. Copy the calculator-plugin folder into wp-content/plugins/.

   3. Activate the plugin via the WordPress admin panel.

   ## Technologies

      PHP 8.3.27 (server-side calculations)

      JavaScript ES6+ (AJAX, plain JS)

      WordPress 6.9

   ### Unit Tests

      Unit tests check the calculator logic without loading WordPress.

   ### Installing dependencies

      ```bash
      composer install 
   
   ## Running tests
   Run all unit tests:
       ```bash
           vendor/bin/phpunit

   ### Test structure

      tests/bootstrap-unit.php — bootstrap for unit tests (Composer autoload)

      tests/Domain/CalculatorTest.php — tests for the Calculator class



   ## Установка
   1. Скачать репозиторий или клонировать:
      ```bash
      git clone https://github.com/PokarPetr/wordpress-calculator-plugin.git

   2. Скопировать папку calculator-plugin в wp-content/plugins/ вашего WordPress.

   3. Активировать плагин через админку WordPress.

   ## Технологии

   1. PHP 8.3.27 (серверные вычисления)

   2. JavaScript ES6+ (AJAX, чистый JS)

   3. Wordpress 6.9

   ### Unit-тесты

   Unit-тесты проверяют логику калькулятора без WordPress.

   ## Установка зависимостей

      ```bash
      composer install    


   ### Запуск тестов
      все unit-тесты
          ```bash
           vendor/bin/phpunit

   ### Структура тестов

      tests/bootstrap-unit.php — bootstrap для unit-тестов (Composer autoload)

      tests/Domain/CalculatorTest.php — тесты для класса Calculator


