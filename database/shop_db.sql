-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2023 at 04:31 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `Date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `full_name`, `username`, `password`, `phone`, `address`, `Date`) VALUES
(14, 'ابوالفضل', 'abolfazl', '$2y$10$WQc5GEs/FOjiQZ2MkYOTcu67XgvhXFZ45Vu5kpFUWFnAX9CMFQHXK', '09044775292', 'مشهد مدرسه کوشش', '2023-04-15 14:12:21'),
(15, 'Amir', 'amir', '$2y$10$AcuN06c1tsdbCAe.Dbh2/u/rfKHxazzdYXVBO9zSh/euUsrDAkGyC', '0915405206', 'ندارم', '2023-04-15 14:13:50'),
(16, 'علیرضا ', '30pac', '$2y$10$zvgVrN8G8kiZlXIPnRFrT.N7fo1hdzcULPIb9kCID3Xqy.icj/eAy', '09058887530', 'مشهد پیروزی', '2023-04-15 14:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_products` smallint(6) NOT NULL,
  `total_price` varchar(25) NOT NULL,
  `date_time` varchar(25) NOT NULL,
  `payment_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `total_products`, `total_price`, `date_time`, `payment_status`) VALUES
(23, 12, 2, '220000', '2020-08-06 13:59:40', 1),
(24, 14, 2, '30850000', '2023-04-08 12:55:47', 1),
(25, 14, 1, '1704000', '2023-04-15 16:55:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `details_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` varchar(25) NOT NULL,
  `order_quantity` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`details_id`, `order_id`, `customer_id`, `product_id`, `product_price`, `order_quantity`) VALUES
(44, 23, 12, 60, '100000', 1),
(45, 23, 12, 59, '120000', 1),
(46, 24, 14, 61, '15000000', 2),
(47, 24, 14, 62, '850000', 1),
(48, 25, 14, 65, '852000', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reg_date` varchar(20) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `caption`, `description`, `price`, `quantity`, `reg_date`, `image_url`) VALUES
(63, 'لپ تاپ 15.6 اینچ ام اس آی مدل Raider GE67 HX 12UHS', '<p>&nbsp;</p>\r\n\r\n<h1><kbd><strong>ویژگی&zwnj;ها</strong></kbd></h1>\r\n\r\n<ul>\r\n	<li>\r\n	<p>سری پردازنده&nbsp;:</p>\r\n\r\n	<p>Core i9</p>\r\n	</li>\r\n	<li>\r\n	<p>ظرفیت حافظه RAM&nbsp;:</p>\r\n\r\n	<p>32 گیگابایت</p>\r\n	</li>\r\n	<li>\r\n	<p>ظرفیت حافظه داخلی&nbsp;:</p>\r\n\r\n	<p>دو ترابایت</p>\r\n	</li>\r\n	<li>\r\n	<p>سازنده پردازنده گرافیکی&nbsp;:</p>\r\n\r\n	<p>NVIDIA</p>\r\n	</li>\r\n	<li>\r\n	<p>دقت صفحه نمایش&nbsp;:</p>\r\n\r\n	<p>QHD|2560x1440</p>\r\n	</li>\r\n	<li>\r\n	<p>طبقه&zwnj;بندی&nbsp;:</p>\r\n\r\n	<p>مخصوص بازی، کاربری مالتی&zwnj;مدیا، کاربری عمومی</p>\r\n\r\n	<hr />\r\n	<h1>معرفی&nbsp;</h1>\r\n	</li>\r\n	<li>\r\n	<p>شرکت ام اس آی (MSI) از دیرباز به عنوان یکی از مطرح&zwnj;ترین شرکت&zwnj;های فعال در زمینه&zwnj;ی تولید قطعات کامپیوتر شناخته می&zwnj;شود و محصولات این شرکت بیشتر به دلیل کیفیت ساخت بالا و قدرت سخت&zwnj;افزاری مثال&zwnj;زدنی مورد استقبال خریداران قرار می&zwnj;گیرد. این شرکت در زمینه&zwnj;ی تولید لپ تاپ&zwnj;ها هم فعالیت چشمگیری دارد و در بین محصولات ام اس آی می&zwnj;توان لپ تاپ&zwnj;های با کیفیت و بالارده&zwnj;ی مختلفی یافت. لپ تاپ ام اس آی مدل Raider GE67 HX 12UHS از جمله لپ تاپ&zwnj;های فوق&zwnj;العاده قدرتمند این شرکت است که از پردازنده&zwnj;ی مرکزی نسل Alder Lake شرکت اینتل یعنی i9-12900HX بهره می&zwnj;برد. همچنین، مشخصه&zwnj;های فنی قابل توجه دیگری از جمله 32 گیگابایت رم DDR5 با سرعت 4800 مگاهرتز در این لپ تاپ به چشم می&zwnj;خورد. ناگفته نماند که شرکت ام اس آی برای حافظه&zwnj;ی ذخیره&zwnj;سازی این پردازنده از 2 ترابایت حافظه&zwnj;ی SSD نسل چهارم از نوع NVMe PCIe استفاده کرده است و این موضوع باعث خواهد شد تا شاهد سرعت بسیار بالایی در انجام فعالیت&zwnj;های مختلف از طریق این لپ تاپ باشیم.</p>\r\n	</li>\r\n</ul>\r\n', '199945000', 20, '2023-04-08 16:56:46', 'http://127.0.0.1/shop/products/22.jpg'),
(64, 'ست گیمینگ اونیکوما مدل Professional 5 in 1', '<h1><strong>مشخصات</strong></h1>\r\n\r\n<p>وزن :</p>\r\n\r\n<p>۳۵۰ گرم</p>\r\n\r\n<p>نوع اتصال :</p>\r\n\r\n<p>با سیم</p>\r\n\r\n<p>منبع تغذیه :</p>\r\n\r\n<p>پورت USB&nbsp;</p>\r\n\r\n<p>نوع رابط :</p>\r\n\r\n<p>USB</p>\r\n\r\n<p>تعداد کلیدهای میانبر :</p>\r\n\r\n<p>۴ عدد</p>\r\n\r\n<p>تعداد کلیدهای ماوس :</p>\r\n\r\n<p>۷ عدد</p>\r\n\r\n<p>نوع حسگر ماوس :</p>\r\n\r\n<p>لیزری</p>\r\n\r\n<p>توضیحات چراغ&zwnj; پس زمینه صفحه کلید :</p>\r\n\r\n<p>RGB</p>\r\n', '2099000', 2, '2023-04-08 16:55:13', 'http://127.0.0.1/shop/products/111.webp'),
(65, 'موس مخصوص بازی هویت مدل HV-MS735', '<p>موس گیمینگ قابل برنامه ریزی هویت HAVIT HV-MS735 دارای 19 کلید و با عمر حدود 1000000 کلیک می باشد و از طریق کابل 180 سانتی متری به پورت USB متصل می گردد. تمام کلیدهای این محصول فوق حرفه ای توسط نرم افزار همراه آن قابل برنامه نویسی می باشد و می توان کلید های مورد نیاز در هر بازی را برای آن ها تعریف کرد. دو کلید DPI که روی موس قرار دارد به منظور تغییر میزان حساسیت موس در برابر حرکت است و می توان بر حسب نیاز این پارامتر را بین 500 تا 12000DPI تنظیم نمود.12 کلید کناری که در سه ردیف قرار دارند جهت استفاده باید برنامه ریزی شوند. اسکرول موس نیز علاوه بر عملکرد قبلی، به طرفین هم جابجا می شود و با حرکت آن به چپ یک کلید و با حرکت به راست کلید دیگر فعال می گردد. کابل این ماوس دارای روکش بافته شده بوده و در برابر گره خوردن و اسیب فیزیکی نیز مقاوم است.</p>\r\n\r\n<hr />\r\n<h2><strong>مشخصات</strong></h2>\r\n\r\n<p>ابعاد :</p>\r\n\r\n<p>۱۲۸x۷۴x۳۴ میلی&zwnj;متر</p>\r\n\r\n<p>وزن :</p>\r\n\r\n<p>۱۳۰ گرم</p>\r\n\r\n<p>تعداد کلید :</p>\r\n\r\n<p>۱۹ عدد</p>\r\n\r\n<p>نوع اتصال :</p>\r\n\r\n<p>با سیم</p>\r\n\r\n<p>نوع رابط :</p>\r\n\r\n<p>USB</p>\r\n', '852000', 2, '2023-04-08 17:02:15', 'http://127.0.0.1/shop/products/1122.webp'),
(66, 'مانیتور هوآوی مدل MateView GT سایز 34 اینچ به همراه ساندبار ', '<p>در بین نمایشگر&zwnj;های شرکت هوآوی که بدون هیچ تعریف اضافی باید گفت عملکرد بسیار خوبی را به&zwnj;نمایش گذاشته&zwnj;اند، شاهد رونمایی برخی از نمایشگر&zwnj;&zwnj;های گیمینگ بودیم که توانایی ارائه علمکرد بسیار خوبی را داشتند. یکی از این نمایشگر&zwnj;های با&zwnj;کیفیت، MateView GT است. این مانیتور با ابعاد 34 اینچی و طرح خمیده خود، در همان ابتدا توجه هر بیننده&zwnj;ای را به خودش جلب می&zwnj;کند. توانایی ارائه رزولوشن 1440&times;3440 پیکسل در کنار نرخ به&zwnj;روزرسانی 165 هرتز سبب شده تا این محصول خود را به&zwnj;عنوان یک نمایشگر قدرتمند معرفی کند. طراحی مانیتور MateView GT همان&zwnj;طور که از نامش پیداست، از برند موفق Mate الهام گرفته شده است. این مانیتور بر خلاف سایر محصولات موجود در بازار از یک زبان طراحی ساده اما مدرن بهره می&zwnj;برد که به خوبی نمایان&zwnj;گر قابلیت&zwnj;های پیشرفته&zwnj; آن است. مانیتور MateView GT هوآوی قادر به نمایش 90 درصد رنگ&zwnj;&shy;های فضای رنگی DCI-P3 است. فضای رنگی مذکور رنگ&zwnj;های بسیار بیشتری نسبت به فضای رنگی مرسوم sRGB داشته و همین موجب شده مانیتورهای سازگار با DCI-P3 رنگ&zwnj;های با طراوت&zwnj;تر و طبیعی&zwnj;تری داشته باشند. مانیتور گیمینگ هوآوی MateView GT از محتواهای HDR 10 نیز پشتیبانی کرده و دارای حداکثر روشنایی 350 نیت و کنتراست 1 به 4000 است و جزئیات تصویر را به طور کامل و شفاف نمایش می&zwnj;دهد. هم&zwnj;چنین وضوح نمایشگر میت&zwnj;ویو GT برابر 3440 در 1440 پیکسل یا همان WQHD بوده و پنل 10 بیتی آن قادر به ارائه تصاویر واضح&zwnj; و روشن&zwnj;تر با رنگ&zwnj;های واقعی&zwnj;تر نسبت به پنل&zwnj;های مرسوم 8 بیتی است. در بخش پایه، مانیتور گیمینگ هوآوی MateView GT یک ساندبار حرفه&zwnj;ای مخفی شده که از یک جفت بلندگوی 5 واتی Full Range بهره می&zwnj;برد. این اسپیکرها صدایی واقع&zwnj;گرایانه را با جزئیات کامل پخش می&zwnj;کنند تا کاربر بدون داشتن بلندگوی مجزا هم بتواند تجربه صوتی دل&zwnj;نشینی داشته باشد. به گفته هوآوی شدت بلندی صدا در این بلندگوها به بیش از 80 دسی&zwnj;بل می&zwnj;رسد که در میان محصولات مشابه خیره&zwnj;کننده به نظر می&zwnj;آید. این ساندبار منحصربه&zwnj;فرد دارای یک نوار نوری لمسی است که کاربر می&zwnj;تواند با لمس کردن و جابه&zwnj;جایی آن، میزان بلندی صدا را تنظیم کند. همچنین این نوار RGB قادر به نمایش رنگ&zwnj;ها و جلوه&zwnj;های نمایشی متعددی است که هیجان گیمینگ یا گوش کردن به موسیقی را دوچندان می&zwnj;کند.</p>\r\n\r\n<hr />\r\n<h1><strong>مشخصات</strong></h1>\r\n\r\n<p>وزن :</p>\r\n\r\n<p>۹۵۵۰ گرم</p>\r\n\r\n<p>پورت USB-C :</p>\r\n\r\n<p>دو عدد</p>\r\n\r\n<p>نوع صفحه&zwnj;نمایش :</p>\r\n\r\n<p>مات</p>\r\n\r\n<p>نوع مانیتور :</p>\r\n\r\n<p>خمیده</p>\r\n\r\n<p>طراحی و ادیت :</p>\r\n\r\n<p>گیمینگ</p>\r\n\r\n<p>نور پس&zwnj;زمینه :</p>\r\n\r\n<p>LED</p>\r\n\r\n<p>نوع پنل :</p>\r\n\r\n<p>VA&nbsp;</p>\r\n\r\n<p>نرخ بروزرسانی تصویر :</p>\r\n\r\n<p>۱۶۵ هرتز</p>\r\n\r\n<p>نسبت تصویر :</p>\r\n\r\n<p>۲۱:۹</p>\r\n\r\n<p>رزولوشن صفحه نمایش :</p>\r\n\r\n<p>۱۴۴۰ &times; ۳۴۴۰ پیکسل</p>\r\n\r\n<p>شدت روشنایی :</p>\r\n\r\n<p>۳۵۰ نیت (شمع در متر مربع)</p>\r\n\r\n<p>تعداد رنگ قابل نمایش :</p>\r\n\r\n<p>۱۰۷۰ میلیون رنگ</p>\r\n\r\n<p>زمان پاسخ&zwnj;گویی :</p>\r\n\r\n<p>۴ میلی&zwnj;ثانیه</p>\r\n\r\n<p>تعداد پورت HDMI :</p>\r\n\r\n<p>یک عدد</p>\r\n\r\n<p>منبع تغذیه :</p>\r\n\r\n<p>آداپتور ۱۳۵ وات</p>\r\n\r\n<p>سایز صفحه نمایش :</p>\r\n\r\n<p>۳۴ اینچ</p>\r\n\r\n<p>درگاه&zwnj;های ارتباطی :</p>\r\n\r\n<p>USB Type-C</p>\r\n\r\n<p>شناسه کالا :</p>\r\n\r\n<p>۲۸۰۰۰۰۱۴۹۲۳۵۸</p>\r\n', '39500000', 7, '2023-04-08 17:30:13', 'http://127.0.0.1/shop/products/444.webp'),
(67, 'مجموعه کنسول بازی سونی مدل PlayStation 5 Drive ظرفیت 825 گیگابایت ', '<h1>پایان انتظار برای نسل جدید همراه با تغییرات گسترده</h1>\r\n\r\n<p>نسل نهم کنسول&zwnj;های بازی هم از راه رسیدند و ورود این کنسول&zwnj;ها دقیقا مقارن بود با سالی که تقریبا تمام مردم جهان با بیماری کرونا دست و پنجه نرم می&zwnj;کردند. تقریبا ۷ سال از عمر نسل هشتم گذشته وشاید بسیاری از ما هنوز هم آمادگی ورود به نسل جدید را نداشته باشیم. اما به هر حال نمی&zwnj;توان جلوی پیشرفت را گرفت و این روز فرارسیده است. سونی در نسل هشتم درس&zwnj;هایی که از نسل هفتم گرفته بود را به خوبی پیاده کرد و توانست به نوعی در نسل هشتم کنسول&zwnj;های بازی فرمانروایی کند و رقیب دیرینه خود را شکست دهد. اما نسل جدید چندان هم ساده به نظر نمی&zwnj;رسد و مایکروسافت با عرضه قدرتمندترین کنسول جهان و همچنین تصاحب برخی از شرکت&zwnj;های بازی&zwnj;سازی، می&zwnj;خواهد شکست نسل هشتم را جبران کند. کنسول نسل نهمی سونی یعنی PS5 چه از نظر سخت افزار و چه از نظر ظاهر و حتی دسته، دارای تغییرات زیادی بوده است. شرکت سونی دو نوع کنسول تا به این لحظه به بازار عرضه کرده است که یکی از آن&zwnj;ها نوع استاندارد و دیگری دیجیتال بوده که ما در اینجا به بررسی نوع استاندارد می&zwnj;پردازیم. پس در ادامه با ما همراه باشید.</p>\r\n\r\n<hr />\r\n<h1>مشخصات&nbsp;</h1>\r\n\r\n<p>انواع حافظه :</p>\r\n\r\n<p>هارد دیسک</p>\r\n\r\n<p>ابعاد :</p>\r\n\r\n<p>۲۶۰x۹۰x۳۹۰ سانتی&zwnj;متر</p>\r\n\r\n<p>ظرفیت هارد دیسک :</p>\r\n\r\n<p>۸۲۵ گیگابایت</p>\r\n\r\n<p>امکانات ظاهری :</p>\r\n\r\n<p>دسته بی سیم</p>\r\n\r\n<p>تعداد دسته :</p>\r\n\r\n<p>دو عدد</p>\r\n\r\n<p>امکانات و قابلیت&zwnj;ها :</p>\r\n\r\n<p>- کنترلرهای Dual Sense - Ethernet (۱۰BASE-T, ۱۰۰BASE-TX, ۱۰۰۰BASE-T) - IEEE ۸۰۲.۱۱ a/b/g/n/ac/ax - Headset Tempest ۳D Audio Tech</p>\r\n\r\n<p>خروجی تصویر :</p>\r\n\r\n<p>HDMI با رزولوشن ۴K و حداکثر ۱۲۰ فریم بر ثانیه</p>\r\n\r\n<p>سایر توضیحات :</p>\r\n\r\n<p>- دارای ۳ عدد پورت HighSpeed USB - دارای پورت USB-C - پایه شارژر با ابعاد ۹&times;۷&times;۱۲ سانتی&zwnj;متر و ظرفیت شارژ دو کنترلر همزمان - هدست سونی دارای تکنولوژی Tempest ۳D Audio صدای سه بعدی - هدست سونی Pulse ۳D مناسب برای انجام بازی&zwnj;های ویدیویی و چت صوتی در بازی&zwnj;های چند نفره</p>\r\n\r\n<p>حافظه RAM :</p>\r\n\r\n<p>۱۶ گیگابایت حافظه GDDR۶ و ۲۵۶ بیتی</p>\r\n\r\n<p>پردازشگر گرافیکی GPU&nbsp;</p>\r\n\r\n<p>پردازنده گرافیکی با معماری شخصی سازی شده RDNA ۲ ، قدرت ۱۰.۲۸ ترافلاپس و ۳۶ واحد محاسباتی (CU) با فرکانس متغیر ۲.۲۳ گیگاهرتز</p>\r\n\r\n<p>پردازشگر اصلی CPU</p>\r\n\r\n<p>پردازنده شخصی&zwnj;سازی شده Zen ۲ با ۸ هسته و فرکانس متغیر ۳.۵ GHz</p>\r\n\r\n<p>نوع درایو کنسول</p>\r\n\r\n<p>درایو نوری اپتیکال بلوری ۴K با ظرفیت مضاعف</p>\r\n\r\n<p>اقلام همراه محصول</p>\r\n\r\n<p>- دو کنترلر - پایه شارژر کنترلر سونی مدل Dualsense Charging Station - هدست سونی مدل Pulse ۳D - کابل HDMI</p>\r\n\r\n<p>وزن :</p>\r\n\r\n<p>۴۵۰۰ گرم</p>\r\n', '41800000', 1, '2023-04-08 17:33:00', 'http://127.0.0.1/shop/products/4442.webp'),
(68, 'هدفون بلوتوثی مدل گربه ای P8 M', '<p>هدفون دخترانه P8M مدل گربه ای یک هدفون رو گوشی که با بدنه ای سبک و نرم طراحی شده است که ظاهری منحصر به فرد و سیلیکونی دارد. از زیبایی این هدفون وجود نور RGB روی گوش های هدفون می باشد که از جذابیت های این هدفون می باشد . کیفیت صدای استریو ،رفع نویز ،میکروفون HDو...این هدفون مخصوص به کودکان و نوجوانان طراحی شده و به تمامی دستگاه هوشمند ، تبلت ها ، مانند Apple iPhone ، iPad Mini ، گوشی های Galaxy Galaxy ، Lenovo ، تلفن همراه آندرویدی ، تبلت ها و موارد دیگر کار می کند. نسخه بلوتوث این هدفون نسخه 5می باشد که اتصال سریعی دارد، هدفون دارای میکروفون با کیفیت است و قابلیت صحبت کردن دارد. این هدفون دارای امکان تنظیم داشته و کوتاه و بلند می شود و منحصرا برای جلوگیری از آسیب رساندن به گوش کودکان طراحی شده است. بر روی هدفون با الهام از گربه دو گوش طراحی شده که ظاهری جذاب برای دختران ایجاد می کند</p>\r\n\r\n<hr />\r\n<h2><strong>مشخصات</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>اقلام همراه هدفون :</p>\r\n\r\n<p>کابل شارژ کابل AUX</p>\r\n\r\n<p>پاسخ فرکانسی :</p>\r\n\r\n<p>۲۰-۲۰k هرتز</p>\r\n\r\n<p>قابلیت&zwnj;های هدفون، هدست و هندزفری :</p>\r\n\r\n<p>نشانگر LED</p>\r\n\r\n<p>نوع گوشی :</p>\r\n\r\n<p>دو گوشی</p>\r\n\r\n<p>سایر مشخصات :</p>\r\n\r\n<p>ظاهری شیک و خاص دارای نورپردازی زیبا قابلیت تنظیم اندازه</p>\r\n\r\n<p>نوع اتصال :</p>\r\n\r\n<p>باسیم</p>\r\n\r\n<p>بلوتوث&nbsp;</p>\r\n\r\n<p>بی&zwnj;سیم</p>\r\n\r\n<p>مناسب برای</p>\r\n\r\n<p>بانوان</p>\r\n\r\n<p>ویژگی&zwnj;های خاص</p>\r\n\r\n<p>کلید مدیریت میزان صدا</p>\r\n', '800000', 5, '2023-04-08 17:34:59', 'http://127.0.0.1/shop/products/سشی.webp'),
(69, 'کیبورد مخصوص بازی کیکورن مدل K2 V2 Hot-Swappable', '<p>گر به دنبال نسل جدید کیبورد های مکانیکال هستید keychron بهترین گزینه برای شماست.ظاهری زیبا در کنار عملکرد فوق العاده شما را قانع خواهد کرد. امکان تعویض کلید ها و از همه مهمتر قابلیت Hot-swappable که امکان تعویض سوییچ را به شما میدهد.قابلیت استفاده با سیم و بی سیم و نورپردازی RGB از مزایا این کیبورد است.این کیبورد مجهز به سوییچ قهوه ای رنگ است.همچنین قابلیت اتصال همزمان به سه دستگاه را دارا میباشد</p>\r\n\r\n<hr />\r\n<h2><strong>مشخصات&nbsp;</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>وزن :</p>\r\n\r\n<p>۶۶۳ گرم</p>\r\n\r\n<p>درگاه&zwnj;های ارتباطی :</p>\r\n\r\n<p>بلوتوث</p>\r\n\r\n<p>نسخه بلوتوث :</p>\r\n\r\n<p>۵.۱</p>\r\n\r\n<p>نوع کابل :</p>\r\n\r\n<p>USB Type-C</p>\r\n\r\n<p>نوع اتصال :</p>\r\n\r\n<p>دوگانه بی&zwnj;سیم و باسیم</p>\r\n\r\n<p>منبع تغذیه :</p>\r\n\r\n<p>باطری داخلی</p>\r\n\r\n<p>سازگار با سیستم&zwnj;عامل&zwnj;های :</p>\r\n\r\n<p>ویندوز مک</p>\r\n\r\n<p>نوع رابط :</p>\r\n\r\n<p>USB Type-C</p>\r\n\r\n<p>بلوتوث :</p>\r\n\r\n<p>سایر قابلیت&zwnj;های صفحه کلید</p>\r\n\r\n<p>Hot-Swappable قابلیت تعویض سوییچ</p>\r\n\r\n<p>توضیحات چراغ&zwnj; پس زمینه صفحه کلید</p>\r\n\r\n<p>RGB با قابلیت ۱۸ حالت نورپردازی</p>\r\n', '7000000', 1, '2023-04-08 17:41:38', 'http://127.0.0.1/shop/products/456.webp'),
(70, 'کیس کامپیوتر مدل GrayMatte', '<p>ین کیس با طراحی خیلی خاص و زیبا به 6 فن RGB فوق العاده قوی هم مجهز شده علاوه بر این کیفیت بی نظیر فلز استفاده شده و شیشه واقعی ( غیر پلاستیکی) باعث کمیاب شدن این مدل کیس های لوکس میشود .</p>\r\n\r\n<hr />\r\n<h2>مشخصات</h2>\r\n\r\n<p>وزن :</p>\r\n\r\n<p>۱۰۰۰۰ گرم</p>\r\n\r\n<p>سازگاری با مادربرد :</p>\r\n\r\n<p>microATX</p>\r\n\r\n<p>Mini-ITX</p>\r\n', '9600000', 0, '2023-04-08 17:44:13', 'http://127.0.0.1/shop/products/9600.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`) VALUES
(1, 'Admin', 'admin', '$2y$10$77dCKou4RDlXfhaaYdmtQebZpeWVY9eEf7Frini1wjgRd9dh7d6O2'),
(19, 'ابوالفضل شریفی', 'vc_abolfazl', '$2y$10$hNzQtFZT4zg.z2TzYeZVF.Ls7/Mr68ngR0sNrRmBGAxS0CnR6WlTi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
