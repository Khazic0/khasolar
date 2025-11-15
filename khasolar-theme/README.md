# Kha Solar WordPress Theme

**Version:** 1.0.0
**Author:** Kha Solar Team
**License:** GPL v2 or later

A complete WordPress theme for **Kha Solar** - a solar energy products business. This theme includes a custom product catalog system, lead generation forms, project showcases, and a modern B2B ecommerce design.

---

## Features

### Core Features
- ✅ **Custom Product System** (CPT + Taxonomy) - No WooCommerce needed
- ✅ **Lead Generation System** - Capture customer inquiries with built-in forms
- ✅ **Project Showcase** - Display completed solar installations
- ✅ **Blog Section** - Share knowledge and guides
- ✅ **Responsive Design** - Mobile-first, modern UI/UX
- ✅ **Demo Content Seeder** - Quick setup with sample data

### Product Management
- Custom post type: `solar_product`
- Taxonomy: `solar_category`
- Meta fields: Brand, Model, Power, Phase, Voltage, Warranty, Origin, Price, Stock Status, Technical Specs
- Product grid and detail pages
- Sidebar filters on archive pages

### Lead Management
- Lead submission forms on product pages
- Custom database table: `wp_khasolar_leads`
- Email notifications to admin
- Admin dashboard to view/manage leads
- Spam protection (nonce + honeypot)

### Project Showcase
- Custom post type: `solar_project`
- Meta fields: Location, Capacity, Type, Equipment, Completion Date, Notes
- Project archive and detail pages

---

## Installation

### Method 1: Upload via WordPress Admin

1. Download or zip the `khasolar-theme` folder
2. Log in to WordPress admin panel
3. Go to **Appearance → Themes → Add New → Upload Theme**
4. Choose the theme ZIP file and click **Install Now**
5. After installation, click **Activate**

### Method 2: Manual Installation

1. Download the `khasolar-theme` folder
2. Upload it to `/wp-content/themes/` directory via FTP
3. Go to **Appearance → Themes** in WordPress admin
4. Find "Kha Solar Theme" and click **Activate**

---

## Initial Setup

### 1. Create Demo Content

The theme includes a demo content generator to quickly populate your site:

1. After activating the theme, go to **Kha Solar Demo** in the admin sidebar
2. Click **"Tạo nội dung demo"** (Create Demo Content)
3. This will create:
   - 10 sample products (inverters, batteries, accessories)
   - 5 product categories
   - 3 completed projects
   - 5 blog posts
   - 6 core pages (About, Contact, Policies)

### 2. Set Homepage

1. Go to **Settings → Reading**
2. Set **"Your homepage displays"** to **"A static page"**
3. Choose **"Trang chủ"** (Homepage) as the homepage
4. Choose a page for **Posts page** (Blog)
5. Click **Save Changes**

### 3. Configure Menus

1. Go to **Appearance → Menus**
2. Create a new menu or use the default menu
3. Add pages to the menu:
   - Trang chủ (Home)
   - Sản phẩm (Products) - Link to `/san-pham`
   - Dự án (Projects) - Link to `/du-an`
   - Blog
   - Giới thiệu (About)
   - Liên hệ (Contact)
4. Assign the menu to **"Header Menu"** location
5. Click **Save Menu**

### 4. Set Custom Logo

1. Go to **Appearance → Customize → Site Identity**
2. Upload your logo (recommended size: 200x80px)
3. Click **Publish**

---

## Using the Theme

### Adding Products

1. Go to **Sản phẩm Solar → Thêm mới** (Solar Products → Add New)
2. Enter product title and description
3. Set featured image
4. Fill in product details:
   - **Thương hiệu** (Brand): e.g., Deye, APESS
   - **Model**: Product model number
   - **Công suất** (Power): in kW or kWp
   - **Pha** (Phase): 1 pha or 3 pha
   - **Điện áp** (Voltage): e.g., 220V, 380V
   - **Bảo hành** (Warranty): in years
   - **Xuất xứ** (Origin): Country of origin
   - **Giá từ** (Price from): in VND
   - **Tình trạng kho** (Stock): Còn hàng, Sắp hết, Hết hàng
5. Enter **Technical Specs** (one per line)
6. Assign to a category
7. Click **Publish**

### Adding Projects

1. Go to **Dự án Solar → Thêm mới** (Solar Projects → Add New)
2. Enter project title and description
3. Set featured image
4. Fill in project details:
   - **Địa điểm** (Location)
   - **Công suất** (Capacity in kWp)
   - **Loại dự án** (Project Type): Dân dụng, Nhà xưởng, Nông nghiệp, etc.
   - **Biến tần** (Inverter used)
   - **Pin lưu trữ** (Battery used)
   - **Ngày hoàn thành** (Completion date)
   - **Ghi chú** (Notes)
7. Click **Publish**

### Managing Leads

1. Go to **Yêu cầu tư vấn** (Lead Requests) in admin sidebar
2. View all customer inquiries with:
   - Customer name and phone
   - Product of interest
   - Location and notes
   - Submission date
