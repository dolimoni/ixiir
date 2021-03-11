<?php

	if(!isset($_SESSION["lang"]))

	{

		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

		$str_lang="en";

		if($lang=="fr"){$str_lang="fr";}

		if($lang=="ar"){$str_lang="ar";}

		$_SESSION["lang"]=$str_lang;

	}

	if(rqstprm("lang")=="ar" || rqstprm("lang")=="fr" || rqstprm("lang")=="en"){$_SESSION["lang"]=rqstprm("lang");}



	function get_label($str_label="")

	{

		$tblang["lbl_descr_login"]=array("On IXIIR, meet only people like you, from the same specialty, or from the same city or even family. To communicate and exchange interests, experiences, and also emotions.", "مرحبا على IXIIR، هنا يجتمع فقط أشخاص من أمثالك، من نفس التخصص أو نفس المدينة أو حتى الأسرة. للتواصل وتقاسم التجارب والخبرات والمشاعر.",

							  "Sur IXIIR, ne rencontrer que des gens comme vous, du même spécialité, ou du même ville ou même famille encore. Pour communiquer et échanger des intérêts, des expériences, et aussi des émotions.");

		$tblang["lbl_login"]=array("Login", "تسجيل الدخول", "Se connecter");

		$tblang["lbl_login_btn"]=array("Register and publish", "سجل و انشر", "S'inscrire et publier");

		$tblang["lbl_sinscrit"]=array("register", "التسجيل", "S'inscrire");

		$tblang["lbl_msg_login_err_bloquer"]=array("Your account is disabled, You do not have access to your account. Please contact the system administrator !!!", "ليس لديك إذن للوصول إلى حسابك. يرجى الاتصال بمسؤول النظام!", "Votre compte est désactivé, Vous n'avez pas d'autorisation d'accès à votre compte. Merci de contacter l'administrateur système !!!");

		$tblang["lbl_msg_login_err_authentf"]=array("Username or password is incorrect", "اسم المستخدم أو كلمة المرور غير صحيحة", "Nom d'utilisateur ou mot de passe est incorrecte");

		$tblang["lbl_aucunresultat"]=array("No posts found", "لا توجد مشاركات", "Aucun post trouvé");

		$tblang["lbl_befirstposthere"]=array("Be the first to post in your section", "كن أول من يتفضل بالنشر في هذا القسم", "Soyez le premier à poster dans votre section");

		$tblang["lbl_msgerrnoselectprof"]=array("Please first specify your city, trade and specialty to direct you to your requests.", "الرجاء تحديد مدينتك مهنتك واختصاصك لتلبية طلباتك", "Veuillez préciser d'abord votre ville, métier et spécialité pour vous diriger versvos demandes.");

		$tblang["lbl_quisomenous"]=array("Who are we ?", "من نحن", "Qui-somme nous ?");

		$tblang["lbl_quisomenoudesc_p1"]=array("We are a website that seeks above all to serve the human being.", "نحن موقع يسعى أولا وقبل كل شيء إلى خدمة الإنسان", "Nous sommes un site web qui cherche avant tout à servir l'être humain.");

		$tblang["lbl_quisomenoudesc_p2"]=array("By allowing people from every specialty, profession, city or family ... to come together and meet.", "من خلال تمكين أهل كل تخصص أو مهنة أو مدينة أو حتى عائلة.. من التجمع والتلاقي", "En permettant les gens de chaque spécialité, profession, ville ou encore famille… de se rassemblent et réunissent.");

		$tblang["lbl_quisomenoudesc_p3"]=array("To share experiences, knowledge, and the possibility of Creativity .. Or for discussion and debate on what is of public interest.", "ومن تم إمكانية جديدة لتبادل الخبرات والتجارب والمعرفة والعطاء أكثر أو التداول والنقاش حول الصالح العام", "Pour partager des expériences, des connaissances, et la possibilité de La créativité.. Ou pour discussion et débat sur ce qui est d'intérêt public.");

		$tblang["lbl_quisomenoudesc_p4"]=array("Or to strengthen and strengthen family ties.", "أو تقوية وتدعيم الترابط العائلي والأسري", "Ou pour consolider et renforcer les liens familiaux.");

		$tblang["lbl_condition_utilisation"]=array("Terms of use", "شروط الاستخدام", "Conditions d'utilisation");

		$tblang["lbl_volezdelpost"]=array("Do you want to delete the post?", "هل تريد حذف المشاركة؟", "Est ce que vous voulez supprimer le post ?");

		$tblang["lbl_volezcontinue"]=array("Do you want to continue this operation?", "هل تريد متابعة هذه العملية ؟", "Est ce que vous voulez continuer cette opération ?");

		$tblang["lbl_rechercher"]=array("Search", "بحت", "Rechercher");

		$tblang["lbl_foi"]=array("time", "مرة", "foi");

		$tblang["lbl_fois"]=array("times", "مرات", "fois");

		$tblang["lbl_chargerplus"]=array("Load more ...", "حمل المزيد...", "Charger plus...");

		$tblang["lbl_nomutilisateur"]=array("Username", "إسم المستخدم", "Nom d'utilisateur");

		$tblang["lbl_password"]=array("Password", "كلمة السر", "Mot de passe");

		$tblang["lbl_se_souvenir_moi"]=array("Remember me", "يتذكرني", "Se souvenir de moi");

		$tblang["lbl_mot_passe_oublie"]=array("Forgot your password ?", "هل نسيت كلمة المرور؟", "Mot de passe oublié ?");

		$tblang["lbl_connexion_via_reseau_soc"]=array("Connection via social networks", "الاتصال عبر الشبكات الاجتماعية", "Connexion via réseau sociaux");

		$tblang["lbl_connexion_facebook"]=array("Login via Facebook", "تسجيل الدخول عبر الفيسبوك", "Connexion via Facebook");

		$tblang["lbl_connexion_googleplus"]=array("Login via google", "تسجيل الدخول عبر جوجل", "Connexion via google");

		$tblang["lbl_nom"]=array("Family name", "الاسم العائلي", "Nom de famille");

		$tblang["lbl_prenom"]=array("First name", "الاسم الشخصي", "Prénom");

		$tblang["lbl_pays"]=array("Country", "بلد", "Pays");

		$tblang["lbl_ville"]=array("City", "مدينة", "Ville");

		$tblang["lbl_villes"]=array("Cities", "مدن", "Villes");

		$tblang["lbl_repeter_mot_passe"]=array("Repeat password", "كرر كلمة المرور", "Répéter le mot de passe");

		$tblang["lbl_yes_acepcondi"]=array("Yes, I understand and agree <a href='[[PARAM]]'> working conditions </a>.", "نعم ، أفهم وأوافق على <a href='[[PARAM]]'>شروط العمل</a>", "Oui, je comprends et accepte <a href='[[PARAM]]' >les conditions de travail</a>.");

		$tblang["lbl_copyright"]=array("Copyright [[PARAM1]], [[PARAM2]] all rights reserved - Develop by [[PARAM3]]", "حقوق الطبع والنشر [[PARAM1]] ، [[PARAM2]] جميع الحقوق محفوظة - تطوير بواسطة [[PARAM3]]", "Copyright [[PARAM1]], [[PARAM2]] tous droits réservés");

		$tblang["lbl_email"]=array("E-mail", "البريد الإلكتروني", "E-mail");

		$tblang["lbl_searchpost"]=array("Find a job", "ابحث عن مقال", "Rechercher un poste");

		$tblang["lbl_masquer"]=array("Hide", "إخفاء", "Masquer");

		$tblang["lbl_non_masquer"]=array("No hide", "غير مخفي", "Non masquer");

		$tblang["lbl_urlyoutube"]=array("Enter the link of the video youtube", "أدخل رابط الفيديو يوتيوب", "Entrez le lien de la video youtube");

		$tblang["lbl_partager"]=array("Share", "مشاركة", "Partager");

		$tblang["lbl_partager_sur"]=array("Share on", "شارك على", "Partager sur");

		$tblang["lbl_copylien"]=array("Copy link", "نسخ الرابط", "Copier le lien");

		$tblang["lbl_mes_posts"]=array("My posts", "مشاركاتي", "Mes posts");

		$tblang["lbl_les_posts"]=array("Posts", "المشاركات", "Les posts");

		$tblang["lbl_mes_messages"]=array("My messages", "رسائلي", "Mes messages");

		$tblang["lbl_modifier_mon_profil"]=array("Edit my profile", "تحرير ملف التعريف الخاص بي", "Modifier mon profil");

		$tblang["lbl_logout"]=array("Sign out", "تسجيل الخروج", "Se déconnecter");

		$tblang["lbl_ma_famille"]=array("My family", "عائلتي", "Ma famille");

		$tblang["lbl_mon_domaine"]=array("My field", "مجالي", "Mon domaine");

		$tblang["plus"]=array("More", "المزيد", "Voir Plus");

		$tblang["lbl_mon_metier"]=array("My job", "وظيفتي", "Mon métier");

		$tblang["lbl_ma_ville"]=array("My city", "مدينتي", "Ma ville");

		$tblang["lbl_mon_pays"]=array("My country", "بلادي", "Mon pays");

		$tblang["lbl_monde"]=array("World", "أمتي", "Monde");

		$tblang["lbl_errservressay"]=array("An error occured, Please try again", "حدث خطأ ، يرجى المحاولة مرة أخرى", "Une erreur est survenue, Merci de réessayer à nouveau");

		$tblang["lbl_domaine"]=array("Field", "مجال", "Domaine");

		$tblang["lbl_specialite"]=array("Specialty", "تخصص", "Spécialité");

		$tblang["lbl_cmptinactive"]=array("Your account is disabled, if you want to activate it it is necessary to authenticate in 15 days", "تم تعطيل حسابك ، إذا كنت تريد تنشيطه ، فمن الضروري المصادقة خلال 15 يومًا", "Votre compte est désactivé, si vous voulez l'activer il se fait de s'authentifier dans 15 jours");

		$tblang["lbl_errorlorathent"]=array("An error occurred during authentication, please try again.", "حدث خطأ أثناء المصادقة ، يرجى المحاولة مرة أخرى.", "Une erreur est survenue lors d'authentification, merci de réessayer.");

		$tblang["lbl_cmntcmrch"]=array("How it works ?", "كيف يعمل؟", "Comment ça marche ?");

		$tblang["lbl_modifier"]=array("Edit", "تعديل", "Modifier");

		$tblang["lbl_supprimer"]=array("Remove", "حذف", "Supprimer");

		$tblang["lbl_commenter"]=array("Comment", "تعليق", "Commenter");

		$tblang["lbl_traitmntencour"]=array("Ongoing treatment", "المعالجة قيد التقدم", "Traitement en cours");

		$tblang["lbl_jaime"]=array("Like", "إعجاب", "J'aime");

		$tblang["lbl_commentaires"]=array("Comments", "تعليقات", "Commentaires");

		$tblang["lbl_commentaire"]=array("Comment", "تعليق", "Commentaire");

		$tblang["lbl_vues"]=array("Views", "عدد المشاهدات", "Vues");

		$tblang["lbl_vue"]=array("View", "رأي", "Vue");

		$tblang["lbl_plusprochvous"]=array("Closest to you", "الأقرب إليك", "Les plus proche de vous");

		$tblang["lbl_viewprofil"]=array("See the profile", "انظر الملف الشخصي", "Voir le profile");

		$tblang["lbl_comutilefficace"]=array("Useful and effective communication", "التواصل المفيد والفعال", "La communication utile et efficace");

		$tblang["lbl_restconnectenvr"]=array("Stay in touch with your environment", "ابق على اتصال مع بيئتك", "Restez en contact avec votre environnement");

		$tblang["lbl_annuler"]=array("Cancel", "إلغاء", "Annuler");

		$tblang["lbl_passconfwrng"]=array("Password and password confirmation are different", "كلمة المرور وتأكيد كلمة المرور مختلفة", "Le mot de passe et la confirmation du mot de passe sont différents");

		$tblang["lbl_emailexist"]=array("E-mail already exists.", "البريد الإلكتروني موجود مسبقا.", "E-mail existe déja.");

		$tblang["lbl_passincorect"]=array("The password is incorrect.", "كلمة المرور غير صحيحة.", "Le mot de pass est incorrect.");

		$tblang["lbl_mon_profil"]=array("My profile", "ملفي الشخصي", "Mon profil");

		$tblang["lbl_desactivacount"]=array("Disable Account", "تعطيل الحساب", "Désactiver le compte");

		$tblang["lbl_updatpictrprofil"]=array("Edit profile picture", "تحرير صورة الملف الشخصي", "Modifier l'image de profil");

		$tblang["lbl_savegard"]=array("Save", "حفظ", "Sauvegarder");

		$tblang["lbl_publier"]=array("Publish", "نشر", "Publier");

		$tblang["lbl_aprfexplicvoplai"]=array("Deepen your explanations, please", "تفسيراتك ، من فضلك", "Approfondissez vos explications, s'il vous plaît");

		$tblang["lbl_desactivmonacount"]=array("Deactivate my account", "توقيف حسابي", "Désactiver mon compte");

		$tblang["lbl_langue"]=array("Language", "لغة", "Langue");

		$tblang["lbl_exprimez_vous"]=array("Only one post every 12 hours","منشور واحد فقط كل 12 ساعة","Un seul poste toutes les 12 heures");

		$tblang["lbl_mot_cle"]=array("Word", "كلمة البحت", "Mot clé");

		$tblang["lbl_yourcmnt"]=array("Your comment", "تعليقك", "Votre commentaire");

		$tblang["lbl_resultpour"]=array("Result of", "نتائج البحت", "Résultat de");

		$tblang["lbl_allmsg"]=array("View all messages", "جميع الرسائل", "Voir tous les messages");

		$tblang["lbl_nomsg"]=array("No messages", "لا توجد رسائل", "Aucun messages");

		$tblang["lbl_envoyermessage"]=array("Send messages", "ارسل رسالة", "Envoyer un message");

		$tblang["lbl_message"]=array("Message", "الرسالة", "Message");

		$tblang["lbl_profil"]=array("Profil", "الملف الشخصي", "Profil");

		$tblang["lbl_msgoksendmsg"]=array("Message send", "لقد تم ارسال الرسالة", "Message envoyé !!!");

		$tblang["lbl_message_envoyer"]=array("Messages sent", "رسائل ارسلتها", "Messages envoyé");

		$tblang["lbl_famille"]=array("Family", "عائلة", "Famille");

		$tblang["lbl_lastpost"]=array("Latest publications", "اخر المنشورات", "Dernières publications");

		$tblang["lbl_mostineractive"]=array("Most interactive", "الأكثر تفاعلا", "Les plus interactifs");    

		$tblang["lbl_nbrvisit_page"]=array("Page visits", "زيارات الصفحة", "Visites de page");

		$tblang["lbl_abonne_fidele"]=array("Loyal followers", "المتابعون الأوفياء", "Abonnés fidèles");

		$tblang["lbl_nbrvueposts"]=array("Total posts views", "مجمل مشاهدات المنشورات", "Total d'affichages des posts");

		$tblang["lbl_ratepagepays"]=array("Page ranking in your country", "ترتيب الصفحة في بلدك", "Classement de page dans votre pays");

		$tblang["lbl_ratepageworld"]=array("Ranking of page in the world", "ترتيب الصفحة في العالم", "Classement de page dans le monde");

		$tblang["lbl_delsuivi"]=array("Unfollow", "إلغاء المتابعة", "Annuler le suivi");

		$tblang["lbl_suivi"]=array("follower", "متابع", "Suiveur");

		$tblang["lbl_suivis"]=array("Followers", "متابعون", "Suiveurs");

		$tblang["lbl_a"]=array("To", "إلى", "À");

		$tblang["lbl_nomobligatoire"]=array("The name of the person of destination is mandatory", "اسم الشخص المقصود إلزامي", "Le nom de personne de destination est obligatoire !!!");

		$tblang["lbl_repondere"]=array("Answer", "إجابة", "Réponde");

		$tblang["lbl_oldversion"]=array("The old version", "النسخة القديمة", "L'ancienne version");

		$tblang["lbl_connectToView"]=array("Please login to see more publications and to be able to post, comment, interact and reach out.", "يرجى تسجيل الدخول لرؤية المزيد من المنشورات وللتمكن من النشر والتعليق والتفاعل والتواصل", "Veuillez vous connecter pour voir plus de postes et pour pouvoir publier, commenter, interagir et contacter.");

		$tblang["lbl_msgForPostMstCnct"]=array("Register & publish", "سجل و انشر", "S'inscrire et publier");

		$tblang["lbl_voirPlus"]=array("See more", "رؤية المزيد", "Voir Plus");

		$tblang["lbl_autre"]=array("Other", "أخرى", "Autre");

		$tblang["lbl_maPage"]=array("My page", "صفحتي", "Ma page");

		$tblang["lbl_"]=array("", "", "");

        $tblang["lbl_income"]=array("Income", "الإيرادات", "Le revenu");
        $tblang["lbl_comments"]=array("The comments", "التعليقات", "Les commentaires");
		

		if(isset($tblang[$str_label]))

		{

			if($_SESSION["lang"]=="en"){return $tblang[$str_label][0];}

			if($_SESSION["lang"]=="ar"){return $tblang[$str_label][1];}

			if($_SESSION["lang"]=="fr"){return $tblang[$str_label][2];}

		}

		else{return $str_label;}

	}

?>