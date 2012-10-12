<?php
class MyHtmlHelper extends HtmlHelper {
	public $helpers = array('Html', 'Form', 'Paginator', 'Time');

	public function getAlphabetListArray($listData) {
		$listAlphabet = array();
		foreach($listData as $key => $name) {
			$letter = strtoupper(substr(removeAccents(utf8_decode($name)), 0, 1));//removeAccent in vendors/functions.php
			if (is_numeric($letter)) {
				$letter = '0-9';
			}
			$listAlphabet[$letter][$key] = $name;  
		}
		
		return $listAlphabet;
	}

	public function niceDate($dateString = null, $format = '%A, %e %B %Y, %H:%M') {
		$date = $dateString ? $this->Time->fromString($dateString) : time();
		return ucfirst(strftime($format, $date));
	}
	
	public function niceDateDMY($dateString = null, $format = '<span class="date-d">%e</span> <span class="date-m">%b</span> <span class="date-y">%Y</span>') {
		$date = $dateString ? $this->Time->fromString($dateString) : time();
		return ucfirst(strftime($format, $date));
	}
	
	public function niceDateShort($dateString = null, $viewHour = true) {
		$date = $dateString ? $this->Time->fromString($dateString) : time();
		$y = $this->Time->isThisYear($date) ? '' : ' %Y';

		if ($this->Time->isToday($date)) {
			$ret = __("aujourd'hui");
		} elseif ($this->Time->wasYesterday($date)) {
			$ret = __("hier");
		} else {
			$ret = ucfirst(strftime("%a %e %b{$y}", $date));
		}
		
		if ($viewHour) {
			$ret .= ', '.date("H:i", $date);
		}

		return $ret;
	}
	
	public function captchaImage($fieldName) {
		$imgSrc = FULL_BASE_URL.$this->request->webroot.'captcha/image.php?sid='.md5(uniqid(time()));
		$imgId = $this->domId($fieldName).'Captcha';
		$out = '<img id="'.$imgId.'" src="'.$imgSrc.'" alt="'.__('Code de sécurité').'" title="'.__('Code de sécurité').'" />';
		$out .= '&nbsp;<a style="cursor:pointer" title="'.__('Réactualiser l\'image').'" onclick="javascript:document.images.'.$imgId.'.src = \''.$imgSrc.'&amp;\'+Math.round(Math.random(0)*1000)+1;" >'.$this->Html->image('captcha-reload.gif',array('alt' => 'Reload')).'</a>';
		return $out;
	}
	
	public function captchaAudio() {
		$audioUrl = FULL_BASE_URL.$this->request->webroot.'captcha/audio.php';
		return sprintf('<a href="%s">%s</a>', $audioUrl, __('Cliquez-ici pour écouter le code'));
	}
	
	public function captcha($fieldName) {
		$solved = CakeSession::read('Captcha.solved');
		
		if (Auth::id() || !empty($solved)) {
			return '';
		} else {
			$str = '<fieldset>';
			$str .= '<legend>'.__('Code de sécurité anti-spam').'</legend>';
			$str .= '<p class="captcha-image">'.$this->captchaImage($fieldName).'</p>';
			$str .= '<p class="captcha-audio">'.$this->captchaAudio().'</p>';
			$str .= $this->Form->input($fieldName, array('label' => __('Recopiez le code de sécurité'), 'size' => 5));
			$str .= '</fieldset>';
			return $str;
		}
	}
	
	public function paginatorSort($key, $title, $sortDirDefault = 'asc', $options = array()) {
		$language = $this->request->params['lang'];

		$paginatorParams = $this->Paginator->params();
		
		if ($paginatorParams['count'] > 1) {
			
			$options = array_merge(array('rel' => 'nofollow', 'url' => array('lang' => $language)), $options);
			
			$sortKey = $this->Paginator->sortKey();
			$defaultModel = $this->Paginator->defaultModel();
			$isSorted = ($sortKey === $key || $sortKey === $defaultModel . '.' . $key || $key === $defaultModel . '.' . $sortKey);
			
			if (!$isSorted) {
				$options['url']['direction'] = $sortDirDefault;
			}
			
			$out = $this->Paginator->sort($key, $title, $options);
			
			if ($isSorted) {
				switch ($this->Paginator->sortDir()) {
					case 'asc':
						$out .= $this->Html->image('paginator/sort-asc.gif');
						break;
					
					case 'desc':
						$out .= $this->Html->image('paginator/sort-desc.gif');
						break;
						
					default:
						break;
				}
			}
		} else {
			$out = $title;//only 1 record, dont need sorting link
		}
		
		return $out;
	}
	
	public function encodeEmail($email, $name = null) {
		$email = preg_replace("/\"/","\\\"",$email);
		$name = is_null($name) ? $email : $name;
		
		$old = "document.write('<a href=\"mailto:$email\">$name</a>')";
		$output = "";
		for ($i=0; $i < strlen($old); $i++) {
			$output = $output . '%' . bin2hex(substr($old,$i,1));
		}
		
		$output = '<script type="text/javascript">eval(unescape(\''.$output.'\'))</script>';
		$output .= '<noscript><div>'.__("Vous devez activer le JavaScript pour voir l'e-mail").'</div></noscript>';
		return $output;
	}
}