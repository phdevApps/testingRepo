const express = require('express');
const cors = require('cors');

const app = express();

const port = 3000

app.use(cors());

app.get('/',(req,res)=>res.json({msg:'hi'}))

app.listen(port,()=>console.log(`server live at http://localhost:${port}`))