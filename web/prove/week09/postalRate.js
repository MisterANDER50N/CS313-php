var express = require('express');
var app = express();


app.set('port', (process.env.PORT || 5000));

app.use(express.static('public'));

app.set('views', 'views');
app.set('view engine', 'ejs');

app.get('/math', postage);

app.get('/home', function(req, res){
	console.log('recieved request for /home');
	
	res.write('This is the home page');
	res.end();
	
});

app.listen(app.get('port'), function() {
	console.log('server running on port 5000')
});

function postage(req, res){
	
	var weight = Number(req.query.wt);
	var mail = req.query.mail;
	var result = 0;
	
	mail = mail.toLowerCase();
	
	if (mail == "stamped")
		result = stamped(res, weight, result);
	if (mail == 'metered')
		result = metered(res, weight, result);
	if (mail == "envelope")
		result = envelope(res, weight, result);
	if (mail == 'package')
		result = package(res, weight, result);
	
	var params = {weight: weight, result: result};
			console.log(result);

	res.render('result', params);
}

function stamped(res, weight, result){
	console.log('entered stamped');
	if(weight <= 1)
			result = .5;
		else if(weight <= 2)
			result = .71;
		else if(weight <= 3)
			result = .92;
		else if(weight <= 3.5)
			result = 1.13;
		else
			result = envelope(res, weight, result);
		console.log(result);
		return result;
}

function metered(res, weight, result){
	if(weight <= 1)
			result = .47;
		else if(weight <= 2)
			result = .68;
		else if(weight <= 3)
			result = .89;
		else if(weight <= 3.5)
			result = 1.1;
		else
			result = envelope(res, weight, result);
	return result;
}

function envelope(res, weight, result){
		if(weight <= 1)
			result = 1;
		else if(weight <= 2)
			result = 1.21;
		else if(weight <= 3)
			result = 1.42;
		else if(weight <= 4)
			result = 1.63;
		else if(weight <= 5)
			result = 1.84;
		else if(weight <= 6)
			result = 2.05;
		else if(weight <= 7)
			result = 2.26;
		else if(weight <= 8)
			result = 2.47;
		else if(weight <= 9)
			result = 2.68;
		else if(weight <= 10)
			result = 2.89;
		else if(weight <= 11)
			result = 3.1;
		else if(weight <= 12)
			result = 3.31;
		else if(weight <= 13)
			result = 3.52;
				return result;
}

function package(res, weight, result){
		if(weight <= 4)
			result = 3.5;
		
		else if(weight <= 8)
			result = 3.75;
		else if(weight <= 9)
			result = 4.1;
		else if(weight <= 10)
			result = 4.45;
		else if(weight <= 11)
			result = 4.8;
		else if(weight <= 12)
			result = 5.15;
		else if(weight <= 13)
			result = 5.5;
				return result;
}