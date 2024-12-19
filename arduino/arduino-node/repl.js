const { Board, Led } = require("johnny-five");
const board = new Board();

board.on("ready", function(){
  let led = new Led(11);
  this.repl.inject({
    greenLed: led
  })
})


//run project
//open terminal and type greenLed.on() greenLed.off() or greenLed.pulse(1000) so on