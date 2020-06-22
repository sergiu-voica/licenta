const express = require('express');
const app = express();
const cors = require('cors');
const bodyParser = require('body-parser');
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
  con.query(`SELECT lat, lng, token, denumire FROM locations, cargo WHERE token = "${token}" AND locations.token = cargo.vehicleNumber ORDER BY entryID DESC LIMIT 1`, (err, result) => {
    if(err) throw err;
    console.log(result);
    res.json(result);
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
  con.query(`SELECT  lat, lng, entryID, LastUpdated, token, denumire FROM cargo, locations,cars WHERE cars.vehicleNumber = token AND entryID = (
    SELECT
      MAX(entryID)
    FROM
      locations latest
    WHERE
      token = locations.token
  )
    AND cars.userUId ="${userId}"`, (err, result) => {
    if(err) throw err;
    console.log(result);
    res.json(result);
  });
});

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/public/');
})