3. Click **Xóa** (Delete) to remove a lead
4. You'll also receive email notifications for new leads

### Customizing Contact Information

The theme displays contact information in the header and footer. To customize:

1. **Email:** Edit in `inc/template-tags.php` → `khasolar_get_email()`
2. **Phone:** Edit in `inc/template-tags.php` → `khasolar_get_phone()`
3. **Address:** Edit in `inc/template-tags.php` → `khasolar_get_address()`
4. **Working Hours:** Edit in `inc/template-tags.php` → `khasolar_get_working_hours()`

Or use filters in your child theme or custom plugin:

```php
add_filter( 'khasolar_phone_number', function() {
    return '0987 654 321';
});

add_filter( 'khasolar_email', function() {
    return 'hello@khasolar.vn';
});
```

### Customizing Colors

Edit color variables in `/assets/css/main.css`:

```css
:root {
    --ks-primary: #FF6B35;      /* Primary brand color (orange) */
    --ks-secondary: #004E89;    /* Secondary brand color (blue) */
    --ks-dark: #1a1a1a;         /* Dark text color */
    --ks-bg: #f5f5f7;           /* Background color */
}
```

---

## Theme Structure

```
khasolar-theme/
├── style.css                   # Theme header (required by WordPress)
├── functions.php               # Main functions file
├── header.php                  # Site header
├── footer.php                  # Site footer
├── front-page.php              # Homepage template
├── index.php                   # Blog fallback
├── page.php                    # Page template
├── single.php                  # Single post template
├── archive.php                 # Archive template
├── search.php                  # Search results
├── 404.php                     # 404 error page
├── archive-solar_product.php   # Products archive
├── single-solar_product.php    # Single product
├── archive-solar_project.php   # Projects archive
├── single-solar_project.php    # Single project
├── /inc/                       # Core functionality
│   ├── setup.php               # Theme setup
│   ├── enqueue.php             # Scripts & styles
│   ├── cpt-solar-product.php   # Product CPT
│   ├── meta-solar-product.php  # Product meta
│   ├── cpt-solar-project.php   # Project CPT
│   ├── template-tags.php       # Helper functions
│   ├── leads.php               # Lead system
│   └── demo-content.php        # Demo seeder
├── /template-parts/            # Reusable templates
│   ├── /header/                # Header components
│   ├── /home/                  # Homepage sections
│   ├── /product/               # Product components
│   └── /project/               # Project components
└── /assets/                    # CSS & JavaScript
    ├── /css/main.css           # Main stylesheet
    └── /js/main.js             # Main JavaScript
```

---

## Database Tables

The theme creates one custom table:

### `wp_khasolar_leads`

Stores customer lead submissions:

| Column        | Type         | Description                    |
|---------------|--------------|--------------------------------|
| id            | INT          | Auto-increment primary key     |
| product_id    | INT          | Related product ID             |
| product_title | TEXT         | Product name                   |
| name          | VARCHAR(255) | Customer name                  |
| phone         | VARCHAR(50)  | Customer phone                 |
| location      | VARCHAR(255) | Customer location              |
| note          | TEXT         | Customer message               |
| created_at    | DATETIME     | Submission timestamp           |

---

## Technical Specifications

- **WordPress Version:** 6.0+
- **PHP Version:** 7.4+
- **License:** GPL v2 or later
- **Text Domain:** khasolar
- **Main Font:** Inter (Google Fonts)

### Custom Post Types

1. **solar_product**
   - Slug: `san-pham`
   - Supports: title, editor, thumbnail, excerpt
   - Has archive: Yes

2. **solar_project**
   - Slug: `du-an`
   - Supports: title, editor, thumbnail, excerpt
   - Has archive: Yes

### Taxonomies

1. **solar_category**
   - Slug: `danh-muc-solar`
   - Hierarchical: Yes
   - For: solar_product

---

## Support & Development

### Theme Support

For theme support, please contact:
- **Email:** contact@khasolar.vn
- **Phone:** 0123 456 789

### Removing Demo Content

To remove all demo content:

1. Go to **Kha Solar Demo** in admin
2. Click **"Xóa nội dung demo"** (Delete Demo Content)
3. Confirm the action

This will delete all demo products, projects, and posts.

---

## Changelog

### Version 1.0.0 - 2025-01-15
- Initial release
- Custom product catalog system
- Lead generation forms
- Project showcase
- Demo content seeder
- Responsive design
- Blog functionality

---

## Credits

- **Theme Design:** Kha Solar Team
- **Font:** Inter by Rasmus Andersson
- **Icons:** Inline SVG (Feather Icons style)
- **WordPress Coding Standards:** Followed

---

## License

This theme is licensed under the GPL v2 or later.

```
Copyright (C) 2025 Kha Solar

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

---

**Kha Solar Theme v1.0.0** - Built with care for solar energy businesses in Vietnam 🌞
