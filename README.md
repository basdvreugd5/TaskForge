# **⚙️ TaskForge**

TaskForge is a modern, responsive web application built on the Laravel framework designed to help individuals and teams manage their to-do lists and projects efficiently.

## **🌟 Key Features**

Based on common task management requirements and a modern framework like Laravel, TaskForge includes the following core functionalities:

* **User Authentication & Authorization:** Secure login and registration for individual users.  
* **Full CRUD for Tasks:** Easily create, read, update, and delete tasks.  
* **Task Status Tracking:** Assign and update statuses (e.g., To Do, In Progress, Completed).  
* **Categorization:** Organize tasks using custom tags or categories.  
* **Responsive UI:** A clean, mobile-friendly user interface built with Blade and Tailwind CSS.

## **🛠 Technology Stack**

TaskForge is built using a modern, robust, and scalable set of technologies:

* **Backend Framework:** [Laravel](https://laravel.com/) (PHP)  
* **Styling & Frontend:** [Tailwind CSS](https://tailwindcss.com/)  
* **Build Tool:** [Vite](https://vitejs.dev/)  
* **Database:** MySQL (or any database supported by Laravel Eloquent)  
* **Package Management:** Composer (PHP) & npm (JavaScript/CSS assets)

## **🚀 Installation & Setup**

To get TaskForge running locally, follow these steps. You will need PHP, Composer, Node.js, and a database (like MySQL) installed.

### **1\. Clone the Repository**

git clone \[https://github.com/basdvreugd5/TaskForge.git\](https://github.com/basdvreugd5/TaskForge.git)  
cd TaskForge

### **2\. Configure Environment**

Copy the example environment file and generate an application key.

```cp .env.example .env  
php artisan key:generate```

Next, open the newly created .env file and configure your database connection settings (e.g., DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD).

### **3\. Install Dependencies**

Install the PHP dependencies using Composer and the frontend dependencies using npm.

composer install  
npm install

### **4\. Database Setup**

Run the database migrations to create the necessary tables, including users and tasks.

php artisan migrate

### **5\. Compile Assets**

Compile the frontend assets (Tailwind CSS and JavaScript):

npm run dev  
\# OR for production  
\# npm run build

### **6\. Run the Application**

Start the local Laravel development server:

php artisan serve

The application should now be accessible at http://127.0.0.1:8000.

## **🤝 Contributing**

We welcome contributions\! If you have suggestions for improvements, feature requests, or find a bug, please feel free to open an issue or submit a pull request.

## **📄 License**

TaskForge is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).