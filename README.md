# Job Portal System

A comprehensive web-based Job Portal application built with PHP and MySQL. This system connects job seekers with employers, facilitating the job application process with a user-friendly interface and robust administrative features.

## 🚀 Features

### For Job Seekers
- **User Registration & Login:** Secure account creation and authentication.
- **Job Search:** Browse and search for available job openings.
- **Detailed Job Views:** View full job descriptions, requirements, and company details.
- **One-Click Application:** Easily apply for jobs directly through the portal.
- **Profile Management:** Update personal information, resume, and skills.
- **Password Management:** Forgot and Reset Password functionality.

### For Admin
- **Admin Dashboard:** Centralized control panel for managing the system.
- **Job Management:** Post, edit, and delete job listings.
- **Application Tracking:** View and manage incoming job applications.
- **User Management:** Manage registered users and testimonials.
- **Contact Messages:** View inquiries from the contact form.

## 🛠️ Technology Stack
- **Backend:** PHP (Native)
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Server:** Apache (via XAMPP/WAMP)

## ⚙️ Installation & Setup

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/asad-waseem/Job_Portal.git
    cd Job_Portal
    ```

2.  **Database Configuration**
    - Open your MySQL Database Management tool (e.g., phpMyAdmin).
    - Create a new database named `user`.
    - Import the SQL file located in `database/user.sql` (or `database/jobportal.sql` - *check the specific file in your directory*).
    - *Note: Ensure your database credentials match those in `partials/config.php`.*

3.  **Configure Connection**
    - Open `partials/config.php` and verify the settings:
      ```php
      define('DB_HOST', 'localhost');
      define('DB_USER', 'root');
      define('DB_PASS', '');
      define('DB_NAME', 'user');
      ```

4.  **Run the Application**
    - Copy the project folder to your server's root directory (e.g., `htdocs` in XAMPP).
    - Start Apache and MySQL text XAMPP Control Panel.
    - Open your browser and navigate to:
      `http://localhost/Job Folder/`

## 📂 Project Structure
- `admin/` - Administrative backend files.
- `assets/` - Static assets (CSS, JS, Images).
- `database/` - SQL database files.
- `partials/` - Reusable code snippets (headers, footers, config).
- `user/` - User-specific pages.
- `*.php` - Core application pages (index, jobs, login, etc.).

## 🤝 Contributing
Contributions are welcome! Please fork the repository and submit a pull request for any improvements.

## 📄 License
This project is open-source and available for educational and commercial use.
