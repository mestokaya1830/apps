// C++ code
//
#define yellow 2
#define red 3
#define green 4
int trigger = 9;
int echo = 10;
float duration, distance;
void setup()
{
  Serial.begin(9600);
  pinMode(yellow, OUTPUT);
  pinMode(red, OUTPUT);
  pinMode(green, OUTPUT);
  pinMode(trigger, OUTPUT);
  pinMode(echo, INPUT);
}

void loop()
{
  digitalWrite(trigger, 0);
  delayMicroseconds(2);
  digitalWrite(trigger, 1);
  delayMicroseconds(10);
  digitalWrite(trigger, 0);

  duration = pulseIn(echo, 1);
  distance = (duration*.0343)/2;
  
  if(distance < 50){
  	digitalWrite(yellow, 1);
    digitalWrite(red, 0);
    digitalWrite(green, 0);
  }
  if(distance > 50 && distance < 150){
  	digitalWrite(red, 1);
    digitalWrite(yellow, 0);
    digitalWrite(green, 0);
  }
  if(distance > 150 && distance < 255){
  	digitalWrite(green, 1);
    digitalWrite(yellow, 0);
    digitalWrite(red, 0);
  }
  delay(100);
}