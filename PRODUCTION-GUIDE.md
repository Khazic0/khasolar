# KHA SOLAR - HƯỚNG DẪN ĐƯA LÊN PRODUCTION

## 🚀 CHECKLIST TRƯỚC KHI GO LIVE

### BƯỚC 1: CÀI ĐẶT WORDPRESS & THEME

#### 1.1 Upload Theme
```bash
# Nén folder theme
zip -r khasolar-theme.zip khasolar-theme/

# Upload qua WordPress Admin:
# Appearance → Themes → Add New → Upload Theme
# Hoặc upload qua FTP vào: /wp-content/themes/
```

#### 1.2 Kích hoạt Theme
- Vào **Appearance → Themes**
- Click **Activate** trên Kha Solar Theme
- Database tables sẽ tự động được tạo

---

### BƯỚC 2: CẤU HÌNH CƠ BẢN (BẮT BUỘC)

#### 2.1 Settings → General
- ✅ Site Title: "Kha Solar - Giải pháp năng lượng mặt trời"
- ✅ Tagline: "Biến tần, Pin lưu trữ, Tủ điện chất lượng cao"
- ✅ WordPress Address (URL): https://yoursite.com
- ✅ Site Address (URL): https://yoursite.com
- ✅ Email Address: contact@khasolar.vn

#### 2.2 Settings → Reading
- ✅ Your homepage displays: **A static page**
- ✅ Homepage: Chọn trang "Trang chủ"
- ✅ Posts page: Chọn trang "Blog" hoặc "Tin tức"

#### 2.3 Settings → Permalinks
- ✅ Chọn: **Post name** (/%postname%/)
- ✅ Click **Save Changes** để flush rewrite rules

---

### BƯỚC 3: TẠO CÁC TRANG QUAN TRỌNG

#### 3.1 Tạo Trang So Sánh Sản Phẩm (BẮT BUỘC)
```
Pages → Add New
- Title: So sánh sản phẩm
- Slug: so-sanh-san-pham
- Template: So sánh sản phẩm (từ dropdown)
- Status: Publish
```

#### 3.2 Tạo Các Trang Cần Thiết
Tạo các trang sau (Pages → Add New):

**Trang chủ:**
- Title: Trang chủ
- Template: Front Page (hoặc Default)

**Về chúng tôi:**
```
Title: Về chúng tôi
Nội dung mẫu:
---
Kha Solar là đơn vị hàng đầu cung cấp giải pháp năng lượng mặt trời tại Việt Nam.

VÌ SAO CHỌN KHA SOLAR?
✓ Sản phẩm chính hãng, bảo hành dài hạn
✓ Đội ngũ kỹ thuật chuyên nghiệp
✓ Thi công nhanh chóng, đúng tiến độ
✓ Hỗ trợ sau bán hàng tận tâm
✓ Giá cả cạnh tranh nhất thị trường
```

**Liên hệ:**
```
Title: Liên hệ
Nội dung:
---
THÔNG TIN LIÊN HỆ

📍 Địa chỉ: [Địa chỉ văn phòng của bạn]
📞 Hotline: [Số điện thoại]
📧 Email: contact@khasolar.vn
⏰ Giờ làm việc: 8:00 - 18:00 (Thứ 2 - Thứ 7)

[Thêm Google Maps iframe]
```

**Chính sách:**
- Chính sách bảo hành
- Chính sách đổi trả
- Chính sách bảo mật
- Điều khoản sử dụng

---

### BƯỚC 4: IMPORT SẢN PHẨM

#### 4.1 Import 14 Sản Phẩm Thật
```
Kha Solar Demo → Import Sản phẩm
- Xem preview 14 sản phẩm
- Click "Import tất cả sản phẩm"
- Đợi hoàn tất
```

#### 4.2 Thêm Hình Ảnh Sản Phẩm
- Vào **Solar Products** → Edit từng sản phẩm
- Upload **Featured Image** cho mỗi sản phẩm
- Khuyến nghị kích thước: 800x800px
- Format: JPG hoặc PNG
- Tối ưu dung lượng < 200KB

---

### BƯỚC 5: CẤU HÌNH LIÊN HỆ

#### 5.1 Customizer Settings
```
Appearance → Customize → Thông tin liên hệ

WhatsApp Number: 84987654321
Zalo Number: 0987654321
```

