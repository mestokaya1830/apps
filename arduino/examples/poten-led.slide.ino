// C++ code
//
#define yellow 2
#define red 3
#define green 4
int poten = 0;
void setup()
{
  Serial.begin(9600);
  pinMode(A0, INPUT);
  pinMode(yellow, OUTPUT);
  pinMode(red, OUTPUT);
  pinMode(green, OUTPUT);
}

void loop()
{
  poten = map(analogRead(A0),0,1023,0,255);
  if(poten < 50){
  	digitalWrite(yellow, 1);
    digitalWrite(red, 0);
    digitalWrite(green, 0);
    delay(500);
    digitalWrite(yellow, 0);
  }
  if(poten > 50 && poten < 150){
  	digitalWrite(red, 1);
    digitalWrite(yellow, 0);
    digitalWrite(green, 0);
    delay(500);
    digitalWrite(red, 0);
  }
  if(poten > 150 && poten < 255){
  	digitalWrite(green, 1);
    digitalWrite(red, 0);
    digitalWrite(yellow, 0);
    delay(500);
    digitalWrite(green, 0);
  }
  delay(500);
}