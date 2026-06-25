MINI ISSUE TRACKER
A simple project management system designed to track tasks, statuses, and priorities.
Built with Laravel, this application features real-time AJAX interactions for a seamless user experience.


FEATURES:

Project Management: Full CRUD operations for projects.

AJAX-Powered Filtering: Search, filter by status, and filter by priority without reloading the page.

Dynamic Tagging: Toggle tags on specific issues instantly using AJAX.

User Assignment: Assign members to issues via a pivot-table integration.

Discussion Thread: Add and view comments in real-time.

Authorization: Role-based access control implemented via Laravel Policies.


TECH STACK:

Framework: Laravel 13

Frontend: Tailwind CSS, Blade Templates

Interactivity: Axios, AJAX

Database: SQLite
<img width="1595" height="872" alt="image" src="https://github.com/user-attachments/assets/eec22253-7f2c-4a45-8cb7-b3828cc8b0ec" />

<img width="1602" height="685" alt="image" src="https://github.com/user-attachments/assets/08203ef9-70ab-41fa-ba04-79ead26dde8d" />

<img width="1596" height="876" alt="image" src="https://github.com/user-attachments/assets/0dae10a8-d12c-4243-aac4-811ef94096c5" />

<img width="1602" height="862" alt="image" src="https://github.com/user-attachments/assets/9570154e-a578-4237-832e-600cea5b7f3d" />






INSTALLATION:

1.Clone the repository:

git clone <https://github.com/shqiponjedani/mini-issue-tracker.git>

cd mini-issue-tracker


2.Install dependencies:

composer install

npm install

npm run dev

3.Configure your environment:

cp .env.example .env

php artisan key:generate

4.Run migrations and seeders:

php artisan migrate --seed

5. Start the application:
   
php artisan serve
