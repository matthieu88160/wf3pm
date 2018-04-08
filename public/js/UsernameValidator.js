
function UsernameValidator(inputSelector, url, method, verbose) {
	this.xhr = undefined;
	
	this.verbose = verbose;
	
	if (inputSelector === undefined) {
		throw 'inputSelector must be defined as first parameter to initialize usernameValidator';
	}
	this.inputSelector = inputSelector;

	if (url === undefined) {
		throw 'url must be defined as second parameter to initialize usernameValidator';
	}
	this.url = url;

	if (method === undefined) {
		method = 'POST';
	}
	this.method = method;
}

UsernameValidator.prototype.setCallback = function(callback){
	this.callback = callback;
}

UsernameValidator.prototype.setBefore = function(callback){
	this.before = callback;
}

UsernameValidator.prototype.getUsername = function(){
	var value = $(this.inputSelector).val();

	if (this.verbose) {
		console.log('Value : ' + value);
	}
	
	return value;
}

UsernameValidator.prototype.startXhr = function(){
	if (this.xhr !== undefined) {
		this.xhr.abort();
	}
	
	req = new XMLHttpRequest();
	req.open(this.method, this.url);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	
	if (this.callback !== undefined) {
		req.addEventListener("load", this.callback);
	}
	
	this.xhr = req;
}

UsernameValidator.prototype.validate = function(){
	if (this.before !== undefined) {
		this.before(this);
	}

	this.startXhr();
	this.xhr.send('username=' + this.getUsername());
}

