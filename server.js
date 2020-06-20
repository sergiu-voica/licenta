const express = require('express');
const app = express();
const cors = require('cors');
const bodyParser = require('body-parser');
const Datastore = require('nedb');
let mysql = require('mysql');

const server = require('http').createServer(app);
const port = 4000;

let userId;
let con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "login"
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Connected to database!");
});

app.listen(port, () =>  console.log("Listening on port: " + port));
app.use(express.static('public'));
app.use(cors());

app.use(bodyParser.json());
app.post('/api', (req, res) => {
  const data = req.body;
  con.query('INSERT INTO locations SET ?', data, (err, res) => {
    if(err) throw err;
  
    console.log('Last insert ID:', res.insertId);
  });


  res.json(data);
});

app.get('/api', (req, res) => {
  const token = req.query.token
  console.log(req.query);
  con.query(`SELECT lat, lng FROM locations WHERE token = "${token}" ORDER BY entryID DESC LIMIT 1`, (err, result) => {
    if(err) throw err;
    // const latestLocation = JSON.stringify(result);
    console.log(result);

    res.json(result);
    
    // console.log('Last location:', console.log(JSON.stringify(res)));
  });
});

app.get('/cars', (req, res) => {
  userId = req.query.userId;
  con.query(`SELECT vehicleNumber FROM cars WHERE userUid="${userId}"`, (err, result) => {
    if(err) throw err;
    console.log(result);
    res.json(result);
  });
});

app.get('/allcars', (req, res) => {
  con.query(`SELECT userUId, lat, lng, entryID, LastUpdated, token FROM locations,cars WHERE vehicleNumber = token AND entryID = (
    SELECT
      MAX(entryID)
    FROM
      locations latest
    WHERE
      token = locations.token
  )
AND userUId ="${userId}"`, (err, result) => {
    if(err) throw err;
    console.log(result);
    res.json(result);
  });
});

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/public/');
})

