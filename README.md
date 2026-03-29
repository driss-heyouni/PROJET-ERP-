# OfficeDesign Pro - ERP Solution for Odoo
**Modern Web Interface for Furniture Distribution.**

## 🚀 Overview
**OfficeDesign Pro** is a high-performance web application built to modernize the sales cycle of furniture distribution companies using Odoo ERP. It provides a sleek, responsive interface for commercial agents to manage clients, products, and sales orders on the field.

### Key Features
- **Admin Dashboard**: Real-time sales analytics and business indicators (KPIs).
- **Product Catalogue**: Multi-stage filtering (eliminates nautical/boat items), HD images, and stock tracking.
- **Quote Automation**: Instant creation of Sale Orders (`sale.order`) in Odoo via XML-RPC.
- **Enterprise CRM**: Focused list of 5 strategic enterprise partners for fast navigation.
- **Fast Authentication**: Dedicated admin login path for instant access.

## 🛠️ Technical Stack
- **Frontend**: Angular 18+ (Signals, Standalone Components, Vite).
- **Backend Bridge**: PHP / Mock API (Fast-Path Architecture).
- **ERP Integration**: Odoo Community Edition (XML-RPC Protocole).
- **Database**: PostgreSQL (Odoo) & SQLite (Local).

## 📦 Installation & Setup
1. **Frontend**:
   ```bash
   cd frontend-app
   npm install
   npm start
   ```
2. **Backend**:
   ```bash
   cd backend_mock
   php -S localhost:8000 index.php
   ```
3. **Odoo Config**: Ensure your Odoo instance is running on `localhost:8069` with the database `oryacht`.

## 📜 Documentation
Full project details can be found in the [Rapport_Projet_ERP.md](./Rapport_Projet_ERP.md).

---
© 2026 OfficeDesign Pro Team.
