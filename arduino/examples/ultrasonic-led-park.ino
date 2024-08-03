// C++ code
//
#define led 2
int trigger = 9;
int echo = 10;
float duration, distance;
void setup()
{
  Serial.begin(9600);
  pinMode(led, OUTPUT);
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
  	digitalWrite(led, 0);
  }
  if(distance > 50 && distance < 100){
  	digitalWrite(led, 1);
    delay(1000);
    digitalWrite(led, 0);
    delay(1000);
  }
  if(distance > 100 && distance < 150){
  	digitalWrite(led, 1);
    delay(500);
    digitalWrite(led, 0);
    delay(500);
  }
  if(distance > 150 && distance < 255){
  	digitalWrite(led, 1);
    delay(200);
    digitalWrite(led, 0);
    delay(200);
  }
  delay(10);
}