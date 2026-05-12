# 🟡 YellowManagement

> **Money Management System for UMKM (Usaha Mikro, Kecil, dan Menengah)**

YellowManagement is a web-based financial and operational management application built specifically for small and medium-sized businesses (UMKM) in Indonesia. It provides a complete Point-of-Sale (POS) system, expense tracking, sales reporting, product catalog management, and discount event handling — all in one place.

---

## ✨ Features

### 👨‍💼 Admin

| Feature                          | Description                                                                                |
| -------------------------------- | ------------------------------------------------------------------------------------------ |
| **Dashboard & KPIs**             | Monitor 7-day sales trends, total revenue, total expenses, and net profit at a glance      |
| **Product & Variant Management** | Full CRUD for products with variants, images, pricing, and stock synchronization           |
| **Category Management**          | Organize products into categories for easier navigation and reporting                      |
| **Product Image Management**     | Centralized media management — upload, search, edit, and associate images to products      |
| **Discount Events**              | Create and manage time-based promotional discount events applied automatically at checkout |
| **Expense Management**           | Track operational costs by category with receipt attachment support                        |
| **Cashier (User) Management**    | Add, edit, and manage cashier accounts with role-based access control                      |
| **Sales Reports**                | View daily/weekly/monthly sales analytics with top product breakdowns; export to PDF/Excel |
| **Transaction Management**       | Audit, adjust, and validate all transactions; change statuses (complete, cancel, suspend)  |
| **Page Content Settings**        | Edit landing page and public menu content without touching code                            |

---

### 🧾 Kasir (Cashier)

| Feature                                     | Description                                                                                  |
| ------------------------------------------- | -------------------------------------------------------------------------------------------- |
| **Cashier Dashboard**                       | Personal 7-day performance summary and recent transaction list                               |
| **POS & Create Transaction**                | Fast product selection with variant and discount support; handles cash and non-cash payments |
| **Complete / Suspend / Cancel Transaction** | Manage pending transactions; cancellations automatically restore stock                       |
| **Print Receipt**                           | Export transaction receipts as PDF/Excel for customers                                       |
| **Transaction History**                     | View and review all personal past transactions                                               |
| **Cashier Reports**                         | Filter and export personal sales reports by daily, weekly, or monthly periods                |
| **Product & Stock Check**                   | Read-only view of active products, variants, categories, and stock availability              |
| **Record Expenses**                         | Log shift-level operational expenses with optional receipt attachment                        |

---

## 🛠 Tech Stack

- **Backend:** [Laravel](https://laravel.com) (PHP)
- **Frontend:** [Blade](https://laravel.com/docs/blade) + [Tailwind CSS](https://tailwindcss.com)
- **Build Tool:** [Vite](https://vitejs.dev)
- **Database:** MySQL (via Laravel Eloquent ORM)
- **Export:** PDF & Excel report generation

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/KORQ-Kalbs/YellowManagement.git
cd YellowManagement

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy and configure your environment file
cp .env.example .env

# 5. Generate the application key
php artisan key:generate

# 6. Configure your database in .env, then run migrations and seeders
php artisan migrate --seed

# 7. Link storage
php artisan storage:link

# 8. Build frontend assets
npm run build

# 9. Serve the application
php artisan serve
```

> **Quick setup (optional):** A `setup.sh` script is included for sidebar UI adjustments. Run `bash setup.sh` after installation if needed.

---

## 👥 User Roles

| Role      | Access Level                                                                          |
| --------- | ------------------------------------------------------------------------------------- |
| **Admin** | Full access — manage products, users, reports, expenses, discounts, and site settings |
| **Kasir** | Operational access — run POS, manage own transactions, log expenses, view own reports |

---

## 📂 Project Structure

```
app/          → Controllers, Models, and business logic
resources/    → Blade views and frontend assets
database/     → Migrations and seeders
routes/       → Web and API route definitions
public/       → Publicly accessible files and compiled assets
storage/      → File uploads and application storage
```

---

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
