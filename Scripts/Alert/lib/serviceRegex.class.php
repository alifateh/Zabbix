<?php

class serviceRegex {

    public $reg = array();

    function __construct() {
        $reg = & $this->reg;

		// General
		$reg['bit']		= '^[01]$';
		$reg['counter']		= '^[0-9]$';	// TODO: check if '0' is necessary
		$reg['counter2']	= '^[1-9][0-9]?$';

			$reg['i_id']		= '[1-9][0-9]{0,10}';
		$reg['id']		= '^'.$reg['i_id'].'$';
		$reg['id_list']		= '^'.
					  $reg['i_id'].
					  '('.
						  ','.$reg['i_id'].
					  ')*'.
					  '$';
		$reg['id_csv']		= $reg['id_list'];

		// Melli Bank
			$reg['i_melli_branch']	= '[0-9]{1,4}';
		$reg['melli_branch']	= '^'.$reg['i_melli_branch'].'$';

			$reg['i_melli_time']	= '[0-9]{1,6}';
		$reg['melli_time']	= '^'.$reg['i_melli_time'].'$';

			$reg['i_melli_date']	= '[89][0-9]{5}';
		$reg['melli_date']	= '^'.$reg['i_melli_date'].'$';

			$reg['i_melli_part_trace']	= '[0-9a-zA-Z_]{5,8}';
		$reg['melli_part_trace']	= '^'.$reg['i_melli_part_trace'].'$';

		$reg['melli_trace']	= '^'.$reg['i_melli_date'].$reg['i_melli_part_trace'].'$';


		$reg['md5']		= '^[a-f0-9]{32}$';
		$reg['pincode']		= '^[1-9][0-9]{8}$';
		$reg['row_num']		= '^[0-9]{0,6}$';
		$reg['captcha']		= '^[0-9a-zA-Z]{5,8}$';
		$reg['calendar']	= '^[gj]$';

		$reg['job']		= '^[a-zA-Z]+$';
		$reg['job_text']	= '^.+$';

		// Date & Time
			$reg['i_year']		= '[0-9]{4}';
			$reg['i_month']		= '[0-9]{2}';
			$reg['i_day']		= '[0-9]{2}';
		$reg['year']		= '^'.$reg['i_year'].'$';
		$reg['month']		= '^'.$reg['i_month'].'$';
		$reg['day']		= '^'.$reg['i_day'].'$';

			$reg['i_date']		= $reg['i_year'].'-'.$reg['i_month'].'-'.$reg['i_day'];
		$reg['date']		= '^'.$reg['i_date'].'$';
		$reg['g_date']		= '^'.$reg['i_date'].'$';

			$reg['i_j_date']	= $reg['i_year'].'/'.$reg['i_month'].'/'.$reg['i_day'];
		$reg['j_date']		= '^'.$reg['i_j_date'].'$';

			$reg['i_hour']		= '[0-2]?[0-9]';
			$reg['i_minute']	= '[0-5]?[0-9]';
			$reg['i_second']	= '[0-5]?[0-9]';
		$reg['hour']		= '^'.$reg['i_hour'].'$';
		$reg['minute']		= '^'.$reg['i_minute'].'$';
		$reg['second']		= '^'.$reg['i_second'].'$';

			$reg['i_time']		= $reg['i_hour'].':'.$reg['i_minute'].':'.$reg['i_second'];
		$reg['time']		= '^'.$reg['i_time'].'$';

			$reg['i_datetime']	= $reg['i_date'].'[ \-]*'.'('.$reg['i_time'].')?';
		$reg['datetime']	= '^'.$reg['i_datetime'].'$';

			$reg['i_lang']		= '(en|fa)';
		$reg['lang']		= '^'.$reg['i_lang'].'$';



		/* FIXME
		$reg['year']	= '^(13|14|19|20)'.
							'[0-9]{2}'.
							'$';
		$reg['month']	= '^((0*[0-9])'.
							'|(1[0-2])'.
							')$';
		$reg['day']		= '^([0-2]?[0-9]'.
							'|3[0-1]'.
							')$';
		*/


		// ASCII Domain
			$reg['i_ascii_domtokken'] = '[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?';	// ASCII domain tokken
			$reg['i_ascii_gtld']	= '[a-zA-Z]{3,6}';				// gTLD
			$reg['i_ascii_cctld']	= '[a-zA-Z]{2}';				// ccTLD
			$reg['i_ascii_tld']	= '('.$reg['i_ascii_gtld'].
						  '|'.$reg['i_ascii_cctld'].
						  ')';
			// FIXME
			$reg['i_ascii_tld']	= '[a-zA-Z]{2,}';
			$reg['i_ascii_domaddr']	= '('.$reg['i_ascii_domtokken'].'\.){1,}'.$reg['i_ascii_tld'];
			$reg['i_ascii_domaddr_1']='('.$reg['i_ascii_domtokken'].'\.)'.$reg['i_ascii_tld'];

		$reg['ascii_domtokken']	= '^'.$reg['i_ascii_domtokken'].'$';
		$reg['ascii_tld']	= '^'.$reg['i_ascii_tld'].'$';
		$reg['ascii_domaddr']	= '^'.$reg['i_ascii_domaddr'].'$';
		$reg['ascii_domaddr_1']	= '^'.$reg['i_ascii_domaddr_1'].'$';

			$reg['i_ascii_domtokken_banned_1']	= '.*--.*';
			$reg['i_ascii_domtokken_banned']	= '('.$reg['i_ascii_domtokken_banned_1'].
								  ')';

		$reg['ascii_domtokken_banned']	= '^'.$reg['i_ascii_domtokken_banned'].'$';


		// IDN Domain
			$reg['i_idn_domtokken_letters']	= '[آاءأبپتثجچحخدذرزژسشصضطظعغفقکگلمنوؤهةیئيك]';
			$reg['i_idn_domtokken_digits']	= '[0123456789٠١٢٣٤٥٦٧٨٩۰۱۲۳۴۵۶۷۸۹]';
			$reg['i_idn_domtokken_others']	= '[-‌‍]';
			$reg['i_idn_domtokken_others_s']= '[-‌‍ ]';		// Allows SPACE

			$reg['i_idn_domtokken']	= $reg['i_idn_domtokken_letters'].
						  '('.
						  '('.$reg['i_idn_domtokken_letters'].
						  '|'.$reg['i_idn_domtokken_digits'].
						  '|'.$reg['i_idn_domtokken_others'].
						  ')*'.
						  $reg['i_idn_domtokken_letters'].
						  ')?';

			$reg['i_idn_domtokken_s']	= $reg['i_idn_domtokken_letters'].			// Allows SPACE
						  '('.
						  '('.$reg['i_idn_domtokken_letters'].
						  '|'.$reg['i_idn_domtokken_digits'].
						  '|'.$reg['i_idn_domtokken_others_s'].
						  ')*'.
						  $reg['i_idn_domtokken_letters'].
						  ')?';

			$reg['i_idn_tld']	= '('.'ایران'.')';

			$reg['i_idn_domaddr']	= '('.$reg['i_idn_domtokken'].'\.)+'.$reg['i_idn_tld'];
			$reg['i_idn_domaddr_s']	= '('.$reg['i_idn_domtokken_s'].'\.)+'.$reg['i_idn_tld'];	// Allows SPACE
			$reg['i_idn_domaddr_s_1']='('.$reg['i_idn_domtokken_s'].'\.)'.$reg['i_idn_tld'];	// Allows SPACE

		$reg['idn_domtokken']	= '^'.$reg['i_idn_domtokken'].'$';
		$reg['idn_domtokken_s']	= '^'.$reg['i_idn_domtokken_s'].'$';					// Allows SPACE

		$reg['idn_tld']		= '^'.$reg['i_idn_tld'].'$';
		$reg['idn_domaddr']	= '^'.$reg['i_idn_domaddr'].'$';

			$reg['i_idn_domtokken_banned_1'] = '.*--.*';
			$reg['i_idn_domtokken_banned']	= '('.$reg['i_idn_domtokken_banned_1'].
							  ')';

		$reg['idn_domtokken_banned']	= '^'.$reg['i_idn_domtokken_banned'].'$';

		// Unicode Domain
			$reg['i_unicode_domtokken']	= '('.$reg['i_ascii_domtokken'].
							  '|'.$reg['i_idn_domtokken'].
							  ')';

			$reg['i_unicode_domtokken_s']	= '('.$reg['i_ascii_domtokken'].			// Allows SPACE
							  '|'.$reg['i_idn_domtokken_s'].
							  ')';

			$reg['i_unicode_tld']		= '('.$reg['i_ascii_tld'].
							  '|'.$reg['i_idn_tld'].
							  ')';

			$reg['i_unicode_domaddr']	= '('.$reg['i_ascii_domaddr'].
							  '|'.$reg['i_idn_domaddr'].
							  ')';

			$reg['i_unicode_domaddr_s_1']	= '('.$reg['i_ascii_domaddr_1'].
							  '|'.$reg['i_idn_domaddr_s_1'].
							  ')';

		$reg['unicode_domtokken']	= '^'.$reg['i_unicode_domtokken'].'$';
		$reg['unicode_domtokken_s']	= '^'.$reg['i_unicode_domtokken_s'].'$';			// Allows SPACE

		$reg['unicode_domtokken_s_csv_nl']='^'.$reg['i_unicode_domtokken_s'].
						  '('."[,\n\r ]+".$reg['i_unicode_domtokken_s'].')*'.
						  '$';

		$reg['unicode_tld']		= '^'.$reg['i_unicode_tld'].'$';
		$reg['unicode_domaddr']		= '^'.$reg['i_unicode_domaddr'].'$';
		$reg['unicode_domaddr_s_1']	= '^'.$reg['i_unicode_domaddr_s_1'].'$';

		$reg['unicode_domaddr_s_1_csv_nl']='^'.$reg['i_unicode_domaddr_s_1'].
						  '('."[,\n\r ]+".$reg['i_unicode_domaddr_s_1'].')*'.
						  '$';

		$reg['unicode_dom_addr_or_tokken']	= '('.$reg['unicode_domtokken'].
							  '|'.$reg['unicode_domaddr'].
							  ')';

			$reg['i_domain']		= '('.$reg['i_unicode_domaddr'].
							  '|'.$reg['i_id'].
							  ')';

		$reg['domain']		= '^'.$reg['i_domain'].'$';

		$reg['domain_csv']	= '^'.$reg['i_domain'].
					  '('.','.$reg['i_domain'].')*'.
					  '$';

		$reg['domain_start']	= '^'.
					   '('.
					   '('.'[a-zA-Z0-9-]'.
					   '|'.$reg['i_idn_domtokken_letters'].
					   '|'.$reg['i_idn_domtokken_digits'].
					   '|'.$reg['i_idn_domtokken_others'].
					   ')*'.
					   '\.?)+'.
					   '$';

			$reg['i_tld_code']	= '([1-9]|1[0])';

		$reg['tld_code']	= '^'.$reg['i_tld_code'].'$';

		$reg['tld_code_list']	= '^'.
					  $reg['i_tld_code'].
					  '('.
						  ','.$reg['i_tld_code'].
					  ')*'.
					  '$';


		// IP
			$reg['i_iptokken']	= '([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])';

			$reg['i_ipv4addr']	= $reg['i_iptokken'].'\.'.
						  $reg['i_iptokken'].'\.'.
						  $reg['i_iptokken'].'\.'.
						  $reg['i_iptokken'];

			$reg['i_ip_private']	= '('.'0?10\.'.'.*'.		// 1 Class A
						  '|'.'172\.0?(1[6-9]|2[0-9]|3[0-1])\.'.'.*'.	// 255 Class B
						  '|'.'192\.168\.'.'.*'.	// 65536 Class C
						  '|'.'169\.254\.'.'.*'.	// Link-local
						  ')';

		$reg['ip']		= '^'.$reg['i_ipv4addr'].'$';

			$reg['i_h16']		= '[0-9a-fA-F]{1,4}';

			$reg['i_l32']		= '('.$reg['i_h16'].':'.$reg['i_h16'].
						  '|'.$reg['i_ipv4addr'].
						  ')';

			$reg['i_ipv6addr']	= '('.										'('.$reg['i_h16'].':'.'){6}'.	$reg['i_l32'].
						  '|'.									'::'.	'('.$reg['i_h16'].':'.'){5}'.	$reg['i_l32'].
						  '|'.	'('.					$reg['i_h16'].')?'.	'::'.	'('.$reg['i_h16'].':'.'){4}'.	$reg['i_l32'].
						  '|'.	'('.	'('.$reg['i_h16'].':'.'){,1}'.	$reg['i_h16'].')?'.	'::'.	'('.$reg['i_h16'].':'.'){3}'.	$reg['i_l32'].
						  '|'.	'('.	'('.$reg['i_h16'].':'.'){,2}'.	$reg['i_h16'].')?'.	'::'.	'('.$reg['i_h16'].':'.'){2}'.	$reg['i_l32'].
						  '|'.	'('.	'('.$reg['i_h16'].':'.'){,3}'.	$reg['i_h16'].')?'.	'::'.	'('.$reg['i_h16'].':'.'){1}'.	$reg['i_l32'].
						  '|'.	'('.	'('.$reg['i_h16'].':'.'){,4}'.	$reg['i_h16'].')?'.	'::'.					$reg['i_l32'].
						  '|'.	'('.	'('.$reg['i_h16'].':'.'){,5}'.	$reg['i_h16'].')?'.	'::'.					$reg['i_h16'].
						  '|'.	'('.	'('.$reg['i_h16'].':'.'){,6}'.	$reg['i_h16'].')?'.	'::'.					''.
						  ')';

		$reg['ipv6']		= '^'.$reg['i_ipv6addr'].'$';

			$reg['i_ipv4v6']	= '('.$reg['i_ipv4addr'].
						  '|'.$reg['i_ipv6addr'].
						  ')';

		$reg['ipv4v6']		= '^'.$reg['i_ipv4v6'].'$';

			#$reg['i_ipv4v6_comma'] = '('.$reg['i_ipv4v6'].'[,\r\n]+'.')'.'{,3}'.
						 #$reg['i_ipv4v6'];

			$reg['i_ipv4v6_comma'] = '('.$reg['i_ipv4v6'].'[,\r\n]+'.')'.'{,3}'.
						 $reg['i_ipv4v6'].'[,\r\n]*';

		$reg['ipv4v6_comma']	= '^'.$reg['i_ipv4v6_comma'].'$';

			$reg['i_ip_or_ascii_domaddr'] = '('.$reg['i_ipv4addr'].
							'|'.$reg['i_ascii_domaddr'].
							')';

		$reg['ip_or_ascii_domaddr'] = '^'.$reg['i_ip_or_ascii_domaddr'].'$';


			$reg['i_ds_record']	= '('.
						  '[a-z1-9.-]+\s+'.	// Domain
						  'IN\s+DS\s+'.		// IN DS
						  '\d{1,11}\s+'.	// Key tag
						  '\d{1,2}\s+'.		// Algorithm
						  '\d{1,2}\s+'.		// Digest Type
						  '([0-9a-fA-F]{,64}\s*)+'.	// Digest
						  ')';

		$reg['ds_record']		= '^'.$reg['i_ds_record'].'$';
		$reg['dnskey_record']		= "^[a-zA-Z0-9+/= \t\n.]+$";

		// Whois
			$reg['i_whois_tld']	= '('.'ir'.
						  '|'.'ایران'.
						  '|'.'ايران'.
						  '|'.'xn--mgba3a4f16a'.
						  '|'.'xn--mgba3a4fra'.
						  ')';

		$reg['whois_tld'] = '^'.$reg['i_whois_tld'].'$';

			$reg['i_whois_domaddr']	= '('.$reg['i_unicode_domtokken'].'\.){1,}'.$reg['i_whois_tld'];

		$reg['whois_domaddr']		= '^'.$reg['i_whois_domaddr'].'$';

		// Email
			$reg['i_mailuser']	= '[a-zA-Z0-9]([a-zA-Z0-9_.\-]*[a-zA-Z0-9])?';

		/* FIXME
		$reg['email']		= '^'.$reg['i_mailuser'].'@'.
					  '('.$reg['i_ascii_domaddr'].
					  '|'.'\['.$reg['i_ipv4addr'].'\]'.
					  ')'.'$';
		*/
		$reg['email']		= '^'.$reg['i_mailuser'].'@'.$reg['i_ascii_domaddr'].'$';

		// Person
		$reg['person_name']	= '^[a-zA-Z]+[a-zA-Z\-\ ]+$';
		$reg['org_name']	= '^[a-zA-Z]+[a-zA-Z0-9\-\ ()\.\,]+$';

			$reg['i_persian_digits']		= '[0123456789٠١٢٣٤٥٦٧٨٩۰۱۲۳۴۵۶۷۸۹]';
			$reg['i_persian_letters']		= '[آاءأبپتثجچحخدذرزژسشصضطظعغفقکگلمنوؤهةیئيك‌]';
			$reg['i_persian_letters_hs']		= '[آاءأبپتثجچحخدذرزژسشصضطظعغفقکگلمنوؤهةیئيك‌\-\ ]';
			$reg['i_persian_letters_digits_punc']	= '[آاءأبپتثجچحخدذرزژسشصضطظعغفقکگلمنوؤهةیئيك‌0123456789٠١٢٣٤٥٦٧٨٩۰۱۲۳۴۵۶۷۸۹\-\ ()\.،]';
		$reg['person_name_fa']	= '^'.$reg['i_persian_letters'].'+'.$reg['i_persian_letters_hs'].'+$';
		$reg['org_name_fa']	= '^'.$reg['i_persian_letters'].'+'.$reg['i_persian_letters_digits_punc'].'+$';

		// Old Handle fields
		$reg['national_id']	= '^[a-zA-Z0-9]([a-zA-Z0-9-]{0,10}[a-zA-Z0-9])?$';
		$reg['legal_name']	= '^[a-zA-Z]+[a-zA-Z0-9\-\ ()\.\,]+$';
		$reg['legal_id']	= '^[0-9a-zA-Z]{2,12}$';
		$reg['company_type']= '^[a-zA-Z]{2,5}$';

		// Ident
		$reg['ident_no']	= '^[0-9a-zA-Z\-]{1,20}$';
		$reg['ident_issuer']	= '^[a-zA-Z]+[a-zA-Z0-9\-\ ()\.\,]+$';
		$reg['ident_private_no2']	= '^[0-9]{11,12}$';

		// Address
		$reg['country']		= '^[A-Z]{2}$';
		$reg['statecity']	= '^[a-zA-Z\ ]+$';

		$reg['address']		= "^[a-zA-Z0-9\-\ \n\r\'\"().,:;#]+$";

		$reg['postcode']	= '^[0-9a-zA-Z]([0-9a-zA-Z\-\ ]*[0-9a-zA-Z])?$';

		$reg['tel']		= '^'.
					  '(((\+|00)?[1-9][0-9]{0,3}[ -]?)?'.	// country code
					  '[(]?[01]?[0-9]{1,3}[)]?[ -]?)?'.	// area code
					  '[0-9]{3,4}[ -]?[0-9]{0,4}'.		// number
					  '[ -]?((x|ext)[.]?[ ]?[0-9]{1,5})?'.	// ext
					  '$';
					  #'[0-9]{3,4}[ -]?[0-9]{3,4}[ -]?'.	// number

		$reg['mobile_org']		= '^'.
					  '09[0-9]{3,9}'.		// number
					  '$';

		$reg['mobile_1']		= '^'.
				'09[0-9]{9}'.
				'$';

		$reg['mobile_2']		= '^'.
				'9[0-9]{9}'.
				'$';

		$reg['mobile_3']		= '^'.
				'\+989[0-9]{9}'.
				'$';

		$reg['mobile_4']		= '^'.
				'989[0-9]{9}'.
				'$';

		$reg['mobile']	= '('.$reg['mobile_1'].
				'|'.$reg['mobile_2'].
				'|'.$reg['mobile_3'].
				'|'.$reg['mobile_4'].
				')';



		// Secret
		$reg['secret_question']		= '^[[:alnum:]\-\ \?\(\)\_]+$';
		$reg['secret_answer']		= '^[a-zA-Z0-9\`\=\~\!\@\#\%\&\_\;\:\"\,\<\>\/\ \'\-\^\.\\\$\|\*\+\?\(\)\{\}]{3,32}$';

		//FIXME: Temporarly until all secret_answers are more then 3 characters long
		$reg['secret_answer_reset']	= '^[a-zA-Z0-9\`\=\~\!\@\#\%\&\_\;\:\"\,\<\>\/\ \'\-\^\.\\\$\|\*\+\?\(\)\{\}]+$';

		$reg['passwd']			= '^[a-zA-Z0-9\`\=\~\!\@\#\%\&\_\;\:\"\,\<\>\/\ \'\-\^\.\\\$\|\*\+\?\(\)\{\}]{6,32}$';


		// Handle
			$reg['i_handle_letters'] = '[a-zA-Z]';
			$reg['i_handle_letters_digits']	= '[a-zA-Z]{2}[0-9]{2,4}';
			$reg['i_handle']	= $reg['i_handle_letters_digits'].'\-irnic';

		$reg['handle']		= '^'.$reg['i_handle'].'$';

		$reg['handlemail']	= '('.$reg['handle'].
					  '|'.$reg['email'].
					  ')';

		$reg['handle_or_id']	= '('.$reg['handle'].
					  '|'.$reg['id'].
					  ')';

		// OldHandle

                        $reg['i_oldhandle']	= '('.
                                                  '('.$reg['i_ascii_domaddr'].
                                                  '|'.$reg['i_handle_letters_digits'].
                                                  ')-oldirnic)';



		$reg['oldhandle']	= '^'.$reg['i_oldhandle'].'$';

		$reg['old_or_handle']	= '('.$reg['handle'].
					  '|'.$reg['oldhandle'].
					  ')';

		$reg['oldhandlemail']	= '('.$reg['handle'].
					  '|'.$reg['oldhandle'].
					  '|'.$reg['email'].
					  ')';
		//NSHost
			$reg['i_nshost_name']	= $reg['i_ascii_domtokken'];

		$reg['nshost_name']	= '^'.$reg['i_nshost_name'].'$';

		$reg['nshost']		= '('.$reg['nshost_name'].
					  '|'.$reg['id'].
					  ')';
		// Migration

		// IR Handle
			$reg['i_ir_handle_1']	= '[nN][iI][cC][0-9]{,5}[hH][0-9]{2,6}';
			$reg['i_ir_handle_2']	= '[a-zA-Z]{2}[0-9]{2,3}\-[nN][iI][cC][iI][rR]';
			$reg['i_ir_handle_3']	= '[iI][rR][nN][iI][cC]\-[a-zA-Z]{1,2}[0-9]{2,3}';

			$reg['i_ir_handle']	= '('.$reg['i_ir_handle_1'].
						  '|'.$reg['i_ir_handle_2'].
						  '|'.$reg['i_ir_handle_3'].
						  ')';

		$reg['ir_handle']	= '^'.$reg['i_ir_handle'].'$';
		$reg['ir_passwd']	= '^[a-zA-Z0-9\*\`\=\~\!\@\#\%\&\_\;\:\"\,\<\>\/\ \'\-\^\.\\\$\|\*\+\?\(\)\{\}]{3,32}$';
		$reg['ir_address']	= '\,[ ]?(IR|Iran)[ ]*[\r\n$]';

		//IDN Handle
			$reg['i_idn_handle']	= '[a-zA-Z0-9\.\,\-]{2}[0-9]{2,3}h\-irnic';

		$reg['idn_handle']	= '^'.$reg['i_idn_handle'].'$';
		$reg['idn_passwd']	= '^[a-zA-Z0-9\*\`\=\~\!\@\#\%\&\_\;\:\"\,\<\>\/\ \'\-\^\.\\\$\|\*\+\?\(\)\{\}]{3,32}$';

		// Payment

		$reg['currency']		= '^[1-9][0-9]{0,10}([.][0-9]{0,2})?$';
		$reg['negative_currency']	= '^\-?[1-9][0-9]{0,10}([.][0-9]{0,2})?$';
		$reg['unit']			= '^[0-9]{0,5}([.][0-9]{0,2})?$';

			$reg['i_currency_type']	= '(IRR|EUR|X01)';
		$reg['currency_type']	= '^'.$reg['i_currency_type'].'$';

			$reg['i_payment_type']	= '(bank_receipt|online_saman|online_parsian|handle_credit|handle_contract|irnic_operator)';
		$reg['payment_type']	= '^'.$reg['i_payment_type'].'$';

			$reg['i_payment_action']	= '(Deposit|Basket)';
		$reg['payment_action']	= '^'.$reg['i_payment_action'].'$';

			$reg['i_credit_type']	= '(all|deposit|expense)';
		$reg['credit_type']	= '^'.$reg['i_credit_type'].'$';

		$reg['deposit_code']	= '^[0-9]{16}$';
		$reg['ref_num']		= '^[0-9]{6,}$';

			$reg['i_contract_number']	= '[a-zA-Z][0-9]{2,9}(-[0-9]{1,2})?';
		$reg['contract_number']	= '^'.$reg['i_contract_number'].'$';
		$reg['contract_version'] = '^[12]$';

		$reg['handlecontracrt']	= '^('.$reg['contract_number'].
					  '|'.$reg['handle'].
					  ')$';

		$reg['order_list_action_type']	= '^(add_to_basket|pay_by_credit)$';
		$reg['order_list_payment_type']	= '^'.$reg['i_payment_type'].'(__('.$reg['i_currency_type'].'|'.$reg['i_contract_number'].'))?$';

		$reg['saman_state']	= '^[a-zA-Z\ ]{2,}$';
		$reg['saman_ref_num']	= '^[a-zA-Z0-9\+\/]{20,30}$';

		$reg['parsian_status']		= '^[0-9]+$';
		$reg['parsian_authority']	= '^[0-9]{,20}$';

			$reg['i_res_num']	= '[0-9]{15}';
		$reg['res_num']			= '^'.$reg['i_res_num'].'$';

			$reg['i_res_num_dash']	= '[0-9]{5}-[0-9]{4}-[0-9]{6}';
		$reg['res_num_dash']		= '^'.$reg['i_res_num_dash'].'$';
		$reg['res_num_all']	= '^('.$reg['i_res_num'].
					  '|'.$reg['i_res_num_dash'].
					  ')$';

		$reg['id_or_res_num']	= '('.$reg['id'].
					  '|'.$reg['res_num_all'].
					  ')';

		// Search
		$reg['search_handle']	= '^'.
					  '([a-zA-Z]{2}[0-9]{0,}(-[irnic]*)?'.
					  '|[a-z0-9][a-z0-9-.]*(-[oldirnic]*)?'.
					  ')$';

		$reg['search_person_name'] = '^[a-zA-Z]+[a-zA-Z\-\ ]+$';

		$reg['search_email']	= '^'.
					  '('. $reg['i_mailuser']. ')?'.
					  '('. '@'. '('.$reg['i_ascii_domtokken'].'|'.'\.'.')+'. ')?'.
					  '$';

		$reg['search_country']	 = '^[a-zA-Z]{2}$';
		$reg['search_statecity'] = '^[a-zA-Z\ ]+$';

		$reg['search_domain']	= '^'.
					   '('.
					   '('.'%'.
					   '|'.'[a-zA-Z0-9-]'.
					   '|'.$reg['i_idn_domtokken_letters'].
					   '|'.$reg['i_idn_domtokken_digits'].
					   '|'.$reg['i_idn_domtokken_others'].
					   ')*'.
					   '\.?)+'.
					   '$';

		$reg['search_nshost']	= '^%?'.
					   '('.
					   '('.'[a-zA-Z0-9-]'.
					   '|'.$reg['i_idn_domtokken_letters'].
					   '|'.$reg['i_idn_domtokken_digits'].
					   '|'.$reg['i_idn_domtokken_others'].
					   ')*'.
					   '\.?)+'.
					   '$';


		// Banned Names

		$reg['banned_category']	= '^[a-zA-Z][a-zA-Z0-9_,\(\) \-]*$';


		// Operator
			$reg['i_op_user']	= '[a-zA-Z]([a-zA-Z0-9_]+[a-zA-Z0-9])?';

		$reg['op_user']		= '^'.$reg['i_op_user'].'$';


		// Status

			$reg['i_no_change']	= 'NoChange';

			$reg['i_address_status']	= '('.'Unapproved'.
						  '|'.'Request'.
						  '|'.'Queued'.
						  '|'.'Locked'.
						  '|'.'Approved'.
						  '|'.'Spam'.
						  ')';

		$reg['address_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_address_status'].
					  ')$';

			$reg['i_migrate_status']	= '('.'QueHolder'.
							  '|'.'QueWaitForDoc'.
							  '|'.'Approved'.
							  '|'.'Rejected'.
							  ')';

		$reg['migrate_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_migrate_status'].
					  ')$';

			$reg['i_login_status']	= '('.'Never'.
						  '|'.'LoggedIn'.
						  '|'.'Banned'.
						  ')';

		$reg['login_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_login_status'].
					  ')$';


			$reg['i_position_status']	= '('.'Banned'.
							  '|'.'NotBanned'.
							  ')';

		$reg['position_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_position_status'].
					  ')$';

			$reg['i_payment_status'] = '('.'Unpaid'.
						   '|'.'Queued'.
						   '|'.'Error'.
						   '|'.'Canceled'.
						   '|'.'Approved'.
						   ')';

		$reg['payment_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_payment_status'].
					  ')$';

		$reg['order_payment_filter']	= '^'.
					  '('.'paid'.
					  '|'.'unpaid_all'.
					  '|'.'unpaid_own_basket'.
					  '|'.'unpaid_others_basket'.
					  ')$';

			$reg['i_service_class'] = '('.'REGISTER'.
						  '|'.'RENEW'.
						  '|'.'RENEW_UNLOCK'.
						  '|'.'TRANSFER'.
						  '|'.'CANCEL'.
						  ')';

		$reg['service_class']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_service_class'].
					  ')$';

			$reg['i_order_confirm_status'] = '('.'QueHolder'.
							 '|'.'QueDomain'.
							 '|'.'QueTransferHolder'.
							 '|'.'QueTransferOperator'.
							 '|'.'QueOperator'.
							 '|'.'QueWaitForDoc'.
							 '|'.'Canceled'.
							 '|'.'Rejected'.
							 '|'.'Approved'.
							 ')';

		$reg['order_confirm_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_order_confirm_status'].
					  ')$';

			  $reg['i_domain_status']	= '('.'Reserved'.
						  '|'.'Registered'.
						  '|'.'Expired'.
						  '|'.'Locked'.
						  '|'.'Canceled'.
						  '|'.'Suspended'.
						  ')';

		$reg['domain_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_domain_status'].
					  ')$';

			$reg['i_nshost_status']	= '('.'Reserved'.
						  '|'.'Registered'.
						  '|'.'Expired'.
						  ')';

		$reg['nshost_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_domain_status'].
					  ')$';

			  $reg['i_transfer_status'] = '('.'QueHolder'.
						  '|'.'Open'.
						  '|'.'Locked'.
						  '|'.'QueOperator'.
						  ')';

		$reg['transfer_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_transfer_status'].
					  ')$';

			$reg['i_contract_status'] = '('.'Enabled'.
						  '|'.'Disabled'.
						  '|'.'Expired'.
						  '|'.'Active'.
						  ')';

		$reg['contract_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_contract_status'].
					  ')$';

			$reg['i_banned_status']	= '('.'Forbidden'.
						  '|'.'Restricted'.
						  ')';

		$reg['banned_status']	= '^'.
					  '('.$reg['i_no_change'].
					  '|'.$reg['i_banned_status'].
					  ')$';

		// NS Hosting Types

			$reg['i_host_type'] = '('.'NS'.
					      '|'.'HOSTING'.
					      ')';

		$reg['host_type'] = '^'.$reg['i_host_type'].'$';

			$reg['i_host_record_type'] = '('.'A'.
						     '|'.'CNAME'.
						     '|'.'MX 10'.
							 '|'.'MX 20'.
							 '|'.'MX 30'.
							 '|'.'AAAA'.
							 '|'.'NAPTR'.
							 '|'.'DNAME'.
						     ')';

		$reg['host_record_type'] = '^'.$reg['i_host_record_type'].'$';


		// Note Page

		$reg['note_page_file']	= '^[A-Za-z0-9_,.]+$';

			$reg['i_note_page_status']	= '('.'Later'.
							  '|'.'Seen'.
							  ')';

		$reg['note_page_status']	= '^'.
						  '('.$reg['i_no_change'].
						  '|'.$reg['i_note_page_status'].
						  ')$';


		// Note system

		$reg['template_file']	= '^[a-z0-9_\.-]+$';

		$reg['note_message']	= '^['.
					  'a-zA-Z0-9'.
					  'آاءأبپتثجچحخدذرزژسشصضطظعغفقکگلمنوؤهةیئيك'.
					  '٠١٢٣٤٥٦٧٨٩۰۱۲۳۴۵۶۷۸۹'.
					  '؟٬٫٪×‍ٔ‌ؤئيإأآة»«؛؟ءٔژٓكًٌٍَُِّْ،'.
					  '\`\=\[\]\~\!\@\#\%\&\_\;\:\"\,\<\>\/\ \'\-\^\.\\\$\|\*\+\?\(\)\{\}\n\r'.
					  ']+$';

		$reg['contact']		= '^'.
					  '('.'holder'.
					  '|'.'admin'.
					  '|'.'tech'.
					  '|'.'bill'.
					  ')$';


		// Statistics
			$reg['i_stat_duration'] = '('.'day'.
						  '|'.'week'.
						  '|'.'month'.
						  '|'.'year'.
						  ')';

		$reg['stat_duration']	= '^'.$reg['i_stat_duration'].'$';

		$reg['limit_num']		= '^[1-9][0-9]?$';


		// Attachments

			$reg['i_filename']	= '[1-9]{1}[0-9]{13}_[a-z0-9_]{8}';

		$reg['filename']	= '^'.$reg['i_filename'].'$';

		$reg['filename_or_id']	= '('.$reg['filename'].
					  '|'.$reg['id'].
					  ')';


		$reg['filename_csv']	= '^'.$reg['i_filename'].
					  '('.','.$reg['i_filename'].')*'.
					  '$';

		$reg['filename_csv_or_id_csv']	= '('.$reg['filename_csv'].
						  '|'.$reg['id_csv'].
						  ')';

		$reg['file_rel_id']	= '('.$reg['domain'].
					  '|'.$reg['id'].
					  '|'.$reg['old_or_handle'].
					  '|'.$reg['res_num_all'].
					  ')';

			$reg['i_doc_assignment_job']  = '('.'([DHPR]\-(App|Mod|Mig|Tra|Can|Reg-2nd|Reg-3rd))'.
							'|'.'(U\-[A-Z][a-z]+)'.
							'|'.'Queue'.
							')';

		$reg['doc_assignment_job']	= '^'.$reg['i_doc_assignment_job'].'$';

		$reg['doc_assignment_job_csv']	= '^'.$reg['i_doc_assignment_job'].
						  '('.',('.$reg['i_doc_assignment_job'].')?)*'.
						  '$';


			$reg['i_doc_in_file_status'] = '(New|Trusted|Denied)';

		$reg['doc_in_file_status'] =	'^'.
						'('.$reg['i_no_change'].
						'|'.$reg['i_doc_in_file_status'].
						')$';


		$reg['doc_service_class'] =	'('.'REGISTER'.
						'|'.'TRANSFER'.
						'|'.'CANCEL'.
						'|'.'MODIFY'.
						')';

			$reg['i_tag'] = '[a-zA-Z0-9_\-]+';

		$reg['tag_csv']	= '^('.$reg['i_tag'].'(,)?)*$';

		$reg['pages']           = "^[0-9\-\,]+$";

		$reg['epp_command'] =	'^('.'all'.
					'|'.'contact\:check'.
					'|'.'contact\:info'.
					'|'.'contact\:create'.
					'|'.'contact\:update'.
					'|'.'domain\:check'.
					'|'.'domain\:info'.
					'|'.'domain\:create'.
					'|'.'domain\:renew'.
					'|'.'domain\:update'.
					'|'.'domain\:transfer'.
					'|'.'domain\:delete'.
					'|'.'poll\:req'.
					'|'.'poll\:ack'.
					')$';

		$reg['reseller_access'] ='^('.'WebDomainRegister'.
					'|'.'WebDomainRenew'.
					'|'.'WebDomainTransfer'.
					'|'.'WebDomainDelete'.
					'|'.'EPPDomainDelete'.
					'|'.'EPPDomainContacts'.
					'|'.'EPPDomainDNS'.
					')$';

		$reg['epp_object_id']	= '^['.
					'a-zA-Z0-9'.
					'آاءأبپتثجچحخدذرزژسشصضطظعغفقکگلمنوؤهةیئيك'.
					'٠١٢٣٤٥٦٧٨٩۰۱۲۳۴۵۶۷۸۹'.
					'‍ٔ‌ؤئيإأآةءٔژٓكًٌٍَُِّْ'.
					'\@\_\.\-'.
					']+$';

		$reg['cert_serial']	= "^[0-9]{6,}$";

			  $reg['i_requester']	= '('.
						  '|'.'myself'.
						  '|'.'other'.
						  ')';

		$reg['requester']	= '^'.
					  '('.$reg['i_requester'].
					  ')$';

		$reg['domain_comma']	= '^'.$reg['i_domain'].
					  '('.'[,\r\n\s]+'.$reg['i_domain'].')*'.
					  '$';

		$reg['handle_comma']	= '^'.$reg['i_handle'].
					  '('.'[,\r\n\s]+'.$reg['i_handle'].')*'.
					  '$';

		$reg['id_comma']	= '^'.$reg['i_id'].
					  '('.'[,\r\n\s]+'.$reg['i_id'].')*'.
					  '$';

		// XXX: just for use in admin pages!
		$reg['string']		= '^[a-zA-Z0-9_\-/]+$';
		$reg['stringfarsi']		= '^.+$';

		$reg['enum']		= '^[a-zA-Z][a-zA-Z0-9]*$';
		$reg['enum_enum']	= '^[a-zA-Z][a-zA-Z0-9]*__[a-zA-Z][a-zA-Z0-9]*$';

        // NOTE: just for use in admin pages!
        $reg['string'] = '^[a-zA-Z0-9_\-/]+$';
        $reg['amount'] = '^[1-9]{1}[0-9]{3,}([.][0-9]{0,2})?$';


			$reg['i_order_category'] =
                          '('.'SabtSherkat__PublicCompany'.
						  '|'.'SabtSherkat__PrivateCompany'.
						  '|'.'SabtSherkat__LimitedCompany'.
						  '|'.'SabtSherkat__CooperativeCompany'.
						  '|'.'SabtSherkat__Organization'.
						  '|'.'Ershad__Publication'.

						  '|'.'Leader__Any'.
						  '|'.'Judiciary__Any'.
						  '|'.'Legislative__Any'.
						  '|'.'Executive__Ministry'.
						  '|'.'Executive__Company'.
						  '|'.'Executive__Organization'.
						  '|'.'Executive__President'.
						  '|'.'Executive__Province'.
						  '|'.'Executive__Municipality'.

						  '|'.'MoEdu__PrimarySch'.
						  '|'.'MoEdu__SecondarySch'.
						  '|'.'MoEdu__HighSch'.
						  '|'.'MoEdu__PreUni'.
						  '|'.'MoEdu__Vocational'.
						  '|'.'MoEdu__OtherSch'.
						  '|'.'MoEdu__Center'.
						  '|'.'MoSRT__PublicUni'.
						  '|'.'MoSRT__AzadUni'.
						  '|'.'MoSRT__PayameNoorUni'.
						  '|'.'MoSRT__AppSciTechUni'.
						  '|'.'MoSRT__OtherUni'.
						  '|'.'MoSRT__Center'.
						  '|'.'MoSRT__ResearchInst'.
						  '|'.'MOHMS__MedPublicUni'.
						  '|'.'MoHMS__MedResearchInst'.
						  ')';

		$reg['order_category']	= '^'.
					  '('.$reg['i_order_category'].
					  ')$';

			$reg['i_order_cat'] =
                          '('.'Gov'.
						  '|'.'PrivateReg'.
						  '|'.'Trademark'.
						  '|'.'Geographic'.
						  '|'.'University'.
						  '|'.'School'.
						  '|'.'idIRAN'.
						  '|'.'idForeign'.
						  ')';

		$reg['order_cat']	= '^'.
					  '('.$reg['i_order_cat'].
					  ')$';



			$reg['i_file_tag'] =
                          '('.'request'.
						  '|'.'statute'.
						  '|'.'newspaper'.
						  '|'.'registeredDocs'.
						  '|'.'translatedDocs'.
						  '|'.'powerOfAttorney'.
						  '|'.'changeNewspaper'.
						  '|'.'trademarkLicense'.
						  '|'.'idDocs'.
						  '|'.'transferDocs'.
						  '|'.'license_statute'.
						  '|'.'activityCrt'.
						  '|'.'idCard'.
						  '|'.'license'.
						  '|'.'passport'.
                          ')';

		$reg['file_tag']	= '^'.
					  '('.$reg['i_file_tag'].
					  ')$';

            $reg['i_order_tag'] =
                '('.'name_approved'.
                '|'.'doc_approved'.
                '|'.'Approved'.
                '|'.'Rejected'.
                ')';

        $reg['order_tag']	= '^'.
            '('.$reg['i_order_tag'].
            ')$';

        $reg['i_file_tag_type'] =
            '('.'supp_doc'.
            '|'.'req_doc'.
            ')';

        $reg['file_tag_type']	= '^'.
            '('.$reg['i_file_tag_type'].
            ')$';

        $reg['i_docName'] =
            '('.'DotIran_Launch_Policy'.
            '|'.'DotIran_Registration_Agreement'.
            '|'.'Appendix_1_Domain_Rules'.
            '|'.'Appendix_2_Whois'.
            '|'.'Appendix_3_Fees'.
            '|'.'Appendix_4_Renewal'.
            '|'.'Appendix_5_Dispute_Resolution_Policy'.
            '|'.'Appendix_6_Dispute_Resolution_Providers'.
            ')';

        $reg['docName']	= '^'.
            '('.$reg['i_docName'].
            ')$';

    }

    public function isRegexValid($a_value, $a_type)
    {
        return mb_ereg($this->reg[$a_type], (string) $a_value);
    }
}

