# ✅ CHECKLIST SẴN SÀNG KINH DOANH - KHA SOLAR

## 🚀 5 PHÚT SETUP - CHECKLIST NHANH

### 1. SETUP TRONG WORDPRESS ADMIN (5 phút)

Vào **⚡ Thiết lập** trong menu WordPress admin, làm theo từng bước:

```
□ Permalinks: Đã set thành /%postname%/
□ Trang so sánh: Đã tạo trang "so-sanh-san-pham"
□ Sản phẩm: Đã import 14 sản phẩm thật
□ Liên hệ: Đã config WhatsApp và Zalo
□ Menu: Đã tạo Header và Footer menu
```

### 2. CẬP NHẬT THÔNG TIN LIÊN HỆ (2 phút)

**Sửa file:** `/wp-content/themes/khasolar-theme/inc/template-tags.php`

Tìm và sửa 3 functions:
```php
function khasolar_get_phone() {
    return '0901 234 567'; // ← SỐ ĐIỆN THOẠI THẬT CỦA BẠN
}

function khasolar_get_email() {
    return 'contact@khasolar.vn'; // ← EMAIL THẬT
}

function khasolar_get_address() {
    return '123 Đường ABC, Quận XYZ, TP.HCM'; // ← ĐỊA CHỈ THẬT
}
```

### 3. UPLOAD HÌNH ẢNH SẢN PHẨM (10-15 phút)

```
□ Vào Solar Products
□ Edit từng sản phẩm (14 sản phẩm)
□ Upload Featured Image
□ Khuyến nghị: 800x800px, < 200KB, JPG/PNG
```

### 4. TẠO NỘI DUNG CƠ BẢN (10 phút)

**Sửa các trang:**
- **Về chúng tôi**: Thêm giới thiệu công ty
- **Liên hệ**: Thêm Google Maps iframe, thông tin chi tiết

### 5. CÀI CÁC PLUGIN QUAN TRỌNG (5 phút)

```
□ WP Mail SMTP - Gửi email
□ WP Super Cache - Tăng tốc website
□ Wordfence Security - Bảo mật
□ UpdraftPlus - Backup tự động
```

### 6. CẤU HÌNH SEO (2 phút)

```
□ Settings → Reading: Bỏ tick "Discourage search engines"
□ Google Search Console: Add property
□ Submit sitemap: https://yoursite.com/?feed=sitemap
```

### 7. SSL & BẢO MẬT (nếu chưa có)

```
□ Cài SSL certificate (Let's Encrypt miễn phí)
□ Force HTTPS trong Settings → General
□ Test: https://yoursite.com phải hiển thị khóa xanh
```

---

## 📋 CHECKLIST ĐẦY ĐỦ TRƯỚC KHI LAUNCH

### TECHNICAL
- [ ] WordPress updated to latest version
- [ ] Theme activated: Kha Solar v1.2.0
- [ ] Permalinks: Set to Post name
- [ ] SSL Certificate installed and forced
- [ ] SMTP Email configured and tested
- [ ] Backup plugin installed and scheduled
- [ ] Caching plugin active
- [ ] Security plugin configured

### CONTENT
- [ ] 14 sản phẩm đã import + hình ảnh
- [ ] Trang "So sánh sản phẩm" đã tạo
- [ ] Trang "Về chúng tôi" có nội dung
- [ ] Trang "Liên hệ" đầy đủ
- [ ] Header menu configured
- [ ] Footer menu configured

### CONTACT & SETTINGS
- [ ] Phone, Email, Address updated trong template-tags.php
- [ ] WhatsApp number configured
- [ ] Zalo number configured
- [ ] Admin email correct trong Settings → General

### SEO & ANALYTICS
- [ ] Search engines enabled (Settings → Reading)
- [ ] Google Search Console verified
- [ ] Sitemap submitted
- [ ] Schema markup active (auto)
- [ ] Google Analytics installed (optional)

### TESTING
- [ ] Homepage loads correctly
- [ ] Product pages display properly
- [ ] Lead form works + email arrives
- [ ] Calculator works
- [ ] Comparison works
- [ ] Reviews can be submitted
- [ ] WhatsApp/Zalo buttons work
- [ ] Mobile responsive looks good

### LEGAL (nếu cần)
- [ ] Privacy Policy page
- [ ] Terms of Service page
- [ ] Cookie notice (GDPR nếu có khách EU)

---

## 🎯 TEST NHANH WEBSITE (5 phút)

### Test 1: Forms hoạt động?
1. Vào bất kỳ sản phẩm nào
2. Điền form "Yêu cầu tư vấn"
3. Submit
4. ✅ Kiểm tra email admin có nhận được không

### Test 2: Comparison hoạt động?
1. Vào /san-pham/
2. Click "So sánh" trên 2-3 sản phẩm
3. Click "Xem so sánh" trong floating bar
4. ✅ Trang comparison hiển thị đúng

### Test 3: Calculator hoạt động?
1. Tìm ROI Calculator (nếu đã thêm vào trang)
2. Nhập số tiền điện và công suất
3. ✅ Kết quả hiển thị

### Test 4: WhatsApp/Zalo?
1. Click floating buttons ở góc phải
2. ✅ Mở đúng WhatsApp/Zalo với số điện thoại đã config

### Test 5: Mobile?
1. Mở website trên điện thoại
2. ✅ Menu, hình ảnh, buttons hiển thị OK

---

## 📱 SAU KHI LAUNCH - MARKETING

### Ngày đầu:
- [ ] Post Facebook announcement
- [ ] Email khách hàng cũ
- [ ] Update Google My Business
- [ ] Share link trên Zalo groups

### Tuần đầu:
- [ ] Publish 3-5 blog posts
- [ ] Thêm 5-10 customer reviews
- [ ] Upload ảnh dự án đã làm
- [ ] Chạy Facebook Ads thử nghiệm

### Tháng đầu:
- [ ] Setup Google Ads
- [ ] Email marketing campaign
- [ ] Retargeting ads
- [ ] Partnership outreach

---

## 🆘 SUPPORT

### Nếu gặp vấn đề:

**Lead form không gửi email?**
→ Cài plugin WP Mail SMTP và config SMTP

**Comparison page trống?**
→ Kiểm tra đã tạo page với template "So sánh sản phẩm" chưa

**Website chậm?**
→ Cài WP Super Cache hoặc WP Rocket

**Bảo mật lo ngại?**
→ Cài Wordfence Security

### Tài liệu:
- **Setup chi tiết:** PRODUCTION-GUIDE.md
- **Theme docs:** README.md
- **Features list:** UPGRADES-COMPLETED.md

### XML Sitemap:
- **URL:** https://yoursite.com/?feed=sitemap
- **Submit to:** Google Search Console

---

## ✅ FINAL CHECK - TRƯỚC KHI ANNOUNCE

```
□ Tôi đã test tất cả forms
□ Tôi đã check mobile responsive
□ Tôi đã test trên Chrome, Safari
□ SSL đang hoạt động (https:// có khóa xanh)
□ Email notifications đang nhận được
□ Số điện thoại, email, địa chỉ đã update
□ WhatsApp và Zalo đang hoạt động
□ Sản phẩm có đầy đủ hình ảnh
□ Backup đã setup
□ Google Search Console đã verify
□ Sitemap đã submit

🎉 SẴN SÀNG KINH DOANH!
```

---

**Theme:** Kha Solar v1.2.0
**Production Ready:** ✅ YES
**Last Updated:** January 2025
