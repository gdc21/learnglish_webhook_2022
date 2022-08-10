var hello = function(data){
	console.log(data);
}
/*accessKey = function(){
	var char = '';
	this.obj = '';
	
	this.setChar = function(key){
		char += String.fromCharCode(key);
		if( !isAndroid() ){
			this.editBox();
		}
	}
		
	this.editBox = function(){
		var txt = $(this.obj).val();
		$(this.obj).val(txt + 'XXX');	
	}
		
	this.getPass = function(){
		if( char ){
			return CryptoJS.SHA1( char ).toString();
		}else{
			return CryptoJS.SHA1( $(this.obj).val() ).toString();
		}
	}
	
	this.resetPass = function(){
		char = '';
	}
	
	this.drop = function(){
		char = char.substring(char, char.length-1);
	}
		
	this.size = function(){
		return char.length;
	}
}*/
$("#test").click(function(e){
	alert("SEND INFO");
	getInfoAjaxComplete("ajaxTest",{"ok":"OK"},"hello");
});





/**/


