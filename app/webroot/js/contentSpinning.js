function preg_replace_callback(pattern, callback, subject, limit){
	limit = !limit?-1:limit;

	var _flag = pattern.substr(pattern.lastIndexOf(pattern[0])+1),
		_pattern = pattern.substr(1,pattern.lastIndexOf(pattern[0])-1),
		reg = new RegExp(_pattern,_flag),
		rs = null,
		res = [],
		x = 0,
		ret = subject;
		
	if(limit === -1){
		var tmp = [];
		
		do{
			tmp = reg.exec(subject);
			if(tmp !== null){
				res.push(tmp);
			}
		}while(tmp !== null && _flag.indexOf('g') !== -1)
	}
	else{
		res.push(reg.exec(subject));
	}
	
	for(x = res.length-1; x > -1; x--){//explore match
		ret = ret.replace(res[x][0],callback(res[x]));
	}
	return ret;
}

//http://webarto.com/62/random-sentence-spinning-function
function contentSpinning(str) {
	callback = function(ins)
	{
		all   = ins[0];
		words = ins[1].split('|');
		rand_keys = Math.floor(Math.random() * words.length);
		return words[rand_keys];
	};
	
	new_str = preg_replace_callback('/\{([^{}]*)\}/im',callback,str);
	if (new_str !== str) str = contentSpinning(new_str);
	return str;
}