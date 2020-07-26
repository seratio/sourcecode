var express = require('express');
var app = express();

app.set('port', (process.env.PORT || 5000));

app.use(express.static(__dirname + '/public'));

// views is directory for all template files
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');

app.get('/', function(request, response) {
  response.render('pages/index');
});

app.listen(app.get('port'), function() {
  console.log('Node app is running on port', app.get('port'));
});

var proxy = require('http-proxy-middleware');


app.use('/eth-api', proxy({target: 'http://localhost:8645', changeOrigin: true}));
app.use('/etc-api', proxy({target: 'http://localhost:8545', changeOrigin: true}));
app.listen(8000,'108.61.174.108');
