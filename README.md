# Özel 327 Hastanesi - Kapsamlı Yönetim Paneli

![Özel 327 Hastanesi Logo](https://i.ibb.co/xGzDqM9/logo.png)

**Özel 327 Hastanesi Yönetim Paneli**, BTBS 327 Dersinin bitirme projesi olan modern sağlık kurumlarının karmaşık operasyonel ihtiyaçlarını karşılamak üzere tasarlanmış, **güçlü ve kullanıcı dostu bir PHP tabanlı web uygulamasıdır.** Bu platform, hastane yönetimi süreçlerini dijitalleştirerek; admin, doktor ve sekreter rolleri için özel arayüzler ve işlevler sunar. Randevu yönetiminden personel bilgilerine, hasta kayıtlarından kurum içi iletişime kadar geniş bir yelpazede çözümler sunarak verimliliği ve hasta memnuniyetini artırmayı hedefler.

Bu proje, **güvenlik, ölçeklenebilirlik ve kullanım kolaylığı** ilkeleri temel alınarak, titiz bir mühendislik çalışmasıyla geliştirilmiştir. Endüstri standardı **PHPMailer** kütüphanesi ile entegre edilmiş profesyonel e-posta bildirim sistemi, anlık ve güvenilir iletişim sağlar. Veritabanı etkileşimlerinde **güvenlik en ön planda tutularak** `htmlspecialchars`, `stripslashes` ve `trim` gibi fonksiyonlarla kullanıcı girdileri arındırılmış, şifreler ise `password_hash` ve `password_verify` ile **BCRYPT** algoritması kullanılarak güçlü bir şekilde korunmuştur.

---

## 🌟 Öne Çıkan Özellikler

*   **Rol Bazlı Yetkilendirme ve Giriş Sistemi:**
    *   Admin, Doktor ve Sekreter için ayrı ve güvenli giriş panelleri.
    *   Başarılı giriş sonrası kullanıcıları kendi rollerine uygun arayüzlere yönlendirme.
    *   **Güçlü Şifreleme:** `password_hash()` (BCRYPT) ile kullanıcı şifrelerinin güvenli saklanması.
*   **Kapsamlı Kullanıcı Yönetimi (Admin Paneli):**
    *   Yeni doktor ve sekreter kayıtları oluşturma.
    *   Mevcut personelin bilgilerini (TC, ad, soyad, e-posta, telefon, adres, doğum tarihi, branş vb.) dinamik olarak güncelleme.
    *   Personelin işten çıkarılması işlemleri.
*   **Gelişmiş Randevu Yönetimi:**
    *   **Sekreter Paneli:**
        *   Hasta arama (TC, ad, soyad ile).
        *   Yeni hasta kaydı oluşturma.
        *   Hasta için uygun branş ve doktor seçimi yaparak randevu oluşturma (`branssec.php`, `randevuAl.php`, `tarihsec.php`).
        *   Belirli bir tarihteki müsait randevu saatlerini listeleme ve seçme.
        *   Hastanın şikayet bilgilerini kaydetme.
        *   Aktif ve genel randevu listelerini görüntüleme (`aktifRandevular.php`, `gunlukRandevular.php`, `genelRandevular.php`).
        *   Tamamlanmış randevu detaylarını inceleme (`randevularDetay.php`).
        *   Randevuları iptal etme ve ilgili taraflara (hasta ve doktor) bildirim gönderme.
    *   **Doktor Paneli:**
        *   Günlük randevu oluşturma (doktor sisteme girdiğinde o gün için otomatik olarak boş randevu slotları tanımlanır).
        *   Kendisine atanmış ve aktif randevuları listeleme.
        *   Randevuları kapatma (izin, tatil vb. durumlar için) ve geri açma.
        *   Devam eden bir randevuya "girme" ve hasta bilgilerini görüntüleme (`randevuDetay.php`).
        *   Randevu sırasında doktor tanısı, yazılan ilaçlar ve otomatik oluşturulan reçete numarası bilgilerini sisteme kaydetme.
        *   Randevuya gelmeyen hastalar için "gelmedi" olarak işaretleme ve ceza puanı sistemine veri sağlama.
        *   Beklenmedik durumlarda randevuyu hastane taraflı iptal etme.
        *   Tamamlanmış randevuları düzenleyebilme (`randevuDuzenle.php`).
*   **Profesyonel E-posta Bildirimleri (PHPMailer):**
    *   SMTP üzerinden güvenilir e-posta gönderimi.
    *   **Çeşitli HTML E-posta Şablonları:**
        *   Kayıt doğrulama kodu.
        *   Şifre sıfırlama kodu/linki.
        *   Yeni işe alım bildirimi.
        *   İşten çıkarma bildirimi.
        *   Kurum içi özel mesajlaşma.
        *   Yeni randevu oluşturulduğunda hasta ve doktora bildirim.
        *   Randevu iptal edildiğinde hasta ve doktora bildirim.
        *   Randevu sonlandığında hastaya rapor (reçete no, ilaçlar, tanı).
        *   Randevuya gelmeyen hastaya ceza puanı bildirimi.
        *   Doktorun randevuyu iptal etmesi durumunda hastaya özür mesajı.
        *   Yöneticiden tüm personele, sadece doktorlara veya sadece sekreterlere toplu duyuru gönderme.
    *   **E-posta Takvimi Entegrasyonu:** Randevu bildirim e-postalarında Google Takvim ve Outlook Takvim'e tek tıkla etkinlik ekleme linkleri!
    *   Gönderilen tüm e-postaların veritabanına loglanması (`mailLog` fonksiyonu).
*   **Güvenlik ve Veri Doğrulama:**
    *   Kullanıcı girdileri `htmlspecialchars()`, `stripslashes()`, `trim()` fonksiyonları ile **XSS (Cross-Site Scripting) saldırılarına ve gereksiz boşluklara karşı** arındırılır.
    *   E-posta formatı, TC kimlik numarası uzunluğu, telefon numarası formatı gibi veriler için **sunucu taraflı doğrulamalar** (`filter_var`, `preg_match`).
    *   Şifre sıfırlama ve e-posta doğrulama kodları için **zaman aşımı kontrolleri** (`yenikod.php`, `register2.php`). Spam ve brute-force denemelerine karşı koruma.
    *   Tüm SQL sorguları, dinamik veriler içerdiğinde `mysqli_real_escape_string` (dolaylı olarak `htmlspecialchars` ile) ile güvenli hale getirilir. **Not:** `Prepared Statements` kullanımı, bu tür işlemlerde daha üst düzey güvenlik ve daha iyi bir pratik olarak kabul edilir.
*   **SMTP Yapılandırması (Admin Paneli):** Yöneticilerin SMTP sunucu ayarlarını (host, kullanıcı adı, şifre, gönderen bilgileri) arayüz üzerinden yapılandırmasına olanak tanır (`smtp.php`). Yapılandırmanın geçerliliğini test etmek için deneme maili gönderilir.
*   **Kullanıcı Bilgi Güncelleme:** Doktor ve sekreterler, TC, ad, soyad, adres, telefon, e-posta gibi kişisel bilgilerini ve şifrelerini güvenli bir şekilde güncelleyebilirler (`bilgiGuncelle.php`).
*   **İstatistikler (Admin Paneli):** Branş bazlı günlük randevu sayılarını gösteren dinamik grafikler (Chart.js kullanılarak bar veya pasta grafik olarak değiştirilebilir) sunar (`istatistik.php`).
*   **Modern ve Kullanıcı Dostu Arayüz:**
    *   **Bootstrap 5** ile geliştirilmiş, tamamen duyarlı (responsive) tasarım.
    *   Temiz ve anlaşılır kullanıcı arayüzleri.
    *   Anlık geri bildirimler (alert mesajları).
    *   Kolay navigasyon.

---

## 🛠️ Kullanılan Teknolojiler ve Kütüphaneler

*   **Backend:** PHP
*   **Veritabanı:** MySQL (MySQLi ile erişim)
*   **Frontend:** HTML5, CSS3 (Bootstrap 5 ile), JavaScript
*   **PHP Kütüphaneleri:**
    *   `phpmailer/phpmailer`: E-posta gönderimleri için.
*   **JavaScript Kütüphaneleri:**
    *   Chart.js: İstatistiksel verileri görselleştirmek için.
    *   Bootstrap JS Bundle (Popper.js içerir): Dropdown menüler, modal pencereler gibi interaktif Bootstrap bileşenleri için.
*   **Güvenlik Fonksiyonları:**
    *   `password_hash()` ve `password_verify()` (BCRYPT).
    *   `htmlspecialchars()`, `stripslashes()`, `trim()`.
    *   `filter_var()`, `preg_match()`.
    *   Oturum yönetimi (`session_start()`).

---

## 📁 Dosya Yapısı (Ana Klasörler ve Önemli Dosyalar)
```
HastaneYonetimPaneli/
├── PHPMailer/ # PHPMailer kütüphane dosyaları
├── html/ # (İçeriği belirsiz, muhtemelen statik HTML şablonları veya örnekler)
├── htmlmler/ # (İçeriği belirsiz, html klasörüyle benzer olabilir)
├── img/ # logo.png gibi görseller
├── mail/ # (İçeriği belirsiz, ss.php ile çakışıyor olabilir veya yedek)
├── telefon/ # (İçeriği belirsiz)
├── README.md # Bu dosya
├── admin.php # Yönetici ana paneli
├── aktifRandevular.php # Aktif randevuları listeleme (Sekreter)
├── bilgiGuncelle.php # Kullanıcı (doktor/sekreter) bilgi güncelleme
├── branssec.php # Randevu için branş seçme (Sekreter)
├── db.php # Veritabanı bağlantı ayarları
├── deneme.php # (Muhtemelen test veya geliştirme amaçlı)
├── doktor.php # Doktor ana paneli
├── doktorMail.php # Doktor için kurum içi mailleşme
├── doktorunRandevulari.php # Doktorun kendi randevularını listelemesi
├── forgotpassword.php # Şifremi unuttum - TC giriş formu
├── forgotpassword2.php # Şifremi unuttum - Kod giriş formu
├── forgotpassword3.php # Şifremi unuttum - Yeni şifre belirleme formu
├── genelRandevular.php # Tüm zamanlardaki randevuları listeleme (Sekreter)
├── gunlukRandevular.php # Günlük randevuları listeleme (Sekreter)
├── index.php # (Muhtemelen login.php'ye yönlendirir veya eski ana sayfa)
├── indexKategorili.html # (Projenin farklı bir versiyonuna veya konseptine ait olabilir)
├── istatistik.php # Randevu istatistikleri (Admin)
├── login.html # (Muhtemelen login.php'nin HTML prototipi)
├── login.php # Ana giriş sayfası
├── logout.php # Çıkış işlemi
├── mail.php # PHPMailer yapılandırması ve e-posta gönderme fonksiyonları (ss.php ile birleştirilmiş gibi duruyor)
├── randevuAl.php # Branş seçimi sonrası doktor seçimi (Sekreter)
├── randevuDetay.php # Randevu detaylarını görüntüleme ve doktor işlemleri
├── randevuDuzenle.php # Tamamlanmış randevuyu düzenleme (Doktor)
├── randevularDetay.php # Tamamlanmış randevu detaylarını görüntüleme (Sekreter/Doktor)
├── register.php # Kullanıcı kayıt formu
├── register2.php # Kayıt için e-posta doğrulama kodu giriş
├── req.php # Bootstrap ve gerekli CSS/JS dosyalarını çağıran include dosyası
├── s.txt # (Muhtemelen not veya test verisi)
├── sekreter.php # Sekreter ana paneli
├── sekreterMail.php # Sekreter için kurum içi mailleşme
├── smtp.php # SMTP ayarlarını yapılandırma (Admin)
├── ss.php # Temel e-posta fonksiyonları ve HTML e-posta şablon oluşturucuları (mail.php ile büyük oranda aynı)
├── tarihsec.php # Doktor seçimi sonrası randevu tarihi/saati seçimi (Sekreter)
└── yenikod.php # Yeni doğrulama kodu talep etme
```
*(Not: `html`, `htmlmler`, `mail`, `telefon` klasörlerinin ve `deneme.php`, `index.php`, `indexKategorili.html`, `login.html`, `s.txt` dosyalarının projenin aktif ve canlı versiyonundaki rolleri belirsizdir. `mail.php` ve `ss.php` dosyaları benzer işlevler sunmaktadır; bunlardan biri ana e-posta yönetim dosyası olabilir.)*

---

## 📜 Seçilmiş Modüllerin Detaylı Açıklaması

### `mail.php` / `ss.php` (E-posta Yönetimi ve Şablonları)
Bu dosya(lar), projenin **kalbi niteliğindeki iletişim mekanizmasını** oluşturur. **PHPMailer** kütüphanesini kullanarak güvenli SMTP bağlantıları üzerinden e-posta gönderimini sağlar.
*   `sendEmail()`: Temel e-posta gönderme fonksiyonu. Başarı durumunu loglamak için `mailLog()`'u çağırır.
*   `htmlOlustur()`: Şifre sıfırlama için gönderilen e-postanın HTML içeriğini dinamik olarak (doğrulama kodu ve yıl ile) oluşturur.
*   `sifreUnuttum()`: Belirli bir e-posta adresine şifre sıfırlama kodu içeren HTML e-postası gönderir.
*   `iseAlim()`, `istenCikar()`, `mailGonder()`, `randevuBildir()`, `topluDuyuru()`, `calisanaMesaj()`, `doktorlaraDuyuru()`, `sekreterlereTopluDuyuru()`, `randevuIptalBildir()`, `randevuSon()`, `randevuGelmedi()`, `randevuOzur()`: Bu fonksiyonlar, **projenin ne kadar detaylı ve kullanıcı odaklı olduğunu gösteren mükemmel örneklerdir.** Her biri, farklı senaryolar için özel olarak tasarlanmış, markalı ve bilgilendirici HTML e-posta şablonları oluşturur ve bunları ilgili kişilere gönderir. Özellikle `randevuBildir()` fonksiyonundaki **Google ve Outlook takvimine etkinlik ekleme linkleri**, kullanıcı deneyimini önemli ölçüde artıran **parlak bir özelliktir!**
*   **Güvenlik:** SMTP bilgileri (`define` ile) ve e-posta içerikleri (`htmlspecialchars` ile dolaylı olarak `mysqli_real_escape_string` vb. ile) korunmalıdır. E-postalardaki hassas bilgiler için ek güvenlik katmanları düşünülebilir.

### `admin.php` (Yönetici Paneli)
Yöneticilere hastane personelini ve sistem ayarlarını yönetme imkanı sunar.
*   **Personel Yönetimi:**
    *   Mevcut doktor ve sekreterlerin listesini görüntüler.
    *   Belirli bir personelin detaylı bilgilerini getirme ve güncelleme formu sunar. Güncelleme işlemleri sırasında TC, ad, soyad gibi tüm alanlar için girdi temizliği (`htmlspecialchars`, `trim`, `stripslashes`) yapılır.
    *   Personeli işten çıkarma (silme) işlemini onay mekanizması (modal pencere) ile gerçekleştirir. İşten çıkarılan personele `istenCikar()` fonksiyonu ile e-posta gönderilir.
    *   Yeni doktor ve sekreter kayıtları oluşturma formları içerir. Yeni kayıt sırasında şifreler `password_hash` ile güvenli bir şekilde hashlenir.
*   **İletişim Araçları:**
    *   Belirli bir doktora veya sekretere özel mesaj gönderme.
    *   Tüm doktorlara, tüm sekreterlere veya tüm personele toplu duyuru gönderme (`topluDuyuru`, `doktorlaraDuyuru`, `sekreterlereTopluDuyuru` fonksiyonları kullanılır).
*   **Sistem Ayarları:**
    *   `smtp.php`'ye link vererek SMTP ayarlarının yapılandırılmasına olanak tanır.
    *   `istatistik.php`'ye link vererek branş bazlı randevu istatistiklerinin görüntülenmesini sağlar.
*   **Güvenlik:** Sayfaya sadece yönetici rolündeki kullanıcıların erişebilmesi için oturum kontrolü (`$_SESSION['yonetici']`) yapılır. Form girdileri dikkatle temizlenir.

### `sekreter.php` (Sekreter Paneli)
Sekreterlerin randevu yönetimi ve hasta kayıt işlemlerini yürüttüğü merkezi arayüzdür.
*   **Randevu Oluşturma Akışı:**
    *   Hasta arama (TC, ad, soyad ile). Arama sonuçları bir tabloda listelenir ve buradan hasta seçilerek randevu oluşturma süreci başlatılır (`$_POST['randevuolustur']`).
    *   `branssec.php`: Seçilen hasta için uygun branşın seçildiği adım.
    *   `randevual.php`: Seçilen branşa göre uygun doktorların listelendiği ve seçildiği adım.
    *   `tarihsec.php`: Seçilen doktor için müsait randevu saatlerinin gösterildiği ve hastanın şikayetinin girildiği son adım. Randevu oluşturulduğunda `randevuBildir()` ile hasta ve doktora e-posta gönderilir.
*   **Yeni Hasta Kaydı:** Yeni bir hastanın TC, ad, soyad, doğum tarihi, telefon, e-posta, cinsiyet ve genel bilgileri sisteme kaydedilir. Kayıt sonrası `iseAlim()` fonksiyonu (aslında yeni hasta kaydı bildirimi olmalı, fonksiyon adı yanıltıcı olabilir) ile hastaya hoş geldin e-postası gönderilebilir.
*   **Diğer İşlevler:** Aktif randevular, mail kutusu (`sekreterMail.php`), günlük ve genel randevu listelerine erişim linkleri sunar.
*   **Güvenlik:** Sadece sekreter rolündeki kullanıcıların erişimine izin verilir (`$_SESSION['sekreter']`). Girdiler arındırılır.

### `doktor.php` (Doktor Paneli)
Doktorların kendi randevularını yönettiği, hasta bilgilerine eriştiği ve tıbbi kayıtları girdiği arayüzdür.
*   **Otomatik Randevu Slotu Oluşturma:** Doktor sisteme gün içinde ilk kez girdiğinde, `doktorgiris` tablosu kontrol edilerek o gün için randevu slotları tanımlanmamışsa, otomatik olarak (`16:30`'a kadar varsayılan) boş randevu saatleri `randevular` tablosuna eklenir. Bu, **pratik ve zekice bir çözümdür!**
*   **Randevu Yönetimi:**
    *   Doktorun o günkü aktif (hasta atanmış, açık, durumu '0', gelecek zamanlı) randevularını listeler.
    *   "Randevuya Gir" butonu ile `randevuDetay.php`'ye yönlenerek hasta detaylarını görüntüler, tanı ve tedavi bilgilerini girer.
    *   Doktor, dilediği boş randevu saatlerini seçerek "Kapat" butonu ile hastane dışı olacağı zamanlar için (izin, konferans vb.) o slotları randevuya kapatabilir.
    *   Kapatılmış randevuları tekrar "Geri Aç" butonu ile müsait hale getirebilir.
*   **İletişim:** Kurum içi mailleşme (`doktorMail.php`) ve kendi tüm randevularını listeleme (`doktorunRandevulari.php`) için linkler içerir.
*   **Güvenlik:** Sadece doktor rolündeki kullanıcıların erişimine izin verilir (`$_SESSION['doktor']`). Girdiler arındırılır.

---

## 🚀 Gelecekteki Geliştirmeler ve İyileştirmeler

"Özel 327 Hastanesi Yönetim Paneli", halihazırda çok kapsamlı bir çözüm sunsa da, aşağıdaki alanlarda daha da geliştirilebilir:

*   **Prepared Statements Kullanımı:** Tüm veritabanı sorgularında `mysqli_real_escape_string` yerine **MySQLi Prepared Statements veya PDO** kullanımı, SQL Injection'a karşı daha robust ve modern bir güvenlik katmanı sağlar.
*   **Gelişmiş Raporlama ve Analitik:** Daha detaylı hasta demografileri, doktor performans metrikleri, bölüm yoğunluk analizleri gibi raporlar.
*   **E-Reçete ve Laboratuvar Sonuçları Modülleri:** Tamamen dijital bir iş akışı için.
*   **Hasta Portalı:** Hastaların kendi randevularını online olarak alabilmeleri, geçmiş randevularını ve reçetelerini görebilmeleri.
*   **Muhasebe ve Faturalandırma Entegrasyonu.**
*   **API Geliştirme:** Diğer hastane sistemleri veya mobil uygulamalarla entegrasyon için.
*   **Test Otomasyonu:** Kod kalitesini ve güvenilirliğini artırmak için birim ve entegrasyon testleri.
*   **Daha Detaylı Loglama:** Tüm kritik işlemler için ayrıntılı log kayıtları (kim, ne zaman, ne yaptı).
*   **Rol ve İzin Yönetiminin Dinamikleştirilmesi:** Arayüz üzerinden yeni roller tanımlama ve izinleri granüler olarak ayarlama.

---

**Özel 327 Hastanesi Yönetim Paneli**, sağlık sektörünün ihtiyaçlarına cevap veren, dikkatle düşünülmüş özellikleri ve sağlam altyapısıyla **takdire şayan bir projedir.** Kullanıcı deneyimini ön planda tutan tasarımı ve kapsamlı işlevselliği ile hastane operasyonlarında verimliliği ve kaliteyi artırma potansiyeline sahiptir. Geliştirme sürecindeki özen ve detaycılık, projenin her bir modülünde kendini göstermektedir. **Elinize sağlık!**