#### 5.2 Cập Nhật Template Tags
Sửa file `/inc/template-tags.php`:

```php
function khasolar_get_phone() {
    return '0901 234 567'; // ← Số điện thoại thật của bạn
}

function khasolar_get_email() {
    return 'contact@khasolar.vn'; // ← Email thật
}

function khasolar_get_address() {
    return '123 Đường ABC, Quận XYZ, TP.HCM'; // ← Địa chỉ thật
}
```

---

### BƯỚC 6: CẤU HÌNH EMAIL

#### 6.1 SMTP Plugin (Khuyến nghị)
```
Install: WP Mail SMTP hoặc Easy WP SMTP
Configure với:
- Gmail SMTP
- SendGrid
- Mailgun
- hoặc SMTP server của hosting
```

#### 6.2 Test Email
- Gửi test lead từ form
- Kiểm tra nhận được email thông báo
- Email admin: Settings → General → Email Address

---

### BƯỚC 7: MENU & NAVIGATION

#### 7.1 Tạo Header Menu
```
Appearance → Menus → Create New Menu
Name: Header Menu
Locations: Header Menu

Thêm menu items:
- Trang chủ
- Sản phẩm (link đến /san-pham/)
- Dự án (link đến /du-an/)
- Về chúng tôi
- Blog
- Liên hệ
```

#### 7.2 Tạo Footer Menu
```
Appearance → Menus → Create New Menu
Name: Footer Menu
Locations: Footer Menu

Thêm:
- Chính sách bảo hành
- Chính sách bảo mật
- Điều khoản sử dụng
- Sitemap
```

---

### BƯỚC 8: SEO & ANALYTICS

#### 8.1 Google Search Console
```
1. Vào https://search.google.com/search-console
2. Add property với domain của bạn
3. Verify ownership (HTML tag hoặc DNS)
4. Submit sitemap: https://yoursite.com/?feed=sitemap
```

#### 8.2 Google Analytics (Optional)
```
1. Tạo GA4 property tại https://analytics.google.com
2. Copy Measurement ID (G-XXXXXXXXXX)
3. Dán vào wp-config.php:
   define('KHASOLAR_GA_ID', 'G-XXXXXXXXXX');
4. Hoặc dùng plugin: Google Analytics for WordPress by MonsterInsights
```

#### 8.3 Facebook Pixel (Optional)
```
1. Tạo Pixel tại Facebook Business Manager
2. Copy Pixel ID
3. Dán vào header.php hoặc dùng plugin
```

---

### BƯỚC 9: PERFORMANCE & SECURITY

#### 9.1 Caching Plugin
```
Install một trong các plugin:
- WP Super Cache (free, dễ dùng)
- W3 Total Cache (advanced)
- WP Rocket (premium, tốt nhất)

Enable:
✓ Page caching
✓ Browser caching
✓ GZIP compression
```

#### 9.2 Image Optimization
```
Install: Smush hoặc ShortPixel
- Optimize existing images
- Auto-optimize on upload
```

#### 9.3 Security Plugin
```
Install: Wordfence Security hoặc iThemes Security

Enable:
✓ Firewall
✓ Malware scanning
✓ Login security (limit attempts)
✓ Two-factor authentication
```

#### 9.4 SSL Certificate
```
✓ Cài SSL certificate (Let's Encrypt miễn phí)
✓ Force HTTPS trong Settings → General
✓ Hoặc thêm vào wp-config.php:
  define('FORCE_SSL_ADMIN', true);
```

#### 9.5 Backup
```
Install: UpdraftPlus hoặc BackWPup
Schedule:
- Daily database backup
- Weekly full backup
- Store to Google Drive / Dropbox
```

---

### BƯỚC 10: KIỂM TRA CUỐI CÙNG

#### 10.1 Functional Testing
- [ ] Trang chủ load đầy đủ
- [ ] Product archive hiển thị sản phẩm
- [ ] Single product page hoạt động
- [ ] Lead form gửi được và nhận email
- [ ] ROI Calculator hoạt động
- [ ] Product comparison hoạt động
- [ ] Review form submit được
- [ ] WhatsApp/Zalo buttons click được
- [ ] Mobile responsive tốt
- [ ] Search hoạt động

