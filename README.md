# Dr.Phone POS

A comprehensive Point of Sale (POS) system designed for mobile phone retail shops, featuring inventory management, sales tracking, customer management, and more.

## Features

- **Sales Management**: Create and manage sales transactions with ease
- **Inventory Management**: Track products, stock levels, and product labels
- **Customer Management**: Maintain customer records and purchase history
- **Invoice & Quotations**: Generate invoices and quotations for customers
- **Returns & Repairs**: Handle product returns and repair tracking
- **Expense Tracking**: Monitor business expenses
- **Supplier Management**: Manage supplier information and orders
- **Multi-Shop Support**: Manage multiple shop locations
- **User Management**: Role-based access control for staff
- **Vault & Balance**: Track cash flow and financial balance

## Tech Stack

### Frontend
- PHP
- HTML/CSS
- JavaScript

### Backend
- Node.js (Express)
- PHP

### Database
- MySQL/MariaDB (configured via `app/src/config/db.config.js`)

## Project Structure

```
Dr.Phone POS/
├── index.php              # Main dashboard
├── login.php              # User authentication
├── app/
│   ├── server.js          # Node.js server
│   └── src/
│       ├── config/        # Database configuration
│       ├── controllers/   # Business logic
│       ├── middleware/    # Middleware functions
│       ├── models/        # Data models
│       └── routes/        # API routes
├── components/            # Reusable component files
│   ├── pages/            # Main application pages
│   ├── UI/               # UI components
│   └── [feature modules] #各功能模块
└── styles/               # CSS stylesheets
```

## Installation

### Prerequisites
- PHP 7.4 or higher
- Node.js 14.x or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd "Dr.Phone POS"
   ```

2. **Configure the database**
   - Create a MySQL database
   - Update database credentials in `app/src/config/db.config.js`

3. **Install Node.js dependencies**
   ```bash
   cd app
   npm install
   ```

4. **Configure web server**
   - Point your web server's document root to the project directory
   - Ensure PHP is properly configured

5. **Start the Node.js server**
   ```bash
   cd app
   node server.js
   ```

6. **Access the application**
   - Open your browser and navigate to `http://localhost/Dr.Phone%20POS`
   - Login with your credentials

## Configuration

### Database Configuration
Edit `app/src/config/db.config.js`:
```javascript
module.exports = {
  host: "localhost",
  user: "your_username",
  password: "your_password",
  database: "pos_database"
};
```

## Usage

### Dashboard
Access the main dashboard at `index.php` to view sales overview, inventory status, and quick actions.

### Sales
Navigate to **Sales > Create** to process new transactions.

### Inventory
Manage products, print labels, and track stock levels in the **Inventory** section.

### Customers
Add and manage customer information in the **Customers** module.

### Reports
Generate financial reports through the **Vault & Balance** section.

## Modules

- **Products**: Add, edit, and manage product catalog
- **Sales**: Process sales transactions
- **Customers**: Customer relationship management
- **Inventory**: Stock and inventory control
- **Invoices & Quotations**: Document generation
- **Returns & Repairs**: After-sales service
- **Expenses**: Expense tracking
- **Suppliers**: Supplier management
- **Shops**: Multi-location management
- **Users**: Staff and access control
- **Settings**: System configuration

## Security

- Implement proper authentication and authorization
- Use prepared statements for database queries to prevent SQL injection
- Validate and sanitize all user inputs
- Keep dependencies up to date

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

[Specify your license here]

## Support

For support and inquiries, please contact [your contact information]

## Changelog

### Version 1.0.0
- Initial release with core POS functionality

---

**Dr.Phone POS** - Streamlining mobile phone retail operations