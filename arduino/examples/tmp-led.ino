// C++ code
//
#define tmp A0
#define red 2
void setup()
{
  Serial.begin(9600);
  pinMode(red, OUTPUT);
  pinMode(tmp, INPUT);
}

void loop()
{
  if(analogRead(tmp) > 150){
    digitalWrite(red, 1);
  } else {
  	digitalWrite(red, 0);
  }
  Serial.println(analogRead(tmp));
  delay(10);
}