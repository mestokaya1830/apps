const http = require("http");
const fs = require("fs");
const { Board, Led } = require("johnny-five");
const board = new Board();

let led;
let led2;
board.on("ready", () => {
  led = new Led(13);
  led2 = new Led(11);
})
http
  .createServer((req, res) => {
    //get person
    if (req.method === "GET" && req.url === "/") {
      res.writeHead(200,{'Content-type': 'text/html'});
      const readStream = fs.createReadStream('./dist/index.html');
      readStream.pipe(res)
    } else if (req.method === "GET" && req.url === "/led-on") {
      led.on()
      led.blink(500)
      res.end();
    } else if (req.method === "GET" && req.url === "/led-off") {
      led.stop()
      led.off()
      res.end()
    } else if (req.method === "GET" && req.url === "/pulse-on") {
      led2.pulse(1000)
      res.end();
    } else if (req.method === "GET" && req.url === "/pulse-off") {
      led2.stop()
      led2.off()
      res.end();
    } else {
      res.writeHead(200, { "Content-Type": "application/json" });
      res.end(JSON.stringify({ message: "Url not found" }));
    }
  })
  .listen(3000, () => {
    console.log("Server is running...");
  });

