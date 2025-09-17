# Ticket Booking Web Application

## Setup Instructions

### Database Setup
1. Import the `schema.sql` file into your MySQL server to create the database and tables with sample data.
   ```bash
   mysql -u root -p < schema.sql
   ```
2. Update database connection details in PHP files if necessary (default is `localhost`, user `root`, no password).

### Running the Application
1. Place the `ticket-booking` directory in your web server's root directory (e.g., `htdocs` for XAMPP).
2. Start your web server and MySQL server.
3. Access the application via `http://localhost/ticket-booking/login.php`.
4. Use the sample users from the database to log in (e.g., username: `user1`, password: the password you set).

### Testing
- Test login/logout functionality.
- Test ticket search and booking for bus, train, and airplane.
- Verify booking confirmation and seat availability updates.
- Check frontend responsiveness on different devices.

## Notes
- Passwords in sample data should be hashed using PHP's `password_hash` function.
- This is a basic implementation with mock payment and no real payment gateway integration.
