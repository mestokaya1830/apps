// C++ code
//
#define red 9
#define blue 10
#define green 11
void setup()
{
  Serial.begin(9600);
  pinMode(red, OUTPUT);
  pinMode(blue, OUTPUT);
  pinMode(green, OUTPUT);
}

void loop()
{
  analogWrite(red, random(255));
  analogWrite(blue, random(255));
  analogWrite(green, random(255));
  Serial.println(analogRead(red));
  delay(1000);
}
