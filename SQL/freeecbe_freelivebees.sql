-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2021 at 01:58 PM
-- Server version: 10.2.38-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freeecbe_freelivebees`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_routes`
--

CREATE TABLE `app_routes` (
  `id` bigint(20) NOT NULL,
  `slug` varchar(192) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'blogpost',
  `resource_id` int(11) NOT NULL,
  `title_french` longtext COLLATE utf8_unicode_ci NOT NULL,
  `title_english` longtext COLLATE utf8_unicode_ci NOT NULL,
  `show_in_nav` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `icon_class` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_routes`
--

INSERT INTO `app_routes` (`id`, `slug`, `controller`, `type`, `resource_id`, `title_french`, `title_english`, `show_in_nav`, `icon_class`) VALUES
(82, 'terms-and-conditions', 'page/cms/3', 'cms', 3, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `blogpost`
--

CREATE TABLE `blogpost` (
  `id` int(11) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_description` text COLLATE utf8_unicode_ci NOT NULL,
  `post_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `post_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'image',
  `video_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.mp4',
  `thumbnail` varchar(244) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `slug_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogpost_comments`
--

CREATE TABLE `blogpost_comments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `body` varchar(255) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogpost_comments`
--

INSERT INTO `blogpost_comments` (`id`, `name`, `email`, `body`, `blog_id`, `created_on`, `status`) VALUES
(1, 'waseem', 'educators@school.com', 'helo from me', 15, '2020-09-06 12:10:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'defaultbanner.png',
  `post_description` text COLLATE utf8_unicode_ci NOT NULL,
  `post_description_fr` text COLLATE utf8_unicode_ci NOT NULL,
  `displaysidebar` int(1) NOT NULL,
  `sidebar` int(1) NOT NULL,
  `meta_keyword` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `post_title`, `short_heading`, `post_banner`, `post_description`, `post_description_fr`, `displaysidebar`, `sidebar`, `meta_keyword`, `meta_title`, `meta_description`, `created_on`) VALUES
(3, 'Termes et conditions', '', 'defaultbanner.png', '<p>Terms and conditions of use of FREE LIVE BEES Web app - Reporting of wild bee swarm nesting sites<br />\nArticle 1: Purpose</p>\n\n<p>The present Terms and Conditions of Use provide a legal framework for the use of the services of the web application app.Freelivebees.org (hereinafter referred to as &quot;the site&quot; or &quot;Free Live Bees&quot;).</p>\n\n<p>The access to the site must be preceded by the acceptance of these GTUs, which constitute the contract between the association POLLINIS, publisher, and the User. Access to this platform signifies acceptance of these GTUs.</p>\n\n<p>Article 2: Legal notice&nbsp;</p>\n\n<p>The Free Live Bees website is published by the association POLLINIS, registered with the RCS under the number 75297592000014, whose head office is located at 10 Rue Saint Marc, 75002, France.</p>\n\n<p>The host of the Free Live Bees website is PLANETHOSTER, located at 4416 Louis B. Mayer Laval (Greater Montreal), Quebec H7P 0G1 Canada</p>\n\n<p>Article 3: Access to the site</p>\n\n<p>The Free Live Bees website allows free access to the following services:</p>\n\n<p>Reporting of nest sites<br />\nUploading information on selected nests<br />\nConnecting users with organisations or beekeepers responsible for the recovery of wild bee nests<br />\nNest search possible with filtering according to selected criteria<br />\nViewing of information and possibility to follow up on observations&nbsp;<br />\nThe site can be accessed free of charge from anywhere by any user with internet access. All costs necessary for access to the services (computer equipment, Internet connection, etc.) are to be borne by the user.</p>\n\n<p>Access to the services dedicated to members is made by means of a login and a password.</p>\n\n<p>For maintenance or other reasons, access to the site may be interrupted or suspended by the publisher without notice or justification.</p>\n\n<p>Article 4: Data collection</p>\n\n<p>For the creation of the User&#39;s account, the collection of information at the time of registration on the site is necessary and mandatory. In accordance with the law n&deg;78-17 of January 6th relating to data processing, files and freedoms, the collection and processing of personal information is carried out in the respect of private life.</p>\n\n<p>In accordance with the French Data Protection Act of 6 January 1978, Articles 39 and 40, the User has the right to access, rectify, delete and oppose his or her personal data. This right can be exercised by</p>\n\n<p>sending an email to contact@geonest.org<br />\nArticle 5: Intellectual property</p>\n\n<p>The brands, logos and content of the Free Live Bees website (graphic illustrations, texts, etc.) are protected by the Intellectual Property Code and by copyright.</p>\n\n<p>Reproduction and copying of content by the User requires prior authorisation from the site. In this case, any use for commercial or advertising purposes is prohibited.</p>\n\n<p>Article 6: Liability</p>\n\n<p>Although the information published on the site is deemed reliable, the site reserves the right not to guarantee the reliability of the sources.</p>\n\n<p>The information published on the Free Live Bees website is presented for information purposes only and has no contractual value. Despite regular updates, the site cannot be held responsible for any changes in administrative and legal provisions that occur after publication. The same applies to the use and interpretation of the information provided on the platform.</p>\n\n<p>The site declines all responsibility for any viruses that may infect the user&#39;s computer equipment after using or accessing this site.</p>\n\n<p>The site cannot be held responsible in the event of force majeure or the unforeseeable and insurmountable act of a third party.</p>\n\n<p>The site does not guarantee the total security and confidentiality of the data. However, the site undertakes to implement all the methods required to do so as best it can.</p>\n\n<p>Article 7: Hypertext links</p>\n\n<p>The site may contain hypertext links. By clicking on them, the User will leave the platform. The platform has no control over and cannot be held responsible for the content of the web pages relating to these links.</p>\n\n<p>Article 8: Cookies</p>\n\n<p>When visiting the site, a cookie may be automatically installed on the User&#39;s browser.</p>\n\n<p>Cookies are small files that are temporarily stored on the hard disk of the User&#39;s computer. These cookies are necessary to ensure accessibility and navigation on the site. These files do not contain any personal information and cannot be used to identify a person.</p>\n\n<p>The information in the cookies is used to improve the performance of the Freelivebees.org website.</p>\n\n<p>By browsing the site, the User accepts cookies. They can be deactivated via the settings of the browser software.</p>\n\n<p>Article 9: Publication by the User</p>\n\n<p>The Free Live Bees website allows members to publish comments.</p>\n\n<p>In their publications, members are required to respect the rules of Netiquette as well as the legal rules in force.</p>\n\n<p>The site has the right to exercise a priori moderation on the publications and may refuse to put them online without having to provide justification.</p>\n\n<p>The member retains all intellectual property rights. However, any publication on the site implies the delegation of the non-exclusive and free right to the publishing company to represent, reproduce, modify, adapt, distribute and disseminate the publication anywhere and on any medium for the duration of the intellectual property. This may be done directly or through an authorised third party. This includes the right to use the publication on the web and on mobile phone networks.</p>\n\n<p>The publisher undertakes to mention the name of the member in the vicinity of the publication for each use.</p>\n\n<p>The User is responsible for any content that he/she puts online. The User undertakes not to publish content that may harm the interests of third parties. Any legal proceedings brought by an injured third party against the site shall be borne by the User.</p>\n\n<p>The deletion or modification by the site of the User&#39;s content may be carried out at any time, for any reason and without notice.</p>\n\n<p>Article 11: Duration of the contract</p>\n\n<p>This contract is valid for an indefinite period. The beginning of the use of the services of the site marks the application of the contract with regard to the User.</p>\n\n<p>Article 12: Applicable law and competent jurisdiction</p>\n\n<p>This contract is subject to French law. Failure to resolve disputes between the parties amicably shall result in recourse to the competent French courts to settle the dispute.</p>\n\n<p>&nbsp;</p>\n', '<p>Conditions g&eacute;n&eacute;rales d&rsquo;utilisation de l&rsquo;application WEB - Signalisation de sites de nidifications d&#39;essaims sauvages d&#39;abeilles&nbsp;FREE LIVE BEES</p>\n\n<p>Article 1&nbsp;: Objet</p>\n\n<p>Les pr&eacute;sentes CGU ou Conditions G&eacute;n&eacute;rales d&rsquo;Utilisation encadrent juridiquement l&rsquo;utilisation des services de l&rsquo;application web app.Freelivebees.org (ci-apr&egrave;s d&eacute;nomm&eacute; &laquo;&nbsp;le site&nbsp;&raquo; ou &laquo;Free Live Bees&nbsp;&raquo;).</p>\n\n<p>Constituant le contrat entre l&rsquo;association POLLINIS, &eacute;diteur, et l&rsquo;Utilisateur, l&rsquo;acc&egrave;s au site doit &ecirc;tre pr&eacute;c&eacute;d&eacute; de l&rsquo;acceptation de ces CGU. L&rsquo;acc&egrave;s &agrave; cette plateforme signifie l&rsquo;acceptation des pr&eacute;sentes CGU.</p>\n\n<p>Article 2&nbsp;:Mentions l&eacute;gales&nbsp;</p>\n\n<p>L&rsquo;&eacute;dition du site Free Live Bees est assur&eacute;e par l&rsquo;association POLLINIS, inscrite au RCS sous le num&eacute;ro 75297592000014, dont le si&egrave;ge social est localis&eacute; au 10 Rue Saint Marc, 75002, France M&eacute;tropolitaine.</p>\n\n<p>L&rsquo;h&eacute;bergeur du site Free Live Bees est la soci&eacute;t&eacute; PLANETHOSTER, sise 4416 Louis B. Mayer Laval (Grand Montr&eacute;al), Qu&eacute;bec H7P 0G1 Canada</p>\n\n<p>Article 3&nbsp;: Acc&egrave;s au site</p>\n\n<p>Le site Free Live Bees permet d&rsquo;acc&eacute;der gratuitement aux services suivants&nbsp;:</p>\n\n<ul>\n	<li>Signalisation des sites de nidification</li>\n	<li>T&eacute;l&eacute;chargement des informations des nids s&eacute;lectionn&eacute;s</li>\n	<li>Mise en relation des utilisateurs avec les organisationsou apictulteurs charg&eacute;s de la r&eacute;cup&eacute;ration des nids d&#39;abeille sauvage</li>\n	<li>Recherche d&#39;un nid possible avec filtrage selon les crit&egrave;res s&eacute;lectionn&eacute;s</li>\n	<li>Visualisation d&#39;informations et possibilit&eacute; de suivi d&#39;observation&nbsp;</li>\n</ul>\n\n<p>Le site est accessible gratuitement depuis n&rsquo;importe o&ugrave; par tout utilisateur disposant d&rsquo;un acc&egrave;s &agrave; Internet. Tous les frais n&eacute;cessaires pour l&rsquo;acc&egrave;s aux services (mat&eacute;riel informatique, connexion Internet&hellip;) sont &agrave; la charge de l&rsquo;utilisateur.</p>\n\n<p>L&rsquo;acc&egrave;s aux services d&eacute;di&eacute;s aux membres s&rsquo;effectue &agrave; l&rsquo;aide d&rsquo;un identifiant et d&rsquo;un mot de passe.</p>\n\n<p>Pour des raisons de maintenance ou autres, l&rsquo;acc&egrave;s au site peut &ecirc;tre interrompu ou suspendu par l&rsquo;&eacute;diteur sans pr&eacute;avis ni justification.</p>\n\n<p>Article 4&nbsp;: Collecte des donn&eacute;es</p>\n\n<p>Pour la cr&eacute;ation du compte de l&rsquo;Utilisateur, la collecte des informations au moment de l&rsquo;inscription sur le site est n&eacute;cessaire et obligatoire. Conform&eacute;ment &agrave; la loi n&deg;78-17 du 6 janvier relative &agrave; l&rsquo;informatique, aux fichiers et aux libert&eacute;s, la collecte et le traitement d&rsquo;informations personnelles s&rsquo;effectuent dans le respect de la vie priv&eacute;e.</p>\n\n<p>Suivant la loi Informatique et Libert&eacute;s en date du 6 janvier 1978, articles 39 et 40, l&rsquo;Utilisateur dispose du droit d&rsquo;acc&eacute;der, de rectifier, de supprimer et d&rsquo;opposer ses donn&eacute;es personnelles. L&rsquo;exercice de ce droit s&rsquo;effectue par&nbsp;:</p>\n\n<ul>\n	<li>envoie d&rsquo;un email &agrave; contact@geonest.org</li>\n</ul>\n\n<p>Article 5&nbsp;: Propri&eacute;t&eacute; intellectuelle</p>\n\n<p>Les marques, logos ainsi que les contenus du site Free Live Bees (illustrations graphiques, textes&hellip;) sont prot&eacute;g&eacute;s par le Code de la propri&eacute;t&eacute; intellectuelle et par le droit d&rsquo;auteur.</p>\n\n<p>La reproduction et la copie des contenus par l&rsquo;Utilisateur requi&egrave;rent une autorisation pr&eacute;alable du site. Dans ce cas, toute utilisation &agrave; des usages commerciaux ou &agrave; des fins publicitaires est proscrite.</p>\n\n<p>Article 6&nbsp;: Responsabilit&eacute;</p>\n\n<p>Bien que les informations publi&eacute;es sur le site soient r&eacute;put&eacute;es fiables, le site se r&eacute;serve la facult&eacute; d&rsquo;une non-garantie de la fiabilit&eacute; des sources.</p>\n\n<p>Les informations diffus&eacute;es sur le site Free Live Bees sont pr&eacute;sent&eacute;es &agrave; titre purement informatif et sont sans valeur contractuelle. En d&eacute;pit des mises &agrave; jour r&eacute;guli&egrave;res, la responsabilit&eacute; du site ne peut &ecirc;tre engag&eacute;e en cas de modification des dispositions administratives et juridiques apparaissant apr&egrave;s la publication. Il en est de m&ecirc;me pour l&rsquo;utilisation et l&rsquo;interpr&eacute;tation des informations communiqu&eacute;es sur la plateforme.</p>\n\n<p>Le site d&eacute;cline toute responsabilit&eacute; concernant les &eacute;ventuels virus pouvant infecter le mat&eacute;riel informatique de l&rsquo;Utilisateur apr&egrave;s l&rsquo;utilisation ou l&rsquo;acc&egrave;s &agrave; ce site.</p>\n\n<p>Le site ne peut &ecirc;tre tenu pour responsable en cas de force majeure ou du fait impr&eacute;visible et insurmontable d&rsquo;un tiers.</p>\n\n<p>La garantie totale de la s&eacute;curit&eacute; et la confidentialit&eacute; des donn&eacute;es n&rsquo;est pas assur&eacute;e par le site. Cependant, le site s&rsquo;engage &agrave; mettre en &oelig;uvre toutes les m&eacute;thodes requises pour le faire au mieux.</p>\n\n<p>Article 7&nbsp;: Liens hypertextes</p>\n\n<p>Le site peut &ecirc;tre constitu&eacute; de liens hypertextes. En cliquant sur ces derniers, l&rsquo;Utilisateur sortira de la plateforme. Cette derni&egrave;re n&rsquo;a pas de contr&ocirc;le et ne peut pas &ecirc;tre tenue responsable du contenu des pages web relatives &agrave; ces liens.</p>\n\n<p>Article 8&nbsp;: Cookies</p>\n\n<p>Lors des visites sur le site, l&rsquo;installation automatique d&rsquo;un cookie sur le logiciel de navigation de l&rsquo;Utilisateur peut survenir.</p>\n\n<p>Les cookies correspondent &agrave; de petits fichiers d&eacute;pos&eacute;s temporairement sur le disque dur de l&rsquo;ordinateur de l&rsquo;Utilisateur. Ces cookies sont n&eacute;cessaires pour assurer l&rsquo;accessibilit&eacute; et la navigation sur le site. Ces fichiers ne comportent pas d&rsquo;informations personnelles et ne peuvent pas &ecirc;tre utilis&eacute;s pour l&rsquo;identification d&rsquo;une personne.</p>\n\n<p>L&rsquo;information pr&eacute;sente dans les cookies est utilis&eacute;e pour am&eacute;liorer les performances de navigation sur le site Freelivebees.org.</p>\n\n<p>En naviguant sur le site, l&rsquo;Utilisateur accepte les cookies. Leur d&eacute;sactivation peut s&rsquo;effectuer via les param&egrave;tres du logiciel de navigation.</p>\n\n<p>Article 9&nbsp;: Publication par l&rsquo;Utilisateur</p>\n\n<p>Le site Free Live Bees permet aux membres de publier des commentaires.</p>\n\n<p>Dans ses publications, le membre est tenu de respecter les r&egrave;gles de la Netiquette ainsi que les r&egrave;gles de droit en vigueur.</p>\n\n<p>Le site dispose du droit d&rsquo;exercer une mod&eacute;ration &agrave; priori sur les publications et peut refuser leur mise en ligne sans avoir &agrave; fournir de justification.</p>\n\n<p>Le membre garde l&rsquo;int&eacute;gralit&eacute; de ses droits de propri&eacute;t&eacute; intellectuelle. Toutefois, toute publication sur le site implique la d&eacute;l&eacute;gation du droit non exclusif et gratuit &agrave; la soci&eacute;t&eacute; &eacute;ditrice de repr&eacute;senter, reproduire, modifier, adapter, distribuer et diffuser la publication n&rsquo;importe o&ugrave; et sur n&rsquo;importe quel support pour la dur&eacute;e de la propri&eacute;t&eacute; intellectuelle. Cela peut se faire directement ou par l&rsquo;interm&eacute;diaire d&rsquo;un tiers autoris&eacute;. Cela concerne notamment le droit d&rsquo;utilisation de la publication sur le web et sur les r&eacute;seaux de t&eacute;l&eacute;phonie mobile.</p>\n\n<p>&Agrave; chaque utilisation, l&rsquo;&eacute;diteur s&rsquo;engage &agrave; mentionner le nom du membre &agrave; proximit&eacute; de la publication.</p>\n\n<p>L&rsquo;Utilisateur est tenu responsable de tout contenu qu&rsquo;il met en ligne. L&rsquo;Utilisateur s&rsquo;engage &agrave; ne pas publier de contenus susceptibles de porter atteinte aux int&eacute;r&ecirc;ts de tierces personnes. Toutes proc&eacute;dures engag&eacute;es en justice par un tiers l&eacute;s&eacute; &agrave; l&rsquo;encontre du site devront &ecirc;tre prises en charge par l&rsquo;Utilisateur.</p>\n\n<p>La suppression ou la modification par le site du contenu de l&rsquo;Utilisateur peut s&rsquo;effectuer &agrave; tout moment, pour n&rsquo;importe quelle raison et sans pr&eacute;avis.</p>\n\n<p>Article 11&nbsp;: Dur&eacute;e du contrat</p>\n\n<p>Le pr&eacute;sent contrat est valable pour une dur&eacute;e ind&eacute;termin&eacute;e. Le d&eacute;but de l&rsquo;utilisation des services du site marque l&rsquo;application du contrat &agrave; l&rsquo;&eacute;gard de l&rsquo;Utilisateur.</p>\n\n<p>Article 12&nbsp;: Droit applicable et juridiction comp&eacute;tente</p>\n\n<p>Le pr&eacute;sent contrat est soumis &agrave; la l&eacute;gislation fran&ccedil;aise. L&rsquo;absence de r&eacute;solution &agrave; l&rsquo;amiable des cas de litige entre les parties implique le recours aux tribunaux fran&ccedil;ais comp&eacute;tents pour r&eacute;gler le contentieux.</p>\n', 0, 0, 'free live bees', '', '', '2021-04-14 06:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_session`
--

CREATE TABLE `forgot_session` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `activtion` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forgot_session`
--

INSERT INTO `forgot_session` (`id`, `email`, `code`, `activtion`, `created_at`) VALUES
(1, 'mharis.javed1996@gmail.com', '1611923248', 1, '2021-01-29 13:27:28'),
(2, 'mharis.javed1996@gmail.com', '1611923867', 1, '2021-01-29 13:37:47'),
(3, 'hacene@pollinis.org', '1612348122', 1, '2021-02-03 11:28:42'),
(4, 'mharis.javed1996@gmail.com', '1612414155', 1, '2021-02-04 05:49:15'),
(5, 'mharis.javed1996@gmail.com', '1612436461', 1, '2021-02-04 12:01:01'),
(6, 'hr.cyphersol@gmail.com', '1612588585', 1, '2021-02-06 06:16:25'),
(7, 'waseemafzal31@gmail.com', '1612766475', 1, '2021-02-08 07:41:15'),
(8, 'waseemafzal31@gmail.com', '1612766656', 1, '2021-02-08 07:44:16'),
(9, 'waseemafzal31@gmail.com', '1612766884', 1, '2021-02-08 07:48:04'),
(10, 'waseemafzal31@gmail.com', '1612767314', 1, '2021-02-08 07:55:14'),
(11, 'waseemafzal31@gmail.com', '1612767461', 1, '2021-02-08 07:57:41'),
(12, 'mharis.javed1996@gmail.com', '1612775819', 1, '2021-02-08 10:16:59'),
(13, 'mharis.javed1996@gmail.com', '1612775866', 1, '2021-02-08 10:17:46'),
(14, 'mharis.javed1996@gmail.com', '1612775916', 1, '2021-02-08 10:18:36'),
(15, 'mharis.javed1996@gmail.com', '1612775952', 1, '2021-02-08 10:19:12'),
(16, 'mharis.javed1996@gmail.com', '1612776014', 1, '2021-02-08 10:20:14'),
(17, 'hacene@pollinis.org', '1612776324', 1, '2021-02-08 10:25:24'),
(18, 'basiles@pollinis.org', '1617982915', 0, '2021-04-09 17:41:55'),
(19, 'mharis.javed1996@gmail.com', '1618212379', 1, '2021-04-12 09:26:19'),
(20, 'mharis.javed1996@gmail.com', '1618212641', 1, '2021-04-12 09:30:41'),
(21, 'waseemafzal31@gmail.com', '1618324660', 1, '2021-04-13 16:37:40'),
(22, 'waseemafzal31@gmail.com', '1618324877', 1, '2021-04-13 16:41:17'),
(23, 'waseemafzal31@gmail.com', '1618324904', 1, '2021-04-13 16:41:44'),
(24, 'waseemafzal31@gmail.com', '1618325239', 1, '2021-04-13 16:47:19'),
(25, 'waseemafzal31@gmail.com', '1618325248', 1, '2021-04-13 16:47:28'),
(26, 'waseemafzal31@gmail.com', '1618325423', 1, '2021-04-13 16:50:23'),
(27, 'waseemafzal31@gmail.com', '1618325510', 1, '2021-04-13 16:51:50'),
(28, 'waseemafzal31@gmail.com', '1618325732', 1, '2021-04-13 16:55:32'),
(29, 'waseemafzal31@gmail.com', '1618325739', 1, '2021-04-13 16:55:39'),
(30, 'waseemafzal31@gmail.com', '1618325830', 1, '2021-04-13 16:57:10'),
(31, 'hacene@pollinis.org', '1618353707', 0, '2021-04-14 00:41:47'),
(32, 'hacene@pollinis.org', '1618393743', 0, '2021-04-14 11:49:03'),
(33, 'basile.soltner@etu-iepg.fr', '1618415405', 0, '2021-04-14 17:50:05'),
(34, 'basile.soltner@etu-iepg.fr', '1618476871', 0, '2021-04-15 10:54:31'),
(35, 'waseemafzal31@gmail.com', '1618479570', 0, '2021-04-15 11:39:30'),
(36, 'waseemafzal31@gmail.com', '1618479614', 0, '2021-04-15 11:40:14'),
(37, 'waseemafzal31@gmail.com', '1618479852', 0, '2021-04-15 11:44:12'),
(38, 'waseemafzal31@gmail.com', '1618479973', 0, '2021-04-15 11:46:13'),
(39, 'basile.soltner@etu-iepg.fr', '1618480781', 0, '2021-04-15 11:59:41'),
(40, 'paolo_api.fontana@fmach.it', '1618554195', 1, '2021-04-16 08:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `leprojects`
--

CREATE TABLE `leprojects` (
  `id` int(11) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_description` text COLLATE utf8_unicode_ci NOT NULL,
  `post_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `post_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'image',
  `video_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.mp4',
  `thumbnail` varchar(244) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `slug_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `leprojects`
--

INSERT INTO `leprojects` (`id`, `post_title`, `post_description`, `post_date`, `post_type`, `video_url`, `thumbnail`, `user_id`, `slug_id`, `created_on`, `category`, `author`) VALUES
(15, 'LES RAISONS DE CE PROJET', '<p>Le frelon asiatique est arriv&eacute; accidentellement en France en 2004 et avait colonis&eacute;, en janvier 2020, sur tout l&#39;Hexagone, &agrave; l&rsquo;exception du Bas-Rhin, du Territoire-de-Belfort et de la Corse. On le retrouve aussi d&eacute;sormais en Espagne, au Portugal, en Italie, en Belgique, aux Pays-Bas, en Allemagne et jusqu&rsquo;en Angleterre. Cette esp&egrave;ce invasive a &eacute;t&eacute; class&eacute;e comme &laquo;&nbsp;danger sanitaire de 2e cat&eacute;gorie&nbsp;&raquo; en France en 2012. L&rsquo;union europ&eacute;enne l&rsquo;a quant &agrave; elle class&eacute; &laquo;&nbsp;nuisible&nbsp;&raquo; en juin 2016. Mais le frelon asiatique continue sa progression, contribuant au d&eacute;clin des abeilles mellif&egrave;res et des pollinisateurs sauvages.</p>\n\n<p><img alt=\"\" src=\"https://cmsphoto.ww-cdn.com/superstatic/1902846/art/default/39721199-37378111.jpg?v=1591779817\" style=\"height:832px; width:1024px\" /></p>\n\n<h3><strong>Un tueur de pollinisateurs&nbsp;</strong></h3>\n\n<p>D&rsquo;une part, il est lui-m&ecirc;me un pollinisateur, il vient donc empi&eacute;ter sur les niches &eacute;cologiques des pollinisateurs autochtones. D&rsquo;autre part, il est un pr&eacute;dateur pour nombre d&rsquo;entre eux&nbsp;: deux tiers de son alimentation est compos&eacute;e d&rsquo;hym&eacute;nopt&egrave;res, dont la moit&eacute; d&rsquo;abeilles mellif&egrave;res.&nbsp;</p>\n\n<p>Des d&eacute;sinsectiseurs sont donc sollicit&eacute;s par des apiculteurs, des particuliers et des collectivit&eacute;s pour d&eacute;truire les nids qui menacent les ruchers ou la s&eacute;curit&eacute; des riverains, dans ou pr&egrave;s des &eacute;coles et dans les jardins publics notamment. Ces professionnels utilisent des insecticides de synth&egrave;se puissants (la perm&eacute;thrine et ses d&eacute;riv&eacute;s) d&eacute;l&eacute;t&egrave;res pour les autres animaux sauvages comme domestiques et la sant&eacute; humaine.&nbsp;</p>\n\n<h3><strong>Trouver une solution propre et efficace</strong></h3>\n\n<p>Il est donc apparu n&eacute;cessaire &agrave; POLLINIS de se saisir de cette question et de d&eacute;velopper&nbsp;:&nbsp;</p>\n\n<p>- une strat&eacute;gie sans pesticides, en coh&eacute;rence avec ce que l&rsquo;association d&eacute;fend concernant les pratiques agricoles.&nbsp;</p>\n\n<p>- une approche holistique qui englobe les trois &eacute;tapes de la lutte&nbsp;: la d&eacute;tection des nids, leur signalement et leur destruction.</p>\n', '', 'image', 'default.mp4', '', 0, 76, '2020-09-06 11:24:41', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `leprojects_comments`
--

CREATE TABLE `leprojects_comments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `body` varchar(255) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `resource_type` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `readed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `body`, `sender_id`, `receiver_id`, `resource_id`, `resource_type`, `created_date`, `readed`) VALUES
(3, 'm syam reported a nest', 140, 138, 269, 'nest', '2020-09-09 06:39:53', 1),
(4, 'Waseem afzal reported a nest', 138, 139, 270, 'nest', '2020-09-16 10:12:00', 1),
(5, 'Waseem afzal reported a nest', 139, 148, 9, 'nest', '2020-11-04 08:18:41', 0),
(6, 'haris javed reported a nest', 142, 148, 14, 'nest', '2020-11-05 09:52:05', 0),
(7, 'hh hh reported a nest', 144, 144, 15, 'nest', '2020-11-05 10:15:48', 0),
(8, 'Hacene Hebbar reported a nest', 143, 149, 20, 'nest', '2020-12-14 15:28:12', 0),
(9, 'hh hh reported a nest', 144, 145, 30, 'nest', '2021-01-07 14:49:04', 0),
(10, 'hh hh reported a nest', 144, 143, 32, 'nest', '2021-01-08 11:22:56', 0),
(11, 'haris javed reported a nest', 142, 142, 35, 'nest', '2021-01-09 09:42:54', 0),
(12, 'haris javed reported a nest', 142, 142, 42, 'nest', '2021-01-09 12:35:25', 0),
(13, 'haris javed reported a nest', 142, 142, 42, 'nest', '2021-01-09 12:36:47', 0),
(14, 'hh hh reported a nest', 144, 143, 44, 'nest', '2021-01-11 10:29:54', 0),
(15, 'Waseem afzal reported a nest', 139, 148, 47, 'nest', '2021-01-13 07:34:46', 0),
(16, 'Waseem afzal reported a nest', 139, 148, 47, 'nest', '2021-01-13 07:36:28', 0),
(17, 'Waseem afzal reported a nest', 139, 148, 47, 'nest', '2021-01-13 07:36:55', 0),
(18, 'Waseem afzal reported a nest', 139, 148, 47, 'nest', '2021-01-13 07:38:25', 0),
(19, 'Waseem afzal reported a nest', 139, 148, 47, 'nest', '2021-01-13 07:40:39', 0),
(20, 'Waseem afzal reported a nest', 139, 148, 47, 'nest', '2021-01-13 07:42:48', 0),
(21, 'Hacene Hebbar reported a nest', 143, 145, 64, 'nest', '2021-01-13 14:56:41', 0),
(22, 'Waseem afzal reported a nest', 139, 148, 65, 'nest', '2021-01-14 11:48:20', 0),
(23, 'haris javed reported a nest', 142, 148, 68, 'nest', '2021-01-18 10:22:37', 0),
(24, 'hh hh reported a nest', 144, 143, 69, 'nest', '2021-01-18 10:28:53', 0),
(25, 'hh hh reported a nest', 144, 149, 69, 'nest', '2021-01-18 10:29:13', 0),
(26, 'haris javed reported a nest', 142, 148, 72, 'nest', '2021-01-18 11:00:28', 0),
(27, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 04:45:14', 0),
(28, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 04:56:09', 0),
(29, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 05:34:06', 0),
(30, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 05:36:46', 0),
(31, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 05:39:11', 0),
(32, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 05:46:23', 0),
(33, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 05:48:01', 0),
(34, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 05:48:59', 0),
(35, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 05:51:01', 0),
(36, 'Waseem afzal reported a nest', 139, 148, 79, 'nest', '2021-01-20 07:45:26', 0),
(37, 'hh hh reported a nest', 144, 149, 80, 'nest', '2021-01-20 09:41:48', 0),
(38, 'hh hh reported a nest', 144, 143, 80, 'nest', '2021-01-20 09:42:00', 0),
(39, 'hh hh reported a nest', 144, 149, 82, 'nest', '2021-01-22 10:48:49', 0),
(40, 'hh hh reported a nest', 144, 149, 84, 'nest', '2021-01-22 10:51:46', 0),
(41, 'haris haris reported a nest', 151, 148, 85, 'nest', '2021-01-23 12:36:50', 0),
(42, 'hebbarH hacene reported a nest', 149, 149, 89, 'nest', '2021-03-02 09:43:06', 0),
(43, 'Waseem afzal reported a nest', 139, 146, 1, 'nest', '2021-03-03 13:03:46', 0),
(44, 'hebbarH hacene reported a nest', 149, 149, 2, 'nest', '2021-03-03 13:34:11', 0),
(45, 'hebbarH hacene reported a nest', 149, 143, 2, 'nest', '2021-03-03 13:34:34', 0),
(46, 'hh hh reported a nest', 144, 152, 5, 'nest', '2021-03-11 16:14:24', 0),
(47, 'admin reported a nest', 1, 142, 6, 'nest', '2021-03-16 05:09:15', 0),
(48, 'hebbarH hacene reported a nest', 149, 149, 8, 'nest', '2021-03-16 09:47:25', 0),
(49, 'hebbarH hacene reported a nest', 149, 149, 9, 'nest', '2021-03-16 14:09:50', 0),
(50, 'hebbarH hacene reported a nest', 149, 143, 9, 'nest', '2021-03-16 14:10:08', 0),
(51, 'hebbarH hacene reported a nest', 149, 143, 11, 'nest', '2021-03-17 12:15:11', 0),
(52, 'Waseem afzal reported a nest', 139, 148, 14, 'nest', '2021-03-17 13:48:29', 0),
(53, 'Waseem afzal reported a nest', 139, 148, 14, 'nest', '2021-03-17 13:58:19', 0),
(54, 'Waseem afzal reported a nest', 139, 148, 31, 'nest', '2021-03-19 12:19:51', 0),
(55, 'Basile Soltner reported a nest', 152, 149, 6, 'nest', '2021-03-31 12:18:14', 0),
(56, 'hebbarH hacene reported a nest', 149, 143, 4, 'nest', '2021-04-02 12:59:54', 0),
(57, 'hebbarH hacene reported a nest', 149, 143, 6, 'nest', '2021-04-02 13:52:17', 0),
(58, 'Basile Soltner reported a nest', 152, 143, 10, 'nest', '2021-04-07 12:47:21', 0),
(59, 'Basile Soltner reported a nest', 152, 143, 10, 'nest', '2021-04-07 12:47:41', 0),
(60, 'hebbarH hacene reported a nest', 149, 143, 12, 'nest', '2021-04-08 08:50:23', 0),
(61, 'hebbarH hacene reported a nest', 149, 149, 13, 'nest', '2021-04-08 09:49:34', 0),
(62, 'hebbarH hacene reported a nest', 149, 149, 15, 'nest', '2021-04-08 10:49:18', 0),
(63, 'Waseem afzal reported a nest', 139, 142, 17, 'nest', '2021-04-08 11:11:37', 0),
(64, 'Waseem afzal reported a nest', 1, 148, 18, 'nest', '2021-04-08 11:30:19', 0),
(65, 'Waseem afzal reported a nest', 139, 148, 19, 'nest', '2021-04-08 11:33:05', 0),
(66, 'hebbarH hacene reported a nest', 149, 149, 23, 'nest', '2021-04-09 10:43:05', 0),
(67, 'Waseem afzal reported a nest', 153, 155, 2, 'nest', '2021-04-13 18:25:46', 0),
(68, 'Waseem afzal reported a nest', 153, 155, 2, 'nest', '2021-04-13 18:33:04', 0),
(69, 'Waseem afzal reported a nest', 153, 155, 2, 'nest', '2021-04-13 18:35:18', 0),
(70, 'Waseem afzal reported a nest', 153, 155, 2, 'nest', '2021-04-13 18:36:24', 0),
(71, 'hacene hebbar reported a nest', 156, 156, 5, 'nest', '2021-04-13 22:46:25', 0),
(72, 'Waseem afzal reported a nest', 153, 155, 7, 'nest', '2021-04-14 09:42:48', 0),
(73, 'Basile Soltner reported a nest', 161, 156, 16, 'nest', '2021-04-16 09:26:42', 0),
(74, 'Basile Soltner reported a nest', 161, 156, 7, 'nest', '2021-04-20 06:57:15', 0),
(75, 'Waseem afzal reported a nest', 153, 163, 27, 'nest', '2021-04-23 09:34:34', 0),
(76, 'haris javed reported a nest', 158, 167, 6, 'nest', '2021-04-27 09:49:36', 0),
(77, 'HH HHUK reported a nest', 169, 156, 7, 'nest', '2021-04-27 11:41:38', 0),
(78, 'Basile Soltner reported a nest', 161, 156, 52, 'nest', '2021-04-29 07:59:40', 0),
(79, 'hacene hebbar reported a nest', 156, 169, 53, 'nest', '2021-04-29 11:42:05', 0),
(80, 'hacene hebbar reported a nest', 156, 169, 14, 'nest', '2021-05-25 10:38:44', 0),
(81, 'Basile Soltner reported a nest', 167, 161, 18, 'nest', '2021-05-27 13:44:49', 0),
(82, 'haris javed reported a nest', 158, 158, 5, 'nest', '2021-06-05 11:28:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `id` int(11) NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prototypeform`
--

CREATE TABLE `prototypeform` (
  `id` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `additional_address` varchar(500) NOT NULL,
  `state_region` varchar(500) NOT NULL,
  `postal_code` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL,
  `time` varchar(200) NOT NULL,
  `place` varchar(200) NOT NULL,
  `nesting_type` varchar(200) NOT NULL,
  `temperature` varchar(200) NOT NULL,
  `weather_situation` varchar(200) NOT NULL,
  `bees_in_pollen` varchar(200) NOT NULL,
  `activity` varchar(200) NOT NULL,
  `babysitters` varchar(200) NOT NULL,
  `flights` varchar(200) NOT NULL,
  `fight_with_workers` varchar(200) NOT NULL,
  `waste_wax` varchar(200) NOT NULL,
  `hornets` varchar(200) NOT NULL,
  `cavity` varchar(200) NOT NULL,
  `beekeeper_r` varchar(200) NOT NULL,
  `additional_information` text NOT NULL,
  `date_picker` varchar(200) NOT NULL,
  `time_picker` varchar(200) NOT NULL,
  `nest_id` int(11) NOT NULL,
  `video` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `description`, `image`, `banner`, `phone`, `status`, `address`, `terms`, `email`) VALUES
(1, '<p>Sed Ut Perspiciatis Unde Omnis Iste Natus Error Sit Voluptatem.</p>\n\n<p>7860 North Park Place<br />\nSan Francisco, CA 94120</p>\n\n<p><strong>Email:</strong>&nbsp;Support@skillsquared</p>\n\n<p><strong>Call:</strong>&nbsp;<a href=\"tel:+15555555555\">555-555-1234</a></p>', '3518166471260.jpg', '5068095178430.jpg', '01 123 456 7895', '1', '#1002 Sector 49', '<p>Hello this is test messageHello this is test messageHello this is tes</p>\n\n<p>t messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is tes</p>\n\n<p>t messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHello this is test messageHell</p>\n\n<p>o this is test message</p>\n', 'waseemafzal31@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'noimg.png',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabl_language_category`
--

CREATE TABLE `tabl_language_category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabl_language_category`
--

INSERT INTO `tabl_language_category` (`id`, `title`) VALUES
(1, ' Navigation'),
(2, 'register'),
(3, 'login'),
(4, 'Reporting'),
(5, 'search'),
(6, 'nest_modal'),
(7, 'suivi'),
(8, 'Map Data_');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_follow`
--

CREATE TABLE `tbl_follow` (
  `id` int(11) NOT NULL,
  `a_information` varchar(255) NOT NULL,
  `nest_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `occupied_species` varchar(255) NOT NULL,
  `recovery_bee_keeper` varchar(255) NOT NULL,
  `disappeared` varchar(255) NOT NULL,
  `pickedup` varchar(255) NOT NULL,
  `cavity_occupied` varchar(255) NOT NULL,
  `which_one` varchar(255) NOT NULL,
  `weather_situation` varchar(255) DEFAULT NULL,
  `temperature` varchar(255) NOT NULL,
  `pollen` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `etat_de_la_colonie` varchar(255) NOT NULL,
  `pouvezvous` varchar(255) DEFAULT NULL,
  `flights` varchar(255) NOT NULL,
  `entries_exits` varchar(255) NOT NULL,
  `waste_wax` varchar(255) NOT NULL,
  `fight_with_workers` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_follow`
--

INSERT INTO `tbl_follow` (`id`, `a_information`, `nest_id`, `date`, `time`, `occupied_species`, `recovery_bee_keeper`, `disappeared`, `pickedup`, `cavity_occupied`, `which_one`, `weather_situation`, `temperature`, `pollen`, `activity`, `user_id`, `etat_de_la_colonie`, `pouvezvous`, `flights`, `entries_exits`, `waste_wax`, `fight_with_workers`) VALUES
(1, '', 5, '2021-04-30', '', '', '', 'Non', 'Non', 'Non', '', 'Eclaircies', '3', 'Oui', 'Modérée, 10 à 25 abeilles', 156, 'Fondatrice', '', '', '', '', ''),
(2, '', 5, '2021-05-01', '', '', '', 'Non', 'Non', 'Non', '', 'Soleil', '3', 'Oui', 'Forte, plus de 25 abeilles', 156, 'Etablie', '', '', '', '', ''),
(3, '', 5, '2021-05-01', '', '', '', 'Non', 'Non', 'Non', '', 'Vent', '3', 'Oui', 'Faible, 1 à 9 abeilles', 156, 'Indéterminée', '', '', '', '', ''),
(8, 'modif', 10, '2021-04-15', '', '', '', 'Non', 'Non', 'Oui', '', 'Soleil', '8', 'Non', 'Modérée, 10 à 25 abeilles', 161, 'Indéterminée', 'des blattes', '', 'Non', 'Non', 'Non'),
(5, 'Followed by me', 3, '2021-04-14', '', '', '', 'Non', 'Non', 'Oui', '', 'Soleil,Eclaircies', '200', 'Oui', 'Forte, plus de 25 abeilles', 153, 'Etablie', 'wasp', '', '', '', ''),
(6, 'asdasdasd', 6, '2021-04-14', '', '', '', 'Non', 'Non', 'Non', '', 'Soleil,Eclaircies', '1122', 'Non', 'Modérée, 10 à 25 abeilles', 158, 'Indéterminée', '', 'Ne sais pas', 'Ne sais pas', 'Ne sais pas', 'Ne sais pas'),
(7, 'working absolutely perfectly fine updated', 6, '2021-04-14', '', '', '', 'Non', 'Non', 'Non', '', 'Nuages,Vent,Pluie', '1122', 'Ne sais pas', 'Faible, 1 à 9 abeilles', 158, 'Fondatrice', '', 'Ne sais pas', 'Ne sais pas', 'Ne sais pas', 'Ne sais pas'),
(9, 'Test monitoring phone ', 5, '2021-07-26', '', '', '', 'Non', 'Non', 'Non', '', 'Eclaircies', '55', 'Oui', 'Forte, plus de 25 abeilles', 161, 'Fondatrice', '', '', '', '', ''),
(10, 'monitoring', 7, '2021-05-01', '', '', '', 'Oui', 'Non', 'Oui', '', 'Eclaircies', '3', 'Ne sais pas', 'Forte, plus de 25 abeilles', 169, 'Fondatrice', 'wasp', 'Non', 'Oui', 'Non', 'Oui'),
(11, '', 29, '2021-04-29', '', '', '', 'Oui', 'Non', 'Oui', '', 'Vent', '11', 'Oui', 'Modérée, 10 à 25 abeilles', 161, 'Fondatrice', 'wasp', '', '', '', ''),
(12, 'extra information', 14, '2021-04-29', '', '', '', 'Oui', 'Oui', 'Oui', '', 'Soleil,Eclaircies', '0900', 'Oui', 'Faible, 1 à 9 abeilles', 1, 'Fondatrice', 'wasp', '', '', '', ''),
(13, '', 52, '2021-04-29', '', '', '', 'Non', 'Non', 'Oui', '', 'Soleil', '44', 'Oui', 'Forte, plus de 25 abeilles', 161, 'Etablie', 'des blattes', '', '', '', ''),
(14, 'Yest', 53, '2021-05-01', '', '', '', 'Non', 'Non', 'Non', '', 'Eclaircies', '15', 'Oui', 'Faible, 1 à 9 abeilles', 159, 'Fondatrice', '', '', '', '', ''),
(15, '', 39, '2021-05-03', '', '', '', 'Non', 'Non', 'Oui', '', 'Eclaircies', '44', 'Oui', 'Modérée, 10 à 25 abeilles', 161, 'Fondatrice', 'a bumblebee', '', '', '', ''),
(16, 'extra information', 16, '2021-05-03', '', '', '', 'Oui', 'Oui', 'Oui', '', 'Soleil,Eclaircies', '1122', 'Oui', 'Faible, 1 à 9 abeilles', 158, 'Fondatrice', 'wasp', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_follow_images`
--

CREATE TABLE `tbl_follow_images` (
  `id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `follow_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_follow_images`
--

INSERT INTO `tbl_follow_images` (`id`, `file`, `follow_id`) VALUES
(1, '8678d46c5a72ab9706dba9347e1fa93b.PNG', 4),
(2, '462e688fbf450a91920d0c70ded015f9.PNG', 5),
(3, '5b9dd96c34fdb064a218c438d74088cb.png', 6),
(4, 'ee9f87cddcedaef96ce1173ada6168fd.png', 7),
(5, '32c576e094575640e15636e989c0ed48.jpg', 8),
(6, '1bf0544e4e8017106ac41c525e158f3c.png', 10),
(7, '684140d451c7f5a466c1e75f7fefb1c1.png', 12),
(8, '635a044a439a93398e19b8a017f3c27b.jpg', 14),
(9, 'ae6e074ac0a2a87144c9f4d1f7f89e23.jpg', 16);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loc`
--

CREATE TABLE `tbl_loc` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `additional_address` varchar(260) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(100) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `date` date DEFAULT NULL,
  `place` varchar(100) NOT NULL,
  `nesting_type` varchar(200) NOT NULL,
  `tree_genes` varchar(200) NOT NULL,
  `height` int(11) NOT NULL,
  `site_tree` varchar(50) NOT NULL,
  `tree_alive` varchar(20) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `pollen` varchar(20) NOT NULL,
  `temperature` int(11) NOT NULL,
  `weather_situation` varchar(300) NOT NULL,
  `detailed_information` text NOT NULL,
  `video` varchar(60) NOT NULL,
  `report_type` int(11) NOT NULL DEFAULT 0 COMMENT 'complete_form=0,simple_form=1',
  `flights` varchar(50) NOT NULL,
  `fight_with_workers` varchar(50) NOT NULL,
  `waste_wax` varchar(100) NOT NULL,
  `observation_date` date NOT NULL,
  `end_time_observation` time NOT NULL,
  `lon` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` varchar(50) NOT NULL,
  `uniqid` varchar(50) NOT NULL,
  `colonie_hauteur` varchar(50) NOT NULL,
  `colonie_dimension` varchar(50) NOT NULL,
  `orientation` varchar(50) NOT NULL,
  `shape` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `entries_exits` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro` int(11) NOT NULL DEFAULT 0,
  `state_region` varchar(255) NOT NULL,
  `findPro` varchar(50) NOT NULL,
  `type_of_colony` varchar(255) NOT NULL DEFAULT '0',
  `e_nesting_type_info` varchar(255) DEFAULT NULL,
  `subspecie` varchar(255) NOT NULL,
  `hide_location` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_loc`
--

INSERT INTO `tbl_loc` (`id`, `name`, `address`, `additional_address`, `city`, `postal_code`, `country`, `date`, `place`, `nesting_type`, `tree_genes`, `height`, `site_tree`, `tree_alive`, `activity`, `pollen`, `temperature`, `weather_situation`, `detailed_information`, `video`, `report_type`, `flights`, `fight_with_workers`, `waste_wax`, `observation_date`, `end_time_observation`, `lon`, `lat`, `timestamp`, `updated_at`, `uniqid`, `colonie_hauteur`, `colonie_dimension`, `orientation`, `shape`, `area`, `entries_exits`, `user_id`, `pro`, `state_region`, `findPro`, `type_of_colony`, `e_nesting_type_info`, `subspecie`, `hide_location`) VALUES
(7, 'Waseem afzal', 'Basti Khudadad, Multan, Punjab, Pakistan', '', NULL, '1622899346', '', '2021-06-05', 'Cavité naturelle', 'Arbre', '', 0, '', '', 'Forte, plus de 25 abeilles', 'Oui', 1122, 'Soleil,Eclaircies', 'information detials', '', 0, '', '', '', '0000-00-00', '00:00:00', '71.40915629999999', '30.1489555', '2021-06-05 13:22:26', '', '1622899346_7', '1122', '', '', '', '', '', 153, 0, '', '', '0', '', '', 'on'),
(8, 'haris javed', 'Basti Khudadad, Multan, Punjab, Pakistan', '', NULL, '1622900368', '', '2021-06-05', 'Cavité naturelle', 'Arbre', '', 0, '', '', 'Forte, plus de 25 abeilles', 'Oui', 1122, 'Soleil,Eclaircies', 'information details', '', 0, '', '', '', '0000-00-00', '00:00:00', '71.40915629999999', '30.1489555', '2021-06-05 13:39:28', '', '1622900368_8', '1122', '', '', '', '', '', 158, 0, '', '', '0', '', '', 'on'),
(9, 'hh heb', '110 Avenue de Paris, 94800 Villejuif, France', '', NULL, '94800', '', '2021-06-07', 'Cavité naturelle', 'Chemineé', '', 0, '', '', 'Forte, plus de 25 abeilles', 'Oui', 4, 'Eclaircies', 'test', '', 0, '', '', '', '0000-00-00', '00:00:00', '2.3651202', '48.7992052', '2021-06-07 09:42:16', '', '94800_9', '3', '', '', '', '', '', 159, 0, '', 'on', '0', '', '', 'off'),
(10, 'Hacene Hebbar', '110 Avenue de Paris, 94800 Villejuif, France', '', NULL, '94800', '', '2021-06-07', 'Cavité naturelle', 'Chemineé', '', 0, '', '', 'Modérée, 10 à 25 abeilles', 'Oui', 2, 'Eclaircies', 'Test', '', 0, '', '', '', '0000-00-00', '00:00:00', '2.3651202', '48.7992052', '2021-06-07 09:47:55', '', '94800_10', '12', '', '', '', '', '', 170, 0, '', 'on', '0', '', '', 'on'),
(11, 'Basile Soltner', '54 Rue de Rivoli, Paris, France', '', NULL, '75004', '', '2021-06-07', 'A l\'air libre', 'Chemineé', '', 0, '', '', 'Modérée, 10 à 25 abeilles', 'Oui', 4, 'Soleil', 'test hidden address', '', 0, '', '', '', '0000-00-00', '00:00:00', '2.353702', '48.857091', '2021-06-07 11:13:55', '', '75004_11', '1', '', '', '', '', '', 167, 0, '', '', '0', '', '', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_map_images`
--

CREATE TABLE `tbl_map_images` (
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=image,1=video mp4',
  `map_id` int(11) NOT NULL COMMENT 'here inserting pk of tbl_loc and also prototype_form',
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_map_images`
--

INSERT INTO `tbl_map_images` (`file`, `type`, `map_id`, `id`) VALUES
('a5fd7ae0acc8f343a5c90f7c34f70692.jpg', 0, 11, 12),
('62888fb0c884bafec16e58c041c75625.jpg', 0, 10, 11),
('943c48acf3a2b2beebf09910ee59da46.PNG', 0, 9, 10),
('e2e36ffe492e18bb248c1433339ff777.jpg', 0, 8, 9),
('b43f567c8db06bc47e168f23fb266292.jpg', 0, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sidebarcontent`
--

CREATE TABLE `tbl_sidebarcontent` (
  `id` int(11) NOT NULL,
  `cms_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'noimg.png',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1,
  `resource_type` varchar(11) NOT NULL,
  `resource_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sidebarcontent`
--

INSERT INTO `tbl_sidebarcontent` (`id`, `cms_id`, `title`, `description`, `url`, `start_date`, `end_date`, `image`, `created_on`, `status`, `resource_type`, `resource_id`) VALUES
(3, 7, 'Hello test dgs hdaks hdksajdh kas hdjsad', '', 'https://www.youtube.com/watch?v=anTzPInhewI&list=RDtDCLbuUpURM&index=2', '', '', '98341e0f13a64466fa60e2e315fb3a37.jpg', '2020-02-18 15:37:51', 1, '', 0),
(4, 7, 'Heddddddddddddddddddddd', '', 'http://locntent/edit/4/?cms_id=7', '', '', '1ebda7aedfac603646480566702d6c93.jpg', '2020-02-18 15:43:14', 1, '', 0),
(5, 7, 'dddd', '', 'https://www.skillsquared.com/freelancers', '', '', 'b86e8b5c74d0936141a1260eed28d78e.jpg', '2020-02-18 15:47:24', 1, '', 0),
(6, 7, 'Heddddddddddddddddddddd', '', 'view-source:http://localhost/cpxglobal/sidebarcontent/edit/4/?cms_id=7', '', '', '84e4b0c50b6bc18d5c058bde879b2e53.jpg', '2020-02-18 15:49:22', 1, '', 0),
(7, 1, 'fffffffffffffffffff', '', 'ww.google.com/search?sxsrf=ACYBGNQKhtaNyXhEKmH-Wbt', '', '', 'a025b6009ed4a5b17bbf7190d12c91fa.jpg', '2020-02-18 15:51:23', 1, '', 0),
(8, 1, 'dasdasdas', '', 'https://www.skillsquared.com/stagingss/freelancers', '', '', '25d5f31a69b9fc047d18d8d90598f29d.jpg', '2020-02-18 18:26:01', 1, '', 0),
(9, 3, 'fdsfsfsdfsdf', '', 'https://www.skillsquared.com/stagingss/freelancers', '', '', '241b27f5b367cb38045f773921eda7ae.jpg', '2020-02-18 18:27:02', 1, '', 0),
(10, 9, 'award', '', '', '', '', 'cfff4568781af8f7f8c9843d2ae55bb7.jpg', '2020-02-25 11:39:01', 1, '', 0),
(11, 9, 'Advertising & PR', '', '', '', '', '973780f0abb3337b79e23b37295ae078.jpg', '2020-02-25 11:39:22', 1, '', 0),
(12, 21, 'CYLINDER QUALITY MANAGEMENT', '', '', '', '', '731afcab5ca00c1e85aebe251a9f0f3e.jpg', '2020-02-26 13:02:08', 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertype`
--

CREATE TABLE `tbl_usertype` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` longtext NOT NULL DEFAULT '0' COMMENT '0=by this user will get  the list of all users who want to change the user type,1=admin has accept the user type , 2=admin has cancel the usertype',
  `previous_usertype` longtext NOT NULL,
  `want_usertype` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_usertype`
--

INSERT INTO `tbl_usertype` (`id`, `userid`, `status`, `previous_usertype`, `want_usertype`) VALUES
(1, 158, '1', '5', '3'),
(2, 158, '2', '3', '4'),
(3, 158, '2', '3', '4'),
(4, 158, '2', '3', '4'),
(5, 158, '2', '3', '4'),
(6, 158, '2', '3', '4'),
(7, 158, '1', '3', '4'),
(8, 159, '0', '5', '4'),
(9, 159, '0', '5', '4'),
(10, 159, '0', '5', '4'),
(11, 167, '0', '4', '5'),
(12, 167, '0', '4', '3'),
(13, 161, '0', '4', '3'),
(14, 161, '0', '4', '3'),
(15, 161, '0', '4', '5'),
(16, 158, '0', '5', '3');

-- --------------------------------------------------------

--
-- Table structure for table `trans_language`
--

CREATE TABLE `trans_language` (
  `id` int(11) NOT NULL,
  `tkey` varchar(255) DEFAULT NULL,
  `english` longtext NOT NULL,
  `french` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `cat_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_language`
--

INSERT INTO `trans_language` (`id`, `tkey`, `english`, `french`, `created_at`, `cat_id`) VALUES
(1, 'search', 'Search', 'Rechercher', '2021-03-04 06:22:01', 1),
(2, 'reporting', 'Reporting', 'Signalisation', '2021-03-04 06:24:01', 1),
(3, 'register', 'Registration', 'Inscription', '2021-03-04 06:25:07', 1),
(4, 'login', 'Log in\r\n', 'Connexion', '2021-03-04 06:25:54', 1),
(5, 'profile', 'Profile', 'Profil', '2021-03-04 06:26:47', 1),
(6, 'signout', 'Sign out\r\n', 'Se déconnecter', '2021-03-04 06:27:27', 1),
(7, 'register_now', 'Register now\r\n', 'S\'inscrire', '2021-03-04 06:42:13', 2),
(8, 'fname', 'First name\r\n', 'Prénom', '2021-03-04 06:42:48', 2),
(9, 'lname', 'Last name\r\n', 'Nom de famille', '2021-03-04 06:43:27', 2),
(10, 'your_email', 'Your email\r\n', 'Votre e-mail', '2021-03-04 06:44:23', 2),
(11, 'password', 'Password\r\n', 'Mot de passe', '2021-03-04 06:45:05', 2),
(12, 'terms_conditions', 'I accept the terms and conditions\r\n', 'J\'accepte les termes et conditions', '2021-03-04 06:46:23', 2),
(13, 'profile_pic', 'Profile picture\r\n', 'Photo de profil', '2021-03-04 06:46:58', 2),
(14, 'choose_profile', 'Choose File', 'Choisir le fichier\r\n', '2021-03-04 06:48:10', 2),
(15, 'submit', 'Submit', 'Soumettre', '2021-03-04 06:49:11', 2),
(16, 'have_an_account', 'Already have an account?\r\n', 'Vous avez déja un compte?', '2021-03-04 06:49:56', 2),
(17, 'you_are', 'You are\r\n', 'Vous êtes', '2021-03-04 07:20:13', 2),
(18, 'referent', 'Referent', 'Référent', '2021-03-04 07:21:02', 2),
(19, 'particular', 'Particular', 'Particulier', '2021-03-04 07:23:32', 2),
(20, 'log_in', 'Log in\r\n', 'S\'identifier', '2021-03-04 07:33:56', 2),
(21, 'mobile', 'please enter your phone / mobile\r\n', 'Veuillez entrer votre téléphone / mobile', '2021-03-04 07:37:16', 2),
(22, 'enter_address', 'Please enter your address\r\n', 'Veuillez entrer votre adresse', '2021-03-04 07:38:20', 2),
(23, 'start_session', 'START YOUR SESSION\r\n', 'COMMENCEZ VOTRE SESSION', '2021-03-04 07:46:46', 3),
(24, 'connection_identifier', 'Connection identifier\r\n', 'Identifiant de connexion', '2021-03-04 07:47:31', 3),
(25, 'pwd', 'Password', 'Mot de passe', '2021-03-04 07:48:30', 3),
(26, 'remember_username', 'Remember my username\r\n', 'Se souvenir de mes identifiants', '2021-03-04 07:49:40', 3),
(27, 'forgot_password', 'Forgot your password?', 'Mot de passe oublié?', '2021-03-04 07:50:20', 3),
(28, 'login_', 'Log in\r\n', 'Log in\r\n', '2021-03-04 07:51:24', 3),
(29, 'reporting_title', 'Full reporting\r\n', 'Signalement Complet\r\n', '2021-03-04 08:13:14', 4),
(30, 'reporting_sub_title', 'Thank you for your help in reporting nesting sites of wild swarms of bees.\r\n\r\nFor a follow-up or a modification of a site already reported, please click on the Search tab in order to select the site to be followed and to carry out the modifications on the site in question.\r\n\r\nOtherwise, this form allows a first report (with in option more detailed information on the site and the entry of the nest with an update of the Canteneur Study (1978)  and the collection of other complementary information allowing a better follow-up later.\r\n\r\nFor any mandatory section indicated by *, please do not hesitate to indicate \"I don\'t know\" if there is no answer to the question.  ', 'Merci pour votre aide dans le signalement de sites de nidification d\'essaims sauvages d\'abeilles.\r\nPour un Suivi ou une modification de site déjà signalé, merci de cliquer sur l\'onglet Recherche afin de selectionner le site à suivre et d\'effectuer les modifications sur le site visé.\r\nSinon, ce formulaire permet un premier signalement (avec en option  des informations plus détaillées sur le site et l\'entrée du nid avec réactualisation de l\'Etude de Canteneur (1978)  et la récolte d\'autres informations complémentaires permettant un meilleur suivi ultérieur.\r\nPour toute section obligatoire indiquée par *, n\'hésitez pas à indiquer \"Je ne sais pas\" en cas d\'absence de réponse à la question. ', '2021-03-04 08:16:38', 4),
(31, 'address', 'Location', 'Localisation', '2021-03-04 08:19:29', 4),
(32, 'date', 'Date ', 'Date ', '2021-03-04 08:20:23', 4),
(33, 'date_title', 'Indicate the date of discovery of the swarm\r\n', 'Indiquer la date de découverte de l\'essaim', '2021-03-04 08:22:46', 4),
(34, 'colonie_title', 'Colony in natural, artificial or open-air cavities', 'Colonie en cavité naturelle, artificielle ou à l\'air libre', '2021-03-04 08:26:48', 4),
(35, 'colonie_sub_title', 'Indicate whether the colony has settled in a natural, artificial or open-air cavity.', 'Indiquer si la colonie s\'est installée dans une cavité naturelle, artificielle ou à l\'air libre', '2021-03-04 08:28:03', 4),
(36, 'colonie1', 'Natural cavity', 'Cavité naturelle', '2021-03-04 08:29:09', 4),
(37, 'orientatio_sub_title', 'Indicate the approximate direction in which the entrance to the nest is facing.\r\n\r\n', 'Indiquer la direction approximative vers laquelle l\'entrée du nid est orientée\r\n', '2021-03-04 08:29:31', 4),
(38, 'colonie3', 'In the open air', 'A l\'air libre', '2021-03-04 08:30:04', 4),
(39, 'Nord', 'North', 'Nord', '2021-03-04 08:45:35', 4),
(40, 'orientation2', 'SOUTH', 'SUD', '2021-03-04 08:45:58', 4),
(41, 'orientation3', 'EAST', 'EST', '2021-03-04 08:46:20', 4),
(42, 'orientation4', 'WEST', 'OUEST', '2021-03-04 08:46:36', 4),
(43, 'complement', 'END OF COMPLEMENT SECTION\r\n', 'FIN SECTION COMPLEMENT\r\n', '2021-03-04 08:47:31', 4),
(44, 'form', 'Entrance: Shape ', 'Entrée : Forme \r\n', '2021-03-04 08:53:38', 0),
(45, 'form_sub_title', 'Indicate the shape of the nest entrance e.g. round, oval, slit, etc.\r\n', 'Indiquer la forme de l\'entrée du nid Ex: ronde, ovale, fente, etc.\r\n\r\n', '2021-03-04 08:54:01', 0),
(46, 'entrance', 'Entrance: Entrance area (cm2) ', 'Entrée : Surface de l\'entrée (cm2) ', '2021-03-04 08:54:50', 0),
(47, 'entrance_sub_title', 'Indicate the approximate area of the entrance to the nesting site. Cf. explanatory sheet for the method of measuring the entrance area.', 'Indiquer la surface approximative de l\'entrée du site de nidification. Cf. Fiche explicative de méthode de mesure de la surface de l\'entrée\r\n\r\n', '2021-03-04 08:55:18', 0),
(48, 'pollen', 'Pollen :\r\n', 'Pollen :\r\n\r\n', '2021-03-04 08:56:06', 0),
(49, 'pollen_sub_title', 'If you can, indicate whether the bees observed at the entrance carry pollen balls on their hind legs.\r\n', 'Si vous le pouvez, indiquez si les abeilles observées à l\'entrée portent des pelotes de pollen sur les pattes arrière\r\n', '2021-03-04 08:57:15', 0),
(50, 'pollen1', 'Yes', 'Oui', '2021-03-04 08:57:42', 0),
(51, 'pollen2', 'No', 'Non', '2021-03-04 08:58:04', 0),
(52, 'pollen3', 'Don\'t Know', 'Ne Sais Pas', '2021-03-04 08:58:32', 0),
(53, 'activity', 'Activity', 'Activité\r\n', '2021-03-04 08:59:18', 4),
(54, 'activity_sub_title', 'Indicate the intensity of swarm activity by counting the number of bees flying in front of the entrance of the swarm at a time over a 30 second observation period.', 'Indiquer l\'intensité de l\'activité de l\'essaim, en comptant le nombre d\'abeilles volant à la fois devant l\'entrée de l\'essaim, sur une période de 30 secondes d\'observation', '2021-03-04 09:00:04', 4),
(55, 'activity1', 'Strong (more than 25 bees)', 'Forte, plus de 25 abeilles', '2021-03-04 09:00:39', 4),
(56, 'activity2', 'Moderate (10 to 25 bees)', 'Modérée, 10 à 25 abeilles', '2021-03-04 09:01:28', 0),
(57, 'activity3', 'Low (1 to 9 bees)', 'Faible, 1 à 9 abeilles', '2021-03-04 09:01:54', 0),
(58, 'activity4', 'I don\'t know', 'Ne Sais Pas', '2021-03-04 09:02:47', 0),
(59, 'temperature', 'Temperature (°C)\r\n', 'Température (°C)\r\n', '2021-03-04 09:03:21', 0),
(60, 'temperature_sub_title', 'Indicate even the approximate temperature during the observation.', 'Indiquer la température même approximative qu\'il faisait pendant l\'observation\r\n', '2021-03-04 09:03:54', 0),
(61, 'conditions', 'Meteorological conditions', 'Conditions météorologiques', '2021-03-04 09:04:23', 0),
(62, 'conditions_sub_title', 'Indicate which of these conditions were met\r\n', 'Indiquer lesquelles de ces conditions étaient réunies\r\n', '2021-03-04 09:04:57', 0),
(63, 'conditions1', 'Sun', 'Soleil', '2021-03-04 09:05:24', 0),
(64, 'conditions2', 'Lightening', 'Éclaircies', '2021-03-04 09:05:40', 0),
(65, 'conditions3', 'Clouds', 'Nuages', '2021-03-04 09:05:56', 0),
(66, 'conditions4', 'Rain', 'Pluie', '2021-03-04 09:06:59', 0),
(67, 'conditions5', 'Wind', 'Vent', '2021-03-04 09:08:45', 0),
(68, 'information', 'Detailed information\r\n\r\n', 'Informations détaillées\r\n\r\n', '2021-03-04 09:10:14', 4),
(69, 'photos', 'ADD PHOTOS OR VIDEOS ', 'AJOUTER DES PHOTOS OU DES VIDÉOS \r\n', '2021-03-04 09:14:34', 4),
(70, 'photos_sub_title', 'Add photos of the swarm and the environment in which the swarm is located', 'Ajouter des photos de l\'essaim et de l\'environnement dans lequel se trouve l\'essaim', '2021-03-04 09:15:04', 4),
(71, 'contact', 'Contact for removal Swabbing\r\n', 'Mise en contact pour enlèvement Essaim\r\n', '2021-03-04 09:18:55', 4),
(72, 'contact_sub_title', 'A list of contacts with beekeepers wishing to recover a swarm will be proposed to you if necessary. You authorise us to take note of your contact details to put you in touch.', 'Une liste de contacts avec des apiculteurs désireux de récupérer un essaim vous sera proposé le cas-échéant. Vous autorisez la prise de connaissance de vos coordonnées pour la mise en contact.', '2021-03-04 09:19:17', 4),
(73, 'entree', 'GET IN TOUCH', 'ENTRER EN CONTACT\r\n', '2021-03-04 09:20:05', 4),
(74, 'colonie2', 'Artificial cavity', 'Cavité artificielle', '2021-03-04 11:19:57', 0),
(75, 'nidification', 'Type of support', 'Type de support', '2021-03-04 11:21:33', 4),
(76, 'nidification1', 'Tree', 'Arbre', '2021-03-04 11:23:43', 4),
(77, 'nidification2', 'Fireplace', 'Cheminée ', '2021-03-04 11:24:53', 4),
(78, 'nidification3', 'Cliff', 'Falaise', '2021-03-04 11:25:21', 4),
(79, 'nidification4', 'Roofing', 'Toiture', '2021-03-04 11:25:43', 4),
(80, 'nidification_sub_title', 'Indicate the type of colony support, i.e. nesting site. Ex: Tree, chimney, cliff, etc.', 'Indiquer le type de support de la colonie, i.e. site de nidification.Ex: Arbre, cheminée, falaise, etc.', '2021-03-04 11:27:13', 4),
(81, 'height', 'Entrance to the colony: Height (m)', 'Entrée de la colonie : Hauteur (m)', '2021-03-04 11:29:14', 4),
(82, 'height_sub_title', 'Indicate the approximate height at which the entrance to the colony is located.', 'Indiquer la hauteur approximative à laquelle se trouve l\'entrée de la colonie\r\n', '2021-03-04 11:29:38', 4),
(83, 'dimension', 'Entrance : Dimension (cm)\r\n', 'Entrée : Dimension (cm)', '2021-03-04 11:31:07', 4),
(84, 'dimension_sub_title', 'Indicate the diameter or the longest length, approximately, of the nest entrance (or the lowest if there are several).\r\n', 'Indiquer le diamètre ou la plus grande longueur, approximativement, de l\'entrée du nid (ou de la plus basse s’il y en a plusieurs)', '2021-03-04 11:31:24', 4),
(85, 'orientation', 'Orientation of the nest entrance :', 'Orientation de l\'entrée du nid :\r\n', '2021-03-04 11:43:43', 4),
(86, 'Nord Est', 'North East', 'Nord Est', '2021-03-04 11:48:17', 4),
(87, 'Est', 'East', 'Est', '2021-03-04 11:48:58', 4),
(88, 'Sud', 'South', 'Sud', '2021-03-04 11:49:31', 4),
(89, 'Sud Ouest', 'South West\r\n', 'Sud Ouest', '2021-03-04 11:50:01', 4),
(90, 'Ouest', 'West\r\n', 'Ouest', '2021-03-04 11:50:52', 4),
(91, 'Nord Ouest', 'North West', 'Nord Ouest', '2021-03-04 11:52:42', 4),
(92, 'activity5', 'Null (0 bees)', 'Nulle, 0 abeilles', '2021-03-04 12:07:36', 4),
(93, 'flights', 'Are the flights in a straight line?', 'Les vols se font-ils en ligne droite ?', '2021-03-04 12:25:41', 4),
(94, 'flights1', 'Yes', 'Oui', '2021-03-04 12:28:03', 4),
(95, 'oui', 'Yes', 'Oui', '2021-03-04 12:28:12', 4),
(96, 'yes', 'Yes', 'Oui', '2021-03-04 12:28:25', 4),
(97, 'no', 'No', 'Non', '2021-03-04 12:29:13', 4),
(98, 'fight', 'Is there a fight between the workers?\r\n', 'Y a-t-il combat entre les ouvrières ?', '2021-03-04 12:31:52', 4),
(99, 'waste_wax', 'Is there waste wax in front of the entrance or on the ground?\r\n', 'Y a-t-il des déchets de cire devant l\'entrée ou au sol?', '2021-03-04 12:32:42', 4),
(100, 'dont_know', 'I Don\'t Know\r\n', 'Ne sais pas', '2021-03-04 13:46:25', 0),
(101, 'search_criteria', 'Search Criteria\r\n', 'Critères de recherche\r\n', '2021-03-05 05:38:53', 5),
(102, 'address_search', 'Address', 'Adresse', '2021-03-05 05:39:50', 5),
(103, 'within_radius', 'Within a radius of (km):\r\n', 'Dans un rayon de (km) :', '2021-03-05 05:41:51', 5),
(104, 'site_code', 'Site code\r\n', 'Code du site', '2021-03-05 05:42:44', 5),
(105, 'site_followed', 'Site monitored by\r\n', 'Site suivi par', '2021-03-05 05:45:04', 5),
(106, 'site_type', 'Type of support:', 'Type de support:', '2021-03-05 05:46:03', 5),
(107, 'site_type1', 'TREE ', 'ARBRE POLLEN', '2021-03-05 05:52:28', 5),
(108, 'site_type2', 'Rock cavity\r\n', 'Cavité rocheuse', '2021-03-05 05:53:20', 5),
(109, 'site_type3', 'Other', 'Autre', '2021-03-05 05:53:56', 5),
(110, 'site_type4', 'Every type\r\n', 'Tout type', '2021-03-05 05:54:37', 5),
(111, 'colonie_search', 'State of the colony\r\n', 'Etat de la colonie\r\n', '2021-03-05 05:56:26', 5),
(112, 'colonie_search1', 'Founder', 'Fondatrice', '2021-03-05 05:57:41', 5),
(113, 'colonie_search2', 'Established', 'Etablie', '2021-03-05 05:58:03', 5),
(114, 'colonie_search3', 'Indeterminate', 'Indéterminée', '2021-03-05 05:58:24', 5),
(115, 'removal_reqiest', 'View removal requests\r\n', 'Voir les demandes d\'enlèvement', '2021-03-05 05:59:20', 5),
(116, 'between', 'Between the :\r\n', 'Entre le :', '2021-03-05 06:00:17', 5),
(117, 'and_the', 'And the:\r\n', 'Et le:', '2021-03-05 06:00:57', 5),
(118, 'submit_search', 'Submit', 'Envoyer', '2021-03-05 06:02:09', 5),
(119, 'nest_btn', 'Find a nest\r\n', 'Rechercher un nid', '2021-03-05 06:03:21', 5),
(120, 'nest', 'nest', 'nids', '2021-03-05 06:05:06', 5),
(121, 'site_code_modal', 'Code:', 'Code:	', '2021-03-05 06:09:41', 6),
(122, 'date_nest_modal', 'Date', 'Date', '2021-03-05 06:10:27', 6),
(123, 'name_nest_modal', 'Name:', 'Nom:', '2021-03-05 06:11:49', 6),
(124, 'address_nest_modal', 'Address:', 'Adresse:', '2021-03-05 06:12:38', 6),
(125, 'law_nest_modal', 'Site:', 'Site:', '2021-03-05 06:14:14', 6),
(126, 'site_nest_modal', 'Support:', 'Support:', '2021-03-05 06:15:04', 6),
(127, 'complement_nest_modal', 'COMPLEMENTARY STUDY\r\n', 'COMPLEMENT ETUDE', '2021-03-05 06:16:01', 6),
(128, 'tree_info_nest_modal', 'Tree Information:\r\n', 'Information Arbre:', '2021-03-05 06:16:59', 6),
(129, 'height_nest_modal', 'Height (m):\r\n', 'Hauteur (m) :', '2021-03-05 06:17:56', 6),
(130, 'circumference_nest_modal', 'Trunk circumference (cm):\r\n', 'Circonférence du tronc (cm) :', '2021-03-05 06:18:34', 6),
(131, 'living_tree_nest_modal', 'Living tree:\r\n', 'Arbre vivant:', '2021-03-05 06:19:21', 6),
(132, 'entry_nest_modal', 'NEST ENTRY\r\n', 'ENTREE DU NID', '2021-03-05 06:20:16', 6),
(133, 'colony_height_nest_modal', 'Height (m):\r\n', 'Hauteur (m) :', '2021-03-05 06:20:54', 6),
(134, 'dimension_nest_modal', 'Dimension (cm):\r\n', 'Dimension (cm) :', '2021-03-05 06:21:51', 6),
(135, 'form_nest_modal', 'Form:', 'Forme:', '2021-03-05 06:23:28', 6),
(136, 'entrance_nest_modal', 'Entrance surface:\r\n', 'Surface de l\\\'entrée:', '2021-03-05 06:24:45', 6),
(137, 'complement_section_nest_modal', 'END OF STUDY COMPLEMENT SECTION\r\n', 'FIN SECTION COMPLEMENT ETUDE\r\n', '2021-03-05 06:25:46', 6),
(138, 'colony_nest_modal', 'Colony:', 'Colonie:', '2021-03-05 06:27:59', 6),
(139, 'observation_nest_modal', 'Observations in front of the site\r\n', 'Observations devant le site', '2021-03-05 06:30:16', 6),
(140, 'flights_nest_modal', 'Are the flights in a straight line?\r\n', 'Les vols se font-ils en ligne droite ?', '2021-03-05 06:31:00', 6),
(141, 'fights_nest_modal', 'Is there a fight between the workers?\r\n', 'Y a-t-il combat entre les ouvrières ?', '2021-03-05 06:32:14', 6),
(142, 'wax_nest_modal', 'Is there waste wax in front of the entrance or on the floor?\r\n', 'Y a-t-il des déchets de cire devant l\'entrée ou au sol?', '2021-03-05 06:33:12', 6),
(143, 'entries_nest_modal', 'Are there entries / exits of hornets or wasps?\r\n', 'Y a-t-il des entrées/sorties de frelons ou de guêpes ?', '2021-03-05 06:33:50', 6),
(144, 'activity_nest_modal', 'Activity:', 'Activité:', '2021-03-05 06:34:54', 6),
(145, 'temperature_nest_modal', 'T°', 'T°', '2021-03-05 06:35:52', 6),
(146, 'weather_forcast_nest_modal', 'Weather:\r\n', 'Météo:', '2021-03-05 06:36:42', 6),
(147, 'details_nest_modal', 'Details', 'Détails ', '2021-03-05 06:37:20', 6),
(148, 'update_nest_modal', 'Update :\r\n', 'Mis à jour : ', '2021-03-05 06:39:00', 6),
(149, 'previous', 'Previous', 'Précédent ', '2021-03-05 06:42:40', 6),
(150, 'next', 'Next', 'Suivant ', '2021-03-05 06:43:42', 6),
(151, 'site_monitor', 'SITE ACTIVITY MONITORING\r\n', 'SUIVI ACTIVITÉ DU SITE', '2021-03-05 07:30:15', 5),
(152, 'height_m', 'Height (m) :', 'Hauteur (m) :', '2021-03-05 07:41:35', 5),
(153, 'observer_date', 'Next observation', 'A venir\r\n', '2021-03-05 07:44:16', 5),
(154, 'new_observation', 'New observation\r\n', 'Nouvelle observation', '2021-03-05 07:45:16', 5),
(155, 'faded', 'Disappeared', 'Disparu', '2021-03-05 07:48:06', 5),
(156, 'busy', 'Occupied', 'Occupée', '2021-03-05 07:51:24', 5),
(157, 'info', 'info', 'Infos', '2021-03-05 07:52:12', 5),
(158, 'media', 'Media', 'Media', '2021-03-05 07:52:51', 5),
(159, 'actions', 'Actions', 'Actions', '2021-03-05 07:53:30', 5),
(160, 'first_observation', 'First observation\r\n', 'Première observation', '2021-03-05 07:57:32', 5),
(161, 'must_login', 'You must first login to access this page!\r\n', 'Vous devez d\'abord vous connecter pour accéder à cette page!', '2021-03-05 07:59:23', 5),
(162, 'suivi', 'MONITORING', 'SUIVI', '2021-03-05 08:27:12', 7),
(163, 'suivi_title', 'Thank you for your help in tracking wild bee swarm nesting sites.\r\n\r\n          For mandatory information marked by for which you do not know the answer, indicate \"I do not know\".', 'Merci pour votre aide dans le suivi des sites de nidification d\'essaims sauvages d\'abeilles.\r\n\r\n          Pour les renseignements obligatoires signalés par dont vous ne connaissez pas la réponse, indiquez \"Je ne sais pas\".', '2021-03-05 08:31:37', 7),
(164, 'suivi_sub_title', 'Indicate the intensity of the salt\'s activity, by counting the number of bees flying in front of the salt entrance at a time over a 30 second observation period.\r\n', 'Indiquer l\'intensité de l\'activité de l\'essaim, en comptant le nombre d\'abeilles volant à la fois devant l\'entrée sur une période de 30 secondes d\'observation', '2021-03-05 08:33:06', 0),
(165, 'swarm_disappear', 'Has the swarm disappeared?\r\n', 'L\'essaim a-t-il disparu ?', '2021-03-05 08:49:53', 0),
(166, 'cavity_suive', 'Is the cavity occupied by another species?\r\n', 'La cavité est-elle occupée par une autre espèce ?', '2021-03-05 08:50:52', 0),
(167, 'specify_suive', 'Can you specify which one?\r\n', 'Pouvez-vous préciser laquelle ?', '2021-03-05 08:52:21', 0),
(168, 'info_suive', 'Other information\r\n', 'Autres Informations', '2021-03-05 08:53:25', 0),
(169, 'addtional_info', 'Please indicate here any additional information\r\n', 'Merci d\'indiquer ici toute information complémentaire\r\n', '2021-03-05 08:54:19', 0),
(170, 'next_date', 'Date of next scheduled observation\r\n', 'Date de la prochaine observation prévue', '2021-03-05 08:55:06', 0),
(171, 'next_observation', 'Indicate the next desired observation date\r\n', 'Indiquer la prochaine date d\'observation souhaitée', '2021-03-05 08:55:41', 0),
(172, 'photos_sub_title_suivi', 'upload one or more images / videos\r\n', 'télécharger une ou plusieurs images / vidéos', '2021-03-05 08:56:56', 0),
(173, 'swarm_photos', 'Add photos of the swarm and the environment in which the swarm is located\r\n', 'Ajouter des photos de l\'essaim et de l\'environnement dans lequel se trouve l\'essaim', '2021-03-05 08:57:45', 0),
(174, 'choose', 'Choose', 'Choisir', '2021-03-05 13:44:37', 0),
(175, 'Institution', 'Institution', 'Institution', '2021-03-08 12:42:06', 0),
(176, 'bee_keeper', 'Was it picked up by a beekeeper?\r\n', 'A-t-il été récupérée par un apiculteur?', '2021-03-08 13:24:20', 7),
(177, 'entries_exist', 'Are there entries / exits of hornets or wasps?', 'Y a-t-il des entrées/sorties de frelons ou de guêpes ?', '2021-03-11 07:05:52', 4),
(178, 'height_reporting', 'Height (m):', 'Hauteur (m):', '2021-03-11 07:34:35', 4),
(179, 'height_sub_title_reporting', 'Indicate the approximate height of the tree in meters.', 'Indiquer la hauteur approximative de la colonie en mètres .', '2021-03-11 07:35:34', 4),
(184, 'height_sub_title_anchor', 'Cf. Explanatory sheet of height measurement method', 'Cf. Fiche explicative de méthode de mesure de la hauteur', '2021-03-16 09:07:09', 0),
(180, 'circumference_sub_title', 'Indicate the approximate trunk circumference in cm, measuring the trunk at chest height', 'Indiquer la circonférence approximative du tronc en cm, en mesurant le tronc à hauteur de poitrine', '2021-03-11 07:38:07', 4),
(181, 'tree_alive', 'Is the tree alive?', 'L\'arbre est-il vivant ?', '2021-03-11 07:39:27', 4),
(182, 'tree_alive_sub_title', 'Indicate whether the tree is alive or not, if you are able to find out\r\n', 'Indiquer si l\'arbre est vivant ou non, si vous êtes en mesure de le savoir', '2021-03-11 07:41:16', 4),
(183, 'Sud Est', 'South East\r\n', 'Sud Est', '2021-03-16 08:00:42', 4),
(185, 'nidification5', 'Other', 'Autre', '2021-03-16 10:32:19', 0),
(186, 'tree_genes', 'Circumference of the trunk (cm)', 'Circonférence du tronc (cm)', '2021-03-17 06:14:39', 0),
(187, 'tree_genes_sub_title', 'Indicate the approximate circumference of the trunk\r\nin cm, by measuring the trunk at chest height.\r\n', 'Indiquer la circonférence approximative du tronc en\r\ncm, en mesurant le tronc à hauteur de poitrine', '2021-03-17 06:15:37', 0),
(189, 'success', 'Operation performed successfully', 'Opération effectuée avec succès', '2021-03-18 11:52:51', 0),
(188, 'specify_nidification', 'Indiquer le type de support', 'Spécifier le type de support', '2021-03-17 13:11:14', 4),
(190, 'submit_reporting', 'Send', 'Envoyer', '2021-03-26 06:41:25', 4),
(191, 'support', 'Support:', 'Support:', '2021-03-26 14:18:04', 0),
(192, 'name_suivi', 'Name', 'Nom', '2021-03-26 14:25:16', 7),
(193, 'activity_suivi', 'Activity', 'Activité ', '2021-03-26 14:26:25', 7),
(194, 'Pollen_suivi', 'Pollen', 'Pollen', '2021-03-26 14:26:57', 7),
(195, 'weather_suivi', 'Weather', 'Météo', '2021-03-26 14:27:52', 7),
(196, 'dont_know_val', 'I don\'t know', 'ne sais pas', '2021-03-31 14:50:57', 0),
(197, 'picked_up_beekeeper', 'Picked up?', 'Enlevé?', '2021-04-02 07:55:14', 7),
(198, 'cavity_suive_modal', 'Occupied?', 'Occupé?', '2021-04-06 08:36:07', 6),
(199, 'specify_suive_modal', 'By which?', 'Par qui?', '2021-04-06 08:40:49', 6),
(200, 'operation', 'Are you sure for this operation?', 'Etes-vous sûr de cette opération?', '2021-04-08 12:49:34', 0),
(201, 'email_btn', 'Nest details', 'Détails du nid', '2021-04-08 13:06:07', 0),
(202, 'enter_message', 'Click here to enter a message\r\n', 'Cliquez ici pour saisir un message', '2021-04-08 13:24:28', 0),
(203, 'contact_pro', 'Contact', 'Contacter ', '2021-04-08 13:26:32', 0),
(204, 'check_weather', 'Meteorological conditions field is required', 'Le champ des conditions météorologiques est obligatoire', '2021-04-09 11:53:03', 0),
(205, 'no_data_found', 'No data found', 'Aucune donnée disponible\r\n', '2021-04-12 08:48:33', 0),
(206, 'pest_control_users', 'Pest control users', 'Desinsectiseur users', '2021-04-12 08:50:25', 0),
(207, 'forgot_your_password', 'Forgot your password', 'Mot de passe oublié', '2021-04-12 09:05:36', 0),
(208, 'to_close', 'Close\r\n', 'Fermer', '2021-04-12 09:09:39', 0),
(209, 'submit_forget', 'submit', 'soumettre', '2021-04-12 09:12:22', 0),
(210, 'forgot_recover_pwd', 'Forgotten Password', 'Mot de passe oublié\r\n', '2021-04-12 09:47:51', 0),
(211, 'click_link_recover_pwd', 'Click on the link below to recover a password\r\n', 'Cliquez sur le lien ci-dessous pour récupérer un mot de passe', '2021-04-12 09:51:33', 0),
(212, 'forgot_pwd_link_send', 'Forgot password Link send your email\r\n', 'Mot de passe oublié Lien envoyer votre email', '2021-04-12 09:52:41', 0),
(213, 'problem_sending_mail', 'problem sending mail\r\n', 'problème d\'envoi de courrier', '2021-04-12 09:54:06', 0),
(214, 'go_to_registration', 'Go to registration unable to find your account\r\n', 'Accédez à l\'inscription impossible de trouver votre compte', '2021-04-12 09:55:30', 0),
(215, 'error', 'Error: Unable to do. Please try again later', 'Erreur: impossible à faire. Veuillez réessayer plus tard', '2021-04-13 16:46:05', 0),
(216, 'newpassword', 'New Password', 'Nouveau mot de passe', '2021-04-13 16:59:29', 0),
(217, 'confirmpassword', 'Confirm the password', 'Confirmez le mot de passe', '2021-04-13 17:01:54', 0),
(218, 'changepassword', 'Change Password', 'Changer le mot de passe', '2021-04-13 17:03:50', 0),
(219, 'bio', 'Bio', 'Bio', '2021-04-13 18:55:00', 0),
(220, 'site_tree', 'Sub-specie', 'Sous-espece', '2021-04-13 20:49:23', 0),
(221, 'subspecie', 'Sub-specie', 'Sous-espece', '2021-04-13 20:55:34', 0),
(222, 'ifreported', 'Check if a nest has been reported within a radius (m) of:', 'Vérifier si un nid a été signalé dans un rayon (m) de:', '2021-04-14 08:50:32', 0),
(223, 'suivi_monitor_btn', 'SITE ACTIVITY MONITORING\r\n', 'SUIVI ACTIVITE DU SITE', '2021-04-15 06:45:33', 0),
(224, 'verify_radius', 'Verify ', 'Vérifier ', '2021-04-15 07:00:54', 0),
(225, 'helptextradius', 'Please modify it if necessary or come back here to report this site', 'Merci de le modifier si besoin sinon revenir au Signalement', '2021-04-15 12:08:13', 4),
(226, 'required_message', 'This field is required', 'Ce champ est requis', '2021-04-17 06:47:30', 0),
(227, 'image_field', 'Image field required', 'Champ d\'image requis', '2021-04-19 13:34:04', 0),
(228, 'address_field', 'Address field required', 'Champ d\'adresse requis\r\n', '2021-04-19 13:36:08', 0),
(229, 'date_field', 'Date field required', 'Champ de date requis\r\n', '2021-04-19 13:37:22', 0),
(230, 'colonie_field', 'Colony field required', 'Champ de colonie requis\r\n', '2021-04-19 13:39:34', 0),
(231, 'height_field', 'Height field required', 'Champ de hauteur requis\r\n', '2021-04-19 13:42:35', 0),
(232, 'type_support_field', 'Type of support required', 'Champ de type de support requis', '2021-04-19 13:47:38', 0),
(233, 'pollen_field', 'Pollen field required', 'Champ de pollen requis', '2021-04-19 13:53:07', 0),
(234, 'activity_field', 'Activity field is required', 'Le champ d\'activité est obligatoire\r\n', '2021-04-19 13:55:49', 0),
(235, 'temperature_field', 'Temperature field is required', 'Le champ de température est obligatoire\r\n', '2021-04-19 13:56:43', 0),
(236, 'detailed_information_field', 'Detailed information field required', 'Champ d\'informations détaillées requis\r\n', '2021-04-19 13:57:37', 0),
(237, 'refresh_page', 'Please refresh your browser in order to continue and allow your location.', 'Veuillez actualiser votre navigateur pour continuer et autoriser votre position.\r\n', '2021-04-21 08:41:48', 0),
(238, 'colonie_hauter', 'Colony height field required', 'Champ Colonie hauteur requis\r\n', '2021-04-22 17:33:08', 0),
(249, 'subject_msg', 'User want to change his user type', 'L\'utilisateur souhaite modifier son type d\'utilisateur\r\n\r\n', '2021-05-27 08:46:33', 0),
(239, 'flight', 'flights field required', 'champ de vols requis\r\n', '2021-04-22 19:51:59', 0),
(240, 'fight_with_workers', 'fight with workers field required', 'lutte avec le champ des travailleurs requis\r\n', '2021-04-22 19:53:46', 0),
(241, 'waste_wax_field', 'waste wax field required', 'champ de cire de rebut requis\r\n', '2021-04-22 19:57:27', 0),
(242, 'entries_exits_field', 'Entries exits field required', 'Champ de sortie des entrées requis\r\n', '2021-04-22 19:58:27', 0),
(243, 'weather_situation_field', 'weather situation field required', 'champ de situation météorologique obligatoire\r\n', '2021-04-23 08:48:07', 0),
(244, 'please_add_radius', 'Please enter the radius!', 'Veuillez saisir le rayon!', '2021-05-22 08:33:15', 0),
(245, 'no_nest_found', 'No nests have yet been reported in this radius.', 'Aucun nid n\'a déjà été signalé dans ce rayon.', '2021-05-22 08:38:06', 0),
(246, 'submit_radius', 'Submit', 'Soumettre', '2021-05-24 08:13:28', 0),
(247, 'hide_location', 'Hide exact location', 'Cacher la localisation exacte', '2021-05-24 14:56:30', 0),
(248, 'hide_location_label', 'Exact address will only be visible for Referents and Institutions', 'L\'adresse exacte ne sera connue que des Référents et Institutions pour le suivi et les études.', '2021-05-24 14:57:08', 0),
(250, 'msg_mail', 'wants to change his user type from', 'veut changer son type d\'utilisateur de', '2021-05-27 08:51:04', 0),
(251, 'block_mail_msg', 'if you want to block him please click on this link', 'if you want to block him please click on this link', '2021-05-27 08:51:46', 0),
(252, 'block_label_msg', 'Block', 'Bloquer', '2021-05-27 08:54:46', 0),
(253, 'rejected_request', 'Sorry your request for change user type has not accepted', 'Désolé, votre demande de changement de type d\'utilisateur n\'a pas été acceptée', '2021-05-27 08:57:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1=super admin,2=admin,3=Pro user,4=Normal user',
  `username` varchar(255) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'noimg.png',
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL COMMENT 'mobile or cell number',
  `address` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `uniq_id` varchar(255) NOT NULL,
  `cover` varchar(500) NOT NULL DEFAULT 'noimg.png',
  `device_id` varchar(255) NOT NULL,
  `devicetype` varchar(255) NOT NULL,
  `social_id` varchar(255) NOT NULL,
  `social_type` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT 1,
  `ip_address` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `timezone` varchar(500) NOT NULL,
  `age` int(11) NOT NULL,
  `about` longtext NOT NULL,
  `player_id` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `online` int(11) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `referal_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `user_type`, `username`, `name`, `email`, `image`, `phone`, `mobile`, `address`, `website`, `uniq_id`, `cover`, `device_id`, `devicetype`, `social_id`, `social_type`, `added_by`, `active`, `ip_address`, `password`, `salt`, `remember_code`, `created_on`, `last_login`, `timezone`, `age`, `about`, `player_id`, `latitude`, `longitude`, `online`, `activation_code`, `referal_code`) VALUES
(1, '', '', 1, '', 'admin', 'admin@flb.com', '1441e351a764a3101c8941604f830672.jpg', '', NULL, '', '', '5d91b28ea286e', 'noimg.png', '', '', '', '', 1, 1, '127.0.0.1', '$2y$08$o9XFDISHmj6WplNgr8mJMO9qNWR6PeNSqkKkEQrALsENjSD/WhxZy', NULL, NULL, 1503419297, 1622275824, '', 0, '', '', '', '', 0, '', ''),
(153, 'Waseem', 'afzal', 4, 'waseemafzal31@gmail.com', 'Waseem afzal', 'waseemafzal31@gmail.com', '2617a49398bc4370e2b56ebddad2d7fa.jpg', '', NULL, 'Peer Colony Multan, Punjab, Pakistan', '', '', 'noimg.png', '', '', '', '', 0, 1, '182.186.36.141', '$2y$08$AG8/rDCgk0SK5XGGK/gYgu1wQ8Dzc6pyZJDrcDH0KPYuJLLNXLsxG', NULL, NULL, 1618208612, 1622976642, '', 0, '', '', '30.159602099999997', '71.40848489999999', 1, '60bca9949f395', '60bca9949f3b8'),
(154, 'Waseem', 'afzal', 4, 'was@gmail.com', 'Waseem afzal', 'was@gmail.com', 'noimg.png', '03417090031', NULL, 'xyz', '', '', 'noimg.png', '', '', '', '', 0, 1, '182.186.36.141', '$2y$08$eRpmX5Xv2lkHPndUyD6hFe5m01GeVMpX75EpAK1yWjZ1mHg2ayTLq', NULL, NULL, 1618334050, NULL, '', 0, 'Web developer', '', '', '', 0, '6075d162064df', '6075d162064e2'),
(155, 'CEO', 'afzal', 3, 'ceo.cyphersol@gmail.com', 'CEO afzal', 'ceo.cyphersol@gmail.com', '9ba290eab18b1aa230e343b3c632e072.PNG', '', NULL, 'multan pakistan', '', '', 'noimg.png', '', '', '', '', 0, 1, '182.186.36.141', '$2y$08$rA6VhBig8Mu3irOrKE3eX.yUphhq2D/JMduT.PRtrBImfPPZ0vBNi', NULL, NULL, 1618337846, 1623059928, '', 0, 'Web developer', '', '48.7988809', '2.3645385', 0, '60bdef2631e35', '60bdef2631e47'),
(156, 'hacene', 'hebbar', 3, 'hacene@pollinis.org', 'hacene hebbar', 'hacene@pollinis.org', '28bb4a7aa7c8e4a75eb91a30c59b0b24.jpg', '00000000000', NULL, '49 Rue Jean Jacques Rousseau, 94800 Villejuif, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '88.127.22.57', '$2y$08$w2gScuD2br7fYJB724Vejuoc9UQCFD1gAOptwHeOxSnzMSv0NRaYa', NULL, NULL, 1618353523, 1622796072, '', 0, 'test', '', '48.7993769', '2.3643575', 1, '60b9e688bfe37', '60b9e688bfe3d'),
(157, 'M', 'afzal', 3, 'mobiledev@gmail.com', 'M afzal', 'mobiledev@gmail.com', 'noimg.png', '03417090031', NULL, 'Bahawalpur, Pakistan', '', '', 'noimg.png', '', '', '', '', 0, 1, '182.186.36.141', '$2y$08$GctRdRHw0G9C4yQilAcg8eCE11Z4ibdmNPuIaxYYx0x2p0nXbLePy', NULL, NULL, 1618382603, NULL, '', 0, 'mobile app develop', '', '29.35435', '71.69106599999999', 0, '60768f0baf175', '60768f0baf17b'),
(158, 'haris', 'javed', 4, 'mharis.javed1996@gmail.com', 'haris javed', 'mharis.javed1996@gmail.com', 'noimg.png', '', NULL, 'khudadad colony ward#10 sher shah road multan', '', '', 'noimg.png', '', '', '', '', 0, 1, '182.186.36.141', '$2y$08$k2kFHnzuNDpTS72pUgHDTewNeB7q4NGCvUwaRkTLntK4IfDjF/G.u', NULL, NULL, 1618383955, 1622994408, '', 0, 'bio', '', '30.159953399999996', '71.4655449', 0, '60bb7f77e69cb', '60bb7f77e69ce'),
(159, 'hh', 'heb', 5, 'flb@pollinis.org', 'hh heb', 'flb@pollinis.org', '347129aacfb2b171df911d701d270053.jpg', '', NULL, '110 Bis Avenue de Paris, 94800 Villejuif, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '88.127.22.57', '$2y$08$D7ZIDi6pBLsjKTiIS7sAgOGKQxLtHMC9bBlanaRxrJaBoodTrQ.tu', NULL, NULL, 1618393676, 1623058860, '', 0, '', '', '48.7990119', '2.3647715', 0, '60bdedb14a0a4', '60bdedb14a0e2'),
(160, 'H', 'Heb', 4, 'flb1@pollinis.org', 'H Heb', 'flb1@pollinis.org', 'noimg.png', '0000', NULL, '110 Bis Avenue de Paris, 94800 Villejuif, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '88.127.22.57', '$2y$08$E/HvQ/HqmH7bONpe74d55eJoUZ.XA5Ml7RqtDdjq2zdFK7IKHMGau', NULL, NULL, 1618393718, 1618484343, '', 0, '', '', '48.7990202', '2.3654326', 1, '6076ba7631b0d', '6076ba7631b10'),
(161, 'Basile', 'Soltner', 5, 'basile.soltner@etu-iepg.fr', 'Basile Soltner', 'basile.soltner@etu-iepg.fr', '6a5d67169aff1f0067f8721117a3b6c8.jpg', '', NULL, 'Paris, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '77.197.171.110', '$2y$08$2qvfJKnTjBcGJDjw0x5vi.C0q.e25pB38EdTp.ya9RZPFyuzO9EXO', NULL, NULL, 1618394988, 1623064462, '', 0, 'Basile as an institution', '', '48.8833024', '2.3625727999999997', 1, '60be0589f33aa', '60be0589f33bc'),
(162, 'Paolo', 'Fontana', 4, 'paolo_api.fontana@fmach.it', 'Paolo Fontana', 'paolo_api.fontana@fmach.it', 'cf951ccc727378262c8be9799b124b38.jpg', '3358359262', NULL, 'Via Marconi, 49', '', '', 'noimg.png', '', '', '', '', 0, 1, '80.182.208.11', '$2y$08$5oMqus5G1hyX6SP97n83Vu0vXoSDPSRJ.R.58xRZYlbgUPUBpTh5m', NULL, NULL, 1618554106, 1618554266, '', 0, '', '', '45.62817279999999', '11.4440394', 1, '60792cf85f63a', '60792cf85f63d'),
(163, 'aqib ', 'haris', 3, 'aqib@yahoo.com', 'aqib  haris', 'aqib@yahoo.com', 'noimg.png', '03013806559', NULL, 'Peer Colony Multan, Punjab, Pakistan', '', '', 'noimg.png', '', '', '', '', 0, 1, '182.186.36.141', '$2y$08$TU74T/4eo.zirf7vwdBF..tK.itgGFVYRa04JffXax3LvYAGQDIXq', NULL, NULL, 1618554710, NULL, '', 0, 'bio', '', '30.1576141', '71.4685247', 0, '60792f56b354e', '60792f56b3551'),
(164, 'haris', 'javed', 3, 'haris1122@yahoo.com', 'haris javed', 'haris1122@yahoo.com', 'noimg.png', '03013806559', NULL, 'khudadad colony ward#10 sher shah road multan, nil', '', '', 'noimg.png', '', '', '', '', 0, 1, '182.186.99.228', '$2y$08$zU9MLQenv5RwSIZV9lO/2em89d80UhUuYZiUqbrUK0yW2NIN9MnHO', NULL, NULL, 1618830400, 1618831421, '', 0, 'bio', '', '30.07360869999999', '71.1804988', 1, '607d6440135cd', '607d6440135d0'),
(165, 'Simon', 'Soltner', 5, 'simon.soltner@gmail.com', 'Simon Soltner', 'simon.soltner@gmail.com', 'noimg.png', '', NULL, 'Saint-Ismier, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '88.123.116.230', '$2y$08$sR24jhscPR1jws/skQ9ZV.T3VVoAjWFxWIHL3snW6OAFUBRpgwz/W', NULL, NULL, 1619178196, 1619178201, '', 0, 'Hey Hey', '', '', '', 0, '6082b33be1151', '6082b33be1179'),
(166, 'Vincent', 'Albouy', 3, 'vincent-albouy@orange.fr', 'Vincent Albouy', 'vincent-albouy@orange.fr', 'noimg.png', '0546918113', NULL, '13 Chemin des Melles, 17350 Annepont, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '82.125.60.15', '$2y$08$JJkmtDpzk0WaHtcnQpAP7Ouk/OtdkdB751BhdB1VWcBCkcydvJBlW', NULL, NULL, 1619497764, 1619497792, '', 0, '', '', '45.8290119', '-0.5999607', 0, '60879324086c2', '60879324086c5'),
(167, 'Basile', 'Soltner', 5, 'basiles@pollinis.org', 'Basile Soltner', 'basiles@pollinis.org', 'noimg.png', '', NULL, '189 Chemin de Buttit, 38330 Saint-Ismier, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '88.123.116.230', '$2y$08$IfrivqA.D8lzByvRl.96u.ofpwRCIJIKfvrUXs.1MirqmNQjkB10C', NULL, NULL, 1619507198, 1623064268, '', 0, '', '', '48.8833024', '2.3625727999999997', 0, '60bdff1ebb003', '60bdff1ebb011'),
(168, 'karin', 'maassen', 4, 'custosapium@gmail.com', 'karin maassen', 'custosapium@gmail.com', 'c60dc4da8a9013aa5370d8b0bb4fb9d4.jpg', '0652038766', NULL, 'Creuse, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '37.166.137.226', '$2y$08$XE26luUtdNogGWEgIJ2CgesNkVRtmikniG5uqWXCV/D/uSILZwfsS', NULL, NULL, 1619512171, 1619597667, '', 0, '', '', '49.83891', '2.163534', 1, '6087cb6b787ee', '6087cb6b787f2'),
(169, 'HH', 'HHUK', 5, 'contactuk@geonest.org', 'HH HHUK', 'contactuk@geonest.org', '2a1010d7852404f587928d04c02d61ec.jpg', '', NULL, '110 Bis Avenue de Paris, 94800 Villejuif, France', '', '', 'noimg.png', '', '', '', '', 0, 1, '88.127.22.57', '$2y$08$83VCEJuvQGuF4oAEFOZy..y4zy34l6FD1hIzkiT4g/Cf46FkCzLYS', NULL, NULL, 1619522745, 1622024767, '', 0, 'Test Ref UK', '', '30.159953399999996', '71.4655449', 1, '60ade8699172b', '60ade8699173a'),
(170, 'Hacene', 'Hebbar', 4, 'hacene.hebbar@gmail.com', 'Hacene Hebbar', 'hacene.hebbar@gmail.com', 'acdbd1ba08405e6eb19af0122f9f2041.jpg', '0612121266', NULL, '51rue Jj Rousseau', '', '', 'noimg.png', '', '', '', '', 0, 1, '88.127.22.57', '$2y$08$BAhCiJXI0zSI2ki2V/mpM.1nD.9jWDAswuA3mri8AIicX.Xit/CHK', NULL, NULL, 1621849561, 1623058949, '', 0, '', '', '48.7990202', '2.3654326', 1, '60ab75d9e7135', '60ab75d9e7139');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_rights`
--

CREATE TABLE `users_rights` (
  `id` int(11) NOT NULL,
  `group_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `add_users` int(11) NOT NULL,
  `edit_users` int(11) NOT NULL,
  `delete_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_rights`
--

INSERT INTO `users_rights` (`id`, `group_title`, `add_users`, `edit_users`, `delete_users`) VALUES
(1, 'SUPER ADMIN', 1, 1, 1),
(2, 'ADMIN', 1, 1, 0),
(3, 'PRO USER', 0, 0, 0),
(4, 'NORMAL USER', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_routes`
--
ALTER TABLE `app_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogpost_comments`
--
ALTER TABLE `blogpost_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgot_session`
--
ALTER TABLE `forgot_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leprojects`
--
ALTER TABLE `leprojects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leprojects_comments`
--
ALTER TABLE `leprojects_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prototypeform`
--
ALTER TABLE `prototypeform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabl_language_category`
--
ALTER TABLE `tabl_language_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_follow`
--
ALTER TABLE `tbl_follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_follow_images`
--
ALTER TABLE `tbl_follow_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_loc`
--
ALTER TABLE `tbl_loc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_map_images`
--
ALTER TABLE `tbl_map_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sidebarcontent`
--
ALTER TABLE `tbl_sidebarcontent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_usertype`
--
ALTER TABLE `tbl_usertype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_language`
--
ALTER TABLE `trans_language`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tkey` (`tkey`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `users_rights`
--
ALTER TABLE `users_rights`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_routes`
--
ALTER TABLE `app_routes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `blogpost`
--
ALTER TABLE `blogpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `blogpost_comments`
--
ALTER TABLE `blogpost_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forgot_session`
--
ALTER TABLE `forgot_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leprojects`
--
ALTER TABLE `leprojects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leprojects_comments`
--
ALTER TABLE `leprojects_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prototypeform`
--
ALTER TABLE `prototypeform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabl_language_category`
--
ALTER TABLE `tabl_language_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_follow`
--
ALTER TABLE `tbl_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_follow_images`
--
ALTER TABLE `tbl_follow_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_loc`
--
ALTER TABLE `tbl_loc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_map_images`
--
ALTER TABLE `tbl_map_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_sidebarcontent`
--
ALTER TABLE `tbl_sidebarcontent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_usertype`
--
ALTER TABLE `tbl_usertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `trans_language`
--
ALTER TABLE `trans_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_rights`
--
ALTER TABLE `users_rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
