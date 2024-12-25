<?php
$eventName = urlencode("Doktor Randevusu");
$startDate = "2024-10-30T09:00:00"; // Başlangıç tarihi ve saati
$endDate = "2024-10-30T10:00:00";   // Bitiş tarihi ve saati
$details = urlencode("Randevu detayları: Hastane ABC, Odası: 101");
$location = urlencode("Hastane ABC");

$outlookCalendarUrl = "https://outlook.live.com/calendar/0/deeplink/compose?path=/calendar/action/compose&subject=$eventName&startdt=$startDate&enddt=$endDate&body=$details&location=$location";
?>

<!-- E-posta veya web sayfasında kullanılacak bağlantı -->
<a href="<?= $outlookCalendarUrl ?>" target="_blank">Outlook Takvimine Ekle</a>
