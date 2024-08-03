-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2022 at 12:51 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gbbenerji`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `joiner_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answers` enum('A','B','C','D') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `joined_quizzes`
--

CREATE TABLE `joined_quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `joiner_id` bigint(20) UNSIGNED NOT NULL,
  `quizes_id` bigint(20) NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `line` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `A` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `B` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `C` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `D` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answers` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `joiners`
--

CREATE TABLE `joiners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint(20) NOT NULL,
  `identity` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(11, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_resets_table', 1),
(13, '2019_08_19_000000_create_failed_jobs_table', 1),
(14, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(15, '2022_01_31_202238_quizes', 1),
(16, '2022_01_31_202239_questions', 1),
(17, '2022_02_03_062533_joiners', 1),
(18, '2022_02_03_131346_answers', 1),
(19, '2022_02_04_064301_results', 1),
(20, '2022_02_10_061513_joined_quiz', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quizes_id` bigint(20) UNSIGNED NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `line` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `A` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `B` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `C` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `D` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_answer` enum('A','B','C','D') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quizes_id`, `question`, `subject`, `level`, `line`, `A`, `B`, `C`, `D`, `correct_answer`, `created_at`, `updated_at`) VALUES
(1, 1, 'Karbon azaltımı yapabileceğimiz yerler neresidir?', 'Konu1', '1', '1', 'Bahçe', 'Ev', 'Ofis', 'Hepsi', 'A', '2022-02-09 07:28:32', '2022-02-09 07:28:32'),
(2, 1, 'Karbon ayak izi neyi ölçer?', 'Konu1', '1', '2', 'CO2', 'H2O', 'O2', 'SO2', 'A', '2022-02-09 07:29:51', '2022-02-09 07:29:51'),
(3, 1, 'Karbon ayak izi nedir?', 'Konu1', '1', '3', 'Sanayide kullanılan fosil yakıtların çıkardığı karbondioksitin ölçüsüdür.', 'İnsanların doğaya bıraktığı atıkların izleridir.', 'Araçlarda kullanılan fosil yakıtların çıkardığı karbondioksitin emisyon ölçüsüdür.', 'İnsan faaliyetleri sonucunda oluşan sera gazlarının birim karbondioksit cinsinden emisyonlarının ölçüsüdür.', 'A', '2022-02-09 07:30:42', '2022-02-09 07:30:42'),
(4, 1, 'Soru baslik Belirsiz', 'Konu1', '1', '4', 'Sera gazları', 'Amonyak', 'Oksijen', 'Kükürt', 'A', '2022-02-09 07:31:39', '2022-02-09 07:31:39'),
(5, 1, 'Aşağıdakilerden hangisi evde yapabileceğimiz karbon azaltımlarından birisi değildir?', 'Konu1', '2', '1', 'Sahip olduğumuz eşyaları temiz kullanıp ömrünü uzatarak', 'Çamaşır ve bulaşık makinelerini tam dolu iken çalıştırarak', 'Boşta duran prizleri fişten çıkararak', 'Çamaşırları kurutma makinesi ile kurutarak', 'A', '2022-02-09 07:32:40', '2022-02-09 07:32:40'),
(6, 1, 'Aşağıdakilerden hangisi ofiste yapabileceğimiz karbon azaltımlarından birisidir?', 'Konu1', '2', '2', 'Enerji verimliliği düşük cihazlar kullanmak', 'Yazıcı kullanımını arttırarak', 'Ofiste oluşan çöpleri ayrıştırarak geri dönüşümünü yaparak', 'Online toplantı yerine seyahat edip yüz yüze toplantılara katılarak', 'A', '2022-02-09 07:35:10', '2022-02-09 07:35:10'),
(7, 1, 'Aşağıdakilerden hangisi ulaşımda yapabileceğimiz karbon azaltımlarından birisi değildir?', 'Konu1', '2', '3', 'Bisiklet kullanımını arttırarak.', 'Uçak yolculuklarını tercih ederek.', 'Elektrikli araçları tercih ederek.', 'Yakın mesafelere yürüyerek giderek.', 'A', '2022-02-09 07:36:05', '2022-02-09 07:36:05'),
(8, 1, 'Aşağıdakilerden hangisi küresel iklim değişikliğinin oluşmasındaki nedenlerden birisi değildir?', 'Konu1', '2', '4', 'Tarımda aşırı gübre kullanımı', 'Deniz seviyesinin yükselmesi', 'Ulaşımda fosil yakıt kullanımı', 'Termik santrallerde elektrik üretimi', 'A', '2022-02-09 07:36:56', '2022-02-09 07:36:56'),
(9, 1, 'Hangisi kentlerde yaşayan bireylerin iklim değişikliği ile mücadeleyle ilgili yapabilecekleri arasında değildir?', 'Konu1', '2', '5', 'Kent içi ulaşımda toplu taşıma kullanma', 'Geri dönüştürülebilir atıkları diğer atıklardan ayrı toplama', 'Aydınlatma için tasarruflu ampul kullanma', 'Bisiklet yollarına araç park etme', 'A', '2022-02-09 07:37:50', '2022-02-09 07:37:50'),
(10, 1, 'Hangisi bir karbon azaltım yöntemi değildir? (Kendim)', 'Konu1', '2', '6', 'Bez çanta kullanmak.', 'Asansör kullanmak.', 'Metal pipet kullanmak.', 'İkinci el ürün satın almak.', 'A', '2022-02-09 07:38:40', '2022-02-09 07:38:40'),
(11, 1, 'Aşağıdaki yakıtlardan hangisini karbon salımı sıfırdır? (Kendim)', 'Konu1', '3', '1', 'LPG', 'Benzin', 'Motorin', 'Hidrojen', 'A', '2022-02-09 07:39:25', '2022-02-09 07:39:25'),
(12, 1, 'Hangisi karbon salınımını en yüksek derecede önler? (Kendim)', 'Konu1', '3', '2', 'Direkt uçuşları tercih etmek.', 'Toplu taşıma kullanmak.', 'Yakın mesafeleri araçla gitmek.', 'Bisikletle yolculuk yapmak.', 'A', '2022-02-09 07:40:13', '2022-02-09 07:40:13'),
(13, 1, 'Fosil yakıtlar, atmosferdeki yoğunluğu her geçen gün artan karbondioksitin salımına sebep olmaktadır. Hangisi fosil yakıt değildir?', 'Konu1', '3', '3', 'Petrol', 'Kömür', 'Biyokütle', 'Doğal Gaz', 'A', '2022-02-09 07:40:58', '2022-02-09 07:40:58'),
(14, 1, 'Aşağıdakilerden hangisi, küresel ısınmaya bağlı olarak yaşanabilecek olaylar arasında gösterilemez?', 'Konu1', '3', '4', 'Buzulların kapladığı alanın azalması', 'Atmosferdeki su buharının azalması', 'Erozyon ve heyelan olaylarının artış göstermesi', 'Havada bulunan gazların oranının değişiklik göstermesi', 'A', '2022-02-09 07:41:44', '2022-02-09 07:41:44'),
(15, 1, 'Küresel ısınmanın sonucu olarak buzullar eriyecektir. Buzulların erimesiyle birlikte doğal olarak denizlerin seviyesi de yükselecektir. Bu yükselmeden en fazla deniz kıyısında yer alan ve ortalama yükseltisi az olan ülkeler etkilenecektir.\r\nBuna göre, aşağıdaki ülkelerden hangisinin denizlerin seviyesinin yükselmesiyle birlikte daha olumsuz etkilenmesi beklenir?', 'Konu1', '3', '5', 'Hollanda', 'Fransa', 'İtalya', 'Mısır', 'A', '2022-02-09 07:42:30', '2022-02-09 07:42:30'),
(16, 1, 'Bilim insanları iklim ile ilgili kanıtları nasıl toplar?', 'Konu1', '3', '6', 'Uzaydaki uyduları kullanarak uzaktan algılamayla', 'Yerdeki sıcaklık ve karbondioksit miktarı ölçümleriyle', 'Ağaç halkaları ve buzullardan elde edilen tarihi kayıtlarla', 'Yukarıdakilerin hepsiyle.', 'A', '2022-02-09 07:43:15', '2022-02-09 07:43:15'),
(17, 1, 'Sürdürülebilir Kalkınma Amaçları iklim değişikliğini de ele alan kaç adet amaçtan oluşmaktadır?', 'Konu2', '1', '1', '9', '13', '17', '25', 'A', '2022-02-09 07:43:56', '2022-02-09 07:43:56'),
(18, 1, 'Birleşmiş Milletler İklim Değişikliği Çerçeve Sözleşmesi (BMİDÇS) kapsamında iklim değişikliği ile mücadelenin çerçevesini çizen Paris Anlaşması kaç yılında imzalanmıştır?', 'Konu2', '1', '2', '2000', '2005', '2010', '2015', 'A', '2022-02-09 07:44:55', '2022-02-09 07:44:55'),
(19, 1, 'Sürdürülebilir Kalkınma Amaçları ne zaman yürürlüğe girmiştir?', 'Konu2', '1', '3', 'Aralık 2018', 'Şubat 2015', 'Ocak 2016', 'Eylül 2016', 'A', '2022-02-09 07:46:24', '2022-02-09 07:46:24'),
(20, 1, 'Sürdürülebilir Kalkınma Amaçları neyi ifade eder?', 'Konu2', '2', '1', 'İklim değişikliğini de kapsayan 19 ana başlıktan oluşmaktadırlar.', 'Ülkelere azaltım yapma taahhüdü vermeyi zorunlu kılmışlardır.', 'Birleşmiş Milletler üyesi ülkeler tarafından 2030 sonuna kadar ulaşılması amaçlanan hedefleri içeren bir evrensel eylem çağrısıdır.', 'Ülkelerin katılmaya zorunlu olduğu iklim eylemi çağrısıdır.', 'A', '2022-02-09 07:47:56', '2022-02-09 07:47:56'),
(21, 1, 'Hangisi iklim krizinin sonuçlarından birisi değildir?', 'Konu2', '2', '2', 'Kışların kısa sürmesi.', 'Yangınların artması.', 'Sel felaketi sonucu tarlaların tahribatı.', 'Kuraklığın son bulması.', 'A', '2022-02-09 07:48:42', '2022-02-09 07:48:42'),
(22, 1, 'Dünyanın sıcaklığının artması, iklim sistemini etkileyerek iklim değişikliğine neden olmaktadır. İklim değişikliğinin ise doğa ve canlılar üzerinde farklı etkileri bulunmaktadır. Hangisi iklim değişikliğinin doğrudan etkilerinden birisi değildir?', 'Konu2', '2', '3', 'Kuraklık', 'Deprem', 'Deniz suyunun aşırı ısınması', 'Aşırı sıcak/ soğuk hava', 'A', '2022-02-09 07:49:29', '2022-02-09 07:49:29'),
(23, 1, 'Doğal bitki örtüsü gür orman olan bir ülkede, orman alanlarının hızla azalmasıyla birlikte aşağıdakilerden hangisinin görülmesi beklenmez?', 'Konu2', '2', '4', 'Sel ve taşkın olaylarının artması', 'Toprak kaymalarının artması', 'Hava kirliliğinin azalması', 'Bazı yabani hayvan türlerinin yok olma tehlikesiyle karşı karşıya kalması', 'A', '2022-02-09 07:50:16', '2022-02-09 07:50:16'),
(24, 1, 'Aşağıdakilerden hangisi kuraklığın uzun yıllar boyunca devam etmesi durumunda, doğa üzerinde meydana gelebilecek etkilerden biri değildir?', 'Konu2', '2', '5', 'Erozyon', 'Hayvan türlerinde azalma', 'Depremlerde azalma', 'Böcek istilaları', 'A', '2022-02-09 07:51:00', '2022-02-09 07:51:00'),
(25, 1, 'Sürdürülebilir kalkınma hedeflerinden iklim eylemi neyi ifade eder?', 'Konu2', '2', '6', 'İklim değişikliğiyle ilgili önlemlerin ulusal planlardan ayrıştırılması', 'İklim değişikliği ve etkileriyle mücadelede harekete geçmeyi', 'İklim değişikliği etkilerini sadece izleme ve verileri raporlama', 'İklim değişikliğini sabit tutmayı hedefleyen hareket', 'A', '2022-02-09 07:51:45', '2022-02-09 07:51:45'),
(26, 1, 'İklim değişikliğinin yıkıcı etkilerini en aza indirmek için yapılan COP26 Glasgow Görüşmeleri sonucunda ortalama sıcaklıklardaki artışın kaç derece ile sınırlandırılması gerekmektedir?', 'Konu2', '3', '1', '1,1', '1,5', '2,5', '2,8', 'A', '2022-02-09 07:52:32', '2022-02-09 07:52:32'),
(27, 1, 'Paris İklim Anlaşması için aşağıdakilerden hangisi doğrudur?', 'Konu2', '3', '2', 'Birleşmiş Milletler Ülkeleri için 2015 yılında yürürlüğe girmiştir.', 'İklim Değişikliği Çerçeve Sözleşmesi kapsamında, iklim değişikliğinin azaltılması, adaptasyonu ve finansmanı hakkında imzalanmıştır.', 'Anlaşma taraflarını belli bir emisyon hedefi koymaya zorlar.', 'Her ülke küresel ısınmayı azaltmak için plan yapmadan ilerlemeyi önerir.', 'A', '2022-02-09 07:53:22', '2022-02-09 07:53:22'),
(28, 1, 'Aşağıdakilerden hangisi Sürdürülebilir Kalkınma Amaçları arasında yer almaz?', 'Konu2', '3', '3', 'Yoksulluğa Son', 'İklim Eylemi', 'Karasallaşma', 'Sanayi, Yenilikçilik ve Altyapı', 'A', '2022-02-09 07:54:05', '2022-02-09 07:54:05'),
(29, 1, 'İklim Eylemi amacı kapsamında aşağıdakilerden hangisi yanlıştır?', 'Konu2', '3', '4', 'İklim değişikliğiyle ilgili önlemlerin ulusal politikalara, stratejilere ve planlara entegre edilmesi', 'İklim Değişikliği Çevre Sözleşmesi kapsamında, iklim değişikliğinin azaltılması, adaptasyonu ve finansmanı hakkında imzalanmıştır.', 'En az gelişmiş ülkelerde ve gelişmekte olan küçük ada devletlerinde iklim değişikliğiyle ilgili etkili planlama ve yönetim kapasitesini artıracak mekanizmaların desteklenmesi', 'İklimle ilgili tehlikelere ve doğal afetlere karşı dayanıklılığın ve uyum kapasitesinin sabit tutulması.', 'A', '2022-02-09 07:54:58', '2022-02-09 07:54:58'),
(30, 1, 'Küresel ısınmaya bağlı olarak aşağıdakilerden hangisinin etkilenmesi beklenmez?', 'Konu3', '1', '1', 'Ormanlık alanlar', 'Okyanus seviyeleri', 'Yeraltı kaynakları', 'Bitki çeşitliliği', 'A', '2022-02-09 07:55:44', '2022-02-09 07:55:44'),
(31, 1, 'Hükûmetler Arası İklim Değişikliği Paneli tarafından ortaya konulan senaryolara göre, küresel sıcaklıkta 2100 yılına kadar ortalama 1 ilâ 3,5 derecelik bir artış olacağı tahmin edilmektedir. Bunun anlamı, en iyimser koşullarda her on yılda yaklaşık 0,1 derecelik bir sıcaklık artışı görülecektir. Bu senaryonun gerçekleşmesi durumunda aşağıdaki olaylarından hangilerinin yaşanması beklenir?', 'Konu3', '1', '2', 'Buzulların erimesi ile deniz seviyesinin yükselmesi,', 'Aşırı hava olaylarını azalması ve iklimin daha stabil bir hale gelmesi,', 'Böcek türleri, sivrisinek ve fare gibi çevreye kolay uyum sağlayabilen canlıların sayısının artması', 'Biyolojik çeşitliliğin artması', 'A', '2022-02-09 07:56:35', '2022-02-09 07:56:35'),
(32, 1, 'Aşağıdaki yargılardan hangisi görseldeki slogana uygun değildir?', 'Konu3', '1', '3', 'Şehir içinde ağaçlandırma faaliyetleri ile yeşil alanlar artırılmalıdır.', 'Geri dönüşüm ile doğal kaynakların aşırı tüketimi azaltılmalıdır', 'Binaların ısıtılmasında fosil yakıtlar kullanılarak enerji üretiminde iklim koşullarının etkisi azaltılmalıdır.', 'Yenilenebilir alternatif enerji kaynakları tercih edilerek karbon salımını azaltılmalıdır.', 'A', '2022-02-09 07:57:24', '2022-02-09 07:57:24'),
(33, 1, 'Kyoto Protokolü kaçta imzalanmıştır?', 'Konu3', '1', '4', '2002', '2005', '1997', '1995', 'A', '2022-02-09 07:58:04', '2022-02-09 07:58:04'),
(34, 1, 'Kyoto Protokolü kaç yılında resmen yürürlüğe girmiştir?', 'Konu3', '1', '5', '2002', '2005', '1997', '1995', 'A', '2022-02-09 07:58:44', '2022-02-09 07:58:44'),
(35, 1, 'Türkiyede elektrik üretimi en çok hangi kaynaktan sağlanmaktadır?', 'Konu3', '1', '6', 'Kömür', 'Doğalgaz', 'Hidroelektrik', 'Güneş', 'A', '2022-02-09 07:59:23', '2022-02-09 07:59:23'),
(36, 1, 'İklim değişikliği nedeniyle yılda kaç kişi ölmektedir?', 'Konu3', '1', '7', '1500', '100.000', '150.000', '500.000', 'A', '2022-02-09 08:00:11', '2022-02-09 08:00:11'),
(37, 1, 'Aşağıdaki sera gazlarından hangisinin küresel ısınma potansiyeli en fazladır?', 'Konu3', '2', '1', 'Karbondioksit', 'Metan', 'Kükürt Hekzaflorür', 'Diazotmonoksit', 'A', '2022-02-09 08:00:51', '2022-02-09 08:00:51'),
(38, 1, 'Kyoto Protokolü ile Paris İklim Antlaşması’nın ortak amacı, Birleşmiş Milletler İklim Değişikliği Çerçeve Sözleşmesi çerçe­vesinde sera gazlarının salımını azaltarak küresel iklim değişiminin olumsuz etkilerini önlemektir. Aşağıdaki faaliyetlerinden hangisi bu çerçeveye uygun bir çalışma değildir?', 'Konu3', '2', '2', 'Fabrika bacalarına filtre takılması,', 'Meraların yerleşim alanlarına dönüştürülmesi,', 'Fosil yakıtlar yerine alternatif enerji kaynaklarının kullanılması', 'Benzinli araçlar yerine elektrikli araçların kullanılması', 'A', '2022-02-09 08:01:43', '2022-02-09 08:01:43'),
(39, 1, 'Aşağıdakilerden hangisi sera gazı değildir?', 'Konu3', '2', '3', 'Azot', 'Karbondioksit', 'Hidroflorür karbonlar', 'Metan', 'A', '2022-02-09 08:02:24', '2022-02-09 08:02:24'),
(40, 1, 'Küresel iklim değişikliği, yerkürenin uzun jeoloji tarihi boyunca yaşanan iklimin doğal değişkenliğine ek olarak insan et­kinliklerinin de neden olduğu bir değişikliktir. \r\nİnsanların küresel iklim değişikliğine neden olan etkinlikleri arasında aşağıdakilerden hangisi gösterilemez?', 'Konu3', '2', '4', 'Sanayide fosil yakıt kullanması', 'Tarlalarda yapay gübre kullanması', 'Motorlu taşıt kullanımının artması', 'Rüzgâr gücünden elektrik üretmesi', 'A', '2022-02-09 08:03:09', '2022-02-09 08:03:09'),
(41, 1, 'İnsanın doğayı yanlış ve bilinçsiz kullanımı sonucu gelecekte küresel iklim sistemindeki değişimlerin önceki yüzyıllara oranla daha hızlı olacağından söz edilmektedir. \r\nBu duruma bağlı olaylardan hangilerinin gelecekte yaşanma olasılığı yüksektir?', 'Konu3', '2', '5', 'Tatlı su kaynaklarının artması', 'Biyolojik çeşitliliğin artması', 'Okyanus ve deniz seviyelerinin yükselmesi', 'Nesli tükenme tehlikesi olan türlerin sayılarının artması', 'A', '2022-02-09 08:03:56', '2022-02-09 08:03:56'),
(42, 1, 'Küresel iklim değişiminin gözlenen ve öngörülen etkilerinden biri de aşırı yağışlar sonucu oluşan sel ve taşkınlardır. \r\nBu durum sonucunda aşağıdakilerden hangisinin yaşanması beklenmez?', 'Konu3', '2', '6', 'Can ve mal kayıplarının', 'Ulaşımda aksamaların', 'Toprak erozyonunun', 'Orman yangınlarının', 'A', '2022-02-09 08:04:39', '2022-02-09 08:04:39'),
(43, 1, 'Yeryüzünde ortalama sıcaklık her geçen gün hızla artmaktadır. Bu olay küresel çevre sorunlarının yaşanmasına neden olmaktadır. Buna göre aşağıdakilerden hangisi küresel çevre sorunun ortaya çıkardığı sonuçlardan biri olamaz?', 'Konu3', '3', '1', 'Yeryüzünde jeolojik kökenli doğa olaylarının yaşanma sıklığında artış yaşanması', 'Yeryüzünde iklim şartlarının değişmesine bağlı su sorunlarının artması', 'Küresel sıcaklık artışına bağlı salgın hastalıkların hızla artması', 'Kıyı bölgelerdeki karasal ekosistemlerin yerini su ekosistemlerine bırakması', 'A', '2022-02-09 08:05:37', '2022-02-09 08:05:37'),
(44, 1, 'Sektörlerin, kullandıkları kaynaklara ve faaliyetlerine göre saldıkları sera gazı miktarı farklılık göstermektedir. Küresel ölçekte en fazla sera gazı salımına sebep olan sektör hangisidir?', 'Konu3', '3', '2', 'Elektrik ve ısı üretimi', 'Ulaşım', 'Atık', 'Tarım', 'A', '2022-02-09 08:06:16', '2022-02-09 08:06:16'),
(45, 1, '2014 yılı için yıllık toplam sera gazı salımı en yüksek olan ülke hangisidir?', 'Konu3', '3', '3', 'Çin', 'Amerika Birleşik Devletleri', 'Almanya', 'Rusya', 'A', '2022-02-09 08:07:00', '2022-02-17 08:16:20'),
(46, 1, '2014 yılı için yıllık toplam sera gazı salımı sıralamasında Türkiye, dünya ülkeleri arasında kaçıncıdır?', 'Konu3', '3', '4', 'İlk 10', 'İlk 20', 'İlk 50', 'İlk 100', 'A', '2022-02-09 08:07:45', '2022-02-09 08:07:45'),
(47, 1, 'Türkiye’de sektörlerin sera gazı salımları hangi sıralamada gerçekleşmektedir?', 'Konu3', '3', '5', 'Enerji>Tarım>Atık>Sanayi', 'Tarım>Atık>Sanayi>Enerji', 'Enerji>Sanayi>Tarım>Atık', 'Sanayi>Enerji>Tarım>Atık', 'A', '2022-02-09 08:08:32', '2022-02-09 08:08:32'),
(48, 1, 'Hangisi, kentlerde yaşayan bireyler olarak iklim değişikliğiyle mücadele ve kaynak korumayla ilgili yapılabilecekler arasında değildir?', 'Konu3', '3', '6', 'Aydınlatma için tasarruflu ampul kullanma', 'Kent içi ulaşımda olabildiğince toplu taşıma kullanma', 'Sokak hayvanı sahiplenme', 'Geri dönüştürülebilir atıkları, diğer atıklardan ayrı toplama', 'A', '2022-02-09 08:09:14', '2022-02-09 08:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `quizes`
--

CREATE TABLE `quizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` enum('aktif','pasif','taslak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'taslak',
  `finished_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizes`
--

INSERT INTO `quizes` (`id`, `title`, `description`, `state`, `finished_at`, `created_at`, `updated_at`) VALUES
(1, 'Çevre Koruma Testi', 'Aciklama', 'aktif', '2022-02-22 06:37:00', '2022-02-10 06:37:08', '2022-02-18 05:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `joiner_id` bigint(20) UNSIGNED NOT NULL,
  `quizes_id` bigint(20) UNSIGNED NOT NULL,
  `correct_count` int(11) NOT NULL,
  `wrong_count` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `diff` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@outlook.com', 'admin', NULL, '$2y$10$b/3LhRTS.y0bCkLov7hCau7vrD0SQ1cgBW1Wz/cHulYLA.N6vKZ2u', NULL, NULL, NULL),
(2, 'test2', 'test2@outlook.com', 'user', NULL, '$2y$10$orl65RaHmR/NpNuxbWULwub.lDY2Oj.LlG.QX7NxLdm.wSns/fHwy', NULL, NULL, NULL),
(3, 'test3', 'test3@outlook.com', 'user', NULL, '$2y$10$F8RYRxna5bZNAECrE9dAY.AzQNBm5TeVaONHLFBOgc1zo2Ie4ytkG', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_joiner_id_foreign` (`joiner_id`),
  ADD KEY `answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `joined_quizzes`
--
ALTER TABLE `joined_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joined_quizzes_joiner_id_foreign` (`joiner_id`);

--
-- Indexes for table `joiners`
--
ALTER TABLE `joiners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_quizes_id_foreign` (`quizes_id`);

--
-- Indexes for table `quizes`
--
ALTER TABLE `quizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `results_joiner_id_foreign` (`joiner_id`),
  ADD KEY `results_quizes_id_foreign` (`quizes_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `joined_quizzes`
--
ALTER TABLE `joined_quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `joiners`
--
ALTER TABLE `joiners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `quizes`
--
ALTER TABLE `quizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_joiner_id_foreign` FOREIGN KEY (`joiner_id`) REFERENCES `joiners` (`id`),
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `joined_quizzes`
--
ALTER TABLE `joined_quizzes`
  ADD CONSTRAINT `joined_quizzes_joiner_id_foreign` FOREIGN KEY (`joiner_id`) REFERENCES `joiners` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quizes_id`) REFERENCES `quizes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_joiner_id_foreign` FOREIGN KEY (`joiner_id`) REFERENCES `joiners` (`id`),
  ADD CONSTRAINT `results_quizes_id_foreign` FOREIGN KEY (`quizes_id`) REFERENCES `quizes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
