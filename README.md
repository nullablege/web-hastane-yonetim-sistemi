# 327 Hastane Yönetim Sistemi

Bu proje, hastane yönetim süreçlerini kolaylaştırmak ve dijitalleştirmek amacıyla geliştirilmiştir. Kullanıcı rolleri (doktor, sekreter, yönetici) ile entegre bir yapı sunar ve detaylı işlevsellikler içerir.

## 🚀 Özellikler

### Genel Özellikler:
- Kullanıcı rolleri: Doktor, Sekreter, Yönetici.
- Giriş yapmayan kullanıcıların erişimini engelleyen **Session** yönetimi.
- Tüm veri giriş/çıkış işlemleri `htmlspecialchars`, `stripslashes`, `trim` fonksiyonları ile güvenlik önlemleri alınarak yapılır.
- Şifreler `password_hash` fonksiyonu ile hashlenerek veritabanında saklanır.
- Mail bildirimleri: SMTP ile kullanıcı ve çalışanlara düzenli bilgilendirme mailleri gönderilir.

### Doktor Sayfası:
- Giriş yapıldığında günlük boş randevuların otomatik oluşturulması.
- Günlük randevuların görüntülenmesi, düzenlenmesi veya iptal edilmesi.
- Hastalara tanı koyma ve reçete yazma işlemleri.
- Randevu durumu yönetimi: Hasta içeride, randevu tamamlandı, randevuya gelmedi durumları.
- Kurum içi mail sistemi ile diğer kullanıcılarla iletişim.

### Sekreter Sayfası:
- Yeni hasta kaydı yapma ve hastalara hoşgeldin maili gönderme.
- Hastalar için randevu oluşturma.
- Günlük ve genel randevu listelerinin yönetimi.
- Randevu iptali ve detay görüntüleme.
- Kurum içi mail sistemi ile iletişim.

### Yönetici (Admin) Sayfası:
- Yeni doktor ve sekreter kaydı oluşturma.
- Doktor ve sekreter bilgilerini güncelleme veya işten çıkarma.
- Tüm çalışanlara toplu veya özel mailler gönderme.
- SMTP ayarlarının kontrol ve güncellenmesi.
- İstatistiklerin grafiksel olarak görüntülenmesi (Chart.js entegrasyonu).

## 🛠️ Kullanılan Teknolojiler

- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Backend:** PHP
- **Veritabanı:** MySQL
  - **Host:** `localhost`
  - **Kullanıcı Adı:** `root`
  - **Şifre:** Yok
  - **Veritabanı Adı:** `327Hastanesi`

## 📦 Kurulum
NOT : Bilmediğim bir sebepten dolayı dosyaları indirirken virüs algılıyor. ( Mail yolladığım dosyalar için ) Bunun sebebini bilmiyorum.

1. Proje dosyalarını indirin veya klonlayın:
   ```bash
   git clone https://github.com/nullablege/web-hastane-yonetim-sistemi.git
