const express = require('express');
const app = express();
const bodyParser = require('body-parser');
const Datastore = require('nedb');

const server = require('http').createServer(app);
const port = 4000;

const database = new Datastore('database.db');
database.loadDatabase();

app.listen(port, () =>  console.log("Listening"));
app.use(express.static('public'));

app.use(bodyParser.json());
app.post('/api', (req, res) => {
  const data = req.body;
  const timestamp = Date.now();
  data.timestamp = timestamp;
  data.id = '1';
  console.log(data);

  database.insert(data);

  res.json(data);
});

app.get('/api', (req, res) => {
  database.find({ id: '1' }).sort({ timestamp: -1 }).exec((err, data) => {
    if(err) {
      res.end();
      return;
    }
    const latestLocation = data[0];
    res.json(latestLocation);
  }) 
  
});

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/public/');
})

