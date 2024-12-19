// C++ code
//
#define flex A0
#define green 2
#define yellow 3
#define red 4
void setup()
{
  Serial.begin(9600);
  pinMode(flex, INPUT);
  pinMode(green, OUTPUT);
  pinMode(yellow, OUTPUT);
  pinMode(red, OUTPUT);
}

void loop()
{
  if(analogRead(flex) == 1022){
  	digitalWrite(green, 1);
    digitalWrite(yellow, 0);
    digitalWrite(red, 0);
  }
  if(analogRead(flex) == 1018){
  	digitalWrite(green, 0);
    digitalWrite(yellow, 1);
    digitalWrite(red, 0);
  }
  
  if(analogRead(flex) == 1016){
  	digitalWrite(green, 0);
    digitalWrite(yellow, 0);
    digitalWrite(red, 1);
  }
  Serial.println(analogRead(flex));
  delay(10);
}