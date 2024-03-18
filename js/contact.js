//名前とメールアドレスが入力されているかチェックする
//メッセージの文字数が制限を超えていないかチェックする
function formCheck(){
	target = document.getElementById("errMessage");
	var customerName = form.name.value;
	var customerEmail = form.email.value;
	var customerMessage = form.message.value;

	//完了メッセージエリアをクリアにする
	var target_compMessage = document.getElementById("compMessage");
	target_compMessage.innerHTML = "";

	//入力チェック
	if(customerName == "" || customerEmail == ""){
		if(customerName == "" && customerEmail == ""){
			target.innerHTML = "A name and an e-mail address must be specified.";
			return false;
		}
		else if(customerName == "" && customerEmail != ""){
			target.innerHTML = "A name must be specified.";
			return false;
		}else if(customerName != "" && customerEmail == ""){
			target.innerHTML = "An e-mail address must be specified.";
			return false;
		}
	//正規表現チェック
	}else if(regexNameCheck(customerName)==false || regexEmailCheck(customerEmail)==false){
		if(regexNameCheck(customerName)==false && regexEmailCheck(customerEmail)==false){
			target.innerHTML = "A name and an e-mail contain invalid characters.";
			return false;
		}
		else if(regexNameCheck(customerName)==false && regexEmailCheck(customerEmail)==true){
			target.innerHTML = "A name contains invalid characters.";
			return false;
		}else if(regexNameCheck(customerName)==true && regexEmailCheck(customerEmail)==false){
			target.innerHTML = "An e-mail address contains invalid characters.";
			return false;
		}
	//文字数チェック
	}else if(customerName.length > 50 || customerEmail.length > 50 || customerMessage.length > 2000){
		if(customerName.length > 50){
			target.innerHTML = "A name can only be 50 characters long.";
			return false;
		}
		else if(customerEmail.length > 50){
			target.innerHTML = "A e-mail can only be 50 characters long.";
			return false;
		}else if(customerMessage.length > 2000){
			target.innerHTML = "A message can only be 2000 characters long.";
			return false;
		}
	}else{
		//条件に一致しない場合(名前とメールアドレスが入力されている場合)
		target.innerHTML = "";    //送信ボタン本来の動作を実行します
		return true;
	}
}

function regexNameCheck(str){
	var reg = new RegExp(/^[a-zA-Z]*$/); //半角英字のみ（空文字OK）
	var response = reg.test(str);
	return response;
}

function regexEmailCheck(str){
	var reg = new RegExp(/^[a-zA-Z0-9!-/:-@¥[-`{-~]*$/); //半角英数記号のみ（空文字OK）
	var response = reg.test(str);
	return response;
}