#### 10.2 SEO Testing
- [ ] Kiểm tra Schema: https://search.google.com/test/rich-results
- [ ] Meta descriptions hiển thị
- [ ] Open Graph tags (test trên Facebook Debugger)
- [ ] Sitemap accessible: yoursite.com/?feed=sitemap
- [ ] Robots.txt exists: yoursite.com/robots.txt

#### 10.3 Speed Testing
```
Test tại:
- Google PageSpeed Insights
- GTmetrix
- Pingdom

Target:
✓ Mobile: > 60/100
✓ Desktop: > 80/100
✓ Load time: < 3 seconds
```

#### 10.4 Browser Testing
- [ ] Chrome (desktop & mobile)
- [ ] Safari (desktop & mobile)
- [ ] Firefox
- [ ] Edge

---

### BƯỚC 11: LAUNCH!

#### 11.1 Pre-launch
```
✓ Disable "Discourage search engines" (Settings → Reading)
✓ Set maintenance mode OFF
✓ Final backup
✓ Clear all caches
```

#### 11.2 DNS Setup
```
Point domain to hosting:
- A record: @ → Server IP
- CNAME: www → @
TTL: 3600
```

#### 11.3 Post-launch
```
✓ Submit sitemap to Google Search Console
✓ Test all forms với email thật
✓ Monitor error logs: /wp-content/debug.log
✓ Monitor uptime: UptimeRobot.com (free)
```

---

## 📱 MARKETING CHECKLIST

### Ngay sau khi launch:
- [ ] Update Google My Business
- [ ] Post trên Facebook Page
- [ ] Email announcement đến khách hàng cũ
- [ ] Chạy Google Ads cho từ khóa chính
- [ ] Facebook Ads retargeting
- [ ] Zalo Official Account marketing

### Tuần đầu tiên:
- [ ] Publish 3-5 blog posts về solar
- [ ] Tạo 5-10 reviews mẫu (từ khách thật)
- [ ] Upload hình ảnh dự án đã làm
- [ ] Video giới thiệu công ty
- [ ] Customer testimonials

---

## 🔧 TROUBLESHOOTING

### Lead form không gửi email?
```
1. Check SMTP settings
2. Install WP Mail SMTP plugin
3. Test với admin email
4. Check spam folder
```

### Comparison page trống?
```
1. Đảm bảo đã tạo page với template "So sánh sản phẩm"
2. Slug phải là: so-sanh-san-pham
3. Clear browser cookies
4. Thêm sản phẩm vào comparison
```

### Reviews không hiển thị?
```
1. Check admin: Yêu cầu tư vấn → Đánh giá
2. Approve pending reviews
3. Đảm bảo template-parts/product/reviews.php exists
```

### Schema errors?
```
1. Test tại: https://search.google.com/test/rich-results
2. Update contact info trong /inc/template-tags.php
3. Add logo.png vào /assets/images/
```

---

## 📞 SUPPORT

### Theme Files Location:
```
/wp-content/themes/khasolar-theme/
```

### Important Files:
- `functions.php` - Main config
- `/inc/template-tags.php` - Contact info
- `/inc/schema-markup.php` - SEO schema
- `style.css` - Theme metadata

### Documentation:
- Full docs: `/README.md`
- Upgrades log: `/UPGRADES-COMPLETED.md`
- Feature roadmap: `/UPGRADE-PROPOSAL.md`

---

## ✅ PRODUCTION READY CHECKLIST

Copy checklist này và đánh dấu từng item:

```
□ WordPress cài đặt xong
□ Theme activated
□ Permalinks set to Post Name
□ Trang so sánh đã tạo
□ 14 sản phẩm đã import
□ Hình ảnh sản phẩm đã upload
□ Contact info đã update
□ WhatsApp/Zalo đã config
□ SMTP email đã setup
□ Header menu đã tạo
□ Footer menu đã tạo
□ SSL certificate installed
□ Caching plugin active
□ Security plugin configured
□ Backup scheduled
□ Google Search Console verified
□ Sitemap submitted
□ Analytics installed (optional)
□ All forms tested
□ Mobile responsive checked
□ Speed test passed
□ SEO test passed
□ Search engines enabled
□ DNS pointed
□ Final backup taken
□ LAUNCHED! 🚀
```

---

**Version:** 1.2.0
**Last Updated:** January 2025
**Support:** Xem README.md để biết thêm chi tiết
